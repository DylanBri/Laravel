<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Client;
use App\Models\SessionProfile;
use App\Models\UserCoordinate;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{

    public const ROLE_SUPADM = 1;
    public const ROLE_ADMIN = 2;
    public const ROLE_MANAGER = 3;
    public const ROLE_USER = 4;
//    public const ROLE_VIEWER = 5;

    public const CATEGORY_SUPADM = 1;
    public const CATEGORY_ADMIN = 2;
    public const CATEGORY_MANAGER = 3;
    public const CATEGORY_USER = 4;
//    public const CATEGORY_VIEWER = 5;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse ($request)
            {
                $credentials = $request->only('email', 'password');
                if (Auth::guard()->attempt(array_merge($credentials))) {
                    $users = UserCoordinate::query()
                        ->join('profiles', 'user_coordinates.user_id', '=', 'profiles.user_id')
                        ->join('users', 'users.id', '=', 'profiles.user_id')
                        ->join('clients', 'profiles.client_id', '=', 'clients.id')
                        ->where('users.email', $credentials['email'])
                        ->where('clients.enabled', 1)
                        ->where('user_coordinates.enabled', 1)
                        ->where('user_coordinates.suppressed', 0)
                        ->get();
                    if ($users->isEmpty()) {
                        return redirect('/');
                    }
                    /*if ($clients->count() > 1) {
                        // TODO check if multi-client with page select client
                    }*/

                    // Get first client found
                    $user = $users->first();

                    // Update table sessions with profile infos (initSession in observer Session)
                    SessionProfile::query()->where('user_id', Auth::user()->getAuthIdentifier())->delete();
                    $session = new SessionProfile();
                    $session->user_id = $user->user_id;
                    $session->role_id = $user->role_id;
                    $session->client_id = $user->client_id;
                    $session->save();
//                    dd($user->isRoleSuperAdministrator());

                    // Check if userCategory is Super Administrator
                    if ($user->isRoleSuperAdministrator()) {
                        return redirect()->route(RouteServiceProvider::SUPADM_HOME);
                    }

                    // Check if userCategory is Administrator
                    if ($user->isRoleAdministrator()) {
                        return redirect()->route(RouteServiceProvider::ADMIN_HOME);
                    }

                    // Check if userCategory is Manager
                    if ($user->isRoleManager()) {
                        return redirect()->route(RouteServiceProvider::MANAGER_HOME);
                    }

                    // Check if userCategory is Viewer
                    /*if ($client->isRoleViewer()) {
                        return redirect()->route(RouteServiceProvider::HOME);
                    }*/

                    // User basic
                    if ($user->isRoleUser()) {
                        return redirect()->route(RouteServiceProvider::USER_HOME);
                    }
                }

                return redirect('/');
            }
        });

        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
            public function toResponse ($request)
            {
                return redirect('/');
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
