<?php

namespace Modules\Profile\Http\Livewire\Layouts\Form;

use App\Models\UserCoordinate;
use App\Repositories\UserCoordinateRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UpdateAddressForm extends Component
{
    Use AuthorizesRequests;

    /**
     * The component's state.
     *
     * @var UserCoordinate
     */
    public $coordinate;

    /**
     * @var boolean $isModal
     */
    public $isModal;

    protected $rules = [
        'coordinate.user_id' => 'nullable|integer',
        'coordinate.category_id' => 'nullable|integer',
        'coordinate.quality' => 'nullable|max:50',
        'coordinate.address' => 'required|max:255',
        'coordinate.address2' => 'nullable|max:255',
        'coordinate.zip_code' => 'nullable|regex:/^\d{5}(?:[-\s]\d{4})?$/',
        'coordinate.city' => 'nullable|max:255',
        'coordinate.region' => 'nullable|max:255',
        'coordinate.country' => 'required|max:50',
//        'coordinate.country' => 'required|exists:countries',
        'coordinate.phone' => 'nullable|regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.0-9]*$/',
        'coordinate.mobile' => 'nullable|regex:/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.0-9]*$/',
    ];

    protected $listeners = [
        'user-address-form-update' => 'mount',
        'user-address-form-success' => 'showSuccessUpdate',
        'user-address-form-error' => 'showErrorUpdate',
        'field-updated' => 'fieldUpdated',
        'submitForm' => 'validateAddressInformation'
    ];

    /**
     * Prepare the component.
     * @param int $userId
     * @param bool $isModal
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(int $userId = 0, bool $isModal = false)
    {
        /** @var UserCoordinate $coordinate */
        $coordinate = UserCoordinateRepository::getByUserId($userId);

        $this->authorize('view', [Auth::user(), $coordinate]);
        if ($coordinate === null) {
            $coordinate = new UserCoordinate();
        }
        $this->coordinate = $coordinate;
        $this->isModal = $isModal;
        $this->emit('user-address-form-mount', $this->coordinate);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('profile::livewire.layouts.form.update-address-form');
    }

    /**
     * Updated the user's address information.
     * @param string $property
     * @param mixed $value
     *
     * @return void
     */
    public function fieldUpdated(string $property, $value)
    {
        $this->coordinate->setAttribute($property, $value);
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

        $this->authorize('update', [Auth::user(), $this->coordinate]);

        $this->emit('user-address-form-validate', $validateData);
//        $this->emit('address-form-validate', []);
    }

    /**
     * Show error message ajax after update form from the component.
     * @param array $errors
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError('user.' . $field, join(' - ', $error));
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
