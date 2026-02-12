<?php

namespace App\Repositories\Insurance;

use App\Helpers\ClaimHelper;
use App\Models\InsuranceClaim;

class ClaimTableRepository implements ClaimTableRepositoryInterface
{
    public function getRowColor(InsuranceClaim $insuranceClaim, array $closedStatus = [])
    {
        if ($insuranceClaim->trashed()) {
            return 'bg-light-primary text-dark';
        }

        if (in_array($insuranceClaim->id, $closedStatus)) {
            return 'bg-success text-white activeTag';
        }

        $days = $insuranceClaim->followDaysRemaining();

        return match (true) {
            $days < 0    => 'bg-danger text-white activeTag', // Any date in the past
            $days === 0  => 'bg-orange text-white activeTag', // Due today
            $days <= 2   => 'bg-warning text-dark activeTag', // 1 or 2 days remaining
            default      => '',                               // 3 or more days / no date
        };
    }

    public function getClosedFollowUpStatus()
    {
        return ClaimHelper::closedFollowUp();
    }
}
