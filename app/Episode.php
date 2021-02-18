<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Utils;

class Episode extends Model
{
    protected $fillable = [
        'episode_name',
        'visual_id',
        'duration'
    ];

    public function visuals() {
        return $this->belongsTo(Visual::class);
    }

    public function streaming_links() {
        return $this->belongsToMany(Streaming_link::class);
    }

    public function download_links(){
        return $this->belongsToMany(Streaming_link::class);
    }
}
