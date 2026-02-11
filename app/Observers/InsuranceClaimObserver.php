<?php

namespace App\Observers;

use App\Enums\Insurance\FollowUpDaysEnum;
use App\Models\InsuranceClaim;
use Carbon\Carbon;

class InsuranceClaimObserver
{
    /**
     * Handle the InsuranceClaim "created" event.
     */
    public function created(InsuranceClaim $insuranceClaim): void
    {
        if($insuranceClaim->followUpModal()->exists()){

            $followUpName = $insuranceClaim->followUpModal->name;

            $enumCase = FollowUpDaysEnum::tryFrom($followUpName);

            if ($enumCase) {
                $days = $enumCase->getDays();

                if ($days > 0) {
                    $insuranceClaim->nxt_flup_dt = Carbon::now()->addDays($days)->format('Y-m-d');
                    $insuranceClaim->saveQuietly();
                }
            }
        }
    }

    /**
     * Handle the InsuranceClaim "updated" event.
     */
    public function updated(InsuranceClaim $insuranceClaim): void
    {
        if ($insuranceClaim->wasChanged('follow_up_status') && $insuranceClaim->followUpModal()->exists()) {
            $followUpName = $insuranceClaim->followUpModal->name;

            $enumCase = FollowUpDaysEnum::tryFrom($followUpName);

            if ($enumCase) {
                $days = $enumCase->getDays();

                if ($days > 0) {
                    $insuranceClaim->nxt_flup_dt = Carbon::now()->addDays($days)->format('Y-m-d');
                    $insuranceClaim->saveQuietly();
                }
            }
        }
    }

    /**
     * Handle the InsuranceClaim "deleted" event.
     */
    public function deleted(InsuranceClaim $insuranceClaim): void
    {
        //
    }

    /**
     * Handle the InsuranceClaim "restored" event.
     */
    public function restored(InsuranceClaim $insuranceClaim): void
    {
        //
    }

    /**
     * Handle the InsuranceClaim "force deleted" event.
     */
    public function forceDeleted(InsuranceClaim $insuranceClaim): void
    {
        //
    }
}
