<?php

namespace App\Livewire\Admin\Themes;

use App\Models\ThemePage;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use Rap2hpoutre\FastExcel\FastExcel;

class PagesListPage extends Component
{
    use WithPagination;
    public array $requestFilter = [];
    public array $filter = [];
    public mixed $search = "",$exportFiles = [];

    public function mount()
    {
        $this->resetFilter();
    }

    public function render()
    {
        if (isset($this->search) && $this->search!=="")
        {
            $data = ThemePage::where(function ($q){
                $q->orWhere('id','like',$this->search)
                    ->orWhere('name','like',"{$this->search}%")
                    ->orWhere('name','like',"%{$this->search}%");
            })->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = ThemePage::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        return view('livewire.admin.themes.pages-list-page',compact('data'));
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function exportData():void
    {
        $this->exportFiles = [];
        $header_style = config('excel.header_style');
        ThemePage::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->chunk(10000, function ($history) use ($header_style) {
                $filename = time()."export_theme_pages.xlsx";
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
        $tag = ThemePage::find($id);
        if ($tag)
        {
            $tag->status = $status?1:0;
            $tag->save();
        }
    }

    public function destroy($id = null):void
    {
        $check = ThemePage::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',type:'success',message:'Deleted Successfully');
        }
    }


}
