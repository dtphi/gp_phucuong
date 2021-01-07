<?php

namespace App\Mail\Representative;

use Illuminate\Mail\Mailable;

/**
 * Class NotifyMessage
 *
 * @package App\Mail\Representative
 */
class NotifyMessage extends Mailable
{
    public $data;

    public $subject;

    /**
     * NotifyNewMessage constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->subject = "[NiMo]メッセージ転送（${data['name']}様分）";
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
                    ->view('mail_templates.sales_representatives.notify_message');
    }
}
