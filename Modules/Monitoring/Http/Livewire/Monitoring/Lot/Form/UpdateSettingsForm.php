<?php

namespace Modules\Monitoring\Http\Livewire\Monitoring\Lot\Form;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Monitoring\Entities\Lot;
use Modules\Monitoring\Repositories\LotRepository;

class UpdateSettingsForm extends Component
{
    Use AuthorizesRequests;

    /**
     * The component's state.
     *
     * @var Lot
     */
    public $lot;

    /**
     * @var boolean $isModal
     */
    public $isModal;

    protected $rules = [
        'lot.client_id' => 'nullable|integer',
        'lot.id' => 'nullable|integer',
        'lot.name'=> 'bail|required|max:255',
        'lot.description'=> 'nullable|max:255'
    ];

    protected $listeners = [
        'lot-settings-form-update' => 'mount',
        'lot-settings-form-success' => 'showSuccessUpdate',
        'lot-settings-form-error' => 'showErrorUpdate',
        'lotSubmitForm' => 'validateLotSettingsInformation'
    ];

    /**
     * Prepare the component.
     * @param int $lotId
     * @param bool $isModal
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(int $lotId, bool $isModal = false)
    {
        /** @var Lot $lot */
        $lot = LotRepository::getById($lotId);

        $this->authorize('view', [Auth::user(), $lot]);
        $this->lot = ($lot === null) ? new Lot() : $lot;
        $this->isModal = $isModal;
        $this->emit('lot-settings-form-mount', $this->lot);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('monitoring::livewire.monitoring.lot.form.update-settings-form');
    }

    /**
     * Validate the user's lot information.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateLotSettingsInformation()
    {
        $validateData = $this->validate();

        $this->authorize('create', [Auth::user()]);
        $this->authorize('update', [Auth::user(), $this->lot]);

        $this->emit('lot-settings-form-validate', $validateData);
//        $this->emit('lot-settings-form-validate', []);
    }

    /**
     * Show error message ajax after update form from the component.
     * @param array $errors
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError('lot.' . $field, join(' - ', $error));
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
