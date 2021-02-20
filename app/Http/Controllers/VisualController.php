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
        
        try{
                $visuals = Visual::orderBy('movie_title','ASC')
                ->with('genre')
                ->get();
                
            if($visuals){ 
                return response($visuals);
            }
            return response()->json([
                'message'=>"empty"
            ], 404);
            }
            catch(Exception $e)
            {
                return response()->json([
                    'message'=> $e
        
                ],500);
            };
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
     * @param  \App\Visual  $visual
     * @return \Illuminate\Http\Response
     */
    public function show( $filter ,$param)
    {
        if($filter=='type')
        {
            if($param =='serie')
            {
               
                $visuals = Visual::with('type')
                ->where('type_id',3)
                ->with('genre')
                ->with('episode')
                ->with('visualDescription')
                ->get();
                return response($visuals);
            }
            else if($param=='tv show')
            {
               
                $visuals = Visual::with('type')
                ->where('type_id',1)
                ->with('genre')
                ->with('episode')
                ->with('visualDescription')
                ->get();
                return response($visuals);
            }else if($param=='movie')
            {
               
                $visuals = Visual::with('type')
                ->where('type_id',2)
                ->with('genre')
                ->with('visualDescription')
                ->get();
                return response($visuals);
            }else
            {
                return response()->json([
                    'message'=>"params not found"
                ], 404);
            }
        }
        else if($filter=='year')
        {
            
            $visuals = Visual::whereYear('year', $param)->get();
            return response($visuals);
        }
        else
        {
            return response()->json([
                'message'=>"params not found"
            ], 404);
        }
    }

    public function showById( $id)
    {
       
               
                $visuals = Visual::where('id',$id)
                ->with('type')
                ->with('genre')
                ->with('episode')
                ->with('visualDescription')
                ->get();
                return response($visuals);
           
                return response()->json([
                    'message'=>"params not found"
                ], 404);
          
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Visual  $visual
     * @return \Illuminate\Http\Response
     */
    public function edit(Visual $visual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Visual  $visual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visual $visual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visual  $visual
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visual $visual)
    {
        //
    }
}
