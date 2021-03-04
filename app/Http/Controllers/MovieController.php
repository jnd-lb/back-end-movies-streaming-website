<?php

namespace App\Http\Controllers;

use App\Description;
use App\Download_link;
use App\Genre;
use App\Http\Requests\StoreVisualRequest;
use App\Streaming_link;
use App\Type;
use App\Visual;
//use Illuminate\Database\Query\Builder;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\DB;


class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function retrieve(){
        try{

            $visuals = Visual::with('genres')
            ->with("types")
            ->with("streaming_links")
                ->orderBy('movie_title', 'asc')
                ->paginate(10);

            return response()->json([
                'error'=>false,
                'message' => "The Download Link has been retrieved successfully",
                'visuals'=> $visuals
            ],200);
        }
        catch(\Illuminate\Database\QueryException $exception){
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured"
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visual = Visual::where('id',$id)->with('genre')
            
        ->with('types')
        ->with('visualDescription')
        ->orderBy('movie_title','ASC')
        ->get();
        

        if ($visual) {
            return response()->json([
                'message' => 'success retrieving visual with id '. $id,
                'error' => false,
                'data' => $visual
            ]);
        }
        return response()->json([
            'message' => 'failed getting speecified visual',
            'error' => true,
            'info' => error_log()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchByName(Request $request)
    {
        $visual = Visual::where([
            ['movie_title', '!=', Null],
            [function ($query) use ($request) {
                if ($movie_title = $request->get('movie_title')) {
                    $query->orWhere('movie_title', 'LIKE', '%'. $movie_title . '%')->get();
                }
            }]
        ])
            ->orderBy('movie_title', 'asc')
            ->paginate(10)
//            ->with('i', (request()->input('page', 1) - 1) * 5)
        ;

        if($visual) {
            return response()->json([
                'message' => 'visual found success',
                'error' => false,
                'data' => $visual,
            ], 200);
        }

        return response()->json([
            'message' => 'visual not found',
            'error' => true,
            'data' => error_log()
        ], 404);
    }

    /**
     * Search for movies based on specified query params.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchBy(Request $request)
    {
        try {

            /* -------------- List all request types -------------- */
            $genre = $request->get('genre');
            $year = $request->get('year');
            $type = $request->get('type');
            $language = $request->get('language');
            $imdb = $request->get('imdb');

            /* ------------------------------- start: Genre Query ------------------------------- */
            if ($genre) {
                $genreQuery = Visual::whereHas('genres', function ($query) use ($request) {
                    if ($genre = $request->get('genre')) {
                        $query
                            ->where('type_id', 3)
                            ->where('genre_in_english', $genre)
                        ;
                    }
                })
                    ->orderBy($genre, 'asc')
                    ->paginate(10);

                return response()->json([
                    'error'=>false,
                    'message' => "The genres has been retrieved successfully",
                    'visuals'=> $genreQuery
                ],200);
            }

            /* ------------------------------- End: Genre Query ------------------------------- */


            /* ------------------------------- start: Type Query ------------------------------- */
            if ($type) {
                $typeQuery = Visual::whereHas('types', function ($query) use ($request) {
                    if ($type = $request->get('type')) {
                        $query
                            ->where('type_in_english', $type);
                    }
                })
                    ->orderBy($type, 'asc')
                    ->paginate(10);

                return response()->json([
                    'error'=>false,
                    'message' => "The genres has been retrieved successfully",
                    'visuals'=> $typeQuery
                ],200);
            }

            /* ------------------------------- End: Type Query ------------------------------- */


            /* ------------------------------- start: Year Query ------------------------------- */

            if ($year) {
                $yearQuery = Visual::where(function ($query) use ($request) {
                    if ($year = $request->get('year')) {
                        $query
                            ->where('type_id', 3)
                            ->whereYear('year', $year);
                    }
                })
                    ->orderBy($year, 'asc')
                    ->paginate(10);

                return response()->json([
                    'error'=>false,
                    'message' => "The genres has been retrieved successfully",
                    'visuals'=> $yearQuery
                ],200);
            }

            /* ------------------------------- End: Year Query ------------------------------- */


            /* ------------------------------- start: Language Query ------------------------------- */

            if ($language) {
                $languageQuery = Visual::whereHas('languages', function ($query) use ($request) {
                    if ($language = $request->get('language')) {
                        $query
                            ->where('type_id', 3)
                            ->where('language_in_english', $language)
                            ->orWhere('language_in_arabic', $language)
                        ;
                    }
                })
                    ->orderBy($language, 'asc')
                    ->paginate(10);

                return response()->json([
                    'error'=>false,
                    'message' => "The " . $language .  " movies has been retrieved successfully",
                    'visuals'=> $languageQuery
                ],200);
            }

            /* ------------------------------- End: Language Query ------------------------------- */


            /* ------------------------------- start: IMDB Query ------------------------------- */

            if ($imdb) {
                $imdbQuery = Visual::where(function ($query) use ($request) {
                    if ($imdb = $request->get('imdb')) {
                        $query
                            ->where('type_id', 3)
                            ->where('imdb_rating', $imdb);
                    }
                })
                    ->orderBy($imdb, 'asc')
                    ->paginate(10);

                return response()->json([
                    'error'=>false,
                    'message' => "The movies with imdb: " . $imdb . "has been retrieved successfully",
                    'visuals'=> $imdbQuery
                ],200);
            }

            /* ------------------------------- End: IMDB Query ------------------------------- */


            return response()->json([
                        'error'=>false,
                        'message' => "No Queries performed",
                    ],200);

        } catch(\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured",
                'errorInfo' => $errorInfo
            ], 500);

        }

    }

