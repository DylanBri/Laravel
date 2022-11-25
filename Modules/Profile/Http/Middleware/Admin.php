<?php

namespace Modules\Profile\Http\Middleware;

use App\Models\UserCoordinate;
use App\Providers\FortifyServiceProvider;
use App\Providers\RouteServiceProvider;
use App\Repositories\UserCoordinateRepository;
use Closure;
use Illuminate\Http\Request;

class Admin
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
        $coordinate = UserCoordinateRepository::getByUserId($user->id);

        if ($user && $coordinate && $coordinate->isRoleAdministrator) {
            return $next($request);
        }

        return redirect()->route(RouteServiceProvider::HOME);
    }
}
