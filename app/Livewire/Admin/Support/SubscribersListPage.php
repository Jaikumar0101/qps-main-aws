<?php

namespace App\Livewire\Admin\Support;

use App\Models\Subscriber;
use Livewire\Component;
use Livewire\WithPagination;
use Rap2hpoutre\FastExcel\FastExcel;

class SubscribersListPage extends Component
{
    use WithPagination;
    protected string $paginationTheme = "bootstrap";
    public array $requestFilter = [];
    public array $filter = [];
    public mixed $search = "",$exportFiles = [];
    public array $request = [];

    protected array $validationAttributes = [
        'request.email'=>'email',
        'request.newsletter'=>'newsletter',
        'request.status'=>'status',
    ];

    protected function rules($id = 0): array
    {
        return [
            'request.email'=>'required|email|unique:subscribers,email,'.$id,
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
            $data = Subscriber::where(function ($q){
                $q->orWhere('id','like',$this->search)
                    ->orWhere('email','like',"{$this->search}%")
                    ->orWhere('email','like',"%{$this->search}%");
            })->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = Subscriber::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        return view('livewire.admin.support.subscribers-list-page',compact('data'))
            ->layout('layouts.admin.app');
    }

    public function save()
    {
        if (\Arr::has($this->request,'id'))
        {
            $this->validate($this->rules($this->request['id']));
            try
            {
                $check = Subscriber::find($this->request['id']);
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
                Subscriber::create($this->request);
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
            $check = Subscriber::find($id);
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
            'email'=>null,
            'newsletter'=>1,
            'status'=>1,
        ];
    }

    private function EditRequest($check)
    {
        $this->request = $check->only([
            'id',
            'email',
            'newsletter',
            'status',
        ]);
    }

    public function exportData():void
    {
        $this->exportFiles = [];
        $header_style = config('excel.header_style');
        Subscriber::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->chunk(10000, function ($history) use ($header_style) {
                $filename = time()."export_blog_tags.xlsx";
                $path = storage_path('app/exports/').$filename;
                (new FastExcel($history))->headerStyle($header_style)
                    ->export($path, function ($ranking) {
                        return [
                            "Email"=>$ranking->email ??'',
                            "Newsletter"=>$ranking->newsletter?'Yes':'No',
                            "Subscribed"=>$ranking->status?'Yes':'No',
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
            'orderBy'=>'desc',
            'perPage'=>10
        ];
    }

    public function applyFilter():void
    {
        $this->filter =  $this->requestFilter;
    }

    public function updateStatus($id = null , $status = false):void
    {
        $check = Subscriber::find($id);
        if ($check)
        {
            $check->status = $status?1:0;
            $check->save();
        }
    }

    public function destroy($id = null):void
    {
        $check = Subscriber::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',type:'success',message:'Deleted Successfully');
        }
    }
}
