<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EpisodeLink extends Model
{
            protected $fillable = ['episode_id','streaming_link_id'];
    
            public function episode()
            {
                return $this->belongTo(Episode::class);
            }
            public function streamlink()
            {
                return $this->hasmany(StreamLink::class);
            }
}
