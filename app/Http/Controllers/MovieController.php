<?php

namespace App\Http\Controllers;

use App\Download_link;
use App\Http\Requests\StoreVisualRequest;
use App\Streaming_link;
use App\Visual;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Psy\Util\Str;
use Symfony\Component\Console\Input\Input;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $visual = Visual::where('id',$id)->get();

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

            /* -------------------------------- Start: attach streaming links ---------------------------------- */

            // Get the associated streaming links from the user and transfrom it into an array
            $slinks= array_map('intval', explode(',', $request->get('slinks')));

            foreach ($slinks as $slink) {
                $slink = new Streaming_link();
                $slink->save();
            }

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

            $visual = Visual::findOrFail($id)->streaming_links;

            return response()->json([
                'error' => false,
                'message' => "The streaming links for movies has been retrieved successfully",
                'data' => $visual
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

            $visual = Visual::findOrFail($id)->download_links;

            return response()->json([
                'error' => false,
                'message' => "The streaming links for movies has been retrieved successfully",
                'data' => $visual
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

