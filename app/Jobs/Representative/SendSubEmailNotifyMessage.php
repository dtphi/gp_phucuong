<?php

namespace App\Jobs\Representative;

use App\Mail\Representative\NotifyMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

/**
 * Class SendSubEmailNotifyMessage
 *
 * @package App\Jobs\Representative
 */
class SendSubEmailNotifyMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $subEmailAddresses;

    protected $email;

    /**
     * SendSubEmailNotifyMessage constructor.
     *
     * @param array $subEmailAddresses
     * @param array $email
     */
    public function __construct(array $subEmailAddresses, array $email)
    {
        $this->subEmailAddresses = $subEmailAddresses;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->subEmailAddresses as $subEmailAddress) {
            if ($subEmailAddress) {
                Mail::to($subEmailAddress)->send(new NotifyMessage($this->email));
            }
        }
    }
}
