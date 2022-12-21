<?php

namespace App\Utilities;

class CustomResponse{


    public static function resource(array $data, string $message, bool $success=true,int $code=200,array $error=[]){

        $result = [
            'data' => $data,
            'error' => [
                'code' => $code == 200 ? 0:$code,
                'data' => $error,
            ],
            'messages' => $message,
            'success' => $success,
        ];

        return response()->json($result,$code);
    }

}
