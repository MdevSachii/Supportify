<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ['ticket_id', 'agent_id', 'message'];

    public function agent()
    {
        return $this->belongsTo(User::class, 'agnet_id');
    }
}
