<?php

namespace App\Http\Livewire\Client\Form;

use App\Models\Client;
use App\Repositories\ClientRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdateSettingsForm extends Component
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
        'client.name' => 'bail|required|max:255',
        'client.folder' => 'nullable|max:255',
        'client.email' => 'bail|required|email',
        'client.licence' => 'bail|required|max:50',
//        'client.licence_expired_at_show' => 'bail|required|date_format:d-m-Y',
        'client.licence_expired_at' => 'nullable|date_format:Y-m-d H:i:s',
        'client.socket_host' => 'nullable|max:255',
        'client.socket_port' => 'nullable|max:255',
        'client.enabled' => 'bail|required|boolean',
    ];

    protected $listeners = [
        'client-settings-form-update' => 'mount',
        'client-settings-form-success' => 'showSuccessUpdate',
        'client-settings-form-error' => 'showErrorUpdate',
        'field-updated' => 'fieldUpdated',
        'submitForm' => 'validateClientSettings'
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

        if ($client === null) {
            $client = new Client();
        }

        $this->authorize('view', [Auth::user(), $client]);
        $this->client = $client;
        $this->isModal = $isModal;
        $this->emit('client-settings-form-mount', $this->client);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.client.form.update-settings-form');
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
     * Validate the client's settings information.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateClientSettings()
    {
        $validateData = $this->validate();

        $this->authorize('create', [Auth::user()]);
        $this->authorize('update', [Auth::user(), $this->client]);

        $this->emit('client-settings-form-validate', $validateData);
//        $this->emit('client-settings-form-validate', []);
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
