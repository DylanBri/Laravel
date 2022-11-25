<?php

namespace Modules\Log\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Log\Entities\LogQueue;
use Modules\Log\Http\Requests\LogQueueRequest;
use Modules\Log\Repositories\LogQueueRepository;

class LogQueueController extends Controller
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
        //$this->authorizeResource(LogQueue::class, 'customer');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', [Auth::user()]);
        
        return view('log::livewire.log-queue.grid');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
//        $this->authorize('create', [Auth::user()]);
        
//        return view('log::livewire.log-queue.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param LogQueueRequest $request
     * @return Renderable
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(LogQueueRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        $customer = LogQueueRepository::create($datas);

        return response()->json(['data' => $customer, 'success' => true]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
//        $this->authorize('view', [Auth::user(), $log]);
        
//        return view('log::livewire.log-queue.form', ['logId' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
//        $this->authorize('view', [Auth::user(), $log]);

//        return view('log::livewire.log-queue.form', ['logId' => $id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param LogQueueRequest $request
     * @param int $id
     * @return Renderable
     * @throws \Exception
     */
    public function update(LogQueueRequest $request, $id)
    {
        /** @var LogQueue $customer */
        $customer = LogQueueRepository::getById($id);
        if ($customer === null) {
            throw new \Exception('Bad customer id');
        }

        $this->authorize('update', [Auth::user(), $customer]);

        $datas = $request->validate($request->rules(), $request->all());

        LogQueueRepository::update($customer, $datas);

        return response()->json(['data' => $customer, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var LogQueue $customer */
        $customer = LogQueueRepository::getById($id);
        if ($customer === null) {
            throw new \Exception('Bad customer id');
        }

        $this->authorize('delete', [Auth::user(), $customer]);

        LogQueueRepository::delete($customer);

        return response()->json(['data' => $customer, 'success' => true]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function purge()
    {
        $this->authorize('viewAny', [Auth::user()]);
        $res = LogQueue::query()->where('log', "=", 'Aucun résultat')->delete();
        return Response()->json(['data' => $res]);
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return Renderable
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById($id)
    {
        $log = LogQueueRepository::getById($id);
//        Log::debug($response);

        $this->authorize('view', [Auth::user(), $log]);

        return response()->json($log);
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return Renderable
//     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getListPaginate(Request $request)
    {
//        $this->authorize('viewAny', [Auth::user()]);

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

        $logs = LogQueueRepository::getListPaginate($currentPage, $perPage, $validatedData);

        return response()->json($logs);
    }
}
