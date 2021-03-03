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

    public function update(Request $request, $id){
       try{
           $episode = Episode::where('id', '=', $id)->first();
           $episode->update($request->only(['episode_name', 'visual_id', 'duration']));
           return response()->json([
            'error'=>false,
            'message'=>'The Episode has been updated successfully',
            'episode'=>$episode
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
                ->orderBy('id', 'ASC')
                ->paginate(10)
            ;

            return response()->json([
                'error' => false,
                'message' => 'Epsiodes retrieved successfully'  ,
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

    public function destroy($id) {

         try {

             $episode = Episode::findOrFail($id)->delete();

             return response()->json([
                 'error' => false,
                 'message' => 'Epsiode with id = ' . $id .' was deleted successfully'
             ],200);

         } catch(\Illuminate\Database\QueryException $exception){
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured"
            ],500);
        }
    }

}


