<?php

namespace Modules\Profile\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Profile\Entities\Manager;
use Modules\Profile\Http\Requests\ManagerRequest;
use Modules\Profile\Repositories\ManagerRepository;

class ManagerController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
//        $this->authorizeResource(Manager::class, 'manager');
    }

    /**
     * Display the dashboard.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('profile::livewire.manager.grid');
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
        return view('profile::livewire.manager.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param  ManagerRequest  $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(ManagerRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        if ($datas['password'] === null) {
            throw new \Exception('Password allowed');
        }

        $manager = ManagerRepository::create($datas);

        return response()->json(['data' => $manager, 'success' => true]);
    }

    /**
     * Display the specified resource.
     * @param  Manager $manager
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Manager $manager)
    {
        $this->authorize('view', [Auth::user(), $manager]);

        // TODO view non créée
        return view('profile::livewire.manager.form', ['managerId' => $manager->id]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Manager $manager
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Manager $manager)
    {
        $this->authorize('update', [Auth::user(), $manager]);

        // TODO view non créée
        return view('profile::livewire.manager.form', ['managerId' => $manager->id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param  ManagerRequest $request
     * @param int $managerId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(ManagerRequest $request, int $managerId)
    {
        /** @var Manager $manager */
        $manager = Manager::query()->where('users.id', $managerId)->first();
        if ($manager === null) {
            throw new \Exception('Bad manager id');
        }

        $this->authorize('update', [Auth::user(), $manager]);

        $datas = $request->validate($request->rules(), $request->all());

        if ($datas['password'] === null) {
            unset($datas['password']);
        }

        ManagerRepository::update($manager, $datas);

        return response()->json(['data' => $manager, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $managerId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $managerId)
    {
        /** @var Manager $manager */
        $manager = Manager::query()->where('users.id', $managerId)->first();
        if ($manager === null) {
            throw new \Exception('Bad manager id');
        }

        $this->authorize('delete', [Auth::user(), $manager]);

        ManagerRepository::delete($manager);

        return response()->json(['data' => $manager, 'success' => true]);
    }

    /**
     * Display the dashboard.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showDashboard()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('profile::livewire.manager.dashboard');
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById(int $id)
    {
        $user = ManagerRepository::getById($id);

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

        $users = ManagerRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($users);
    }
}
