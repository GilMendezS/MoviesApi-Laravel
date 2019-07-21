<?php
namespace App\Repositories;

use App\Movie;
use GuzzleHttp\Client;
use App\Http\Resources\MovieResource;

class MovieRepository{
    const URI_MOVIEDB_API = "https://api.themoviedb.org";
    protected $http;
    protected $apikey;
    public function __construct(){
        $this->http = new Client(['base_uri' => self::URI_MOVIEDB_API, 'timeout' => 5]);
        $this->apikey = config('services.moviedb.api_key');
    }
    public function getMovies($page = 1){
        $response = $this->http->request('GET', "/3/movie/popular?api_key=$this->apikey&page=$page");
        //check response status ex: 200 is 'OK'
        if ($response->getStatusCode() == 200) { 
             //get body content
            $data = $response->getBody()->getContents();   
            $movies = json_decode($data,true);
            $count = 0;
            foreach($movies['results'] as $movie)
            {
                 $movie['poster_path'] = Movie::URI_FOR_IMAGES . $movie['poster_path'];
                 $movies['results'][$count] = $movie;
                 $count++;
            }
            return $movies;
        }
        else {
            return array('success' => FALSE, 'message' => 'Error fetching movies from api');
        }
    }
    public function getMovieWithQuery($query = ''){
        $query = "/3/search/movie?api_key=$this->apikey&query=$query";
        $response = $this->http->request('GET', $query);
        //check response status ex: 200 is 'OK'
        if ($response->getStatusCode() == 200) { 
             //get body content
            $data = $response->getBody()->getContents();   
            $movies = json_decode($data,true);
            $count = 0;
            foreach($movies['results'] as $movie)
            {
                 $movie['poster_path'] = Movie::URI_FOR_IMAGES . $movie['poster_path'];
                 $movies['results'][$count] = $movie;
                 $count++;
            }
            return $movies;
             return array('success' => TRUE, 'data' => $bodyContent);
        }
        else {
            return array('success' => FALSE, 'message' => 'Error fetching movies from api');
        }
    }
    public function getMovie($movieId){
        try {
            $response = $this->http->request('GET', "/3/movie/$movieId?api_key=$this->apikey");
            //check response status ex: 200 is 'OK'
            if ($response->getStatusCode() == 200) { 
                //get body content
                $data = $response->getBody()->getContents();   
                $movie = json_decode($data,true);
                return MovieResource::make($movie)->resolve();
                
            }
            else {
                return array('success' => FALSE, 'message' => 'Error fetching movie from api');
            }
        } catch (\Exception $e) {
            return array('success' => FALSE, 'message' => 'Error fetching movie from api');
        }
        
    }
}

?>