<?php

namespace App\Http\Resources;

use App\Movie;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource movie into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource['id'],
            'title' => $this->resource['title'],
            'overview' => $this->resource['overview'],
            'backdrop_path' => $this->resource['backdrop_path'],
            'poster_path' => Movie::URI_FOR_IMAGES . $this->resource['poster_path'],
            'adult' => $this->resource['adult'],
            'genres' => $this->resource['genres'],
            'release_date' => $this->resource['release_date'],
            'status' => $this->resource['status'],
            'vote_average' => $this->resource['vote_average'],
        ];
    }
}
