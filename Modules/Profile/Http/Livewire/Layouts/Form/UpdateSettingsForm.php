<?php

namespace Modules\Profile\Http\Livewire\Layouts\Form;

//use Illuminate\Support\Facades\Log;
use App\Models\UserCoordinate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Profile\Entities\User;
use Modules\Profile\Repositories\AdministratorRepository;
use Modules\Profile\Repositories\ManagerRepository;
use Modules\Profile\Repositories\SuperAdministratorRepository;
use Modules\Profile\Repositories\UserRepository;

class UpdateSettingsForm extends Component
{
    Use AuthorizesRequests;

    /**
     * The component's state.
     *
     * @var User
     */
    public $user;

    /**
     * @var boolean $isModal
     */
    public $isModal;

    /**
     * @var boolean $isModal
     */
    public $type;

    protected $rules = [
        'user.name' => 'bail|required|max:255',
        'user.email' => 'bail|required|email',
        'user.password' => 'nullable|max:255',
        'user.enabled' => 'bail|required|boolean',
        'user.suppressed' => 'bail|required|boolean',
    ];

    protected $listeners = [
        'user-settings-form-update' => 'mount',
        'user-settings-form-success' => 'showSuccessUpdate',
        'user-settings-form-error' => 'showErrorUpdate',
        'field-updated' => 'fieldUpdated',
        'submitForm' => 'validateUserSettings'
    ];

    /**
     * Prepare the component.
     * @param int $userId
     * @param string $type
     * @param bool $isModal
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(int $userId = 0, string $type, bool $isModal = false)
    {
        switch ($type) :
            case 'supadm' :
                $user = SuperAdministratorRepository::getById($userId);
                break;
            case 'admin' :
                $user = AdministratorRepository::getById($userId);
                break;
            case 'manager' :
                $user = ManagerRepository::getById($userId);
                break;
            case 'user' :
                $user = UserRepository::getById($userId);
                break;
            default :
                $user = null;
        endswitch;

        if ($user !== null && $userId > 0) {
            $user->setAttribute('password', null);
            $this->authorize('view', [Auth::user(), $user]);
        } elseif ($userId === 0) {
            $user = new UserCoordinate();
        }

        $this->user = $user;
        $this->type = $type;
        $this->isModal = $isModal;
        $this->emit('user-settings-form-mount', $user);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('profile::livewire.layouts.form.update-settings-form');
    }

    /**
     * Updated the user's setting information.
     * @param string $property
     * @param mixed $value
     *
     * @return void
     */
    public function fieldUpdated(string $property, $value)
    {
        $this->user->setAttribute($property, $value);
    }

    /**
     * Validate the user's setting information.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateUserSettings()
    {
        $validateData = $this->validate();

        $this->authorize('create', [Auth::user()]);
        $this->authorize('update', [Auth::user(), $this->user]);

        $this->emit('user-settings-form-validate', $validateData);
//        $this->emit('user-settings-form-validate', []);
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
