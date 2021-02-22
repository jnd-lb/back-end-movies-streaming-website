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
        return $this->belongsTo(Type::class, 'type_id');
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
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function descriptions() {
        return $this->hasOne(DescriptionVisual::class);
    }






}
