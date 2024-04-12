<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class DueDateRangeFormat implements Rule // ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    /* public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    } */

    public function passes($attribute, $value)
    {
        // Validate the format of $value (expecting two dates separated by '\')
        $dates = explode('\\', $value);
        return count($dates) === 2 && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dates[0]) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dates[1]);
    }
    
    public function message()
    {
        return 'The :attribute must be in the format YYYY-MM-DD\YYYY-MM-DD.';
    }
}
