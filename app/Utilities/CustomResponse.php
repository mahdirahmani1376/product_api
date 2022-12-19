<?php

namespace App\Utilities;

class CustomResponse{


    public static function resource(array $data,array $error,int $code, string $message, bool $success){

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
