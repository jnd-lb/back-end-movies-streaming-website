<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode_Download_Link extends Model
{
    //
    protected $table = 'episode_download_link';
    protected $fillable = ['episode_id','download_link_id'];

    
}
