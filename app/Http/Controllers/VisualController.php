<?php

namespace App\Http\Controllers;

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
        //
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
        ]);
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
