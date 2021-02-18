<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StreamLink extends Model
{
            protected $fillable = ['description','link'];
            
            public function episodelink()
                {
                    return $this->belongsToMany(EpisodeLink::class);
                }
}
