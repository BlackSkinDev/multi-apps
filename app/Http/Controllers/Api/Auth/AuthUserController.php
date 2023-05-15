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
        $user  = auth()->user();

        $data = [
            'name'        => $user->firstname,
            'email'       => $user->email,
            'is_admin'    => (bool) $user->is_admin,
            'has_company' => (bool) $user->company_id,
            'photo'       => url("/").'/images/avatar.png'
        ];
        return httpResponse(true,$data);
    }

}
