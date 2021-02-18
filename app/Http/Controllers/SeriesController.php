<?php

namespace App\Http\Controllers;

use App\Episode;
use App\Visual;
use Exception;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
     public function create(Request $request){

        try{
        //
        SeriesController::create(array(
            //
        ));

        return response()->json([
            'error' => false,
            'message' => "The SeriesController has been added successfully"
        ],201);

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
          $X = SeriesController::paginate();
          return response()->json([
              'error'=>false,
              'X'=>$X
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

    public function update(Request $request,$id){
       try{
           $X = SeriesController::where('id', '=', $id)->first();
           //$X->name = $request['name'];
           $X->save();
           return response()->json([
            'error'=>false,
            'message'=>'The SeriesController has been updated successfully',
            'X'=>$X
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

    public function getEpisodes(){

         try {
             $episodes = Visual::where('type_id', '1')
                 ->with('episodes')
                 ->get()
             ;
             return response()->json([
                 'error' => false,
                 'message' => "The episodes has been added retrieved successfully",
                 'data' => $episodes
             ],201);

         } catch(\Illuminate\Database\QueryException $exception){
                 $errorInfo = $exception->errorInfo;
                 return response()->json([
                     'error' => true,
                     'message' => "Internal error occured",
                     'data' => $errorInfo
                 ],500);
             }
     }
}


