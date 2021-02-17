<?php

namespace App\Http\Controllers;

use App\Episode;
use Exception;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
     public function create(Request $request){

        try{
        //
        Episode::create(array(
            $request->all()
        ));

        return response()->json([
            'error' => false,
            'message' => "The Episode has been added successfully"
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
          $X = Episode::paginate();
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
           $X = Episode::where('id', '=', $id)->first();
           //$X->name = $request['name'];
           $X->save();
           return response()->json([
            'error'=>false,
            'message'=>'The Episode has been updated successfully',
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




}


