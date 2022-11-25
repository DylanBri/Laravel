<?php

namespace Modules\Customer\Http\Controllers;

//use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Http\Requests\AddressRequest;
use Modules\Customer\Http\Requests\CustomerRequest;
use Modules\Customer\Repositories\CustomerRepository;

class CustomerController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
//        $this->authorizeResource(Customer::class, 'customer');
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('customer::livewire.customer.grid');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', [Auth::user()]);

        return view('customer::livewire.customer.form');
    }

    /**
     * Show the form for creating a new resource.
     * @param CustomerRequest $request
     * @return Customer
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CustomerRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        //$requestAdd = (new AddressRequest());
        $datas = $request->validate($request->rules(), $request->all());
        //$datas['address'] = $request->validate($requestAdd->rules(), $request->all());

        $customer = CustomerRepository::create($datas);

        return response()->json($customer);
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

        return view('customer::livewire.customer.form', ['customerId' => $id]);
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

        return view('customer::livewire.customer.form', ['customerId' => $id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param CustomerRequest $request
     * @param int $id
     * @return Customer
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CustomerRequest $request, int $id)
    {
        // Get all info from GetCustomer by id
        $customer = CustomerRepository::getById($id);
        if ($customer === null) {
            throw new \RuntimeException('Customer Id Does Not Exist');
        }

        $this->authorize('update', [Auth::user(), $customer]);

        //$requestAdd = (new AddressRequest());
        $datas = $request->validate($request->rules(), $request->all());
        //$datas['address'] = $request->validate($requestAdd->rules(), $request->all());

        CustomerRepository::update($customer, $datas);

        return response()->json(['data' => $customer, 'success' => true]);
    }

    /**
     * Remove the specified resource in storage.
     //* @param Request $request
     * @param int $id
     * @return Customer
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(int $id)
    {
        // Get all info from GetCustomer by id
        $customer = CustomerRepository::getById($id);
        if ($customer === null) {
            throw new \RuntimeException('Customer Id Does Not Exist');
        }

        $this->authorize('delete', [Auth::user(), $customer]);

        CustomerRepository::delete($customer);

        return response()->json($customer);
    }

    /**
     * Show the specified resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSearch()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('customer::livewire.customer.listing');
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return Customer
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById($id)
    {
        $customer = CustomerRepository::getById($id);

        $this->authorize('view', [Auth::user(), $customer]);

        return response()->json($customer);
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

        $customers = CustomerRepository::getList($validatedData);

        return response()->json($customers);
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

        $customers = CustomerRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($customers);
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

        $customer = CustomerRepository::search($validatedData);

        return response()->json($customer);
    }
}
