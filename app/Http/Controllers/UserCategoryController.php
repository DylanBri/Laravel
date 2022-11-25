<?php

namespace App\Http\Controllers;

use App\Models\UserCategory;

class UserCategoryController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList()
    {
        $categories = UserCategory::all();
        return response()->json($categories);
    }
}
