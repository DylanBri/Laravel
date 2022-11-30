<?php

namespace Modules\Monitoring\Http\Controllers;

//use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Modules\Monitoring\Entities\WorkSiteLotCompany;
use Modules\Monitoring\Http\Requests\WorkSiteLotCompanyRequest;
use Modules\Monitoring\Repositories\WorkSiteLotCompanyRepository;

class WorkSiteLotCompanyController extends Controller
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
        return view('monitoring::livewire.monitoring.work-site-lot-company.grid');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('viewAny', [Auth::user()]);
        return view('monitoring::livewire.monitoring.work-site-lot-company.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param WorkSiteLotCompanyRequest $request
     * @return WorkSiteLotCompany
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(WorkSiteLotCompanyRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        $workSiteLotCompany = WorkSiteLotCompanyRepository::create($datas);

        return response()->json(['data' => $workSiteLotCompany, 'success' => true]);
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
        return view('monitoring::livewire.monitoring.work-site-lot-company.form', ['workSiteLotCompanyId' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->authorize('view', [Auth::user(), $id]);
        return view('monitoring::livewire.monitoring.work-site-lot-company.form', ['workSiteLotCompanyId' => $id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param WorkSiteLotCompanyRequest $request
     * @param int $id
     * @return WorkSiteLotCompany
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(WorkSiteLotCompanyRequest $request, $id)
    {
        // Get all info from GetCustomer by id
        $workSiteLotCompany = WorkSiteLotCompanyRepository::getById($id);
        if ($workSiteLotCompany === null) {
            throw new \RuntimeException('Does Not Exist');
        }

        $this->authorize('update', [Auth::user(), $workSiteLotCompany]);
        //dd($request);
        $datas = $request->validate($request->rules(), $request->all());

        WorkSiteLotCompanyRepository::update($workSiteLotCompany, $datas);

        return response()->json(['data' => $workSiteLotCompany, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return WorkSiteLotCompany
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $workSiteLotCompany = WorkSiteLotCompanyRepository::getById($id);
        if ($workSiteLotCompany === null) {
            throw new \RuntimeException('Does Not Exist');
        }

        $this->authorize('delete', [Auth::user(), $lot]);

        WorkSiteLotCompanyRepository::delete($workSiteLotCompany);

        return response()->json($workSiteLotCompany);
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
     * @return WorkSiteLotCompany
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById($id)
    {
        $workSiteLotCompany = WorkSiteLotCompanyRepository::getById($id);

        $this->authorize('view', [Auth::user(), $workSiteLotCompany]);

        return response()->json($workSiteLotCompany);
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
        
        $workSiteLotCompany = WorkSiteLotCompanyRepository::getList($validatedData);

        return response()->json($workSiteLotCompany);
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
        
        $workSiteLotCompany = WorkSiteLotCompanyRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($workSiteLotCompany);
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

        $workSiteLotCompany = WorkSiteLotCompanyRepository::search($validatedData);

        return response()->json($workSiteLotCompany);
    }

    /**
     * Display a listing of the resource.
     * @param int $workSiteId
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showByWorkSite(int $workSiteId)
    {
        $this->authorize('viewAny', [Auth::user()]);
        return view('monitoring::livewire.monitoring.work-site-lot-company.grid', ['workSiteId' => $workSiteId]);
    }

    public function showByMonitoring(int $monitornigId)
    {
        $this->authorize('viewAny', [Auth::user()]);
        return view('monitoring::livewire.monitoring.work-site-lot-company.grid', ['monitornigId' => $monitornigId]);
    }
}
