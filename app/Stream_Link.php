<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stream_Link extends Model
{
    //
    protected $table = 'streaming_links';
    protected $fillable = ['description','link'];
    
   
}
