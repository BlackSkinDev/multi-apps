<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddTokenToHeaderFromCookie
{
    /**
     * Fetch access token stored in cookie and to request header to authenticate user
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->bearerToken()) {
            if ($request->hasCookie('access_token')) {
                $token = $request->cookie('access_token');
                $request->headers->add([
                    'Authorization' => 'Bearer ' . $token
                ]);
            }
        }
        return $next($request);
    }
}
