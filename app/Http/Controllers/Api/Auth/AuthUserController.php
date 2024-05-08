<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;


class AuthUserController extends Controller
{
    /**
     * Get authenticated user
     * @return JsonResponse
     */

    public function show(): JsonResponse
    {
        $user  = auth()->user();

        $data = [
            'username'            => $user->username,
            'email'                => $user->email,
            'photo'                => $user->photo,
            'bio'         => $user->bio,
        ];
        return successResponse($data);
    }

}
