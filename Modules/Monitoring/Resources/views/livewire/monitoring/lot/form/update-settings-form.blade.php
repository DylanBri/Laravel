<x-jet-form-simple id="lotSettingsForm" submit="validateLotSettingsInformation">
    <x-slot name="form">
        @csrf
        <div class="md:grid md:gap-6 md:grid-cols-1">
            <div class="mt-5 md:mt-0">
                <!-- Id -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="id">{{ __('monitoring::lot.Id') }}</label>
                    <input id="id" type="text" class="form-input input-text input-disabled" disabled wire:model.defer="lot.id"/>
                    @error('lot.id') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <!-- Name -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="name">{{ __('monitoring::lot.Name') }}</label>
                    <input id="name" type="text" class="form-input input-text" wire:model.defer="lot.name"/>
                    @error('lot.name') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <!-- Description -->
                <div class="col-span-6 sm:col-span-4">
                    <input id="company_id" type="hidden" wire:model.defer="lot.description"/>
                    <label for="description">{{ __('monitoring::lot.Description') }}</label>
                    <input id="description" type="text" class="form-input input-text" wire:model.defer="lot.description"/>
                    @error('lot.description') <span class="text-error">{{ $message }}</span> @enderror
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
            @livewire('components.alert', ['elId' => 'lot-form-alert-success', 'type' => 'alert-success'])
        </div>
    </x-jet-action-message>
</x-jet-form-simple>

@include('monitoring::livewire.monitoring.lot.form.update-settings-form-js')
