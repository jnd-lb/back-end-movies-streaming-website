<?php

namespace App\Http\Controllers;

use App\Visual;
use App\Genre;
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
    public function show( Request  $request)
    {
        if($request->get('type'))
        {
            
            $visuals = Visual::whereHas('type', function($q)use ($request){
                $q->where('type_in_english', '=', $request->get('type'));
            })
            ->with('type')
            ->with('genre')
            ->with('visualDescription')
            ->orderBy('movie_title','ASC')
            ->paginate(10);
            
            return response()->json([
                'data'=>$visuals
            ],200);
           
            
        } 
         if($request->get('genre'))
        {
            
            $visuals = Visual::whereHas('genre', function($q)use ($request){
                $q
                ->where('genre_in_english', '=', $request->get('genre'));
            })
            ->whith('type')
            ->with('genre')
            ->with('visualDescription')
            ->orderBy('movie_title','ASC')
            ->paginate(10);
            
            
           
            return response()->json([
                'data'=>$visuals
            ],200);
                    
     
        } 
        
         if($request->get('year'))
        {
            
                
            $visuals = Visual::where( function($q)use ($request){
                $q
                ->Where('type_id',2)
                ->whereYear('year', '=', $request->get('year'))
                ->orWhere('type_id',1)
                ->whereYear('year', '=', $request->get('year'));
            })
            
            ->with('type')
            ->with('genre')
            ->with('visualDescription')
            ->orderBy('movie_title','ASC')
            ->paginate(10);
           
                return response()->json([
                    'data'=>$visuals
                ],200);
            
        } 
         if($request->get('name'))
        {
            $visuals = Visual::where( function($q)use ($request){
                $q->where('type_id',1)
                ->where('movie_title','LIKE','%'.$request->get('name').'%')
                ->orWhere('type_id',2)
                ->where('movie_title','LIKE','%'.$request->get('name').'%');
            })
            ->with('type')
            ->with('genre')
            ->with('visualDescription')
            ->orderBy('movie_title','ASC')
            ->paginate(10);
            
            return response()->json([
                'data'=>$visuals
            ]);
        }
        else
        {
            return response()->json([
                'message'=>"Not found"
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
           
                
                
    }


    public function showHome( Request $request)
    {
        if($request->get('type'))
        {
            
            $home = Visual::whereHas('type', function($q)use ($request){
                $q->where('type_in_english', '=', $request->get('type'));
            })
            ->with('type')
            ->with('genre')
            ->with('visualDescription')
            ->orderBy('movie_title','ASC')
            ->paginate(10);
                return response()->json([
                    "data"=>$home,
                    'message'=>"Data Found"
                ],200);
           
            
        } 
        
         if($request->get('genre'))
        {

            $home = Visual::whereHas('genre', function($q)use ($request){
                $q 
                
                ->where('genre_in_english', '=', $request->get('genre'));
            })
            ->with('type')
            ->with('genre')
            ->with('visualDescription')
            ->orderBy('movie_title','ASC')
            ->paginate(10);

            return response()->json([
                'message'=>$home
            ],200);
                    
     
        } 
        
         if($request->get('year'))
        {
            
            $home = Visual::with('type')
            ->whereYear('year', $request->get('year'))
            ->with('genre')
            ->with('visualDescription')
            ->orderBy('movie_title','ASC')
            ->paginate(10);

                return response()->json([
                    'message'=>$home
                ],200);
        } 
         if($request->get('name'))
        {
            $home = Visual::where('movie_title','LIKE','%'.$request->get('name').'%')
            ->with('type')
            ->with('genre')
            ->with('visualDescription')
            ->orderBy('movie_title','ASC')
            ->paginate(10);

            return response()->json([
                'data'=>$home
            ]);
        }
        else
        {
            return response()->json([
                'message'=>"params not found"
            ], 404);
        }
               
                
    }

    public function getAll(){
        $home = Visual
        ::with('type')
        ->with('genre')
        ->with('visualDescription')
        ->orderBy('movie_title','ASC')
        ->paginate(10);

        
        return response()->json([
            "data"=>$home,
            'message'=>"Data Found"
        ],200);
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
