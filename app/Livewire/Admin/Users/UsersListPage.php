<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Rap2hpoutre\FastExcel\FastExcel;

class UsersListPage extends Component
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
            $data = User::where('user_type','user')
            ->where(function ($q){
                $q->orWhere('id','like',$this->search)
                    ->orWhere('name','like',"{$this->search}%")
                    ->orWhere('name','like',"%{$this->search}%");
            })->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = User::where('user_type','user')
                ->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        return view('livewire.admin.users.users-list-page',compact('data'))
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function exportData():void
    {
        $this->exportFiles = [];
        User::where('user_type','user')
            ->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->chunk(10000, function ($history) {
                $filename = time()."export_users.xlsx";
                $path = storage_path('app/exports/').$filename;
                (new FastExcel($history->sortByDesc('id')))->headerStyle(config('excel.header_style'))
                    ->export($path, function ($ranking) {
                        return [
                            "User Id"=>$ranking->id ??'',
                            "Salutation"=>$ranking->salutation ??'',
                            "First Name"=>$ranking->name ??'',
                            "Last Name"=>$ranking->last_name ??'',
                            "Email"=>$ranking->email,
                            "Country"=>$ranking->country,
                            "State"=>$ranking->state,
                            "City"=>$ranking->city,
                            "User Account Registration"=>Carbon::parse($ranking->created_at)->format('d F Y, l'),
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
        $check = User::find($id);
        if ($check && $check->isUser())
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
