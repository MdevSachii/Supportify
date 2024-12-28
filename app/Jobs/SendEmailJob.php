<?php

namespace App\Jobs;

use App\Mail\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $emailAddress;

    protected $messageContent;

    public function __construct($emailAddress, $messageContent)
    {
        $this->emailAddress = $emailAddress;
        $this->messageContent = $messageContent;
    }

    public function handle()
    {
        Mail::to($this->emailAddress)->send(new Notifications($this->messageContent));
    }
}
