<?php

namespace Modules\Monitoring\Http\Livewire\Monitoring\WorkSiteLotCompany\Form;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Monitoring\Entities\WorkSiteLotCompany;
use Modules\Monitoring\Repositories\WorkSiteLotCompanyRepository;
use Modules\Monitoring\Entities\WorkSite;
use Modules\Monitoring\Repositories\WorkSiteRepository;
use Modules\Monitoring\Repositories\MonitoringRepository;
use Modules\Monitoring\Entities\Lot;
use Modules\Monitoring\Repositories\LotRepository;

class UpdateSettingsForm extends Component
{
    Use AuthorizesRequests;

    /**
     * The component's state.
     *
     * @var WorkSiteLotCompany
     */
    public $workSiteLotCompany;

    /**
     * The component's state.
     *
     * @var WorkSite
     */
    public $workSite;

    /**
     * The component's state.
     *
     * @var Monitoring
     */
    public $monitoring;

    /**
     * @var boolean $isModal
     */
    public $isModal;

    /**
     * @var boolean $isEdit
     */
    public $isEdit;

    protected $rules = [
        'workSiteLotCompany.id' => 'nullable|integer',
        'workSiteLotCompany.work_site_id' => 'nullable|integer',
        'workSiteLotCompany.work_site_name' => 'nullable|max:255',
        'workSiteLotCompany.lot_id' => 'nullable|integer',
        'workSiteLotCompany.lot_name' => 'nullable|max:255',
        'workSiteLotCompany.company_id' => 'nullable|integer',
        'workSiteLotCompany.company_name' => 'nullable|max:255',
        'workSiteLotCompany.monitoring_id' => 'nullable|integer',
        //workSiteLotCompany.customer_id' => 'nullable|integer',
        'workSiteLotCompany.name' => 'nullable|max:255',
        'workSiteLotCompany.type' => 'nullable|boolean',
        'workSiteLotCompany.amount_ttc' => 'nullable|numeric',
        'workSiteLotCompany.cumul_monitoring' => 'nullable|numeric',
        'workSiteLotCompany.cumul_payment' => 'nullable|numeric',
    ];

    protected $listeners = [
        'work-site-lot-company-settings-form-update' => 'mount',
        'work-site-lot-company-settings-form-success' => 'showSuccessUpdate',
        'work-site-lot-company-settings-form-error' => 'showErrorUpdate',
        'work-site-lot-company-submit-form' => 'validateWorkSiteLotCompanySettingsInformation'
    ];

    /**
     * Prepare the component.
     * @param int $workSiteLotCompanyId
     * @param int $monitoringId
     * @param int $typeId
     * @param int $workSiteId
     * @param bool $isModal
     * @param bool $isEdit
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(int $workSiteLotCompanyId = 0, int $monitoringId = 0, int $typeId = 0, int $workSiteId = 0, bool $isModal = false, $isEdit = false)
    {
        $workSite = WorkSiteRepository::getById($workSiteId);

        $monitoring = MonitoringRepository::getById($monitoringId);

        /** @var WorkSiteLotCompany $workSiteLotCompany */
        $workSiteLotCompany = WorkSiteLotCompanyRepository::getById($workSiteLotCompanyId);

        $this->authorize('view', [Auth::user(), $workSiteLotCompany]);
        $this->workSiteLotCompany = ($workSiteLotCompany === null) ? new WorkSiteLotCompany() : $workSiteLotCompany;
        
        /* if ($workSiteLotCompany === null) {
            $this->emit('work-site-lot-company-form-without-customerid');
        } */
        
        if ($workSiteLotCompany === null) {
            if ($workSiteId > 0 && $workSite !== null) {
                $this->workSiteLotCompany->setAttribute('work_site_id', $workSiteId);
                $this->workSiteLotCompany->setAttribute('work_site_name', $workSite->name);
            }
            
            if ($monitoringId > 0 && $monitoring !== null) {
                $this->workSiteLotCompany->setAttribute('monitoring_id', $monitoringId);
                $this->workSiteLotCompany->setAttribute('monitoring_name', $monitoring->name);
            }
            
            $this->workSiteLotCompany->setAttribute('type', $typeId);
        }

        $this->isModal = $isModal;
        $this->isEdit = $isEdit;
        $this->emit('work-site-lot-company-settings-form-mount', $this->workSiteLotCompany);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('monitoring::livewire.monitoring.work-site-lot-company.form.update-settings-form');
    }

    /**
     * Validate the user's WorkSiteLotCompany information.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateWorkSiteLotCompanySettingsInformation()
    {
        $validateData = $this->validate();
        //dd($validateData);
        
        $this->authorize('create', [Auth::user()]);
        $this->authorize('update', [Auth::user(), $this->workSiteLotCompany]);

        $this->emit('work-site-lot-company-settings-form-validate', $validateData);
//        $this->emit('lot-settings-form-validate', []);
    }

    /**
     * Show error message ajax after update form from the component.
     * @param array $errors
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError('workSiteLotCompany.' . $field, join(' - ', $error));
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
