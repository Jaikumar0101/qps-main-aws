<?php

namespace App\Livewire\Admin\Grouping\Address;

use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use OpenSpout\Writer\Common\Creator\Style\StyleBuilder;
use Rap2hpoutre\FastExcel\FastExcel;

class StateListPage extends Component
{
    use WithPagination;
    protected string $paginationTheme = "bootstrap";
    public array $requestFilter = [];
    public array $filter = [];
    public mixed $search,$exportFiles = [];
    public array $request = [];

    protected array $validationAttributes = [
        'request.name' => 'name',
        'request.country_id' => 'country',
        'request.status' => 'status',
    ];

    public mixed $countries;
    public $country_id;

    public function mount():void
    {
        $this->countries = Country::orderBy('name','asc')->get();
        $this->NewRequest();
        $this->resetFilter();
    }

    public function render()
    {
        if (isset($this->search) && $this->search!=="")
        {
            $data = State::where(function ($q){
                $q->orWhere('id','like',$this->search)
                    ->orWhere('name','like',"{$this->search}%")
                    ->orWhere('name','like',"%{$this->search}%");
            })->where('country_id',$this->country_id?'=':'!=',$this->country_id)
                ->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = State::where('country_id',$this->country_id?'=':'!=',$this->country_id)
                ->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        return view('livewire.admin.grouping.address.state-list-page',compact('data'))
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function save()
    {
        $this->validate([
            'request.name'=>'required|max:255',
            'request.country_id'=>'required',
            'request.status'=>'required',
        ]);

        if (State::where('id','!=',$this->request['id'] ??'0')->where('name',$this->request['name'])->count()>0)
        {
            $this->dispatch('SetMessage',
                type:'error',
                message:'Same name already exists',
            );
        }
        else { $this->createOrUpdate($this->request); }
    }

    public function createOrUpdate($data)
    {
        if (Arr::has($data,'id'))
        {
            State::where('id',$data['id'])->update(Arr::only($data,[
                'name',
                'country_id',
                'status'
            ]));
            $this->dispatch('SetMessage',
                type:'success',
                message:'Updated successfully',
                close:true,
            );
        }
        else {
            State::create($data);
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
            $state = State::find($id);
            $state?$this->EditRequest($state):$this->NewRequest();
        }
        else{ $this->NewRequest(); }
        $this->dispatch('OpenAddEditModal');
    }

    protected function NewRequest() {
        $this->request = [
            "name" => null,
            'country_id'=>null,
            "status" => 1,
        ];
    }

    protected function EditRequest($state)
    {
        $this->request = $state->only([
            'id',
            'name',
            'country_id',
            'status'
        ]);
    }


    public function exportData():void
    {
        $this->exportFiles = [];
        State::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->chunk(10000, function ($history) {
                $filename = time()."export_states.xlsx";
                $path = storage_path('app/exports/').$filename;
                (new FastExcel($history->sortByDesc('id')))->headerStyle(config('excel.header_style'))
                    ->export($path);
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

    public function updateStatus($id = null , $status = false):void
    {
        $state = State::find($id);
        if ($state)
        {
            $state->status = $status?1:0;
            $state->save();
        }
    }

    public function resetFilter():void
    {
       $this->requestFilter = $this->filter = [
            'sortBy'=>'name',
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
        $check = State::find($id);
        if ($check)
        {
            $check->delete();
            $this->dispatch('SetMessage',
                type:'success',
                message:'Deleted Successfully'
            );
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}
