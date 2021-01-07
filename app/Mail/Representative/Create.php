<?php

namespace App\Mail\Representative;

use Illuminate\Mail\Mailable;

/**
 * Class Create
 *
 * @package App\Mail\Representative
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
        $this->subject = '[NiMo]新規登録完了';
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
                    ->view('mail_templates.sales_representatives.create');
    }
}
