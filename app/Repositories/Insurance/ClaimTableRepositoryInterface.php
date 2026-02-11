<?php

namespace App\Repositories\Insurance;

use App\Models\InsuranceClaim;

interface ClaimTableRepositoryInterface
{
    public function getRowColor(InsuranceClaim $insuranceClaim, array $closedStatus = []);
    public function getClosedFollowUpStatus();
}
