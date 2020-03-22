<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'source_lat', 'source_lng', 'destination_lat', 'destination_lng'
    ];
}