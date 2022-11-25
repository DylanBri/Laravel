<?php

namespace Modules\Profile\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SessionProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Profile\Entities\Administrator;
use Modules\Profile\Http\Requests\AdministratorRequest;
use Modules\Profile\Repositories\AdministratorRepository;

class AdministratorController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
//        $this->authorizeResource(Administrator::class, 'admin');
    }

    /**
     * Display the dashboard.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('profile::livewire.admin.grid');
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
        return view('profile::livewire.admin.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param  AdministratorRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(AdministratorRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        if ($datas['password'] === null) {
            throw new \Exception('Password allowed');
        }

        $admin = AdministratorRepository::create($datas);

        return response()->json(['data' => $admin, 'success' => true]);
    }

    /**
     * Display the specified resource.
     * @param  Administrator $admin
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Administrator $admin)
    {
        $this->authorize('view', [Auth::user(), $admin]);

        // TODO view non créée
        return view('profile::livewire.admin.form', ['adminId' => $admin->id]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Administrator $admin
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Administrator $admin)
    {
        $this->authorize('update', [Auth::user(), $admin]);

        // TODO view non créée
        return view('profile::livewire.admin.form', ['adminId' => $admin->id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param  AdministratorRequest $request
     * @param  int $adminId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(AdministratorRequest $request, int $adminId)
    {
        /** @var Administrator $admin */
        $admin = Administrator::query()->where('users.id', $adminId)->first();
        if ($admin === null) {
            throw new \Exception('Bad admin id');
        }

        $this->authorize('update', [Auth::user(), $admin]);

        $datas = $request->validate($request->rules(), $request->all());

        if ($datas['password'] === null) {
            unset($datas['password']);
        }

        AdministratorRepository::update($admin, $datas);

        return response()->json(['data' => $admin, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $adminId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $adminId)
    {
        /** @var Administrator $admin */
        $admin = Administrator::query()->where('users.id', $adminId)->first();
        if ($admin === null) {
            throw new \Exception('Bad admin id');
        }

        $this->authorize('delete', [Auth::user(), $admin]);

        AdministratorRepository::delete($admin);

        return response()->json(['data' => $admin, 'success' => true]);
    }

    /**
     * Display the dashboard.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showDashboard()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('profile::livewire.admin.dashboard');
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById(int $id)
    {
        $user = AdministratorRepository::getById($id);

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

        $users = AdministratorRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($users);
    }

    /**
     * @param int $holdingId
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeProfile(int $holdingId)
    {
        if (Auth::user() !== null) {
            // Controle auth is admin
            $user = AdministratorRepository::getById(Auth::id());

            // $holdingId fait parti des profile de l'auth
            if ($user !== null && $user->holdings()->where('holding_id', $holdingId)->exists()) {
                // Récupération des infos profile
                $profile = DB::table('profiles')
                    ->where('user_id', Auth::id())
                    ->where('holding_id', $holdingId)
                    ->first();

                SessionProfile::query()
                    ->where('user_id', Auth::id())
                    ->where('holding_id', session('holdingId'))
                    ->update([
                        'holding_id' => $profile->holding_id,
                        'company_id' => $profile->company_id,
                        'office_id' => $profile->office_id
                    ]);

                // Modification de la session
                session(['holdingId' => $profile->holding_id]);
                session(['companyId', $profile->company_id]);
                session(['officeId', $profile->office_id]);

                return response()->json($profile);
            }
        }

        return response()->json([]);
    }
}
