<?php

namespace App\Livewire\Admin\InsuranceClaim;

use App\Helpers\ClaimHelper;
use App\Helpers\Role\RoleHelper;
use App\Models\InsuranceClaim;
use App\Models\InsuranceClaimAnswer;
use App\Models\InsuranceClaimStatus;
use App\Models\InsuranceEobDl;
use App\Models\InsuranceFollowUp;
use App\Models\InsuranceWorkedBy;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Rap2hpoutre\FastExcel\FastExcel;

class InsuranceClaimListPage extends Component
{
    use WithPagination;
    protected string $paginationTheme = "bootstrap";
    public array $requestFilter = [];
    public array $filter = [];
    public $search = "";
    public array $exportFiles = [];

    public $closedStatus = [];
    public $selectedStatus = [];
    public $followUpList = [],$eobList = [],$teamList = [],$followList = [];

    public $selectedClaimStatus = [],$claimStatusList = [];

    public $editFields = false;
    public $editModal;

    public User $adminUser;

    public $userCustomers = [], $selectedCustomers = [];

    public function mount()
    {
        $this->adminUser = User::find(auth()->user()->id);

        $this->closedStatus = ClaimHelper::closedFollowUp();
        $this->followUpList = InsuranceFollowUp::where('status',1)->pluck('id')->toArray();

        $this->claimStatusList = InsuranceClaimStatus::where('status',1)->get();
        $this->eobList = InsuranceEobDl::where('status',1)->get();
        $this->teamList = InsuranceWorkedBy::where('status',1)->get();
        $this->followList = InsuranceFollowUp::where('status',1)->get();

        $this->resetFilter();

        $this->userCustomers = RoleHelper::getUserCustomers($this->adminUser);
    }

    public function render()
    {
        $data = InsuranceClaim::query();

        if (count($this->selectedStatus)>0)
        {
            $data->whereIn('follow_up_status',$this->selectedStatus);
        }

        if (count($this->selectedClaimStatus)>0)
        {
            $data->whereIn('claim_status',$this->selectedClaimStatus);
        }

        if (count($this->selectedCustomers)>0)
        {
            $data->whereIn('customer_id',$this->selectedCustomers);
        }

        if (checkData($this->search))
        {
            $data->where(function ($q) {
                $q->orWhere('id', 'like', $this->search)
                    ->orWhere('ins_name', 'like', "%{$this->search}%")
                    ->orWhere('dos', 'like', "%{$this->search}%")
                    ->orWhere('patent_name', 'like', "%{$this->search}%")
                    ->orWhere(function ($qs){
                        $qs->whereHas('claimStatusModal',function ($status){
                            $status->where('name','LIKE',"%{$this->search}%");
                        });
                    });
            });
        }

        if ($this->adminUser->isStaff())
        {
            $data->whereHas('assigns',function ($q){
                $q->where('user_id',$this->adminUser->id);
            });
        }

        $data = $data->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->paginate($this->filter['perPage']);

        return view('livewire.admin.insurance-claim.insurance-claim-list-page',compact('data'));
    }

    public function resetFilter():void
    {
        $this->requestFilter =  $this->filter = [
            'sortBy'=>'ins_name',
            'orderBy'=>'asc',
            'perPage'=>10
        ];
    }

    public function exportData():void
    {
        $this->exportFiles = [];
        InsuranceClaim::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
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

    public function applyFilter():void
    {
        $this->filter =  $this->requestFilter;
    }

    public function destroy($id = null):void
    {
        $check = InsuranceClaim::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',type:'success',message:'Deleted Successfully');
        }
    }

    public function updatedSearch()
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

    public function findFiledValue($id = null, $field = "ins_name")
    {
        $this->editModal = InsuranceClaim::find($id);
        if ($this->editModal)
        {
            switch ($field)
            {
                default:
                    $this->dispatch('setModalValue',
                        value:$this->editModal?->$field ??'',
                        row:$id,
                        field:$field,
                    );
            }
        }
    }

    public function saveFieldValue(
        $id = null,
        $field = null,
        $value = null
    ): void
    {
        if (checkData($id) && checkData($field))
        {
            $model = InsuranceClaim::find($id);
            if ($model)
            {
                switch ($field)
                {
                    case "eob_dl":
                    case "follow_up_status":
                    case "team_worked":
                        if (!checkData($value))
                        {
                            $value = null;
                        }
                        $model->$field = $value;
                        break;
                    case "claim_status":
                        $claimStatus = InsuranceClaimStatus::find($value);
                        if ($claimStatus)
                        {
                            $model->$field = $value;
                            $model->status_description = $claimStatus->note;
                            $model->claim_action = $claimStatus->description;

                            $ids = [];

                            foreach ($claimStatus->questions as $item)
                            {
                                $check = InsuranceClaimAnswer::where([
                                    'claim_id'=>$model->id,
                                    'question_id'=>$item->id,
                                ])->first();

                                if (!$check)
                                {
                                    $check = new InsuranceClaimAnswer();
                                }

                                $check->fill([
                                    'claim_id'=>$model->id,
                                    'question_id'=>$item->id,
                                    'question'=>$item->title ??'',
                                ]);

                                $check->save();

                                $ids[] = $check->id;

                            }

                            InsuranceClaimAnswer::where([
                                'claim_id'=>$model->id,
                            ])->whereNotIn('id',$ids)->delete();

                        }
                        break;
                    case "a_1":
                    case "a_2":
                    case "a_3":
                    case "a_4":
                    case "a_5":
                        $this->saveClaimAnswer($model,$field,$value);
                        break;
                    default:
                        $model->$field = $value;
                }
                $model->save();
            }
        }
    }

    private function saveClaimAnswer($model, mixed $field, mixed $value): void
    {

        $data = explode('_',$field);
        $skip = max($data[1] - 1,0);

        $check = $model->answers->skip($skip)?->first();

        if ($check)
        {
            InsuranceClaimAnswer::where('id',$check->id)->update([
                'answer'=>$value
            ]);
        }

    }
}
