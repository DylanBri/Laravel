<?php

namespace Modules\Company\Http\Controllers;

//use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Modules\Company\Entities\Payment;
use Modules\Company\Http\Requests\PaymentRequest;
use Modules\Company\Repositories\PaymentRepository;

class PaymentController extends Controller
{
    protected $repository;

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->authorizeResource(Company::class, 'Company');
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', [Auth::user()]);
        return view('company::livewire.company.payment.grid');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        return view('company::livewire.company.payment.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param PaymentRequest $request
     * @return Payment
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(PaymentRequest $request)
    {
        $this->authorize('create', [Auth::user()]);
        
        $datas = $request->validate($request->rules(), $request->all());

        $payment = PaymentRepository::create($datas);

        return response()->json($payment);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        return view('company::livewire.company.payment.form', ['paymentId' => $id]);
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

        return view('company::livewire.company.payment.form', ['paymentId' => $id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param PaymentRequest $request
     * @param int $id
     * @return Payment
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(PaymentRequest $request, $id)
    {
        // Get all info from PaymentCompany by id
        $payment = paymentRepository::getById($id);
        if ($payment === null) {
            throw new \RuntimeException('Payment Id Does Not Exist');
        }

        $this->authorize('update', [Auth::user(), $payment]);

        $datas = $request->validate($request->rules(), $request->all());

        PaymentRepository::update($payment, $datas);

        return response()->json(['data' => $payment, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Payment
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        // Get all info from GetPayment by id
        $payment = PaymentRepository::getById($id);
        if ($payment === null) {
            throw new \RuntimeException('payment Id Does Not Exist');
        }

        $this->authorize('delete', [Auth::user(), $payment]);

        PaymentRepository::delete($payment);

        return response()->json($payment);
    }

    /**
     * Show the specified resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSearch()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('company::livewire.company.payment.listing');
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return Payment
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById($id)
    {
        $payment = PaymentRepository::getById($id);

        $this->authorize('view', [Auth::user(), $payment]);

        return response()->json($payment);
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

        $payment = PaymentRepository::getList($validatedData);

        return response()->json($payment);
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

        $payment = PaymentRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($payment);
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

        $payment = PaymentRepository::search($validatedData);

        return response()->json($payment);
    }
}
