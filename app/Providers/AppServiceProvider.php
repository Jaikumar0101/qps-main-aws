<?php

namespace App\Providers;

use App\Models\InsuranceClaim;
use App\Observers\InsuranceClaimObserver;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        HeadingRowFormatter::extend('custom', function ($value, $key) {
            return $value;
        });

        InsuranceClaim::observe(InsuranceClaimObserver::class);
    }
}
