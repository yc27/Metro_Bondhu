<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WayPoint extends Model
{
    protected $fillable = ['way_point_lat', 'way_point_lng'];
}