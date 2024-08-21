<?php

namespace App\Livewire\Admin\Blog;

use App\Models\BlogTag;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use Rap2hpoutre\FastExcel\FastExcel;

class TagPage extends Component
{
    use WithPagination;
    protected string $paginationTheme = "bootstrap";
    public array $requestFilter = [];
    public array $filter = [];
    public mixed $search = "",$exportFiles = [];
    public array $request = [];
    protected array $validationAttributes = [
        'request.name'=>'name',
        'request.status'=>'status',
    ];

    public function mount()
    {
        $this->resetFilter();
    }

    public function render()
    {
        if (isset($this->search) && $this->search!=="")
        {
            $data = BlogTag::where(function ($q){
                    $q->orWhere('id','like',$this->search)
                        ->orWhere('name','like',"{$this->search}%")
                        ->orWhere('name','like',"%{$this->search}%");
                })->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = BlogTag::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        return view('livewire.admin.blog.tag-page',compact('data'))
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        $this->validate([
            'request.name'=>'required|max:255',
            'request.status'=>'required',
        ]);

        if (Arr::has($this->request,'id'))
        {
            $this->validate([
                'request.name'=>'unique:blog_tags,name,'.$this->request['id']
            ]);
        }
        $this->createOrUpdate($this->request);
    }

    public function createOrUpdate($data)
    {
        if (Arr::has($data,'id'))
        {
            BlogTag::where('id',$data['id'])
                ->update(Arr::only($data,['name','status']));
            $this->dispatch('SetMessage',
                type:'success',
                message:'Updated successfully',
                close:true,
            );
        }
        else {
            BlogTag::create($data);
            $this->dispatch('SetMessage',
                type:'success',
                message:'Created successfully',
                close:true,
            );
            $this->NewRequest();
        }
    }

    public function OpenAddEditModal($id = null):void
    {
        if (isset($id) && $id!=="")
        {
            $blogTag = BlogTag::find($id);
            $blogTag?$this->EditRequest($blogTag):$this->NewRequest();
        }
        else{ $this->NewRequest(); }
        $this->dispatch('OpenAddEditModal');
    }

    protected function NewRequest() {
        $this->request = [
            'name'=>null,
            'status'=>1,
        ];
    }

    protected function EditRequest($blogTag)
    {
        $this->request = $blogTag->only([
            'id',
            'name',
            'status',
        ]);
    }


    public function exportData():void
    {
        $this->exportFiles = [];
        $header_style = config('excel.header_style');
        BlogTag::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->chunk(10000, function ($history) use ($header_style) {
                $filename = time()."export_blog_tags.xlsx";
                $path = storage_path('app/exports/').$filename;
                (new FastExcel($history->sortByDesc('id')))->headerStyle($header_style)
                    ->export($path, function ($ranking) {
                        return [
                            "Tag ID"=>$ranking->id ??'',
                            "Name"=>$ranking->name ??'',
                            "Status"=>$ranking->status ??'',
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
        $tag = BlogTag::find($id);
        if ($tag)
        {
            $tag->status = $status?1:0;
            $tag->save();
        }
    }

    public function destroy($id = null):void
    {
        $check = BlogTag::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',type:'success',message:'Deleted Successfully');
        }
    }

}
