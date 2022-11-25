<?php

namespace Modules\Customer\Http\Controllers;

//use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\Entities\Address;
use Modules\Customer\Http\Requests\AddressRequest;
use Modules\Customer\Repositories\AddressRepository;

class AddressController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
//        $this->authorizeResource(Address::class, 'address');
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', [Auth::user()]);

//        return view('customer::livewire.customer.address.grid');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', [Auth::user()]);

//        return view('customer::livewire.customer.address.form');
    }

    /**
     * Show the form for creating a new resource.
     * @param AddressRequest $request
     * @return Address
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(AddressRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        $address = AddressRepository::create($datas);

        return response()->json($address);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(int $id)
    {
        $this->authorize('view', [Auth::user(), $id]);

//        return view('customer::livewire.customer.address.form', ['addressId' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(int $id)
    {
        $this->authorize('update', [Auth::user(), $id]);

//        return view('customer::livewire.customer.address.form', ['addressId' => $id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param AddressRequest $request
     * @param int $id
     * @return Address
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(AddressRequest $request, int $id)
    {
        // Get all info from GetCustomer by id
        $address = AddressRepository::getById($id);
        if ($address === null) {
            throw new \RuntimeException('Address Id Does Not Exist');
        }

        $this->authorize('update', [Auth::user(), $address]);

        $datas = $request->validate($request->rules(), $request->all());

        AddressRepository::update($address, $datas);

        return response()->json(['data' => $address, 'success' => true]);
    }

    /**
     * Update the specified resource in storage.
    //* @param Request $request
     * @param int $id
     * @return Address
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(int $id)
    {
        // Get all info from GetProduct by id
        $address = AddressRepository::getById($id);
        if ($address === null) {
            throw new \RuntimeException('Address Id Does Not Exist');
        }

        $this->authorize('delete', [Auth::user(), $address]);

        AddressRepository::delete($address);

        return response()->json($address);
    }

    /**
     * Show the specified resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSearch()
    {
        $this->authorize('viewAny', [Auth::user()]);

//        return view('customer::livewire.customer.address.listing');
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return Address
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById($id)
    {
        $address = AddressRepository::getById($id);

        $this->authorize('view', [Auth::user(), $address]);

        return response()->json($address);
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

        $addresss = AddressRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($addresss);
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

        $address = AddressRepository::search($validatedData);

        return response()->json($address);
    }
}
