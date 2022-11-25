<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
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
     * Show initial page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Show dashboard page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showDashboard()
    {
        return view('dashboard');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    /*public function translate(Request $request){
        $pathRoot = __DIR__ . '/../../..';
        $pathRootBase = 'resources/views';
        $pathRootModule = 'Resources/views';
        $path = $request->path;
        $lng = $request->lng;
        $parsePath = explode(':', $path);

        //Validation

        if ($path === 'base') {
            $pathFull = sprintf('%s/%s/../lang/%s.json',$pathRoot, $pathRootBase, $lng);
        } elseif (count($parsePath) === 2) {
            $pathFull = sprintf('%s/Modules/%s/%s/%s/lng/%s.json', $pathRoot, $parsePath[0], $pathRootModule, strtolower($parsePath[1]), $lng);
        } else {
            $pathFull = sprintf('%s/%s/%s/lng/%s.json', $pathRoot, $pathRootBase, strtolower($path), $lng);
        }
        $pathFull = str_replace('\\', '/', $pathFull);
        $content = file_get_contents($pathFull);

        return response()->json(['data' => $content]);
    }*/

    public function hashNewPass(Request $request) {
        $users = User::query()->whereColumn('email', '=', 'password')->get();

        foreach ($users as $user) {
            $user->password = Hash::make($user->email);
            $user->save();
        }
    }
}
