<?php

namespace App\Traits;


trait ApiResponses{

    protected function ok($message,$data=[]){
         
        return $this->success($message,$data,200);

    }

    // successful case responses 

    protected function success($message, $data=[], $statusCode=200){
        return response()->json([

            // success was changed , data is added for token producing 
            'data'=>$data,
            'message'=> $message,
            'status'=> $statusCode
        ], $statusCode);
    }


    //failure case responses 
    protected function error($message, $statusCode){
        return response()->json([
            'message'=> $message,
            'status'=> $statusCode
        ], $statusCode);
    }
}


