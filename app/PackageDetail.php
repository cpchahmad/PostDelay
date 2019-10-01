<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PackageDetail extends Model
{
   protected $fillable = [
     'type','shape','special_holding','scale','height','weight','length','width','girth'
   ];
}
