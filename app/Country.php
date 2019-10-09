<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function has_states(){
        return $this->hasMany('App\State','country_id');
    }

}
