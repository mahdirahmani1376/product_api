<?php

namespace App\Utilities;

class CustomResponse{


    public static function resource(array $data,array $error, string $message, bool $success,int $code=200){

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
