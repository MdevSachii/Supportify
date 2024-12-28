<?php

namespace App\Services;

use App\Jobs\SendEmailJob;
use App\Models\Ticket;

class EmailService
{
    public function opentTicket(Ticket $ticket)
    {
        $emailAddress = $ticket->customer->email;
        $messageContent = [
            'title' => 'Ticket Opened Successfully',
            'body' => "Your ticket has been successfully opened. The ticket reference number is: {$ticket->reference_number}",
        ];

        dispatch(new SendEmailJob($emailAddress, $messageContent));
    }

    public function replyToTicket(Ticket $ticket)
    {
        $emailAddress = $ticket->customer->email;
        $messageContent = [
            'title' => 'Received Ticket Reply',
            'body' => "The Support Agent has replied to your ticket. Please check the reply using this reference number: {$ticket->reference_number}",
        ];

        dispatch(new SendEmailJob($emailAddress, $messageContent));
    }
}
