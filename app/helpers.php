<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\MessageBag;

if (! function_exists('successResponse')) {
    /**
     * Return a standard success json response
     *
     */
    function successResponse($data = [], int $code = 200) : JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $data
        ], $code);
    }
}

if (! function_exists('errorResponse')) {
    /**
     * Return a standard error json response
     *
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
