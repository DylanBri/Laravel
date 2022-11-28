<?php

namespace Modules\Monitoring\Http\Livewire\Monitoring\Form;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Monitoring\Entities\Monitoring;
use Modules\Monitoring\Repositories\MonitoringRepository;
use Modules\Monitoring\Repositories\WorkSiteLotCompanyRepository;

class UpdateSettingsForm extends Component
{
    Use AuthorizesRequests;

    /**
     * The component's state.
     *
     * @var Monitoring
     */
    public $monitoring;

    /**
     * The component's state.
     *
     * @var WorkSiteLotCompany
     */
    public $workSiteLotCompany;

    /**
     * @var boolean $isModal
     */
    public $isModal;

    /**
     * @var boolean $isEdit
     *
     * public $isEdit;
     */

    protected $rules = [
        'monitoring.client_id' => 'bail|required|integer',
        'monitoring.parent_id' => 'nullable|integer',
        /*
        'monitoring.lot_id' => 'bail|required|integer',
        'monitoring.lot_name' => 'bail|required|max:255',
        'monitoring.work_site_id' => 'bail|required|integer',
        'monitoring.work_site_name' => 'bail|required|max:255',
        */
        'monitoring.work_site_lot_company_id' => 'nullable|integer',
        'monitoring.work_site_lot_company_name' => 'nullable|max:255',
        'monitoring.id' => 'nullable|integer',
        'monitoring.name'=> 'nullable|max:255',
        'monitoring.date'=> 'nullable|date_format:Y-m-d H:i:s',
        'monitoring.market_amount'=> 'nullable|numeric',
        'monitoring.modify_market_amount'=> 'nullable|numeric',
        'monitoring.tot_market_amount'=> 'nullable|numeric',
        'monitoring.rate_vat'=> 'nullable|numeric',
        'monitoring.deposit'=> 'nullable|numeric',
        'monitoring.account_percent'=> 'nullable|numeric',
        'monitoring.account'=> 'nullable|numeric',
        'monitoring.account_management_percent'=> 'nullable|numeric',
        'monitoring.account_management'=> 'nullable|numeric',
        'monitoring.bank_guarantee'=> 'nullable|numeric',
        'monitoring.retention_money_percent'=> 'nullable|numeric',
        'monitoring.retention_money'=> 'nullable|numeric',
        'monitoring.balance'=> 'nullable|numeric',
        'monitoring.doc_penality_percent'=> 'nullable|numeric',
        'monitoring.doc_penality'=> 'nullable|numeric',
        'monitoring.work_penality'=> 'nullable|numeric',
        'monitoring.progress'=> 'nullable|numeric',
        'monitoring.balance_du' => 'nullable|numeric',
        'monitoring.payment_amount_ttc'=> 'nullable|numeric',
        'monitoring.deduction_previous_payment' =>'nullable|numeric',
        'monitoring.amount_to_pay' =>'nullable|numeric',
        'monitoring.cumul_work_sit_lot_company'=> 'nullable|numeric',
        'monitoring.cumul_monitoring_previous'=> 'nullable|numeric',
    ];

    protected $listeners = [
        'monitoring-settings-form-update' => 'mount',
        'monitoring-settings-form-success' => 'showSuccessUpdate',
        'monitoring-settings-form-error' => 'showErrorUpdate',
        'monitoring-settings-form-submit' => 'validateMonitoringSettingsInformation'
    ];

    /**
     * Prepare the component.
     * @param int $monitoringId
     * @param bool $isModal
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(int $workSiteLotCompanyId = 0, int $monitoringId = 0, bool $isModal = false)
    {
        $workSiteLotCompany = WorkSiteLotCompanyRepository::getById($workSiteLotCompanyId);
        
        /** @var Monitoring $monitoring */
        $monitoring = MonitoringRepository::getById($monitoringId);

        $this->authorize('view', [Auth::user(), $monitoring]);
        $this->monitoring = ($monitoring === null) ? new Monitoring() : $monitoring;
        
        if ($monitoring === null && $workSiteLotCompanyId > 0) {
            $this->monitoring->setAttribute('work_site_lot_company_id', $workSiteLotCompanyId);
            $this->monitoring->setAttribute('work_site_lot_company_name', $workSiteLotCompany->name);

            // calcul à afficher
            //dd($workSiteLotCompany->cumul_monitoring);
            $this->monitoring->setAttribute('cumul_monitoring_previous', $workSiteLotCompany->cumul_monitoring);
        }
        
        $this->isModal = $isModal;
        //$this->isEdit = $isEdit;
        $this->emit('monitoring-settings-form-mount', $this->monitoring);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('monitoring::livewire.monitoring.form.update-settings-form');
    }

    /**
     * Validate the user's monitoring information.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateMonitoringSettingsInformation()
    {
        $validateData = $this->validate();

        $this->authorize('create', [Auth::user()]);
        $this->authorize('update', [Auth::user(), $this->monitoring]);

        $this->emit('monitoring-settings-form-validate', $validateData);
//        $this->emit('monitoring-settings-form-validate', []);
    }

    /**
     * Show error message ajax after update form from the component.
     * @param array $errors
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError('monitoring.' . $field, join(' - ', $error));
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
