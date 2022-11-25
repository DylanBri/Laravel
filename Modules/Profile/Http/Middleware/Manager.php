<?php

namespace Modules\Profile\Http\Middleware;

use App\Models\UserCoordinate;
use App\Providers\FortifyServiceProvider;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class Manager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $coordinate = UserCoordinate::query()->where('user_id', $user->id)->first();

        if ($user && $coordinate && $coordinate->isRoleManager()) {
            return $next($request);
        }

        return redirect()->route(RouteServiceProvider::HOME);
    }
}
