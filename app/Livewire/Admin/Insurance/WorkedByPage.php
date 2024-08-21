<?php

namespace App\Livewire\Admin\Insurance;

use App\Models\InsuranceWorkedBy;
use Livewire\Component;
use Livewire\WithPagination;
use Rap2hpoutre\FastExcel\FastExcel;

class WorkedByPage extends Component
{
    use WithPagination;

    public array $requestFilter = [];
    public array $filter = [];
    public mixed $search = "",$exportFiles = [];
    public array $request = [];

    protected array $validationAttributes = [
        'request.name'=>'name',
        'request.position'=>'position',
        'request.status'=>'status',
    ];

    protected function rules(): array
    {
        return [
            'request.name'=>'required|max:255',
        ];
    }

    public function mount()
    {
        $this->resetFilter();
        $this->NewRequest();
    }

    public function render()
    {
        if (checkData($this->search))
        {
            $data = InsuranceWorkedBy::where(function ($q){
                $q->orWhere('id','like',$this->search)
                    ->orWhere('name','like',"{$this->search}%")
                    ->orWhere('name','like',"%{$this->search}%");
            })->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = InsuranceWorkedBy::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        return view('livewire.admin.insurance.worked-by-page',compact('data'));
    }
    public function save()
    {
        if (\Arr::has($this->request,'id'))
        {
            $this->validate($this->rules());
            try
            {
                $check = InsuranceWorkedBy::find($this->request['id']);
                $check->fill(\Arr::except($this->request,'id'));
                $check->save();
                $this->dispatch('SetMessage',type:'success',message:'Updated Successfully',close:true);
            }
            catch (\Exception $exception)
            {
                $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
            }
        }
        else
        {
            $this->validate($this->rules());
            try
            {
                InsuranceWorkedBy::create($this->request);
                $this->NewRequest();
                $this->dispatch('SetMessage',type:'success',message:'Added Successfully',close:true);
            }
            catch (\Exception $exception)
            {
                $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
            }
        }
    }

    public function OpenAddEditModal($id = null)
    {
        if (checkData($id))
        {
            $check = InsuranceWorkedBy::find($id);
            if ($check)
            {
                $this->EditRequest($check);
                $this->dispatch('OpenAddEditModal');
            }
        }
        else
        {
            $this->NewRequest();
            $this->dispatch('OpenAddEditModal');
        }
    }

    private function NewRequest()
    {
        $this->request = [
            'name'=>null,
            'position'=>0,
            'status'=>1,
        ];
    }

    private function EditRequest($check)
    {
        $this->request = $check->only([
            'id',
            'name',
            'position',
            'status',
        ]);
    }

    public function exportData():void
    {
        $this->exportFiles = [];
        $header_style = config('excel.header_style');

        InsuranceWorkedBy::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->chunk(10000, function ($history) use ($header_style) {
                $filename = time()."export_follow_up.xlsx";
                $path = storage_path('app/exports/').$filename;
                (new FastExcel($history))->headerStyle($header_style)
                    ->export($path, function ($ranking) {
                        return [
                            "Name"=>$ranking->name ??'',
                            "Status"=>$ranking->status?'Active':'Inactive',
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

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function resetFilter():void
    {
        $this->requestFilter = $this->filter = [
            'sortBy'=>'id',
            'orderBy'=>'asc',
            'perPage'=>10
        ];
    }

    public function applyFilter():void
    {
        $this->filter =  $this->requestFilter;
    }

    public function updateStatus($id = null , $status = false):void
    {
        $check = InsuranceWorkedBy::find($id);
        if ($check)
        {
            $check->status = $status?1:0;
            $check->save();
        }
    }

    public function destroy($id = null):void
    {
        $check = InsuranceWorkedBy::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',type:'success',message:'Deleted Successfully');
        }
    }
}
