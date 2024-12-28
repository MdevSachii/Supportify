<?php

namespace App\Enums;

enum TicketStatus: string
{
    case NEW = 'New';
    case OPEN = 'Open';
    case RESOLVE = 'Resolved';
}
