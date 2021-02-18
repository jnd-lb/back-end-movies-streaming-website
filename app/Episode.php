<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable =['episode_name','visual_id','duration'];

    public function episodelink()
    {
        return $this->hasmany(EpisodeLink::class);
    }
}
