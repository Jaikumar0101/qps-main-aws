<?php

namespace App\Rules;

use App\Models\ClientAssign;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ClaimClientCheckRule implements ValidationRule
{
    public User $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->user->canAccess('claim::import'))
        {
            $check = ClientAssign::where([
                'user_id'=>$this->user->id,
                'customer_id'=>$value ??null,
            ])->count();
            if ($check == 0)
            {
                $fail('The selected customer is not assigned to this user.');
            }
        }

    }
}
