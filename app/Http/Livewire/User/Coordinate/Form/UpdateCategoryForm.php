<?php

namespace App\Http\Livewire\User\Coordinate\Form;

use App\Models\UserCategory;
use App\Models\UserCoordinate;
use App\Repositories\UserCoordinateRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UpdateCategoryForm extends Component
{
    Use AuthorizesRequests;

    /**
     * @var UserCategory
     */
    public $category;

    /**
     * @var boolean $isModal
     */
    public $isModal;

    protected $rules = [
        'category.name' => 'required|max:50',
    ];

    protected $listeners = [
        'category-form-update' => 'mount',
        'category-form-success' => 'showSuccessUpdate',
        'category-form-error' => 'showErrorUpdate',
        'field-updated' => 'fieldUpdated',
        'submitForm' => 'validateUserCategory'
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
        $coordinate = UserCoordinateRepository::getByUserId(Auth::user()->getAuthIdentifier());

        $this->authorize('view', [Auth::user(), $coordinate]);
        /** @var UserCategory $category */
        $category = $coordinate->category()->first();
        $this->category = $category;
        $this->isModal = $isModal;
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.user.coordinate.form.update-category-form');
    }

    /**
     * Updated the user's category information.
     * @param string $property
     * @param mixed $value
     *
     * @return void
     */
    public function fieldUpdated(string $property, $value)
    {
        $this->category->setAttribute($property, $value);
    }

    /**
     * Validate the user's category information.
     *
     * @return void
//     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateUserCategory()
    {
//        $this->validate();

//        $this->authorize('update', [Auth::user(), $this->category]);

        $this->emit('category-form-validate', $this->category);
    }

    /**
     * Show error message ajax after update form from the component.
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError($field, join(' - ', $error));
        }
    }

    /**
     * Show success message ajax after update form from the component.
     */
    public function showSuccessUpdate($result)
    {
        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }
}
