<?php

namespace App\Mail\Store;

use Illuminate\Mail\Mailable;

/**
 * Class ResetPassword
 *
 * @package App\Mail\Store
 */
class ResetPassword extends Mailable
{
    public $data;

    public $subject;

    /**
     * ResetPassword constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->subject = "[NiMo]パスワードの再発行（${data['name']}様分）";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject($this->subject)
                    ->view('mail_templates.stores.reset_password');
    }
}
