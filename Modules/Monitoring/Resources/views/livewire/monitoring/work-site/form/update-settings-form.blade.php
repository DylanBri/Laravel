<x-jet-form-simple id="workSiteSettingsForm" submit="validateWorkSiteSettingsInformation">
    <x-slot name="form">
        @csrf
        <div class="md:grid md:gap-6 md:grid-cols-1">
            <div class="mt-5 md:mt-0">
                <div class="col-span-6 sm:col-span-4 flex">
                        <!-- Id -->
                        <div class="w-20 mr-2">
                            <label for="id">{{ __('monitoring::work-site.Id') }}</label>
                            <input id="id" type="text" class="form-input input-text input-disabled" disabled wire:model.defer="workSite.id"/>
                            @error('workSite.id') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                    <!-- Name -->
                    <div class="flex-1 mr-2">
                        <label for="name">{{ __('monitoring::work-site.Name') }}</label>
                        <input id="name" type="text" class="form-input input-text" wire:model.defer="workSite.name"/>
                        @error('workSite.name') <span class="text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Customer_Name -->
                    <div class="flex-1 mr-2">
                        <input id="customer_id" type="hidden" wire:model.defer="work-site.customer_id"/>
                        <label for="customer_name">{{ __('monitoring::work-site.Customer_name') }}</label>
                        <input id="customer_name" type="text" class="form-input input-text" wire:model.defer="workSite.customer_name"/>
                        @error('workSite.customer_id') <span class="text-error">{{ $message }}</span> @enderror
                        @error('workSite.customer_name') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4 flex">
                    <div class="flex-1 mr-2">
                        <!-- Notes -->
                        <div class="flex-1 mr-2">    
                            <label for="notes">{{ __('monitoring::work-site.Notes') }}</label>    
                            <textarea id="notes" class="form-textarea input-text" wire:model.defer="workSite.notes"></textarea>    
                            @error('workSite.notes') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Address1 -->
                    <div class="flex-1 mr-2">
                        <label for="address1">{{ __('customer::address.Address 1') }}</label>
                        <input id="address1" type="text" class="form-input input-text" wire:model.defer="workSite.address1"/>
                        @error('workSite.address1') <span class="text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Address2 -->
                    <div class="flex-1 mr-2">
                        <label for="address2">{{ __('customer::address.Address 2') }}</label>
                        <input id="address2" type="text" class="form-input input-text" wire:model.defer="workSite.address2"/>
                        @error('workSite.address2') <span class="text-error">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex-1 flex">
                        <!-- zip_code -->
                        <div class="flex-1 mr-2">
                            <label for="zip_code">{{ __('customer::address.Zip Code') }}</label>
                            <input id="zip_code" type="text" class="form-input input-text" wire:model.defer="workSite.zip_code"/>
                            @error('workSite.zip_code') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- City -->
                        <div class="flex-1 mr-2">
                            <label for="city">{{ __('customer::address.City') }}</label>
                            <input id="city" type="text" class="form-input input-text" wire:model.defer="workSite.city"/>
                            @error('workSite.city') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <label for="cumul">{{ __('monitoring::work-site.Cumul') }}</label>
            <input id="cumul" type="number" class="form-input input-text input-disabled" disabled wire:model.defer="workSite.cumul" step="0.01"/>
            @error('workSite.cumul') <span class="text-error">{{ $message }}</span> @enderror
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
            @livewire('components.alert', ['elId' => 'work-site-form-alert-success', 'type' => 'alert-success'])
        </div>
    </x-jet-action-message>
</x-jet-form-simple>

@include('monitoring::livewire.monitoring.work-site.form.update-settings-form-js')
