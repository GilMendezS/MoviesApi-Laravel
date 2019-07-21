<?php

namespace App\Http\Controllers\Api;

use App\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\MovieRepository;

class MovieController extends Controller
{
    private $repository;

    public function __construct(MovieRepository $repository){
        $this->middleware('auth:api')->only(['store','destroy','myMovies']);
        $this->repository = $repository;
    }
    /**
     * Display a listing of the resource of movies.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(!empty($request->query('name'))){
            $data = $this->repository->getMovieWithQuery($request->query('name'));
        }
        else {
            $page = request('page') ?? 1;
            $data = $this->repository->getMovies($page);
        }

        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage - favorite movie of user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->user()->hasMovie($request->id)){
            return response()->json([
                'message' => 'You already have the movie as favorite',
                'success' => FALSE
            ], 200);
        }
        try {

            $request->user()->movies()->create([
                'serialized_movie' => $request->all(),
            ]);
            return response()->json(['message' => 'Movie added as favorite', 'success' => TRUE], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error saving the movie',
                'success' => FALSE,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $movie = $this->repository->getMovie($id);
        if(!empty($movie)){
            return response()->json([
                'data' => $movie,
                'success' => TRUE,
            ], 200);

        }
        else {
            return response()->json([
                'data' => NULL,
                'message' => 'Error fetching data of the movie',
                'success' => FALSE,
            ], 404);
        }
    }

    /**
     * Show the favorits movies of user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function myMovies(Request $request)
    {
        return response()->json($request->user()->movies, 200);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        try {
            $movie->delete();
            return response()->json(['message' => 'Movie removed from favorites', 'success' => TRUE], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error removing the movie',
                'success' => FALSE,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
