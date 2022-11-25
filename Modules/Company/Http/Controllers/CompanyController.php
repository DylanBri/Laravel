<?php

namespace Modules\Company\Http\Controllers;

//use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Modules\Company\Entities\Company;
use Modules\Company\Http\Requests\CompanyRequest;
use Modules\Company\Repositories\CompanyRepository;

class CompanyController extends Controller
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
        return view('company::livewire.company.grid');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', [Auth::user()]);

        return view('company::livewire.company.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param CompanyRequest $request
     * @return Company
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CompanyRequest $request)
    {
        $this->authorize('create', [Auth::user()]);

        $datas = $request->validate($request->rules(), $request->all());

        $company = CompanyRepository::create($datas);

        return response()->json($company);
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

        return view('company::livewire.company.form', ['companyId' => $id]);
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

        return view('company::livewire.company.form', ['companyId' => $id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param CompanyRequest $request
     * @param int $id
     * @return Company
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CompanyRequest $request, $id)
    {
        // Get all info from GetCompany by id
        $company = CompanyRepository::getById($id);
        if ($company === null) {
            throw new \RuntimeException('Company Id Does Not Exist');
        }

        $this->authorize('update', [Auth::user(), $company]);

        $datas = $request->validate($request->rules(), $request->all());
        
        CompanyRepository::update($company, $datas);

        return response()->json(['data' => $company, 'success' => true]);

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Company
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        // Get all info from GetCompany by id
        $company = CompanyRepository::getById($id);
        if ($company === null) {
            throw new \RuntimeException('company Id Does Not Exist');
        }

        $this->authorize('delete', [Auth::user(), $company]);

        CompanyRepository::delete($company);

        return response()->json($company);
    }

      /**
     * Show the specified resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSearch()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('company::livewire.company.listing');
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return Company
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById($id)
    {
        $company = CompanyRepository::getById($id);

        $this->authorize('view', [Auth::user(), $company]);

        return response()->json($company);
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

        $company = CompanyRepository::getList($validatedData);

        return response()->json($company);
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

        $company = CompanyRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($company);
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

        $company = CompanyRepository::search($validatedData);

        return response()->json($company);
    }
}
