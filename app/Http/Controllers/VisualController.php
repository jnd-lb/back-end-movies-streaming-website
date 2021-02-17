<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisualRequest;
use App\Visual;
use Illuminate\Http\Request;

class VisualController extends Controller
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
    public function uploadVisual(StoreVisualRequest $request)
    {
        $visual = new Visual();
        $visual->fill($request->all());

        if ($request->hasFile('poster_image_link')) {
            $poster_image = $request->file('poster_image_link');
            $movie_name = $request->get('movie_title');
            $filename = $movie_name. '.' . $poster_image->getClientOriginalExtension();
            $poster_image->storeAs('public/images/'. $request->get('language_id', $filename) );
            $visual->poster_image = $poster_image->hashName();
        }

        if ($visual) {
            return response()->json([
                'message' => 'successfully uploaded visual',
                'error'   => false,
                'data'    => $visual
            ], 200);
        }

        return response()->json([
            'message' => 'failed uploading visual',
            'error' => true,
            'data'  => error_log()
        ], 404);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
