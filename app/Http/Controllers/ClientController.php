<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('supadm');
//        $this->authorizeResource(Client::class, 'client');
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('livewire.client.grid');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', [Auth::user()]);

        return view('livewire.client.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param  ClientRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ClientRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        $client = ClientRepository::create($datas);

        return response()->json(['data' => $client, 'success' => true]);
    }

    /**
     * Display the specified resource.
     * @param  Client $client
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Client $client)
    {
        $this->authorize('view', [Auth::user(), $client]);

        return view('livewire.client.form', ['clientId' => $client->id]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  Client $client
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Client $client)
    {
        $this->authorize('update', [Auth::user(), $client]);

        return view('livewire.client.form', ['clientId' => $client->id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param  ClientRequest $request
     * @param  int $clientId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(ClientRequest $request, int $clientId)
    {
        /** @var Client $client */
        $client = ClientRepository::getById($clientId);
        if ($client === null) {
            throw new \Exception('Bad client id');
        }

        $this->authorize('update', [Auth::user(), $client]);

        $datas = $request->validate($request->rules(), $request->all());

        ClientRepository::update($client, $datas);

        return response()->json(['data' => $client, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param  int $clientId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(int $clientId)
    {
        /** @var Client $client */
        $client = ClientRepository::getById($clientId);
        if ($client === null) {
            throw new \Exception('Bad client id');
        }

        $this->authorize('delete', [Auth::user(), $client]);

        ClientRepository::delete($client);

        return response()->json(['data' => $client, 'success' => true]);
    }

    /**
     * Display the specified resource.
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById(int $id)
    {
        $client = ClientRepository::getById($id);

        $this->authorize('view', [Auth::user(), $client]);

        return response()->json($client);
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

        // Begin with function queryBase
        $clients = ClientRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($clients);
    }
}