//
//    public function movieSort(Request $request) {
//
//        try {
//
//        } catch(\Illuminate\Database\QueryException $exception) {
//            $errorInfo = $exception->errorInfo;
//            return response()->json([
//                'error' => true,
//                'message' => "Internal error occured",
//                'errorInfo' => $errorInfo
//            ], 500);
//
//        }
//    }
//


    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getAllYears() {
        $years = Visual::select('year')->get();

        if ($years) {
            return response()->json([
                'message' => 'success returning years',
                'error' => false,
                'data' => $years,
            ], 200);
        }
        return response()->json([
            'message' => 'failed returning years',
            'error' => true,
        ], 404);

    }

    /**
     * Store the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function uploadVisual(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'movie_title'       => 'required|max:255',
            'duration'          => 'required',
            'language_id'       => 'required',
            'movie_trailer'     => 'string|required',
            'year'              => 'date|required',
            'type_id'           => 'required',
            'poster_image_link' => 'required|regex:/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i',
            'slug'              => 'string',
        ]);

        try {
            $visual = new Visual();
            $visual->fill([
                'movie_title' => $request->get('movie_title'),
                'duration' => $request->get('duration'),
                'language_id' => $request->get('language_id'),
                'movie_trailer' => $request->get('movie_trailer'),
                'year' => $request->get('year'),
                'imdb_rating' => $request->get('imdb_rating'),
                'type_id' => $request->get('type_id'),
                'poster_image_link' => $request->get('poster_image_link'),
                'slug' => $request->get('slug')
            ]);

            $visual->save();


            /* -------------------------------- Start: add a description ---------------------------------- */

            $description = new Description();
            $description->visual_id = $visual->id;

            if ($request->get('description_in_arabic')) {
                $description->description_in_arabic = $request->get('description_in_arabic');
            }
            if ($request->get('description_in_english')) {
                $description->description_in_english = $request->get('description_in_english');
            }

            $description->save();

            /* -------------------------------- End: add a description ---------------------------------- */



            /* -------------------------------- Start: attach genre ---------------------------------- */

            $genres = array_map('intval', explode(',', $request->get('genres')));

            foreach ($genres as $genre) {
                $genre = new Genre();
                $genre->save();
            }

            // Insert the array into the pivot table
            $visual->genres()->attach($genres);


            /* -------------------------------- End: attach genre ---------------------------------- */



            /* -------------------------------- Start: attach streaming links ---------------------------------- */

            // Get the associated streaming links from the user and transfrom it into an array
            $slinks= array_map('intval', explode(',', $request->get('slinks')));

            foreach ($slinks as $slink) {
                $slink = new Streaming_link();
                $slink->save();
            }

            // Insert the array into the pivot table
            $visual->streaming_links()->attach($slinks);

            /* -------------------------------- End: attach streaming links ---------------------------------- */


            /* -------------------------------- Start: attach download links ---------------------------------- */

            $dlinks= array_map('intval', explode(',', $request->get('dlinks')));

            foreach ($dlinks as $dlink) {
                $dlink = new Download_link();
                $dlink->save();
            }

            // Insert the array into the pivot table
            $visual->download_links()->attach($dlinks);

            /* -------------------------------- End: attach download links ---------------------------------- */


            return response()->json([
                'message' => 'successfully uploaded visual',
                'error'   => false,
                'data'    => $visual
            ], 200);

        } catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured",
                'errormessage' => $errorInfo
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $visual = Visual::findOrFail($id);

        if ($visual) {
            $visual->update($request->all());

            return response()->json([
                'meesage' => 'visual updated',
                'error' => false,
                'data' => $visual
            ], 200);
        } else {

            return response()->json([
                'message' => 'failed updating visual',
                'error' => true,
            ], 404);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visual = Visual::findOrFail($id);

        if ($visual) {
            $visual->delete();
            return response()->json([
                'message' => 'successfully deleted visual with id = '. $id,
                'error' => false
            ], 200);
        }

        return response()->json([
            'message' => 'failed deletion.. visual not found',
            'error' => true,
        ], 404);
    }

    /**
     * get all movies streaming links.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function getStreamingLinks($id) {

        try {

            $visual_slinks = Visual::findOrFail($id)->streaming_links;

            return response()->json([
                'error' => false,
                'message' => "The streaming links for movies has been retrieved successfully",
                'data' => $visual_slinks
            ],201);

        } catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured",
                'data' => $errorInfo
            ], 500);
        }
    }

    public function getDownloadLinks($id)
    {
        try {

            $visual_dlinks = Visual::findOrFail($id)->download_links;

            return response()->json([
                'error' => false,
                'message' => "The streaming links for movies has been retrieved successfully",
                'data' => $visual_dlinks
            ], 201);

        } catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured",
                'data' => $errorInfo
            ], 500);
        }
    }



    public function getGenres($id)
    {
        try {

            $visual_genres = Visual::findOrFail($id)->genres;

            return response()->json([
                'error' => false,
                'message' => "The streaming links for movies has been retrieved successfully",
                'data' => $visual_genres
            ], 201);

        } catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured",
                'data' => $errorInfo
            ], 500);
        }
    }

}

