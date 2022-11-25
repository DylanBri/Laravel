<?php

namespace Modules\Monitoring\Http\Controllers;

//use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Modules\Monitoring\Entities\Monitoring;
use Modules\Monitoring\Http\Requests\MonitoringRequest;
use Modules\Monitoring\Repositories\MonitoringRepository;

class MonitoringController extends Controller
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
        return view('monitoring::livewire.monitoring.grid');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', [Auth::user()]);
        return view('monitoring::livewire.monitoring.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param MonitoringRequest $request
     * @return Monitoring
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(MonitoringRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        $monitoring = MonitoringRepository::create($datas);

        return response()->json(['data' => $monitoring, 'success' => true]);
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
        return view('monitoring::livewire.monitoring.form', ['monitoringId' => $id]);
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
        return view('monitoring::livewire.monitoring.form', ['monitoringId' => $id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param MonitoringRequest $request
     * @param int $id
     * @return Monitoring
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(MonitoringRequest $request, $id)
    {
        // Get all info from GetCustomer by id
        $monitoring = MonitoringRepository::getById($id);
        if ($monitoring === null) {
            throw new \RuntimeException('Monitoring Id Does Not Exist');
        }

        $this->authorize('update', [Auth::user(), $monitoring]);
        //dd($request);
        $datas = $request->validate($request->rules(), $request->all());

        MonitoringRepository::update($monitoring, $datas);

        return response()->json(['data' => $monitoring, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        // Get all info from GetProduct by id
        $monitoring = MonitoringRepository::getById($id);
        if ($monitoring === null) {
            throw new \RuntimeException('Monitoring Id Does Not Exist');
        }
 
        $this->authorize('delete', [Auth::user(), $monitoring]);

        MonitoringRepository::delete($monitoring);
 
        return response()->json($monitoring);
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
     * @return Monitoring
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById($id)
    {
        $monitoring = MonitoringRepository::getById($id);

        $this->authorize('view', [Auth::user(), $monitoring]);

        return response()->json($monitoring);
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

        $monitorings = MonitoringRepository::getList($validatedData);

        return response()->json($monitorings);
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

        $monitorings = MonitoringRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($monitorings);
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

        $monitoring = MonitoringRepository::search($validatedData);

        return response()->json($monitoring);
    }

    /**
     * Display a listing of the resource.
     * @param int $workSiteLotCompanyId
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
    */
    public function showByWorkSiteLotCompany(int $workSiteLotCompanyId)
    {
        $this->authorize('viewAny', [Auth::user()]);
        return view('monitoring::livewire.monitoring.grid', ['workSiteLotCompanyId' => $workSiteLotCompanyId]);
    }
}
