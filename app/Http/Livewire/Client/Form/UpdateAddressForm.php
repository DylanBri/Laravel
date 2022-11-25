<?php

namespace App\Http\Livewire\Client\Form;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateAddressForm extends Component
{
    Use AuthorizesRequests;

    /**
     * The component's state.
     *
     * @var Client
     */
    public $client;

    /**
     * @var boolean $isModal
     */
    public $isModal;

    protected $rules = [
        'client.address' => 'required|max:255',
        'client.address2' => 'nullable|max:255',
        'client.zip_code' => 'nullable|regex:/^\d{5}(?:[-\s]\d{4})?$/',
        'client.city' => 'nullable|max:255',
        'client.country' => 'required|max:50',
//        'client.country' => 'required|exists:countries',
        'client.phone' => 'nullable|regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.0-9]*$/',
    ];

    protected $listeners = [
        'client-address-form-update' => 'mount',
        'client-address-form-success' => 'showSuccessUpdate',
        'client-address-form-error' => 'showErrorUpdate',
        'field-updated' => 'fieldUpdated',
        'submitForm' => 'validateAddressInformation'
    ];

    /**
     * Prepare the component.
     * @param int $clientId
     * @param bool $isModal
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(int $clientId = 0, bool $isModal = false)
    {
        /** @var Client $client */
        $client = ClientRepository::getById($clientId);

        $this->authorize('view', [Auth::user(), $client]);
        $this->client = $client;
        $this->isModal = $isModal;
        $this->emit('client-address-form-mount', $this->client);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.client.form.update-address-form');
    }

    /**
     * Updated the office settings information.
     * @param string $property
     * @param mixed $value
     *
     * @return void
     */
    public function fieldUpdated(string $property, $value)
    {
        $this->client->setAttribute($property, $value);
    }

    /**
     * Validate the user's address information.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateAddressInformation()
    {
        $validateData = $this->validate();

        $this->authorize('update', [Auth::user(), $this->client]);

        $this->emit('client-address-form-validate', $validateData);
//        $this->emit('client-address-form-validate', []);
    }

    /**
     * Show error message ajax after update form from the component.
     * @param array $errors
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError('client.' . $field, join(' - ', $error));
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
