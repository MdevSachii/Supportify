<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'ticket_id');
    }
}
