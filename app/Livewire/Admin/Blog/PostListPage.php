<?php

namespace App\Livewire\Admin\Blog;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\WithPagination;
use Rap2hpoutre\FastExcel\FastExcel;

class PostListPage extends Component
{
    use WithPagination;
    protected string $paginationTheme = "bootstrap";
    public array $requestFilter = [];
    public array $filter = [];
    public mixed $search,$exportFiles = [];

    public function mount()
    {
        $this->resetFilter();
    }

    public function render()
    {
        if (isset($this->search) && $this->search!=="")
        {
            $data = BlogPost::where(function ($q){
                $q->orWhere('id','like',$this->search)
                    ->orWhere('title','like',"{$this->search}%")
                    ->orWhere('title','like',"%{$this->search}%");
            })->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = BlogPost::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        return view('livewire.admin.blog.post-list-page',compact('data'))
           ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function exportData():void
    {
        $this->exportFiles = [];
        $header_style = config('excel.header_style');
        BlogPost::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->chunk(10000, function ($history) use ($header_style) {
                $filename = time()."export_blog_posts.xlsx";
                $path = storage_path('app/exports/').$filename;
                (new FastExcel($history->sortByDesc('id')))->headerStyle($header_style)
                    ->export($path, function ($ranking) {
                        return [
                            "ID"=>$ranking->id ??'',
                            "Title"=>$ranking->title ??'',
                            "Description"=>$ranking->desc ??'',
                            "PostDate"=>$ranking->displayPostDate('d m,Y'),
                            "Status"=>$ranking->status,
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

    public function destroy($id = null):void
    {
        $check = BlogPost::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',
                type:'success',
                message:'Deleted Successfully'
            );
        }
    }

}
