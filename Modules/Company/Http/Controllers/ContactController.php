<?php

namespace Modules\Company\Http\Controllers;

//use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Modules\Company\Entities\Contact;
use Modules\Company\Http\Requests\ContactRequest;
use Modules\Company\Repositories\ContactRepository;

class ContactController extends Controller
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
        return view('company::livewire.company.contact.grid');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        return view('company::livewire.company.contact.form');
    }

    /**
     * Store a newly created resource in storage.
     * @param ContactRequest $request
     * @return Contact
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ContactRequest $request)
    {
        $this->authorize('create', [Auth::user()]);
        
        $datas = $request->validate($request->rules(), $request->all());

        $contact = ContactRepository::create($datas);

        return response()->json($contact);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        return view('company::livewire.company.contact.form', ['contactId' => $id]);
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

        return view('company::livewire.company.contact.form', ['contactId' => $id, 'withEdit' => true]);
    }

    /**
     * Update the specified resource in storage.
     * @param ContactRequest $request
     * @param int $id
     * @return Contact
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ContactRequest $request, $id)
    {
        // Get all info from Contact by id
        $contact = ContactRepository::getById($id);
        if ($contact === null) {
            throw new \RuntimeException('Contact Id Does Not Exist');
        }

        $this->authorize('update', [Auth::user(), $contact]);

        $datas = $request->validate($request->rules(), $request->all());

        ContactRepository::update($contact, $datas);

        return response()->json(['data' => $contact, 'success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Contact
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        // Get all info from GetContact by id
        $contact = ContactRepository::getById($id);
        if ($contact === null) {
            throw new \RuntimeException('Contact Id Does Not Exist');
        }

        $this->authorize('delete', [Auth::user(), $contact]);

        ContactRepository::delete($contact);

        return response()->json($contact);
    }

    

    /**
     * Show the specified resource.
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function showSearch()
    {
        $this->authorize('viewAny', [Auth::user()]);

        return view('company::livewire.company.contact.listing');
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id
     * @return Contact
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getById($id)
    {
        $contact = ContactRepository::getById($id);

        $this->authorize('view', [Auth::user(), $contact]);

        return response()->json($contact);
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

        $contact = ContactRepository::getList($validatedData);

        return response()->json($contact);
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

        $contact = ContactRepository::getPaginate($currentPage, $perPage, $validatedData);

        return response()->json($contact);
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

        $contact = ContactRepository::search($validatedData);

        return response()->json($contact);
    }
}
