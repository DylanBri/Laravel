<x-jet-form-section id="userSettingsForm" submit="validateUserSettings">
    <x-slot name="title">
        {{ __('profile::' . $type . '.Settings Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('profile::' . $type . '.Update User settings information.') }}
    </x-slot>

    <x-slot name="form">
    @csrf

        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <label for="name">{{ __('Name') }}</label>
            <input id="name" type="text" class="form-input input-text" wire:model.defer="user.name"/>
            @error('user.name') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <label for="email">{{ __('Email') }}</label>
            <input id="email" type="text" class="form-input input-text" wire:model.defer="user.email"/>
            @error('user.email') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div class="col-span-6 sm:col-span-4">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-input input-text" wire:model.defer="user.password"/>
            @error('user.password') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Enabled -->
        <div class="col-span-6 sm:col-span-4">
            @component('components.toggle-checkbox', [
                    'id' => 'enabled', 'modelField' => 'user.enabled', 'label' => 'user-coordinates.Enabled'
                ])
            @endcomponent
            @error('user.enabled') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Suppressed -->
        <div class="col-span-6 sm:col-span-4">
            @component('components.toggle-checkbox', [
                    'id' => 'suppressed', 'modelField' => 'user.suppressed', 'label' => 'user-coordinates.Suppressed'
                ])
            @endcomponent
            @error('user.suppressed') <span class="text-error">{{ $message }}</span> @enderror
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
        @livewire('components.alert', ['elId' => 'user-settings-form-alert-success', 'type' => 'alert-success'])
    </div>
</x-jet-action-message>

@include('profile::livewire.layouts.form.update-settings-form-js')