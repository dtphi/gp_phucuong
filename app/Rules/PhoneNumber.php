<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class PhoneNumber
 *
 * @package App\Rules
 */
class PhoneNumber implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^(?:\d{2}-\d{4}-\d{4}|\d{3}-\d{3}-\d{4}|\d{3}-\d{4}-\d{4}|\d{3}-\d{4}-\d{5}|\d{4}-\d{2}-\d{4}|\d{4}-\d{3}-\d{3})$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return trans('validation.phone');
    }
}