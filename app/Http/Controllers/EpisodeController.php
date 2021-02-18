<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Streaming_link;
use App\Visual;
use Exception;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{

     public function uploadEpisode(Request $request){

        try{
        //
//        dd($episode = Episode::create(array(
//            $request->all()
//        )));

        $episode = new Episode();
        $episode->fill($request->all());
        $episode->save();

        return response()->json([
            'error' => false,
            'message' => "The Episode has been added successfully",
            'data' => $episode,
        ],200);

    }catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured",
                'errormessage' => $errorInfo
            ],500);
        }
    }

   public function retrieve(Request $request){
      try{
          $episodes = Episode::paginate();
          return response()->json([
              'error'=>false,
              'X'=>$episodes
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

    public function update(Request $request, $id){
       try{
           $episode = Episode::where('id', '=', $id)->first();
           //$X->name = $request['name'];
           $episode->save();
           return response()->json([
            'error'=>false,
            'message'=>'The Episode has been updated successfully',
            'X'=>$episode
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


    public function getAllEpisodes(Request $request, $id){
        try{

            $episodes = Episode::where('visual_id', $id)
                ->get()
            ;

//            $episodes = Episode::where([
//                function ($query) use ($request) {
//                    if ($visual_id = $request->get('visual_id')) {
//                        $query->where('visual_id', 'LIKE', '%'.$visual_id.'%' )->get();
//                    }
//                }
//            ])
//                ->orderBy('id', 'ASC')
//                ->paginate(10)
//            ;

            return response()->json([
                'error'=>false,
                'episodes'=>$episodes
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
     * Retrieve All streaming links for an episode.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getAllStreamingLinks($id){

        try {
            $streaming_links = Episode::findOrFail($id)->with('streaming_links')->get();
            return response()->json([
                'error' => false,
                'message' => 'sucess retrieving data',
                'data' => $streaming_links
            ], 200);
        } catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured"
            ],500);
        }

    }

}


