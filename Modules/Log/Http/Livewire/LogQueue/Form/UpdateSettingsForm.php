<?php

namespace Modules\Log\Http\Livewire\LogQueue\Form;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\Log\Entities\LogQueue;

class UpdateSettingsForm extends Component
{
    Use AuthorizesRequests;

    /**
     * @var LogQueue
     */
    public $log;

    /**
     * @var boolean $isModal
     */
    public $isModal;

    protected $rules = [
        'log.name' => 'bail|required|max:50',
        'log.action' => 'bail|required|max:50',
        'log.data' => 'nullable|string',
        'log.log' => 'bail|required|string',
        'log.state' => 'bail|required|integer',
    ];

    protected $listeners = [
        'log-queue-settings-form-update' => 'mount',
        'log-queue-settings-form-success' => 'showSuccessUpdate',
        'log-queue-settings-form-error' => 'showErrorUpdate',
        'field-updated' => 'fieldUpdated',
        'submitForm' => 'validateLogQueueSettings'
    ];

    /**
     * Prepare the component.
     * @param int $logId
     * @param bool $isModal
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function mount(int $logId, bool $isModal = false)
    {
        /** @var LogQueue $log */
        $log = LogQueue::query()->find($logId);

        $this->authorize('view', [Auth::user(), $log]);
        $this->log = $log;

        if ($log === null) {
            $this->log = new LogQueue();
        }

        $this->isModal = $isModal;
        $this->emit('log-queue-settings-form-mount', $this->log);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('log::livewire.log-queue.form.update-settings-form');
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
        $this->log->setAttribute($property, $value);
        $this->emit('log-queue-settings-form-updated', $this->log);
    }

    /**
     * Validate the customer settings information.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function validateLogQueueSettings()
    {
        $validateData = $this->validate();

        $this->authorize('create', [Auth::user()]);
        $this->authorize('update', [Auth::user(), $this->log]);

        $this->emit('log-queue-settings-form-validate', $validateData);
//        $this->emit('log-queue-settings-form-validate', []);
    }

    /**
     * Show error message ajax after update form from the component.
     * @param array $errors
     */
    public function showErrorUpdate(array $errors)
    {
        foreach ($errors as $field => $error) {
            $this->addError('logQueue.' . $field, join(' - ', $error));
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
