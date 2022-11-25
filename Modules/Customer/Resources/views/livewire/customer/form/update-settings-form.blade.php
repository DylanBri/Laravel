<x-jet-form-simple id="customerSettingsForm" submit="validateCustomerSettingsInformation">
    <x-slot name="form">
        @csrf
        <div class="md:grid md:gap-6 md:grid-cols-1">
            <div class="mt-5 md:mt-0">
                <div class="col-span-6 sm:col-span-4 flex"> 
                    <div class="flex-1 flex">
                        <!-- Id -->
                        <div class="flex-1 mr-2">
                            <label for="id">{{ __('customer::customer.Id') }}</label>
                            <input id="id" type="text" class="form-input input-text input-disabled" disabled wire:model.defer="customer.id"/>
                            @error('customer.id') <span class="text-error">{{ $message }}</span> @enderror
                        </div> 

                        <!-- Gender -->
                        <div class="flex-1 mr-2">
                            <label for="gender">{{ __('customer::customer.Gender') }}</label>
                            <input id="gender" type="text" class="form-input input-text" wire:model.defer="customer.gender"/>
                            @error('customer.gender') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="flex-1 mr-2">
                        <label for="name">{{ __('customer::customer.Name') }}</label>
                        <input id="name" type="text" class="form-input input-text" wire:model.defer="customer.name"/>
                        @error('customer.name') <span class="text-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex-1 flex">
                        <!-- Phone -->
                        <div class="flex-1 mr-2">
                            <label for="phone">{{ __('customer::customer.Phone') }}</label>
                            <input id="phone" type="text" class="form-input input-text" wire:model.defer="customer.phone"/>
                            @error('customer.phone') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Fax -->
                        <div class="flex-1 mr-2">
                            <label for="fax">{{ __('customer::customer.Fax') }}</label>
                            <input id="fax" type="text" class="form-input input-text" wire:model.defer="customer.fax"/>
                            @error('customer.fax') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="col-span-6 sm:col-span-4 flex"> 
                    <!-- Address -->
                    <div class="flex-1 mr-2">
                        <label for="address_1">{{ __('customer::address.Address 1') }}</label>
                        <input id="address_1" type="text" class="form-input input-text"
                            wire:model.defer="customer.address_1"/>
                        @error('customer.address_1') <span class="text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Address 2 -->
                    <div class="flex-1 mr-2">
                        <label for="address_2">{{ __('customer::address.Address 2') }}</label>
                        <input id="address_2" type="text" class="form-input input-text"
                            wire:model.defer="customer.address_2"/>
                        @error('customer.address_2') <span class="text-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex-1 flex">
                        <!-- Zip Code -->
                        <div class="flex-1 mr-2">
                            <label for="zip_code">{{ __('customer::address.Zip Code') }}</label>
                            <input id="zip_code" type="text" class="form-input input-text"
                                wire:model.defer="customer.zip_code"/>
                                @error('customer.zip_code') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- City -->
                        <div class="flex-1">
                            <label for="city">{{ __('customer::address.City') }}</label>
                            <input id="city" type="text" class="form-input input-text" 
                                wire:model.defer="customer.city"/>
                                @error('customer.city') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
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
            @livewire('components.alert', ['elId' => 'customer-form-alert-success', 'type' => 'alert-success'])
        </div>
    </x-jet-action-message>
</x-jet-form-simple>

@include('customer::livewire.customer.form.update-settings-form-js')
