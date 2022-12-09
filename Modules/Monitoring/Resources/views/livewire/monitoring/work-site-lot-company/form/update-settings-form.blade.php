<x-jet-form-simple id="workSiteLotCompanySettingsForm" submit="validateWorkSiteLotCompanySettingsInformation">
    <x-slot name="form">
        @csrf
        <div class="md:grid md:gap-6 md:grid-cols-1">
            <div class="mt-5 md:mt-0">
                <div class="col-span-6 sm:col-span-4 flex">
                    <div class="">
                        <!-- Id -->
                        <div class="w-20 mr-2">
                            <label for="id">{{ __('monitoring::work-site-lot-company.Id') }}</label>
                            <input id="id" type="text" class="form-input input-text input-disabled" disabled wire:model.defer="workSiteLotCompany.id"/>
                            @error('workSiteLotCompany.id') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="flex-1 mr-2">
                        <label for="name">{{ __('monitoring::work-site-lot-company.Name') }}</label>
                        <input id="name" type="text" class="form-input input-text" wire:model.defer="workSiteLotCompany.name"/>
                        @error('workSiteLotCompany.name') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4 flex">
                    <div class="flex-1 flex">
                        <!-- Lot_Name -->
                        <div class="flex-1 mr-2">
                            <input id="lot_id" type="hidden" wire:model.defer="workSiteLotCompany.lot_id"/>
                            <label for="lot_name">{{ __('monitoring::monitoring.Lot_name') }}</label>
                            <input id="lot_name" type="text" class="form-input input-text" wire:model.defer="workSiteLotCompany.lot_name"/>
                            @error('workSiteLotCompany.lot_name') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Work_site_Name -->
                        <div class="flex-1 mr-2">
                            <input id="work_site_id" type="hidden" wire:model.defer="workSiteLotCompany.work_site_id"/>
                            <label for="work_site_name">{{ __('monitoring::monitoring.Work_site_name') }}</label>
                            <input id="work_site_name" type="text" class="form-input input-text" wire:model.defer="workSiteLotCompany.work_site_name"/>
                            @error('workSiteLotCompany.work_site_name') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4 flex">
                    <div class="flex-1 flex">
                        <!-- Company_name -->
                        <div class="flex-1 mr-2">
                            <input id="company_id" type="hidden" wire:model.defer="workSiteLotCompany.company_id"/>
                            <label for="company_name">{{ __('monitoring::lot.Company_name') }}</label>
                            <input id="company_name" type="text" class="form-input input-text" wire:model.defer="workSiteLotCompany.company_name"/>
                            @error('workSiteLotCompany.company_name') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Amount_ttc -->
                        <div class="flex-1 mr-2">
                            <label for="amount_ttc">{{ __('monitoring::work-site-lot-company.Amount_ttc') }}</label>
                            <input id="amount_ttc" type="number" class="form-input input-text" wire:model.defer="workSiteLotCompany.amount_ttc"/>
                            @error('workSiteLotCompany.amount_ttc') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="cumulMonitoring">
            <label for="cumul">{{ __('monitoring::work-site.Cumul') }}</label>
            <input id="cumul" type="number" class="form-input input-text input-disabled" disabled wire:model.defer="workSiteLotCompany.cumul_monitoring"/>
            @error('workSiteLotCompany.cumul_monitoring') <span class="text-error">{{ $message }}</span> @enderror
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
            @livewire('components.alert', ['elId' => 'work-site-lot-company-form-alert-success', 'type' => 'alert-success'])
        </div>
    </x-jet-action-message>
</x-jet-form-simple>

@include('monitoring::livewire.monitoring.work-site-lot-company.form.update-settings-form-js')
