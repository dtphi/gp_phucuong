<?php

namespace App\Jobs\Store;

use App\Mail\Store\NotifyNewMessage;
use App\Models\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendEmailNotifyNewMessage
 *
 * @package App\Jobs\Store
 */
class SendEmailNotifyNewMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $store;

    protected $email;

    /**
     * SendEmailNotifyNewMessage constructor.
     *
     * @param Store $store
     * @param array $email
     */
    public function __construct(Store $store, array $email)
    {
        $this->store = $store;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails = [
            $this->store->main_email,
            $this->store->sub_email1,
            $this->store->sub_email2,
            $this->store->sub_email3,
            $this->store->sub_email4
        ];

        foreach ($emails as $email) {
            if ($email) {
                Mail::to($email)->send(new NotifyNewMessage($this->email));
            }
        }
    }
}
