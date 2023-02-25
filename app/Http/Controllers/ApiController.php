<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    public function sendResponse($result, $message = null)
    {
        $response = [
            "data" => empty($message) ? $message : $result,
            "message" => !isset($message) ? $result : $message,
            "code" => 200
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            "error" => $error,
            "messages" => $errorMessages,
            "code" => $code
        ];

        return response()->json($response, $code);
    }
}
