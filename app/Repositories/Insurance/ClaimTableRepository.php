<?php

namespace App\Repositories\Insurance;

use App\Helpers\ClaimHelper;
use App\Models\InsuranceClaim;

class ClaimTableRepository implements ClaimTableRepositoryInterface
{
    public function getRowColor(InsuranceClaim $insuranceClaim, array $closedStatus = [])
    {
        if ($insuranceClaim->trashed()) {
            return 'bg-table-primary text-dark';
        }

        if (in_array($insuranceClaim->id, $closedStatus)) {
            return 'bg-table-success text-white ';
        }

        $days = $insuranceClaim->followDaysRemaining();

        return match (true) {
            $days < 0    => 'bg-table-danger text-dark ', // Any date in the past
            $days === 0  => 'bg-table-orange text-dark ', // Due today
            $days <= 2   => 'bg-table-warning text-dark ', // 1 or 2 days remaining
            default      => '',                               // 3 or more days / no date
        };
    }

    public function getClosedFollowUpStatus()
    {
        return ClaimHelper::closedFollowUp();
    }
}
