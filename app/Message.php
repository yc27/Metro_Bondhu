<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Support\HtmlString;

class Message extends Model
{
    protected $fillable = ['name', 'mail', 'massage', 'is_opened'];

    public function getMessage()
    {
        return new HtmlString($this->message);
    }
}