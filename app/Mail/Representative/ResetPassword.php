<?php

namespace App\Mail\Representative;

use Illuminate\Mail\Mailable;

/**
 * Class ResetPassword
 *
 * @package App\Mail\Representative
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
        $this->subject = '[NiMo]パスワードの再発行';
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
                    ->view('mail_templates.sales_representatives.reset_password');
    }
}
