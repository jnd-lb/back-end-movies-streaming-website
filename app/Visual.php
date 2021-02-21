<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visual extends Model
{
    protected $fillable = [
        'movie_title',
        'duration',
        'language_id',
        'description',
        'movie_trailer',
        'year',
        'imdb_rating',
        'type_id',
        'poster_image_link',
        'slug',
    ];

    // relation to types table
    public function types()
    {
        return $this->hasOne(Type::class);
    }

    // Ask about the language table (it should be many-to-many)

    public function episodes() {
        return $this->hasMany(Episode::class);
    }

    public function streaming_links() {
        return $this->belongsToMany(
            Streaming_link::class,
            'streaming_link_visual',
            'visual_id',
            'streaming_link_id'
        );
    }

    public function download_links() {
        return $this->belongsToMany(Download_link::class);
    }

    public function genres() {
       return $this->belongsToMany(Genre::class);
    }

    public function languages() {
        return $this->hasOne(Language::class);
    }

    public function descriptions() {
        return $this->hasOne(DescriptionVisual::class);
    }







}
