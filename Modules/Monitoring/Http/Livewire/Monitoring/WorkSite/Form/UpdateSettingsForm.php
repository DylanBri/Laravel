<?php

namespace Modules\Monitoring\Http\Livewire\Monitoring\WorkSite\Form;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Monitoring\Entities\WorkSite;
use Modules\Monitoring\Repositories\WorkSiteRepository;
use Modules\Customer\Repositories\CustomerRepository;

class UpdateSettingsForm extends Component
{
    Use AuthorizesRequests;

    /**
     * The component's state.
     *
     * @var WorkSite
     */
    public $workSite;

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
        'workSite.client_id' => 'nullable|integer',
        'workSite.customer_id' => 'nullable|integer',
        'workSite.customer_name' => 'nullable|max:255',
        'workSite.address1' => 'nullable|max:255',
        'workSite.address2' => 'nullable|max:255',
        'workSite.city' => 'nullable|max:255',
        'workSite.zip_code' => 'nullable|max:10',
        'workSite.country' => 'nullable|max:50',
        'workSite.id' => 'nullable|integer',
        'workSite.name'=> 'nullable|max:255',
        'workSite.notes'=> 'nullable|max:255',
        'workSite.cumul'=> 'nullable|numeric',
    ];

    protected $listeners = [
        'work-site-settings-form-update' => 'mount',
        'work-site-settings-form-success' => 'showSuccessUpdate',
        'work-site-settings-form-error' => 'showErrorUpdate',
        'work-site-submit-form' => 'validateWorkSiteSettingsInformation'
    ];

    /**
     * Prepare the component.
     * @param int $customerId
     * @param int $workSiteId
     * @param bool $isModal
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(int $customerId = 0, int $workSiteId = 0, bool $isModal = false, bool $isEdit = false)
    {
        $customer = CustomerRepository::getById($customerId);

        /** @var WorkSite $WorkSite */
        $workSite = WorkSiteRepository::getById($workSiteId);

        $this->authorize('view', [Auth::user(), $workSite]);
        $this->workSite = ($workSite === null) ? new WorkSite() : $workSite;

        if ($workSite === null && $customerId > 0) {
            $this->workSite->setAttribute('customer_id', $customerId);
            $this->workSite->setAttribute('customer_name', $customer->name);
        }

        $this->isModal = $isModal;
        $this->isEdit = $isEdit;
        $this->emit('work-site-settings-form-mount', $this->workSite);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('monitoring::livewire.monitoring.work-site.form.update-settings-form');
    }

    /**
     * Validate the user's WorkSite information.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateWorkSiteSettingsInformation()
    {
        $validateData = $this->validate();

        $this->authorize('create', [Auth::user()]);
        $this->authorize('update', [Auth::user(), $this->workSite]);

        $this->emit('work-site-settings-form-validate', $validateData);
//        $this->emit('work-site-settings-form-validate', []);
    }

    /**
     * Show error message ajax after update form from the component.
     * @param array $errors
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError('workSite.' . $field, join(' - ', $error));
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
