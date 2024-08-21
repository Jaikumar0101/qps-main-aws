<?php

namespace App\Livewire\Admin\AdsSpace;

use App\Models\Advertisement;
use App\Models\UserRole;
use Illuminate\Support\Str;
use Livewire\Component;
use Psy\Output\Theme;

class AdsAddEditPage extends Component
{
    public $ads_id;
    public array $request = [];

    protected array $validationAttributes = [
        'request.name'=>'name',
        'request.status'=>'status',
    ];

    protected function rules():array
    {
        return [
            'request.key'=>'required|min:4|unique:advertisements,key,'.$this->ads_id ??0,
            'request.name'=>'required|max:255',
            'request.image'=>'max:500',
            'request.url'=>'max:500',
        ];
    }

    public function mount()
    {
        if (checkData($this->ads_id))
        {
            $check = Advertisement::find($this->ads_id);
            $check?$this->EditRequest($check):redirect()->route('admin::ads:list')->withErrors('Invalid Ads Id');
        }
        else
        {
            $this->NewRequest();
        }
    }

    public function render()
    {
        return view('livewire.admin.ads-space.ads-add-edit-page')
            ->layout('layouts.admin.app');
    }

    public function Submit()
    {
        $this->validate($this->rules());
        $this->create($this->request);
    }

    private function create($data = [])
    {
        try
        {
            $check = Advertisement::create($data);
            $this->ads_id = $check->id;
            $this->dispatch('SweetMessage',
                type:'success',
                title:'New Advertisement',
                message:'Created Successfully',
                url:route('admin::ads:list')
            );
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',
                type:'error',
                message:$exception->getMessage()
            );
        }
    }

    public function Save()
    {
        $this->validate($this->rules());
        $this->update($this->request);
    }

    private function update($data = [])
    {
        try
        {
            $check = Advertisement::find($this->ads_id);
            $check->fill($data);
            $check->save();
            $this->dispatch('SweetMessage',
                type:'success',
                title:'Edit Advertisement',
                message:'Updated Successfully',
                url:route('admin::ads:list')
            );
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',
                type:'error',
                message:$exception->getMessage()
            );
        }
    }

    private function NewRequest()
    {
        $this->request = [
            'key'=>Str::upper(Str::random(8)),
            'name'=>null,
            'type'=>'image',
            'image'=>null,
            'embed_code'=>null,
            'url'=>null,
            'open_new_tab'=>1,
            'position'=>0,
            'status'=>1,
            'location'=>null,
            'expire_at'=>now()->addDays(14)->format('Y-m-d'),
        ];
    }

    private function EditRequest($check)
    {
        $this->request = $check->only([
            'key',
            'name',
            'type',
            'image',
            'embed_code',
            'url',
            'open_new_tab',
            'position',
            'status',
            'location',
            'expire_at',
        ]);
    }
}
