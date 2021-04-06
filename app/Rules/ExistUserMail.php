<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Admin;

class ExistUserMail implements Rule
{
    private $userId = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @author : Phi .
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $originUser = Admin::find($this->userId);

        if ($originUser->email == $value) {
            return true;
        } else {
            $member = Admin::where(['email' => $value])->get();

            return ($member->count() == 0);
        }
    }

    /**
     * @author : Phi .
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Một tài khoản đã tồn tại email!';
    }
}
