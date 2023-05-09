<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;

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


if (! function_exists('removeSpecialChars')) {
    /**
     * remove all non-special characters other than - from a string
     *
     */
    function removeSpecialChars($string): array|string|null
    {
        $pattern = '/[^a-zA-Z0-9-]/'; // pattern to match all non-alphanumeric and non-hyphen characters
        // remove all non-matching characters
        return preg_replace($pattern, '', $string);
    }

}
