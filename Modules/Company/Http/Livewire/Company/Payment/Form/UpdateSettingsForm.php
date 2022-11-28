<?php

namespace Modules\Company\Http\Livewire\Company\Payment\Form;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Company\Entities\Payment;
use Modules\Company\Repositories\PaymentRepository;

class UpdateSettingsForm extends Component
{
    Use AuthorizesRequests;
    
    /**
     * The component's state.
     *
     * @var Payment
     */
    public $payment;

    /**
     * @var boolean $isModal
     */
    public $isModal;

    /**
     * @var boolean $isEdit
     * 
     */
    public $isEdit;

    protected $rules = [
        'payment.client_id' => 'nullable|integer',
        'payment.customer_id' => 'nullable|integer',
        'payment.customer_name' => 'nullable|string',
        'payment.company_id' => 'nullable|integer',
        'payment.company_name' => 'nullable|string',
        'payment.monitoring_id' => 'nullable|integer',
        'payment.monitoring_name' => 'nullable|string',
        'payment.id' => 'nullable|integer',
        'payment.name' => 'nullable|string',
        'payment.payment_request_date' => 'nullable|date_format:Y-m-d H:i:s',
        'payment.amount_ttc' => 'nullable|numeric',
        'payment.is_staged' => 'nullable|boolean',
        'payment.is_done' => 'nullable|boolean',
        'payment.payment_date' => 'nullable|date_format:Y-m-d H:i:s',
        'payment.payment_method' => 'nullable|string',
        'payment.bank_name' => 'nullable|string',
        'payment.enabled' => 'nullable|boolean',
        'payment.suppressed' => 'nullable|boolean'
    ];

    protected $listeners = [
        'payment-settings-form-update' => 'mount',
        'payment-settings-form-success' => 'showSuccessUpdate',
        'payment-settings-form-error' => 'showErrorUpdate',
        'submitForm' => 'validatePaymentSettingsInformation'
    ];

    /**
     * Prepare the component.
     * @param int $paymentId
     * @param bool $isModal
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(int $paymentId, bool $isModal = false)
    {
        /** @var Payment $payment */
        $payment = PaymentRepository::getById($paymentId);

        $this->authorize('view', [Auth::user(), $payment]);
        $this->payment = ($payment === null) ? new Payment() : $payment;
        $this->isModal = $isModal;
        $this->emit('payment-settings-form-mount', $this->payment);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('company::livewire.company.payment.form.update-settings-form');
    }
    
    /**
     * Validate the user's payment information.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validatePaymentSettingsInformation()
    {
        $validateData = $this->validate();

        $this->authorize('create', [Auth::user()]);
        $this->authorize('update', [Auth::user(), $this->payment]);

        $this->emit('payment-settings-form-validate', $validateData);
//        $this->emit('payment-settings-form-validate', []);
    }

    /**
     * Show error message ajax after update form from the component.
     * @param array $errors
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError('payment.' . $field, join(' - ', $error));
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
