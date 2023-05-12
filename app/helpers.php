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
