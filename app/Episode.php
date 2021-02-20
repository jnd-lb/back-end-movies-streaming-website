<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $table= 'episodes';
    protected $fillable =['episode_name','visual_id','duration'];

    public function downloadLinks()
    {
        return $this->belongsToMany('App\Download_Link','episode_download_link','episode_id','download_link_id');
    } 
    public function episodeStreamingLinks()
    {
        return $this->belongsToMany('App\Stream_Link','episode_streaming_link','episode_id','streaming_link_id');
    }
}
