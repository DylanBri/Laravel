<?php

namespace Modules\Company\Http\Livewire\Company\Form;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Company\Entities\Company;
use Modules\Company\Repositories\CompanyRepository;

class UpdateSettingsForm extends Component
{
    Use AuthorizesRequests;

    /**
     * The component's state.
     *
     * @var Company
     */
    public $company;

    /**
     * @var boolean $isModal
     */
    public $isModal;

    /**
     * @var boolean $isModal
     */
    public $isEdit;

    protected $rules = [
        'company.id' => 'nullable|integer',
        'company.title' => 'nullable|max:255', 
        'company.name'=> 'bail|required|max:255',
        'company.address_1'=> 'bail|required|max:255',
        'company.address_2'=> 'nullable|max:255',
        'company.zip_code'=> 'bail|required|regex:/^\d{5}(?:[-\s]\d{4})?$/',
        'company.city'=> 'bail|required|max:50',
        'company.country'=> 'nullable|max:50',
        'company.phone'=> 'bail|required|max:50',
        'company.supervisor'=> 'nullable|max:255',
        'company.siret'=> 'bail|required|max:14',
        'company.classification'=> 'bail|required|max:255',
        'company.code_ape'=> 'bail|required|max:5',
        'company.email'=> 'nullable|email',
        'company.insurance'=> 'nullable|max:255',
    ];

    protected $listeners = [
        'company-settings-form-update' => 'mount',
        'company-settings-form-success' => 'showSuccessUpdate',
        'company-settings-form-error' => 'showErrorUpdate',
        'submitForm' => 'validateCompanySettingsInformation'
    ];

    /**
     * Prepare the component.
     * @param int $companyId
     * @param bool $isModal
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(int $companyId, bool $isModal = false, bool $isEdit = false)
    {
        /** @var Company $company */
        $company = CompanyRepository::getById($companyId);

        $this->authorize('view', [Auth::user(), $company]);
        $this->company = ($company === null) ? new Company() : $company;
        $this->isModal = $isModal;
        $this->isEdit = $isEdit;
        $this->emit('company-settings-form-mount', $this->company);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('company::livewire.company.form.update-settings-form');
    }

    /**
     * Validate the user's company information.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateCompanySettingsInformation()
    {
        $validateData = $this->validate();

        $this->authorize('create', [Auth::user()]);
        $this->authorize('update', [Auth::user(), $this->company]);

        $this->emit('company-settings-form-validate', $validateData);
//        $this->emit('company-settings-form-validate', []);
    }

    /**
     * Show error message ajax after update form from the component.
     * @param array $errors
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError('company.' . $field, join(' - ', $error));
            $this->addError('address.' . $field, join(' - ', $error));
        }
    }

    /**
     * Show success message ajax after update form from the component.
     * @param mixed $result
     */
    public function showSuccessUpdate($result)
    {
        $this->emit('saved', $result);
    }
}
