<?php

namespace App\Utilities;

class CustomResponse{


    public static function resource($data, string $message, bool $success=true,int $code=200,array $error=[]) : \Illuminate\Http\JsonResponse
{

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
