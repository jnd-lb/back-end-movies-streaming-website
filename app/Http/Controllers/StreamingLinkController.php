<?php

namespace App\Http\Controllers;

use App\Streaming_link;
use Exception;
use Illuminate\Http\Request;

class StreamingLinkController extends Controller
{
     public function create(Request $request){

        try{
        //
        Streaming_link::create(array(
            $request->all()
        ));

        return response()->json([
            'error' => false,
            'message' => "The streaming link has been added successfully"
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
          $streaming_link = Streaming_link::paginate();
          return response()->json([
              'error'=>false,
              'X'=>$streaming_link
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
           $streaming_link = Streaming_link::where('id', '=', $id)->first();
           //$X->name = $request['name'];
           $streaming_link->save();
           return response()->json([
            'error'=>false,
            'message'=>'The StreamingLinkController has been updated successfully',
            'X'=>$streaming_link
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


