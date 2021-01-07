<?php

namespace App\Mail\Store;

use Illuminate\Mail\Mailable;

/**
 * Class ResetPassword
 *
 * @package App\Mail\Representative
 */
class Reorder extends Mailable
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
        $this->subject = '[NiMo]発注依頼（' . $data['store_name'] . ' 様）';
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
                    ->view('mail_templates.stores.reorder');
    }
}
