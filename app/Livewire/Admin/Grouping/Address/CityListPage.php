<?php

namespace App\Livewire\Admin\Grouping\Address;

use App\Models\City;
use App\Models\State;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use OpenSpout\Writer\Common\Creator\Style\StyleBuilder;
use Rap2hpoutre\FastExcel\FastExcel;

class CityListPage extends Component
{
    use WithPagination;
    protected string $paginationTheme = "bootstrap";
    public array $requestFilter = [];
    public array $filter = [];
    public mixed $search,$exportFiles = [];
    public array $request = [];
    public mixed $states;
    public $state_id;

    protected array $validationAttributes = [
        'request.name' => 'name',
        'request.state_id' => 'state',
        'request.status' => 'status',
    ];

    public function mount():void
    {
        $this->states = State::orderBy('name','asc')->get();
        $this->NewRequest();
        $this->resetFilter();
    }

    public function render()
    {
        if (isset($this->search) && $this->search!=="")
        {
            $data = City::where(function ($q){
                $q->orWhere('id','like',$this->search)
                    ->orWhere('name','like',"{$this->search}%")
                    ->orWhere('name','like',"%{$this->search}%");
            })->where('state_id',$this->state_id?'=':'!=',$this->state_id)
                ->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = City::where('state_id',$this->state_id?'=':'!=',$this->state_id)
                ->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        return view('livewire.admin.grouping.address.city-list-page',compact('data'))
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function save()
    {
        $this->validate([
            'request.name'=>'required|max:255',
            'request.state_id'=>'required',
            'request.status'=>'required',
        ]);

        if (City::where('id','!=',$this->request['id'] ??'0')->where('name',$this->request['name'])->count()>0)
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
            City::where('id',$data['id'])->update(Arr::only($data,[
                'name',
                'state_id',
                'status'
            ]));
            $this->dispatch('SetMessage',
                type:'success',
                message:'Updated successfully',
                close:true,
            );
        }
        else {
            City::create($data);
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
            $city = City::find($id);
            $city?$this->EditRequest($city):$this->NewRequest();
        }
        else{ $this->NewRequest(); }
        $this->dispatch('OpenAddEditModal');
    }

    protected function NewRequest()
    {
        $this->request = [
            "name" => null,
            'state_id'=>null,
            "status" => 1,
        ];
    }

    protected function EditRequest($city)
    {
        $this->request = $city->only([
            'id',
            'name',
            'state_id',
            'status'
        ]);
    }

    public function exportData():void
    {
        $this->exportFiles = [];
        City::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->chunk(10000, function ($history) {
                $filename = time()."export_cities.xlsx";
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
        $city = City::find($id);
        if ($city)
        {
            $city->status = $status?1:0;
            $city->save();
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
        $check = City::find($id);
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
