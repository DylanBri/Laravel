<?php

namespace Modules\Company\Http\Livewire\Company\Contact\Form;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Company\Entities\Contact;
use Modules\Company\Repositories\ContactRepository;
use Modules\Company\Repositories\CompanyRepository;

class UpdateSettingsForm extends Component
{
    Use AuthorizesRequests;
    
    /**
     * The component's state.
     *
     * @var Contact
     */
    public $contact;
    
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

    protected $rules = [
        'contact.client_id' => 'nullable|integer',
        'contact.company_id' => 'nullable|integer',
        'contact.company_name' => 'nullable|max:255',
        'contact.firstname' => 'nullable|max:255', 
        'contact.lastname'=> 'nullable|max:255',
        'contact.phone'=> 'nullable|max:50',
        'contact.email'=> 'nullable|email',
        'contact.enabled' => 'nullable|boolean',
        'contact.suppressed' => 'nullable|boolean'
    ];

    protected $listeners = [
        'contact-settings-form-update' => 'mount',
        'contact-settings-form-success' => 'showSuccessUpdate',
        'contact-settings-form-error' => 'showErrorUpdate',
        'contactSubmitForm' => 'validateContactSettingsInformation'
    ];

    /**
     * Prepare the component.
     * @param int $contactId
     * @param int $companyId
     * @param bool $isModal
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(int $companyId = 0, int $contactId, bool $isModal = false)
    {
        $company = CompanyRepository::getById($companyId);
        /** @var Contact $contact */
        $contact = ContactRepository::getById($contactId);

        $this->authorize('view', [Auth::user(), $contact]);
        $this->contact = ($contact === null) ? new Contact() : $contact;

        if ($contact === null && $companyId > 0 && $company !== null) {
            $this->contact->setAttribute('company_id', $companyId);
            $this->contact->setAttribute('company_name', $company->name);
        }

        $this->isModal = $isModal;
        $this->emit('contact-settings-form-mount', $this->contact);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('company::livewire.company.contact.form.update-settings-form');
    }

    /**
     * Validate the user's contact information.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateContactSettingsInformation()
    {
        $validateData = $this->validate();
        
        $this->authorize('create', [Auth::user()]);
        $this->authorize('update', [Auth::user(), $this->contact]);

        $this->emit('contact-settings-form-validate', $validateData);
//        $this->emit('contact-settings-form-validate', []);
    }

    /**
     * Show error message ajax after update form from the component.
     * @param array $errors
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError('contact.' . $field, join(' - ', $error));
            $this->addError('company.' . $field, join(' - ', $error));
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
