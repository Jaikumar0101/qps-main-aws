<?php

namespace App\Livewire\Admin\Insurance;

use App\Models\InsuranceClaimStatus;
use Livewire\Component;

class StatusAddEditPage extends Component
{
    public $status_id;

    public $request = [];

    protected $validationAttributes = [
        'request.name'=>'name',
        'request.description'=>'description',
        'request.note'=>'note',
    ];

    protected $rules = [
        'request.name'=>'required|max:255',
        'request.description'=>'max:500',
        'request.note'=>'max:5000',
    ];

    public function mount()
    {
        if(checkData($this->status_id))
        {
            $check = InsuranceClaimStatus::find($this->status_id);
            if(!$check)
            {
                return redirect()->route('admin::insurance-grouping:status.list')->with('error','Invalid Status');
            }
            $this->EditRequest($check);
        }
        else
        {
            $this->NewRequest();
        }
    }

    public function render()
    {
        return view('livewire.admin.insurance.status-add-edit-page');
    }

    public function Submit()
    {
        $this->validate($this->rules);
        $this->create($this->request);
    }

    protected function create($data = [])
    {
        try
        {
            $check = InsuranceClaimStatus::create($data);
            $this->status_id = $check->id;
            $this->dispatch('SweetMessage',
                type:'success',
                title:'New Status',
                message:'Added Successfully',
                url:route('admin::insurance-grouping:status.list'),
            );
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }

    public function Save()
    {
        $this->validate($this->rules);
        $this->update($this->request);
    }

    protected function update($data = [])
    {
        try
        {
            $check = InsuranceClaimStatus::find($this->status_id);
            $check->fill($data);
            $check->save();

            $this->dispatch('SweetMessage',
                type:'success',
                title:'Edit Status',
                message:'Updated Successfully',
                url:route('admin::insurance-grouping:status.list'),
            );
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }

    private function EditRequest($check):void
    {
        $this->request = $check->only([
            'name',
            'description',
            'note',
            'position',
            'status',
        ]);
    }

    private function NewRequest():void
    {
        $this->request = [
            'name'=>null,
            'description'=>null,
            'note'=>null,
            'position'=>0,
            'status'=>1,
        ];
    }
}
