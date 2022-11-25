<x-jet-form-section id="clientSettingsForm" submit="validateClientSettings">
    <x-slot name="title">
        {{ __('client.Settings Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('client.Update client settings information.') }}
    </x-slot>

    <x-slot name="form">
    @csrf
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <label for="name">{{ __('Name') }}</label>
            <input id="name" type="text" class="form-input input-text" wire:model.defer="client.name"/>
            @error('client.name') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Folder -->
        {{--<div class="col-span-6 sm:col-span-4">
            <label for="folder">{{ __('client.Folder') }}</label>
            <input id="folder" type="text" class="form-input input-text" wire:model.defer="client.folder"/>
            @error('client.folder') <span class="text-error">{{ $message }}</span> @enderror
        </div>--}}

        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <label for="email">{{ __('Email') }}</label>
            <input id="email" type="text" class="form-input input-text" wire:model.defer="client.email"/>
            @error('client.email') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Licence -->
        <div class="col-span-6 sm:col-span-4">
            <label for="licence">{{ __('client.Licence') }}</label>
            <input id="licence" type="text" class="form-input input-text" wire:model.defer="client.licence"/>
            @error('client.licence') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Licence Expired At -->
        <div class="col-span-6 sm:col-span-4">
            <label for="licence_expired_at">{{ __('client.Licence Expired At') }}</label>
            <input id="licence_expired_at_show" type="text" class="form-input input-text"
                   wire:model.defer="client.licence_expired_at"/>
            <input id="licence_expired_at" type="hidden" class="form-input input-text"
                   wire:model.defer="client.licence_expired_at"/>
            @error('client.licence_expired_at') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Socket Host -->
        {{--<div class="col-span-6 sm:col-span-4">
            <label for="socket_host">{{ __('client.Socket Host') }}</label>
            <input id="socket_host" type="text" class="form-input input-text" wire:model.defer="client.socket_host"/>
            @error('client.socket_host') <span class="text-error">{{ $message }}</span> @enderror
        </div>--}}

        <!-- Socket Port -->
        {{--<div class="col-span-6 sm:col-span-4">
            <label for="socket_port">{{ __('client.Socket Port') }}</label>
            <input id="socket_port" type="text" class="form-input input-text" wire:model.defer="client.socket_port"/>
            @error('client.socket_port') <span class="text-error">{{ $message }}</span> @enderror
        </div>--}}

        <!-- Enabled -->
        <div class="col-span-6 sm:col-span-4">
            @component('components.toggle-checkbox', [
                    'id' => 'enabled', 'modelField' => 'client.enabled', 'label' => 'client.Enabled'
                ])
            @endcomponent
            @error('client.enabled') <span class="text-error">{{ $message }}</span> @enderror
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
            @livewire('components.alert', ['elId' => 'client-settings-form-alert-success', 'type' => 'alert-success'])
        </div>
    </x-jet-action-message>
</x-jet-form-section>

@include('livewire.client.form.update-settings-form-js')