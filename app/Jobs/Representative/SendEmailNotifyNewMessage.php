<?php

namespace App\Jobs\Representative;

use App\Mail\Representative\NotifyNewMessage;
use App\Models\Representative;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendEmailNotifyNewMessage
 *
 * @package App\Jobs\Representative
 */
class SendEmailNotifyNewMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $representative;

    protected $email;

    /**
     * SendEmailNotifyNewMessage constructor.
     *
     * @param Representative $representative
     * @param array          $email
     */
    public function __construct(Representative $representative, array $email)
    {
        $this->representative = $representative;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->representative->main_email)->send(new NotifyNewMessage($this->email));
    }
}
