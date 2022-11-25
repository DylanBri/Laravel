<?php

namespace Modules\Profile\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Gate;
use Modules\Profile\Entities\SuperAdministrator;
use Modules\Profile\Http\Requests\SuperAdministratorRequest;
use Modules\Profile\Repositories\SuperAdministratorRepository;

class SuperAdministratorController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('supadm');
//        $this->authorizeResource(SuperAdministrator::class, 'supadm');
    }

    /**
     * Display the dashboard.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('profile::livewire.supadm.grid');
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
        return view('profile::livewire.supadm.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param  SuperAdministratorRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(SuperAdministratorRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        if ($datas['password'] === null) {
            throw new \Exception('Password allowed');
        }

        $supadm = SuperAdministratorRepository::create($datas);

        return response()->json(['data' => $supadm, 'success' => true]);
    }

    /**
     * Display the specified resource.
     * @param  SuperAdministrator $supadm
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(SuperAdministrator $supadm)
    {
        $this->authorize('view', [Auth::user(), $supadm]);

        // TODO view non créée
        return view('profile::livewire.supadm.form', ['supadmId' => $supadm->id]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  SuperAdministrator $supadm
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(SuperAdministrator $supadm)
    {
        $this->authorize('update', [Auth::user(), $supadm]);

        // TODO view non créée
        return view('profile::livewire.supadm.form', ['supadmId' => $supadm->id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param  SuperAdministratorRequest $request
     * @param  int $supadmId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(SuperAdministratorRequest $request, int $supadmId)
    {
        /** @var SuperAdministrator $supadm */
        $supadm = SuperAdministrator::query()->where('users.id', $supadmId)->first();
        if ($supadm === null) {
            throw new \Exception('Bad super admin id');
        }

        $this->authorize('update', [Auth::user(), $supadm]);

        // Validation des données envoyées dans request
        $datas = $request->validate($request->rules(), $request->all());

        if ($datas['password'] === null) {
            unset($datas['password']);
        }

//        dd($datas);
        SuperAdministratorRepository::update($supadm, $datas);

        return response()->json(['data' => $supadm, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $supadmId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $supadmId)
    {
        /** @var SuperAdministrator $supadm */
        $supadm = SuperAdministrator::query()->where('users.id', $supadmId)->first();
        if ($supadm === null) {
            throw new \Exception('Bad super admin id');
        }

        $this->authorize('delete', [Auth::user(), $supadm]);

        SuperAdministratorRepository::delete($supadm);

        return response()->json(['data' => $supadm, 'success' => true]);
    }

    /**
     * Display the dashboard.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showDashboard()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('profile::livewire.supadm.dashboard');
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById(int $id)
    {
        $user = SuperAdministratorRepository::getById($id);

        $this->authorize('view', [Auth::user(), $user]);

        return response()->json($user);
    }

    /**
     * Display the specified resource.
     * @param  Request $request
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

        $users = SuperAdministratorRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($users);
    }
}
