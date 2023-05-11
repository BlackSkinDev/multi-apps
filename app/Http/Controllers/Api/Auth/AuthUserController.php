<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthUserController extends Controller
{
    /**
     * Get authenticated user
     * @return JsonResponse
     */
    public function show(): JsonResponse
    {
        $data = [
            'name'       => auth()->user()->name,
            'email'      => auth()->user()->email,
            'is_admin'   => (bool) auth()->user()->is_admin
        ];
        return httpResponse(true,$data);
    }

}
