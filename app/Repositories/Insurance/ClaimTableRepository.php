<?php

namespace App\Repositories\Insurance;

use App\Helpers\ClaimHelper;
use App\Models\InsuranceClaim;

class ClaimTableRepository implements ClaimTableRepositoryInterface
{
    public function getRowColor(
        InsuranceClaim $insuranceClaim,
        array $closedStatus = []
    )
    {
        if ($insuranceClaim->trashed()) {
            return 'bg-light-primary text-dark';
        }

        if(in_array($insuranceClaim->id, $closedStatus)) {
            return 'bg-success text-white activeTag';
        }

        return '';
    }

    public function getClosedFollowUpStatus()
    {
        return ClaimHelper::closedFollowUp();
    }
}
