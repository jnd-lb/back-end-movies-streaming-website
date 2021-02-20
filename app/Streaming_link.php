<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Streaming_link extends Model
{
    protected $fillable = ['description', 'link'];

    public function visuals() {
        return $this->belongsToMany(
            Visual::class,
            'streaming_link_visual',
            'streaming_link_id',
            'visual_id'
        );
    }

    public function episodes() {
        return $this->belongsToMany(Episode::class);
    }
}


