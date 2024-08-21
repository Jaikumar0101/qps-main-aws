<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use App\Models\InsuranceClaim;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Rap2hpoutre\FastExcel\FastExcel;

class CustomersListPage extends Component
{
    use WithPagination;
    protected string $paginationTheme = "bootstrap";
    public array $requestFilter = [];
    public array $filter = [];
    public $search = "";
    public array $exportFiles = [];

    public ?User $adminUser;

    public function mount()
    {

        $this->adminUser = User::find(auth()->user()->id);
        $this->resetFilter();
    }

    public function render()
    {
        $data = Customer::query();

        if (checkData($this->search))
        {
            $data->where(function ($q) {
                      $q->orWhere('id', 'like', $this->search)
                        ->orWhere('email', 'like', "%{$this->search}%")
                        ->orWhere('first_name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%");
                });
        }

        if (!$this->adminUser->canAccess('client::access'))
        {
            $data->whereHas('assigns',function ($q){
                $q->where('user_id',$this->adminUser->id);
            });
        }

        $data = $data->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->paginate($this->filter['perPage']);

        return view('livewire.admin.customers.customers-list-page',compact('data'));
    }

    public function exportData():void
    {
        $this->exportFiles = [];
        Customer::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->chunk(10000, function ($history) {
                $filename = time()."export_users.xlsx";
                $path = storage_path('app/exports/').$filename;
                (new FastExcel($history->sortByDesc('id')))->headerStyle(config('excel.header_style'))
                    ->export($path, function ($ranking) {
                        return [
                            "Id"=>$ranking->id ??'',
                            "First Name"=>$ranking->first_name ??'',
                            "Last Name"=>$ranking->last_name ??'',
                            "Email"=>$ranking->email ??'',
                            "Phone"=>$ranking->phone ??'',
                            "Account Registration"=>Carbon::parse($ranking->created_at)->format('d F Y, l'),
                        ];
                    });
                $this->exportFiles [] = [
                    'name'=>$filename,
                    'link'=>'app/exports/'.$filename,
                    'path'=>$path,
                    'removed'=>false,
                ];
            });
        $this->dispatch('OpenExportModal');
    }

    public function exportClaims($id):void
    {
        $this->exportFiles = [];
        InsuranceClaim::where('customer_id',$id)
            ->chunk(10000, function ($history) {
                $filename = time()."export_insurance_claims.xlsx";
                $path = storage_path('app/exports/').$filename;
                (new FastExcel($history->sortByDesc('id')))->headerStyle(config('excel.header_style'))
                    ->export($path, function ($ranking) {
                        return [
                            'ID'=>$ranking->code(),
                            'INS Name'=>$ranking->ins_name ??'',
                            'INS Phone'=>$ranking->ins_phone ??'',
                            'SUB Name'=>$ranking->sub_name ??'',
                            'SUB ID'=>$ranking->sub_id ??'',
                            'Patient ID'=>$ranking->patent_id ??'',
                            'Patient Name'=>$ranking->patent_name ??'',
                            'DOB'=>$ranking->dob ??'',
                            'DOS'=>$ranking->dos ??'',
                            'SENT'=>$ranking->sent ??'',
                            'Total'=>$ranking->total ??'',
                            'Days'=>$ranking->days ??'',
                            'Days-R'=>$ranking->days_r ??'',
                            'PROV NM'=>$ranking->prov_nm ??'',
                            'Location'=>$ranking->location ??'',
                            'Claim Status'=>$ranking->claimStatusModal?->name ??'',
                            'Status Description'=>$ranking->status_description ??'',
                            'Q1'=>$ranking->answers?->first()?->question ??'',
                            'A1'=>$ranking->answers?->first()?->answer ??'',
                            'Q2'=>$ranking->answers->skip(1)?->first()?->question ??'',
                            'A2'=>$ranking->answers->skip(1)?->first()?->answer ??'',
                            'Q3'=>$ranking->answers->skip(2)?->first()?->question ??'',
                            'A3'=>$ranking->answers->skip(2)?->first()?->answer ??'',
                            'Q4'=>$ranking->answers->skip(3)?->first()?->question ??'',
                            'A4'=>$ranking->answers->skip(3)?->first()?->answer ??'',
                            'Q5'=>$ranking->answers->skip(4)?->first()?->question ??'',
                            'A5'=>$ranking->answers->skip(4)?->first()?->answer ??'',
                            'Enter Additional Notes here'=>$ranking->note ??'',
                            'Claim Action'=>$ranking->claim_action ??'',
                            'COF'=>$ranking->cof ??'',
                            'NXT FLUP DT'=>$ranking->nxt_flup_dt ??'',
                            'EOB DL'=>$ranking->eobDlModal?->name ??'',
                            'Team Worked'=>$ranking->teamModal?->name ??'',
                            'Worked By'=>$ranking->worked_by ??'',
                            'Worked DT'=>$ranking->worked_dt ??'',
                            'Follow-Up Status'=>$ranking->followUpModal?->name ??'',
                        ];
                    });
                $this->exportFiles [] = [
                    'name'=>$filename,
                    'link'=>'app/exports/'.$filename,
                    'path'=>$path,
                    'removed'=>false,
                ];
            });
        $this->dispatch('OpenExportModal');
    }

    public function DownloadFile($index): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $path = $this->exportFiles[$index]['link'];
        $this->exportFiles[$index]['removed'] = true;
        return response()->download(storage_path($path))->deleteFileAfterSend();
    }

    public function resetFilter():void
    {
        $this->requestFilter =  $this->filter = [
            'sortBy'=>'first_name',
            'orderBy'=>'asc',
            'perPage'=>10
        ];
    }

    public function applyFilter():void
    {
        $this->filter =  $this->requestFilter;
    }

    public function destroy($id = null):void
    {
        $check = Customer::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',type:'success',message:'Deleted Successfully');
        }
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function changeSortBy($sortBy = 'id'): void
    {
        if ($this->filter['sortBy'] == $sortBy)
        {
            $this->filter['orderBy'] = $this->filter['orderBy'] == "desc"?'asc':'desc';
        }
        else
        {
            $this->filter['sortBy'] = $sortBy;
            $this->filter['orderBy'] = "asc";
        }
    }

    public function deleteCustomerClaims($id)
    {
        $customer = Customer::find($id);

        $customer->leads()->forceDelete();
    }

}
