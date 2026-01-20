<?php

namespace App\Livewire\Admin\Insurance;

use App\Models\InsuranceClaimStatus;
use Livewire\Component;
use Livewire\WithPagination;
use Rap2hpoutre\FastExcel\FastExcel;

class StatusListPage extends Component
{
    use WithPagination;
    protected string $paginationTheme = "bootstrap";
    public array $requestFilter = [];
    public array $filter = [];
    public $search = "";
    public array $exportFiles = [];

    public function mount()
    {
        $this->resetFilter();
    }

    public function render()
    {
        if (checkData($this->search))
        {
            $data = InsuranceClaimStatus::where(function ($q) {
                $q->orWhere('id', 'like', $this->search)
                    ->orWhere('name', 'like', "{$this->search}%");
            })
                ->orderBy($this->filter['sortBy'], $this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = InsuranceClaimStatus::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        return view('livewire.admin.insurance.status-list-page',compact('data'));
    }


    public function exportData():void
    {
        $this->exportFiles = [];
        InsuranceClaimStatus::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->chunk(10000, function ($history) {
                $filename = time()."export_status.xlsx";
                $path = storage_path('app/exports/').$filename;
                (new FastExcel($history->sortByDesc('id')))->headerStyle(config('excel.header_style'))
                    ->export($path, function ($ranking) {
                        return [
                            'name'=>$ranking->name ??'',
                            'description'=>$ranking->description ??'',
                            'note'=>$ranking->note ??'',
                            'status'=>$ranking->status ?'Active':'Inactive',
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
            'sortBy'=>'id',
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
        $check = InsuranceClaimStatus::find($id);
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


}
