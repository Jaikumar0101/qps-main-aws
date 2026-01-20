<?php

namespace App\Livewire\Admin\InsuranceClaim;

use App\Helpers\Role\RoleHelper;
use App\Models\Customer;
use App\Models\InsuranceClaim;
use App\Models\InsuranceClaimAnswer;
use App\Models\InsuranceClaimStatus;
use App\Models\User;
use Livewire\Component;

class InsuranceClaimAddEditPage extends Component
{
    public $claim_id;

    public $request = [];
    public $questionAnswers = [];

    public $backUrl;

    public $adminUser,$customers = [];

    protected $validationAttributes = [
        'request.ins_name'=>'ins name',
        'request.ins_phone'=>'ins phone',
        'request.patent_name'=>'patent name',
    ];

    protected function rules()
    {
        return [
            'request.ins_name'=>'nullable|max:255',
            'request.ins_phone'=>'nullable|max:255',
            'request.patent_name'=>'nullable|max:255',
        ];
    }

    public function mount()
    {
        if (checkData($this->claim_id))
        {
            $check = InsuranceClaim::find($this->claim_id);

            if($check)
            {
               $this->EditRequest($check);
            }
            else
            {
                return redirect()->route('admin::insurance-claim:list')->with('error','Invalid Claim Id');
            }
        }
        else
        {
            $this->NewRequest();
        }
        $this->backUrl = back()->getTargetUrl();

        $this->adminUser = User::find(auth()->user()->id);
        $this->customers = RoleHelper::getUserCustomers($this->adminUser);
    }

    public function render()
    {
        return view('livewire.admin.insurance-claim.insurance-claim-add-edit-page');
    }

    public function Submit()
    {
        $this->validate($this->rules());
        $this->create($this->request);
    }

    protected function create($data)
    {
        try
        {
            $check = InsuranceClaim::create($data);
            $this->claim_id = $check->id;
            $this->createOrUpdateAnswers();
            $this->dispatch('SweetMessage',
                type:'success',
                title:'New Insurance Claim',
                message:'Added Successfully',
                url:route('admin::insurance-claim:list'),
            );
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }

    public function Save()
    {
        $this->validate($this->rules());
        $this->update($this->request);
    }

    protected function update($data)
    {
        try
        {
            $check = InsuranceClaim::find($this->claim_id);
            $check->fill($data);
            $check->save();
            $this->createOrUpdateAnswers();
            $this->dispatch('SweetMessage',
                type:'success',
                title:'Edit Insurance Claim',
                message:'Updated Successfully',
                url:route('admin::insurance-claim:list'),
            );
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',type:'error',message:$exception->getMessage());
        }
    }
    protected function createOrUpdateAnswers(): void
    {
        $ids = [];
        foreach ($this->questionAnswers as $i=>$item)
        {
            $check = null;

            if (\Arr::has($item,'id'))
            {
                $check = InsuranceClaimAnswer::where([
                    'id'=>$item['id'],
                    'claim_id'=>$this->claim_id,
                    'question_id'=>$item['question_id'],
                ])->first();

                if (!$check)
                {
                    $check = new InsuranceClaimAnswer();
                    $check->fill([
                        'claim_id'=>$this->claim_id,
                        'question_id'=>$item['question_id'],
                    ]);
                }

                $check->fill([
                    'question'=>$item['question'],
                    'answer'=>$item['answer'],
                ]);

                $check->save();

                $ids[] = $this->questionAnswers[$i]['id'] = $check->id;
            }

        }

        InsuranceClaimAnswer::where('claim_id',$this->claim_id)
            ->whereNotIn('id',$ids)->delete();
    }

    private function EditRequest($check):void
    {
        $this->request = $check->only([
            'customer_id',
            'ins_name',
            'ins_phone',
            'sub_id',
            'sub_name',
            'patent_id',
            'patent_name',
            'dob',
            'dos',
            'sent',
            'total',
            'days',
            'days_r',
            'prov_nm',
            'location',
            'claim_status',
            'status_description',
            'claim_action',
            'note',
            'cof',
            'nxt_flup_dt',
            'eob_dl',
            'team_worked',
            'worked_by',
            'worked_dt',
            'follow_up_status'
        ]);

        $this->questionAnswers = InsuranceClaimAnswer::where('claim_id',$check->id)
            ->get([
                'id',
                'claim_id',
                'question_id',
                'question',
                'answer',
            ])->toArray();
    }

    private function NewRequest(): void
    {
        $this->request = [
            'customer_id'=>null,
            'ins_name'=>null,
            'ins_phone'=>null,
            'sub_id'=>null,
            'sub_name'=>null,
            'patent_id'=>null,
            'patent_name'=>null,
            'dob'=>null,
            'dos'=>null,
            'sent'=>null,
            'total'=>null,
            'days'=>null,
            'days_r'=>null,
            'prov_nm'=>null,
            'location'=>null,
            'claim_status'=>null,
            'status_description'=>null,
            'note'=>null,
            'claim_action'=>null,
            'cof'=>null,
            'nxt_flup_dt'=>null,
            'eob_dl'=>null,
            'team_worked'=>null,
            'worked_by'=>null,
            'worked_dt'=>null,
            'follow_up_status'=>null,
        ];
    }

    public function updatedRequestClaimStatus(): void
    {
        $claimStatus = InsuranceClaimStatus::find($this->request['claim_status']);
        if ($claimStatus)
        {
            $this->request['status_description'] = $claimStatus->note;
            $this->request['claim_action'] = $claimStatus->description;
            $this->questionAnswers = [];

            foreach ($claimStatus->questions as $item)
            {
                $this->questionAnswers[] = [
                    'claim_id'=>$this->claim_id,
                    'question_id'=>$item->id,
                    'question'=>$item->title ??'',
                    'answer'=>null,
                ];
            }

        }
        else
        {
            $this->request['claim_action']  =  $this->request['status_description'] = null;
            $this->questionAnswers = [];
        }
    }

}
