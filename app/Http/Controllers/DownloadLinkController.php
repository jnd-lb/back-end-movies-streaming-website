<?php

namespace App\Http\Controllers;

use App\Download_link;
use Exception;
use Illuminate\Http\Request;

class DownloadLinkController extends Controller
{
     public function create(Request $request){

        try{

            $dlink = new Download_link();
            $dlink->fill($request->all());
            $dlink->save();

        return response()->json([
            'error' => false,
            'message' => "The Download Link has been added successfully",
            'data' => $dlink
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

   public function retrieve(){
      try{
          $dlinks = Download_link::paginate();
          return response()->json([
              'error'=>false,
              'message' => "The Download Link has been retrieved successfully",
              'dlinks'=>$dlinks
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
           $dlink = Download_link::where('id', '=', $id)->first();
           $dlink->download_link = $request->get('dlink');
           $dlink->save();
           return response()->json([
            'error'=>false,
            'message'=>'The Download Link has been updated successfully',
            'dlink'=>$dlink
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

    public function destroy ($id) {
        try {

            $dlink = Download_link::findOrFail($id);
            $dlink->delete();
            return response()->json([
                'error'=>false,
                'message'=>'The Download Link has been deleted successfully',
                'dlink'=>$dlink
            ],200);

        } catch (\Illuminate\Database\QueryException $exception) {
            $errorInfo = $exception->errorInfo;
            return response()->json([
                'error' => true,
                'message' => "Internal error occured"
            ],500);
        }
    }

}


