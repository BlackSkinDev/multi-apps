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
            'name'                 => $user->name,
            'firstname'            => $user->firstname,
            'email'                => $user->email,
            'is_admin'             => (bool) $user->is_admin,
            'has_company'          => (bool) $user->company,
            'photo'                => $user->photo,
            'company_name'         => $user->company?->name,
            'company_description'  => Str::limit(strip_tags($user->company?->description), 20, '...'),
            'company_image'        => $user->company?->image
        ];
        return httpResponse(true,$data);
    }

}
