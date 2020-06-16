<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\HtmlString;

class Notice extends Model
{
    protected  $fillable = ['color', 'date', 'topic', 'title', 'body'];
    
    public function getNotice()
    {
        return new HtmlString($this->body);
    }
}