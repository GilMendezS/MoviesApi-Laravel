<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    const URI_FOR_IMAGES = 'https://image.tmdb.org/t/p/w500';// domain to fetch images
    protected $table = 'movies';

    protected $fillable = [
        'user_id','serialized_movie'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    //serialize data before to save in db
    public function setSerializedMovieAttribute($value)
    {
        $this->attributes['serialized_movie'] = serialize($value);
    }
    //getter to know id if the movie in api and our own db
    public function getSerializedMovieAttribute($value)
    {
        $movieInformation =  unserialize($value);
        $movieInformation['movie_id'] = $movieInformation['id'];
        return $movieInformation;
    }
}
