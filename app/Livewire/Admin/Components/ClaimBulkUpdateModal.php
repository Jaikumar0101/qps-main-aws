<?php

namespace App\Livewire\Admin\Components;

use App\Models\InsuranceClaim;
use App\Models\InsuranceClaimAnswer;
use App\Models\InsuranceClaimStatus;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use Livewire\Component;

class ClaimBulkUpdateModal extends Component
{
    public $parentRenderMethod = "parentRenderMethod";

    public $selected = [];
    public $request = [];

    public $editModal = false;

    protected function rules():array
    {
        return [];
    }

    public function mount()
    {
        $this->NewRequest();
    }

    public function render()
    {
        return view('livewire.admin.components.claim-bulk-update-modal');
    }

    #[On('openBulkFieldUpdateModal')]
    public function openBulkFieldUpdateModal($selected = []):void
    {
        $this->selected = $selected;
        $this->NewRequest();
        $this->editModal = true;
    }

    public function save():void
    {
        $this->updateClaims($this->request);
    }

    private function updateClaims($data = [])
    {
        try
        {
            $finalData = [];
            $data = collect($data)->where('update',1);
            foreach ($data as $key=>$item)
            {
                $finalData[$key] = $item['value'];
            }

            $claimStatus = null;

            if (Arr::has($finalData,'claim_status'))
            {
                $claimStatus = InsuranceClaimStatus::find($finalData['claim_status']);

                if ($claimStatus)
                {
                    $data['status_description'] = $claimStatus->note ??'';
                    $data['claim_action'] = $claimStatus->description ??'';
                }
            }

            InsuranceClaim::whereIn('id',$this->selected)
                ->update($finalData);

            if (Arr::has($finalData,'claim_status') && $claimStatus)
            {
                foreach ($this->selected as $modelId)
                {
                    $model = InsuranceClaim::find($modelId);
                    if ($model)
                    {
                        $ids = [];

                        foreach ($claimStatus->questions as $item)
                        {
                            $check = InsuranceClaimAnswer::where([
                                'claim_id'=>$model->id,
                                'question_id'=>$item->id,
                            ])->first();

                            if (!$check)
                            {
                                $check = new InsuranceClaimAnswer();
                            }

                            $check->fill([
                                'claim_id'=>$model->id,
                                'question_id'=>$item->id,
                                'question'=>$item->title ??'',
                            ]);

                            $check->save();

                            $ids[] = $check->id;

                        }

                        InsuranceClaimAnswer::where([
                            'claim_id'=>$model->id,
                        ])->whereNotIn('id',$ids)->delete();
                    }
                }
            }

            $this->editModal = false;
            $this->dispatch('SetMessage',
                type:'success',
                message:'Updated successfully',
            );
            $this->dispatch('resetSelectedRows');
            $this->dispatch($this->parentRenderMethod);
        }
        catch (\Exception $exception)
        {
            $this->dispatch('SetMessage',
                type:'error',
                message:$exception->getMessage()
            );
        }
    }

    public function NewRequest():void
    {
        $this->request = [
            'claim_status'=>[
                'value'=>null,
                'update'=>0,
            ],
            'follow_up_status'=>[
                'value'=>null,
                'update'=>0,
            ],
            'eob_dl'=>[
                'value'=>null,
                'update'=>0,
            ],
            'team_worked'=>[
                'value'=>null,
                'update'=>0,
            ],
            'cof'=>[
                'value'=>null,
                'update'=>0,
            ],
            'nxt_flup_dt'=>[
                'value'=>null,
                'update'=>0,
            ],
            'worked_dt'=>[
                'value'=>null,
                'update'=>0,
            ],
            'method'=>[
                'value'=>null,
                'update'=>0,
            ],
            'pms_note'=>[
                'value'=>null,
                'update'=>0,
            ],
            'note'=>[
                'value'=>null,
                'update'=>0,
            ],
        ];
    }
}
