<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class KatakanaAndSpace
 *
 * @package App\Rules
 */
class KatakanaAndSpace implements Rule
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
        if (preg_match('/^[ 　]+$/u', $value)) {
            return false;
        }
        $text = mb_convert_kana($value, 'K', 'UTF-8');

        return preg_match('/^[ァ-ヶー 　]+$/u', $text);
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return trans('validation.katakana');
    }
}