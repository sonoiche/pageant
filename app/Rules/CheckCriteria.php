<?php

namespace App\Rules;

use App\Models\Criteria;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckCriteria implements ValidationRule
{
    public $contest_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($contest_id)
    {
        $this->contest_id = $contest_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $percentage = Criteria::where('contest_id', $this->contest_id)->sum('percentage');
        $final      = $percentage + $value;

        if($final > 100) {
            $fail('The :attribute for this contest cannot be exceed to 100%. Please edit the criteria and make sure it will sum up to 100%. Current percentage is '.$percentage.'%');
        }
    }
}
