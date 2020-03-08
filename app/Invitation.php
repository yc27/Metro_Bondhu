<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'email', 'inviter_id', 'invitation_token', 'registered_at', 'is_active', 'is_used'
    ];
}