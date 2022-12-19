<?php

namespace App\Utilities;

class CustomResponse{


    public static function resource($data=[],array $error,int $ErrorCode, string $message, bool $success){

        $result = [
            'data' => $data,
            'error' => [
                'code' => $ErrorCode,
                'data' => $error,
            ],
            'messages' => $message,
            'success' => $success,
        ];

        return response()->json($result);
    }

}
