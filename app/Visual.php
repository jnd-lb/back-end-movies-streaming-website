<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visual extends Model
{
    protected $table= 'visuals';
    protected $fillable = ['movie_title','duration','language_id','description','movie_trailer','year','imdb_rating','type_id','poster_image_link','slug'];
    
    public function type()
    {
         return $this->belongsTo(Type::class);
    }
    public function language()
    {
         return $this->belongsTo(Language::class);
    }
    public function episode()
    {
         return $this->hasmany(Episode::class)
         ->with('downloadLinks')
         ->with('episodeStreamingLinks');
    }     
    public function genre()
    {
        return $this->belongsToMany('App\Genre','genre_visuals','vidsual_id','genre_id');
    }
    public function visualDescription()
    {
        return $this->hasMany(Visual_Description::class);
    }

}
