<?php

namespace App\Http\Controllers;

use App\Models\SessionProfile;

class SessionProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLogged() {
        $profile = new SessionProfile([
            'client_id' => session('clientId'),
            'user_id' => session('userId'),
            'role_id' => session('roleId'),
        ]);

        return response()->json(["data" => [
            "profile" => $profile,
//            "right" => session('right'),
            'isSuperAdmin' => session('isSuperAdmin'),
            'isAdmin' => session('isAdmin'),
            'isManager' => session('isManager'),
            'isUser' => session('isUser'),
            'isViewer' => session('isViewer')
        ]]);
    }

    /**
     * Function reset
     */
    public function reset()
    {
        return;
    }
}
