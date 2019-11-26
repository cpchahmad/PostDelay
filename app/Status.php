<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [
        "name","phase",'description','color','subject','message','button_text'
    ];

}
