<?php

namespace App\Livewire\Admin\Grouping\Address;

use App\Models\Country;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;
use Rap2hpoutre\FastExcel\FastExcel;

class CountryListPage extends Component
{
    use WithPagination;
    protected string $paginationTheme = "bootstrap";
    public array $requestFilter = [];
    public array $filter = [];
    public mixed $search,$exportFiles = [];
    public array $request = [];

    protected array $validationAttributes = [
        'request.name' => 'name',
        'request.nicename' => 'nicename',
        'request.status' => 'status',
    ];

    public function mount()
    {
        $this->resetFilter();
    }

    public function render()
    {

        if (isset($this->search) && $this->search!=="")
        {
            $data = Country::where(function ($q){
                $q->orWhere('id','like',$this->search)
                  ->orWhere('name','like',"{$this->search}%")
                  ->orWhere('name','like',"%{$this->search}%");
            })->orderBy($this->filter['sortBy'],$this->filter['orderBy'])
                ->paginate($this->filter['perPage']);
        }
        else
        {
            $data = Country::orderBy($this->filter['sortBy'],$this->filter['orderBy'])->paginate($this->filter['perPage']);
        }

        return view('livewire.admin.grouping.address.country-list-page',compact('data'))
            ->layout('layouts.admin.app',['includeAddons'=>true]);
    }

    public function save()
    {
        $this->validate([
            'request.name'=>'required|max:255',
            'request.nicename'=>'required|max:255',
            'request.status'=>'required',
        ]);

        if (Country::where('id','!=',$this->request['id'] ??'0')->where('name',$this->request['name'])->count()>0)
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
            Country::where('id',$data['id'])->update(Arr::only($data,['iso','name','nicename','timezone','status','abbreviations']));
            $this->dispatch('SetMessage',
                type:'success',
                message:'Updated successfully',
                offCanvasHide:"offcanvasRight",
            );
        }
        else {
            Country::create($data);
            $this->dispatch('SetMessage',
                type:'success',
                message:'Created successfully',
                offCanvasHide:"offcanvasRight",
            );
            $this->NewRequest();
        }
    }

    public function OpenAddEditModal($id = null):void
    {
        if (isset($id) && $id!=="")
        {
            $country = Country::find($id);
            $country?$this->EditRequest($country):$this->NewRequest();
        }
        else{ $this->NewRequest(); }
        $this->dispatch('OpenAddEditModal');
    }

    protected function NewRequest() {
        $this->request = [
            "iso" => null,
            "name" => null,
            "nicename" => null,
            "iso3" => null,
            "numcode" => null,
            "phonecode" => null,
            "region_id" => null,
            "timezone" => null,
            "utcname" => null,
            "utc" => null,
            "abbreviations" => null,
            "status" => 1,
        ];
    }

    protected function EditRequest($country)
    {
        $this->request = $country->only([
            "id",
            "iso",
            "name",
            "nicename",
            "iso3",
            "numcode",
            "phonecode",
            "region_id",
            "timezone",
            "utcname",
            "utc",
            "abbreviations",
            "status",
        ]);
    }


    public function exportData():void
    {
        $this->exportFiles = [];
        Country::orderBy($this->filter['sortBy'],$this->filter['orderBy'])
            ->chunk(10000, function ($history) {
                $filename = time()."export_countries.xlsx";
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
        $country = Country::find($id);
        if ($country)
        {
            $country->status = $status?1:0;
            $country->save();
        }
    }

    public function resetFilter():void
    {
        $this->requestFilter =  $this->filter = [
            'sortBy'=>'nicename',
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
        $country = Country::find($id);
        if ($country)
        {
            $country->delete();
            $this->dispatch('SetMessage',type:'success',message:'Deleted Successfully');
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }
}
