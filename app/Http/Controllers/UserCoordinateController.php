<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCoordinateRequest;
use App\Models\UserCoordinate;
use App\Repositories\UserCoordinateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCoordinateController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
//        $this->authorizeResource(UserCoordinate::class, 'coordinate');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', [Auth::user()]);

        // TODO view non créer
        return view('/user/coordinate');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', [Auth::user()]);

        // TODO view non créer
        return view('/user/coordinate/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserCoordinateRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(UserCoordinateRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        UserCoordinateRepository::create($datas);

        return response()->json(['data' => ['state' => 'success']]);
    }

    /**
     * Display the specified resource.
     *
     * @param  UserCoordinate $coordinate
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(UserCoordinate  $coordinate)
    {
        $this->authorize('view', [Auth::user(), $coordinate]);

        // TODO view non créer
        return view('/user/coordinate/' . $coordinate->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  UserCoordinate $coordinate
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(UserCoordinate  $coordinate)
    {
        $this->authorize('update', [Auth::user(), $coordinate]);

        // TODO view non créer
        return view('/user/coordinate/' . $coordinate->id . '/edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserCoordinateRequest $request
     * @param  int $coordinateId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(UserCoordinateRequest $request, int $coordinateId)
    {
        /** @var UserCoordinate $coordinate */
        $coordinate = UserCoordinateRepository::getById($coordinateId);
        if ($coordinate === null) {
            throw new \Exception('Bad user coordinate id');
        }

        $this->authorize('update', [Auth::user(), $coordinate]);

        $datas = $request->validate($request->rules(), $request->all());

        UserCoordinateRepository::update($coordinate, $datas);

        return response()->json(['data' => ['state' => 'success']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $coordinateId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $coordinateId)
    {
        /** @var UserCoordinate $coordinate */
        $coordinate = UserCoordinateRepository::getById($coordinateId);
        if ($coordinate === null) {
            throw new \Exception('Bad user coordinate id');
        }

        $this->authorize('delete', [Auth::user(), $coordinate]);

        UserCoordinateRepository::delete($coordinate);

        return response()->json(['data' => ['state' => 'success']]);
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showUserAuth()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('livewire.user.coordinate.form');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById(int $id)
    {
        $coordinate = UserCoordinateRepository::getById($id);

        $this->authorize('view', [Auth::user(), $coordinate]);

        return response()->json($coordinate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
//     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function autocomplete(Request $request)
    {
//        $this->authorize('viewAny', [Auth::user()]);

        $validatedData = $request->validate([
            'query' => 'required'
        ]);

        $data = UserCoordinateRepository::autocomplete($validatedData);

        return response()->json($data);
    }
}
