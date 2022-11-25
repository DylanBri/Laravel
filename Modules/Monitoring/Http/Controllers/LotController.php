<?php

namespace Modules\Monitoring\Http\Controllers;

//use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Modules\Monitoring\Entities\Lot;
use Modules\Monitoring\Http\Requests\LotRequest;
use Modules\Monitoring\Repositories\LotRepository;

class LotController extends Controller
{
    protected $repository;
    
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->authorizeResource(Lot::class, 'lot');
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', [Auth::user()]);
        return view('monitoring::livewire.monitoring.lot.grid');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', [Auth::user()]);
        return view('monitoring::livewire.monitoring.lot.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param LotRequest $request
     * @return Lot
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(LotRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        $lot = LotRepository::create($datas);

        return response()->json($lot);
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
        return view('monitoring::livewire.monitoring.lot.form', ['lotId' => $id]);
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
        return view('monitoring::livewire.monitoring.lot.form', ['lotId' => $id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param LotRequest $request
     * @param int $id
     * @return Lot
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(LotRequest $request, $id)
    {
        // Get all info from GetCustomer by id
        $lot = LotRepository::getById($id);
        if ($lot === null) {
            throw new \RuntimeException('Lot Id Does Not Exist');
        }

        $this->authorize('update', [Auth::user(), $lot]);
        //dd($request);
        $datas = $request->validate($request->rules(), $request->all());

        LotRepository::update($lot, $datas);

        return response()->json(['data' => $lot, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Lot
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        // Get all info from GetProduct by id
        $lot = LotRepository::getById($id);
        if ($lot === null) {
            throw new \RuntimeException('Lot Id Does Not Exist');
        }

        $this->authorize('delete', [Auth::user(), $lot]);

        LotRepository::delete($lot);

        return response()->json($lot);
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
     * @return Lot
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById($id)
    {
        $lot = LotRepository::getById($id);

        $this->authorize('view', [Auth::user(), $lot]);

        return response()->json($lot);
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

        $lots = LotRepository::getList($validatedData);

        return response()->json($lots);
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

        $lots = LotRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($lots);
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

        $lot = LotRepository::search($validatedData);

        return response()->json($lot);
    }
}
