<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    protected $fillable = ['day_id', 'section_id', 'period_id', 'subject_id', 'teacher_id', 'room'];
}