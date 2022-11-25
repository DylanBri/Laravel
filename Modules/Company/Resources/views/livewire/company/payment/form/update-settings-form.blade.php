<x-jet-form-simple id="paymentSettingsForm" submit="validatePaymentSettingsInformation">
    <x-slot name="form">
        @csrf
        <div class="md:grid md:gap-6 md:grid-cols-3">
            <div class="mt-5 md:mt-0">
                <!-- Id -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="id">{{ __('company::payment.Id') }}</label>
                    <input id="id" type="text" class="form-input input-text input-disabled" disabled wire:model.defer="payment.id"/>
                    @error('payment.id') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <!-- Amount TTC -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="amount_ttc">{{ __('company::payment.Amount_ttc') }}</label>
                    <input id="amount_ttc" type="number" class="form-input input-text" wire:model.defer="payment.amount_ttc" step=".01"/>
                    @error('payment.amount_ttc') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <!-- payment_request_date -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="payment_request_date">{{ __('company::payment.Payment_request_date') }}</label>
                    <input id="payment_request_date_show" type="text" class="form-input input-text"/>
                    <input id="payment_request_date" type="hidden" class="form-input input-text" wire:model.defer="payment.payment_request_date"/>
                    @error('payment.payment_request_date') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <!-- Company_name -->
                <div class="col-span-6 sm:col-span-4">
                    <input id="company_id" type="hidden" wire:model.defer="payment.company_id"/>
                    <label for="company_name">{{ __('company::payment.Company_name') }}</label>
                    <input id="company_name" type="text" class="form-input input-text" wire:model.defer="payment.company_name"/>
                    @error('payment.company_name') <span class="text-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mt-5 md:mt-0">
                <!-- Name -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="name">{{ __('company::payment.Name') }}</label>
                    <input id="name" type="text" class="form-input input-text" wire:model.defer="payment.name"/>
                    @error('payment.name') <span class="text-error">{{ $message }}</span> @enderror
                </div>
                
                <!-- Payment_method -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="payment_method">{{ __('company::payment.Payment_method') }}</label>
                    <input id="payment_method" type="text" class="form-input input-text" wire:model.defer="payment.payment_method"/>
                    @error('payment.payment_method') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <!-- payment_date -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="payment_date">{{ __('company::payment.Payment_date') }}</label>
                    <input id="payment_date_show" type="text" class="form-input input-text"/>
                    <input id="payment_date" type="hidden" class="form-input input-text" wire:model.defer="payment.payment_date"/>
                    @error('payment.payment_date') <span class="text-error">{{ $message }}</span> @enderror
                </div>
                
                <!-- Customer_name -->
                <div class="col-span-6 sm:col-span-4">
                    <input id="customer_id" type="hidden" wire:model.defer="payment.customer_id"/>
                    <label for="customer_name">{{ __('company::payment.Customer_name') }}</label>
                    <input id="customer_name" type="text" class="form-input input-text" wire:model.defer="payment.customer_name"/>
                    @error('payment.customer_name') <span class="text-error">{{ $message }}</span> @enderror
                </div>

            </div>
            <div class="mt-5 md:mt-0">
                <!-- Is_staged -->
                <div class="col-span-6 sm:col-span-4">    
                    @component('components.toggle-checkbox', [
                    'id' => 'is_staged', 'modelField' => 'payment.is_staged', 'label' => 'company::payment.Is_staged'
                    ])
                    @endcomponent
                    @error('payment.is_staged') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <!-- Is_done -->
                <div class="col-span-6 sm:col-span-4">    
                    @component('components.toggle-checkbox', [
                    'id' => 'is_done', 'modelField' => 'payment.is_done', 'label' => 'company::payment.Is_done'
                    ])
                    @endcomponent
                    @error('payment.is_done') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <!-- Bank_name -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="bank_name">{{ __('company::payment.Bank_name') }}</label>
                    <input id="bank_name" type="text" class="form-input input-text" wire:model.defer="payment.bank_name"/>
                    @error('payment.bank_name') <span class="text-error">{{ $message }}</span> @enderror
                </div>
                
                <div class="col-span-6 sm:col-span-4"></div>

                <!-- Monitoring_name -->
                <div class="col-span-6 sm:col-span-4">
                    <input id="monitoring_id" type="hidden" wire:model.defer="payment.monitoring_id"/>
                    <label for="monitoring_name">{{ __('company::payment.Monitoring_name') }}</label>
                    <input id="monitoring_name" type="text" class="form-input input-text" wire:model.defer="payment.monitoring_name"/>
                    @error('payment.monitoring_name') <span class="text-error">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <div class="@if ($isModal) hidden @endif">
            <button type="submit" class="btn-primary" wire:loading.attr="disabled">
                {{ __('Save') }}
            </button>
        </div>
    </x-slot>

    <x-jet-action-message class="mr-3" on="saved">
        <div class="@if ($isModal) hidden @endif">
            @livewire('components.alert', ['elId' => 'payment-form-alert-success', 'type' => 'alert-success'])
        </div>
    </x-jet-action-message>
</x-jet-form-simple>

@include('company::livewire.company.payment.form.update-settings-form-js')
