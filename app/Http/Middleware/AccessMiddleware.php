<?php

namespace App\Http\Middleware;

use App\Libraries\ResponseStd;
use App\Models\User;
use Closure;
use Symfony\Component\HttpFoundation\JsonResponse;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = User::query()->where('id', auth('api')->user()->id)->first();
        if ($user) {
            $is_admin = $user['is_admin'];
            if ($is_admin) {
                return $next($request);
            }
        }
        return ResponseStd::fail('Unauthorized access', JsonResponse::HTTP_UNAUTHORIZED, 'Cannot access. You You must be an Admin to get access.');
    }
}
