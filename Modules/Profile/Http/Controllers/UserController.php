<?php

namespace Modules\Profile\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \Modules\Profile\Entities\User;
use Illuminate\Http\Request;
use Modules\Profile\Http\Requests\UserRequest;
use Modules\Profile\Repositories\UserRepository;

class UserController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
//        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display the dashboard.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('profile::livewire.user.grid');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', [Auth::user()]);

        // TODO view non créée
        return view('profile::livewire.user.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param  UserRequest  $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(UserRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        if ($datas['password'] === null) {
            throw new \Exception('Password allowed');
        }

        $user = UserRepository::create($datas);

        return response()->json(['data' => $user, 'success' => true]);
    }

    /**
     * Display the specified resource.
     * @param  User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', [Auth::user(), $user]);

        // TODO view non créée
        return view('profile::livewire.user.form', ['userId' => $user->id]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  User $user
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', [Auth::user(), $user]);

        // TODO view non créée
        return view('profile::livewire.user.form', ['userId' => $user->id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param  UserRequest $request
     * @param int $userId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(UserRequest $request, int $userId)
    {
        /** @var User $user */
        $user = User::query()->where('users.id', $userId)->first();
        if ($user === null) {
            throw new \Exception('Bad user id');
        }

        $this->authorize('update', [Auth::user(), $user]);

        $datas = $request->validate($request->rules(), $request->all());

        if ($datas['password'] === null) {
            unset($datas['password']);
        }

        UserRepository::update($user, $datas);

        return response()->json(['data' => $user, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $userId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $userId)
    {
        /** @var User $user */
        $user = User::query()->where('users.id', $userId)->first();
        if ($user === null) {
            throw new \Exception('Bad user id');
        }

        $this->authorize('delete', [Auth::user(), $user]);

        UserRepository::delete($user);

        return response()->json(['data' => $user, 'success' => true]);
    }

    /**
     * Show the specified resource.
     * @return \Illuminate\Http\Response
    //     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSearch()
    {
//        $this->authorize('view', [Auth::user()]);

        return view('profile::livewire.user.listing', ['officeId' => 0]);
    }

    /**
     * Show the specified resource.
     * @param int $officeId
     * @return \Illuminate\Http\Response
    //     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSearchByOffice(int $officeId)
    {
//        $this->authorize('view', [Auth::user()]);

        return view('profile::livewire.user.listing', ['officeId' => $officeId]);
    }

    /**
     * Display the dashboard.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showDashboard()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('profile::livewire.user.dashboard');
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById(int $id)
    {
        $user = UserRepository::getById($id);

        $this->authorize('view', [Auth::user(), $user]);

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getPaginate(Request $request)
    {
        $this->authorize('viewAny', [Auth::user()]);

        $validatedData = $request->validate([
            'current_page' => 'required',
            'per_page' => 'required',
            'sort' => 'nullable',
            'order' => 'nullable',
            'filters' => 'nullable'
        ]);

        $currentPage = $validatedData['current_page'];
        $perPage = $validatedData['per_page'];

        $users = UserRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($users);
    }

    /**
     * Display the specified resource.
     * @param  Request $request
     * @return \Illuminate\Http\Response
    //     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(Request $request)
    {
//        $this->authorize('viewAny', [Auth::user()]);

        $validatedData = $request->validate([
            'sort' => 'nullable',
            'order' => 'nullable',
            'filters' => 'nullable'
        ]);

        $users = UserRepository::search($validatedData);

        return response()->json($users);
    }
}
