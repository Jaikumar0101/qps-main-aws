<?php

namespace App\Livewire\Admin\Insurance;

use App\Models\InsuranceClaimStatus;
use App\Models\InsuranceClaimStatusQuestion;
use Illuminate\Support\Arr;
use Livewire\Component;

class StatusQuestionPage extends Component
{
    public $status_id;
    public $insuranceStatus;

    public $request = [];

    protected $validationAttributes = [
        'request.*.title'=>'title',
    ];

    protected $rules = [
        'request.*.title'=>'required',
    ];

    public function mount()
    {
        if(checkData($this->status_id))
        {
            $this->insuranceStatus = InsuranceClaimStatus::find($this->status_id);
            if(!$this->insuranceStatus)
            {
                return redirect()->route('admin::insurance-grouping:status.list')->with('error','Invalid Status');
            }
            $this->EditRequest();
        }
        else
        {
            return redirect()->route('admin::insurance-grouping:status.list')->with('error','Invalid Status');
        }
    }

    public function render()
    {
        return view('livewire.admin.insurance.status-question-page');
    }

    public function Save()
    {
        $this->validate($this->rules);
        try
        {
            $ids = [];
            foreach ($this->request as $i=>$item)
            {
                $check = null;
                if (Arr::has($item,'id'))
                {
                    $check = InsuranceClaimStatusQuestion::find($item['id']);
                }

                if (!$check)
                {
                    $check = new InsuranceClaimStatusQuestion();
                }

                $check->fill($item);
                $check->save();

                $ids[] = $this->request[$i]['id'] = $check->id;
            }

            InsuranceClaimStatusQuestion::where('status_id',$this->insuranceStatus->id)
                ->whereNotIn('id',$ids)
                ->delete();

            $this->dispatch('SweetMessage',
                type:'success',
                title:'Status Questions',
                message:'Saved Successfully',
                url:route('admin::insurance-grouping:status.list'),
            );

        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }

    private function EditRequest()
    {
        $this->request = InsuranceClaimStatusQuestion::where('status_id',$this->insuranceStatus->id)
            ->get([
                'id',
                'status_id',
                'title',
                'description',
                'position',
                'status',
            ])->toArray();
    }

    public function addNewQuestion():void
    {
        $this->request[] = [
            'status_id'=>$this->insuranceStatus->id,
            'title'=>null,
            'description'=>null,
            'position'=>0,
            'status'=>1,
        ];
    }

    public function removeQuestion($index = null):void
    {
        if (Arr::has($this->request,$index))
        {
            $temp = $this->request;
            Arr::forget($temp,$index);
            $this->request = array_values($temp);
        }
    }
}
