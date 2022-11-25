<?php

namespace App\Http\Livewire\User\Coordinate\Form;

use App\Models\UserCoordinate;
use App\Repositories\UserCoordinateRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
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
        'address-form-update' => 'mount',
        'address-form-success' => 'showSuccessUpdate',
        'address-form-error' => 'showErrorUpdate',
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
        $this->coordinate = $coordinate;
        $this->isModal = $isModal;
        $this->emit('address-form-mount', $this->coordinate);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.user.coordinate.form.update-address-form');
    }

    /**
     * Updated the user's address information.
     * @param string $property
     * @param mixed $value
     *
     * @return void
//     * @throws \Illuminate\Validation\ValidationException
     */
    public function fieldUpdated(string $property, $value)
    {
//        $this->validateOnly($property);

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
        $validateDate = $this->validate();

        $this->authorize('create', [Auth::user()]);
        $this->authorize('update', [Auth::user(), $this->coordinate]);

        $this->emit('address-form-validate', $validateDate);
    }

    /**
     * Show error message ajax after update form from the component.
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError('coordinate.' . $field, join(' - ', $error));
        }
    }

    /**
     * Show success message ajax after update form from the component.
     */
    public function showSuccessUpdate($result)
    {
        $this->emit('saved');
    }
}
