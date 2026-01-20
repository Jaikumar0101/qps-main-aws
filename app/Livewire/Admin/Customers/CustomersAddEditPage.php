<?php

namespace App\Livewire\Admin\Customers;

use App\Models\Customer;
use Livewire\Component;

class CustomersAddEditPage extends Component
{
    public $customer_id;

    public $request = [];

    protected $validationAttributes = [
        'request.first_name'=>'name',
        'request.last_name'=>'company name',
        'request.email'=>'email',
        'request.phone'=>'phone',
    ];

    protected $rules = [
        'request.first_name'=>'required|max:255',
        'request.last_name'=>'required|max:255',
        'request.email'=>'max:255|nullable|email',
        'request.phone'=>'max:255',
    ];

    public function mount()
    {
        if (checkData($this->customer_id))
        {
            $check = Customer::find($this->customer_id);
            if (!$check)
            {
                return redirect()->route('admin::customers:list')->with('error','Invalid customer');
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
        return view('livewire.admin.customers.customers-add-edit-page');
    }

    public function Submit()
    {
        $this->validate($this->rules);
        $this->create($this->request);
    }

    private function create($data = [])
    {
        try
        {
            $check = Customer::create($data);
            $this->customer_id = $check->id;
            $this->dispatch('SweetMessage',
                type:'success',
                title:'New Client',
                message:'Added Successfully',
                url:route('admin::customers:list'),
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

    private function update($data = [])
    {
        try
        {
            $check = Customer::find($this->customer_id);
            $check->fill($data);
            $check->save();
            $this->dispatch('SweetMessage',
                type:'success',
                title:'Edit Client',
                message:'Updated Successfully',
                url:route('admin::customers:list'),
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
            'first_name',
            'last_name',
            'email',
            'phone',
            'dob',
            'dos',
            'address',
            'tax_id',
            'npi_number',
            'practice_management_software',
            'status',
        ]);
    }

    private function NewRequest():void
    {
        $this->request = [
            'first_name'=>null,
            'last_name'=>null,
            'email'=>null,
            'phone'=>null,
            'dob'=>null,
            'dos'=>null,
            'address'=>null,
            'tax_id'=>null,
            'npi_number'=>null,
            'practice_management_software'=>null,
            'status'=>1,
        ];
    }
}
