<?php

namespace Modules\Monitoring\Http\Controllers;

//use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Modules\Monitoring\Entities\WorkSite;
use Modules\Monitoring\Http\Requests\WorkSiteRequest;
use Modules\Monitoring\Repositories\WorkSiteRepository;

class WorkSiteController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', [Auth::user()]);
        return view('monitoring::livewire.monitoring.work-site.grid');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', [Auth::user()]);
        return view('monitoring::livewire.monitoring.work-site.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param WorkSiteRequest $request
     * @return WorkSite
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(WorkSiteRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        $worksite = WorkSiteRepository::create($datas);

        return response()->json(['data' => $worksite, 'success' => true]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $this->authorize('view', [Auth::user(), $id]);
        return view('monitoring::livewire.monitoring.work-site.form', ['workSiteId' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($id)
    {
        $this->authorize('update', [Auth::user(), $id]);
        return view('monitoring::livewire.monitoring.work-site.form', ['workSiteId' => $id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param WorkSiteRequest $request
     * @param int $id
     * @return WorkSite
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(WorkSiteRequest $request, $id)
    {
        // Get all info from GetCustomer by id
        $worksite = WorkSiteRepository::getById($id);
        if ($worksite === null) {
            throw new \RuntimeException('workSite Id Does Not Exist');
        }
 
        $this->authorize('update', [Auth::user(), $worksite]);
        //dd($request);
        $datas = $request->validate($request->rules(), $request->all());
 
        WorkSiteRepository::update($worksite, $datas);
 
        return response()->json(['data' => $worksite, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return WorkSite
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        // Get all info from GetProduct by id
        $worksite = WorkSiteRepository::getById($id);
        if ($worksite === null) {
            throw new \RuntimeException('workSite Id Does Not Exist');
        }

        $this->authorize('delete', [Auth::user(), $worksite]);

        WorkSiteRepository::delete($worksite);

        return response()->json($worksite);
    }
    
    /**
     * Show the specified resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSearch()
    {
        $this->authorize('viewAny', [Auth::user()]);
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return WorkSite
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById($id)
    {
        $worksite = WorkSiteRepository::getById($id);

        $this->authorize('view', [Auth::user(), $worksite]);

        return response()->json($worksite);
    }

    /**
     * Display listing of the resources
     * @param  Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getList(Request $request)
    {
        $this->authorize('viewAny', [Auth::user()]);

        $validatedData = $request->validate([
            'filters' => 'nullable',
            'query' => 'nullable'
        ]);

        $worksites = WorkSiteRepository::getList($validatedData);

        return response()->json($worksites);
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Paginator
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getPaginate(Request $request)
    {
        $this->authorize('viewAny', [Auth::user()]);

        // Validation
        $validatedData = $request->validate([
            'current_page' => 'required',
            'per_page' => 'required',
            'sort' => 'nullable',
            'order' => 'nullable',
            'filters' => 'nullable'
        ]);

        $currentPage = $validatedData['current_page'];
        $perPage = $validatedData['per_page'];

        $worksites = WorkSiteRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($worksites);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function search(Request $request)
    {
        $this->authorize('viewAny', [Auth::user()]);

        $validatedData = $request->validate([
            'sort' => 'nullable',
            'order' => 'nullable',
            'filters' => 'nullable'
        ]);

        $worksite = WorkSiteRepository::search($validatedData);

        return response()->json($worksite);
    }

    /**
     * Display a listing of the resource.
     * @param int $workSiteId
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showByCustomer(int $customerId)
    {
        $this->authorize('viewAny', [Auth::user()]);
        return view('monitoring::livewire.monitoring.work-site.grid', ['customerId' => $customerId]);
    }
}
