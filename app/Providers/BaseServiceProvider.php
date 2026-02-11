<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\InsurancePortalService;
use App\Repositories\Insurance\InsuranceClaimRepositoryInterface;
use App\Repositories\Insurance\InsuranceClaimRepository;
use App\Repositories\Insurance\ClaimTableRepositoryInterface;
use App\Repositories\Insurance\ClaimTableRepository;

class BaseServiceProvider extends ServiceProvider
{
    public $repositories = [
        InsuranceClaimRepositoryInterface::class =>
        InsuranceClaimRepository::class,

        ClaimTableRepositoryInterface::class =>
        ClaimTableRepository::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind all repositories
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }

        // Bind the InsurancePortalService
        $this->app->singleton('insurance_claim_portal', function ($app) {
            return new InsurancePortalService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
