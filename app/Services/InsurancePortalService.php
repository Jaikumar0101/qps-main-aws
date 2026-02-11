<?php

namespace App\Services;

use App\Repositories\Insurance\ClaimTableRepositoryInterface;
use App\Repositories\Insurance\InsuranceClaimRepositoryInterface;

class InsurancePortalService
{
    protected function insuranceClaims()
    {
        return app(InsuranceClaimRepositoryInterface::class);
    }

    public function claimsTable()
    {
        return app(ClaimTableRepositoryInterface::class);
    }
}
