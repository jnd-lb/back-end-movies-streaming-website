<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode_streaming_link extends Model
{
    protected $table= 'episode_streaming_link';
    protected $fillable =['episode_id','streaming_link_id'];

    
}
