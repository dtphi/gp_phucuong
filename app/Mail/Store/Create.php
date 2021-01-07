<?php

namespace App\Mail\Store;

use Illuminate\Mail\Mailable;

/**
 * Class Create
 *
 * @package App\Mail\Store
 */
class Create extends Mailable
{
    public $data;

    public $subject;

    /**
     * Create constructor.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->subject = "[NiMo]新規登録完了(${data['code']}　${data['name']}様分）";
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
                    ->view('mail_templates.stores.create');
    }
}
