<?php

namespace App\Helpers\Imports;

use App\Models\ClaimAnswerHistoryLog;
use App\Models\ClaimHistoryLog;
use App\Models\ImportClaimHistory;
use App\Models\InsuranceClaim;
use App\Models\InsuranceFollowUp;

class ImportLogHelper
{
    public string $type = "old";

    public array $data = [];

    public $importData = [];

    public ImportClaimHistory $importHistory;
    public InsuranceClaim $insuranceClaim;

    public ?ClaimHistoryLog $claimLog;

    public function __construct($data,$insuranceClaim,$importHistory,$type,$importData = [])
    {
        $this->data = $data;
        $this->insuranceClaim = $insuranceClaim;
        $this->importHistory = $importHistory;
        $this->type = $type;

        $this->importData = $importData;
    }

    public function processLog(): void
    {
        switch ($this->type)
        {
            case "merged":
            case "import":
                break;
            default:
                $this->data = $this->insuranceClaim->only([
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
                    'note',
                    'claim_action',
                    'cof',
                    'nxt_flup_dt',
                    'eob_dl',
                    'team_worked',
                    'worked_by',
                    'worked_dt',
                    'follow_up_status'
                ]);

        }
        $this->generate();
    }

    protected function generate(): void
    {
        $this->claimLog = new ClaimHistoryLog();
        $this->claimLog->fill($this->data);
        $this->claimLog->fill([
            'parent_id'=>$this->insuranceClaim->id,
            'import_id'=>$this->importHistory->id,
            'type'=>$this->type
        ]);

        if ($this->type == "import")
        {
            $followUp = InsuranceFollowUp::where('name','LIKE',$this->importData['Follow-Up Status'] ??null)->first();
            if ($followUp){
                $this->claimLog->follow_up_status = $followUp->id;
            }
        }

        $this->claimLog->save();

        $this->createOrUpdateAnswers();
    }

    private function createOrUpdateAnswers(): void
    {
        if ($this->insuranceClaim->answers()->exists())
        {
            foreach ($this->insuranceClaim->answers as $answer)
            {
                ClaimAnswerHistoryLog::create([
                    'log_id'=>$this->claimLog->id,
                    'question'=>$answer->question,
                    'answer'=>$answer->answer,
                ]);
            }
        }
    }

}
