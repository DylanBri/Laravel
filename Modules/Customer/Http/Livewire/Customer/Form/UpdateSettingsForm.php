<?php

namespace Modules\Customer\Http\Livewire\Customer\Form;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Repositories\CustomerRepository;

class UpdateSettingsForm extends Component
{
    Use AuthorizesRequests;

    /**
     * The component's state.
     *
     * @var Customer
     */
    public $customer;

    /**
     * @var boolean $isModal
     */
    public $isModal;

    /**
     * @var boolean $isEdit
     */
    public $isEdit;

    protected $rules = [
        'customer.id' => 'nullable|integer',
        'customer.address_1' => 'bail|required|max:255',
        'customer.address_2' => 'nullable|max:255',
        'customer.zip_code' => 'bail|required|regex:/^\d{5}(?:[-\s]\d{4})?$/',
        'customer.city' => 'bail|required|max:50',
        'customer.country' => 'nullable|max:50',
        'customer.name' => 'bail|required|max:255',
        'customer.gender' => 'nullable|max:255',
        'customer.phone' => 'nullable|max:50',
        'customer.email' => 'nullable|email',
    ];

    protected $listeners = [
        'customer-settings-form-update' => 'mount',
        'customer-settings-form-success' => 'showSuccessUpdate',
        'customer-settings-form-error' => 'showErrorUpdate',
        'customer-submit-form' => 'validateCustomerSettingsInformation'
    ];

    /**
     * Prepare the component.
     * @param int $customerId
     * @param bool $isModal
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(int $customerId, bool $isModal = false, bool $isEdit = false)
    {
        /** @var Customer $customer */
        $customer = CustomerRepository::getById($customerId);

        $this->authorize('view', [Auth::user(), $customer]);
        if($customer === null)
        {
            
            $this->emit('work-site-form-without-customerid');
        }
        $this->customer = ($customer === null) ? new Customer() : $customer;
        $this->isModal = $isModal;
        $this->isEdit = $isEdit;
        $this->emit('customer-settings-form-mount', $this->customer);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('customer::livewire.customer.form.update-settings-form');
    }

    /**
     * Validate the user's customer information.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateCustomerSettingsInformation()
    {
        $validateData = $this->validate();

        $this->authorize('create', [Auth::user()]);
        $this->authorize('update', [Auth::user(), $this->customer]);

        $this->emit('customer-settings-form-validate', $validateData);
//        $this->emit('customer-settings-form-validate', []);
    }

    /**
     * Show error message ajax after update form from the component.
     * @param array $errors
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError('customer.' . $field, join(' - ', $error));
            $this->addError('address.' . $field, join(' - ', $error));
        }
    }

    /**
     * Show success message ajax after update form from the component.
     * @param mixed $result
     */
    public function showSuccessUpdate($result)
    {
        //dd($result);
        $this->emit('saved', $result);
    }
}
