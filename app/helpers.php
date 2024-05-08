<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;

if (! function_exists('httpResponse')) {
    /**
     * Return a standard  json response
     *
     */
    function httpResponse(bool $success,$data=[],string $message=null, int $code=null) : JsonResponse
    {
        $response = [
            'success' => $success,
        ];
        if ($success){
            $response['data'] = $data;
        }

        if ($message){
            $response['message'] = $message;
        }

        if (!$code){
            $code = $success ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST;
        }

        return response()->json($response, $code);
    }
}

if (! function_exists('generateHashToken')) {
    /**
     * generate hash tokens app wide
     *
     */
    function generateHashToken(int $length): array|string|null
    {
        return  hash('sha256', Str::random($length));
    }

}



if (! function_exists('successResponse')) {
    /**
     * Return a standard success json response
     */
    function successResponse($data = [], int $code = 200, $message = "Success") : JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $data,
            'message' => $message
        ], $code);
    }
}

if (! function_exists('errorResponse')) {
    /**
     * Return a standard error json response
     */
    function errorResponse(string $message, int $code = 400, MessageBag $errors = null) : JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }
}

