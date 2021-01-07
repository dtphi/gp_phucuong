<?php

namespace App\Mail\Store;

use Illuminate\Mail\Mailable;

/**
 * Class RequestPassword
 *
 * @package App\Mail\Store
 */
class RequestPassword extends Mailable
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
        $this->subject = "[NiMo]パスワードの再発行依頼（${data['name']}様分）";
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
                    ->view('mail_templates.stores.request_password');
    }
}
