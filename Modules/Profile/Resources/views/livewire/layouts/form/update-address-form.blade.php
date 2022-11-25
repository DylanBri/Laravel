<x-jet-form-section id="userAddressForm" submit="validateAddressInformation">
    <x-slot name="title">
        {{ __('profile::user.Address Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('profile::user.Update your account\'s address information.') }}
    </x-slot>

    <x-slot name="form">
        @csrf
        <input id="user_id" type="hidden" class="form-input input-text" wire:model.defer="coordinate.user_id" />
        <input id="category_id" type="hidden" class="form-input input-text" wire:model.defer="coordinate.category_id" />

        <!-- Address -->
        <div class="col-span-6 sm:col-span-4">
            <label for="address">{{ __('Address') }}</label>
            <input id="address" type="text" class="form-input input-text" wire:model.defer="coordinate.address" />
            @error('coordinate.address') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Address2 -->
        <div class="col-span-6 sm:col-span-4">
            <label for="address2">{{ __('address.Address2') }}</label>
            <input id="address2" type="text" class="form-input input-text" wire:model.defer="coordinate.address2" />
            @error('coordinate.address2') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Zip Code -->
        <div class="col-span-6 sm:col-span-4">
            <label for="zip_code">{{ __('Zip / Postal Code') }}</label>
            <input id="zip_code" type="text" class="form-input input-text" wire:model.defer="coordinate.zip_code" />
            @error('coordinate.zip_code') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- City -->
        <div class="col-span-6 sm:col-span-4">
            <label for="city">{{ __('City') }}</label>
            <input id="city" type="text" class="form-input input-text" wire:model.defer="coordinate.city" />
            @error('coordinate.city') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Region -->
        <div class="col-span-6 sm:col-span-4">
            <label for="region">{{ __('address.Region') }}</label>
            <input id="region" type="text" class="form-input input-text" wire:model.defer="coordinate.region" />
            @error('coordinate.region') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Country -->
        <div class="col-span-6 sm:col-span-4">
            <label for="country">{{ __('Country') }}</label>
            <input id="country" type="text" class="form-input input-text" wire:model.defer="coordinate.country" />
            @error('coordinate.country') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Phone -->
        <div class="col-span-6 sm:col-span-4">
            <label for="phone">{{ __('address.Phone') }}</label>
            <input id="phone" type="text" class="form-input input-text" wire:model.defer="coordinate.phone" />
            @error('coordinate.phone') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Mobile -->
        <div class="col-span-6 sm:col-span-4">
            <label for="mobile">{{ __('address.Mobile') }}</label>
            <input id="mobile" type="text" class="form-input input-text" wire:model.defer="coordinate.mobile" />
            @error('coordinate.mobile') <span class="text-error">{{ $message }}</span> @enderror
        </div>
    </x-slot>

    <x-slot name="actions">
        <div class="@if ($isModal) hidden @endif">
            <button type="submit" class="btn-primary" wire:loading.attr="disabled">
                {{ __('Save') }}
            </button>
        </div>
    </x-slot>
</x-jet-form-section>

<x-jet-action-message class="mr-3" on="saved">
    <div class="@if ($isModal) hidden @endif">
        @livewire('components.alert', ['elId' => 'user-address-form-alert-success', 'type' => 'alert-success'])
    </div>
</x-jet-action-message>

@include('profile::livewire.layouts.form.update-address-form-js')