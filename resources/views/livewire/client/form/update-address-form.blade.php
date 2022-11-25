<x-jet-form-section id="clientAddressForm" submit="validateAddressInformation">
    <x-slot name="title">
        {{ __('client.Address Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('client.Update client address information.') }}
    </x-slot>

    <x-slot name="form">
    @csrf
    <!-- Address -->
        <div class="col-span-6 sm:col-span-4">
            <label for="address">{{ __('Address') }}</label>
            <input id="address" type="text" class="form-input input-text" wire:model.defer="client.address"/>
            @error('client.address') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Address2 -->
        <div class="col-span-6 sm:col-span-4">
            <label for="address2">{{ __('address.Address2') }}</label>
            <input id="address2" type="text" class="form-input input-text" wire:model.defer="client.address2"/>
            @error('client.address2') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Zip Code -->
        <div class="col-span-6 sm:col-span-4">
            <label for="zip_code">{{ __('Zip / Postal Code') }}</label>
            <input id="zip_code" type="text" class="form-input input-text" wire:model.defer="client.zip_code"/>
            @error('client.zip_code') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- City -->
        <div class="col-span-6 sm:col-span-4">
            <label for="city">{{ __('City') }}</label>
            <input id="city" type="text" class="form-input input-text" wire:model.defer="client.city"/>
            @error('client.city') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Country -->
        <div class="col-span-6 sm:col-span-4">
            <label for="country">{{ __('Country') }}</label>
            <input id="country" type="text" class="form-input input-text" wire:model.defer="client.country"/>
            @error('client.country') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Phone -->
        <div class="col-span-6 sm:col-span-4">
            <label for="phone">{{ __('address.Phone') }}</label>
            <input id="phone" type="text" class="form-input input-text" wire:model.defer="client.phone"/>
            @error('client.phone') <span class="text-error">{{ $message }}</span> @enderror
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
            @livewire('components.alert', ['elId' => 'client-address-form-alert-success', 'type' => 'alert-success'])
        </div>
    </x-jet-action-message>
</x-jet-form-section>

@include('livewire.client.form.update-address-form-js')
