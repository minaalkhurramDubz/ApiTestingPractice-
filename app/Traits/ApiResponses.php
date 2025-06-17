<?php

namespace App\Traits;


trait ApiResponses{

    protected function ok($message){
         
        return $this->success($message,200);

    }

    // successful case responses 

    protected function success($message, $statusCode=200){
        return response()->json([
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


