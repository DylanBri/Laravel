<x-jet-form-section id="logQueueSettingsForm" submit="validateLogQueueSettings">
    <x-slot name="title">
        {{ __('log::logQueue.Log Queue Settings') }}
    </x-slot>

    <x-slot name="description">
        {{ __('log::logQueue.Update logQueue\'s settings.') }}
    </x-slot>

    <x-slot name="form">
    @csrf
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <label for="name">{{ __('Name') }}</label>
            <input id="name" type="text" class="form-input input-text" wire:model.defer="log.name" />
            @error('log.name') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Action -->
        <div class="col-span-6 sm:col-span-4">
            <label for="action">{{ __('Action') }}</label>
            <input id="action" type="text" class="form-input input-text" wire:model.defer="log.action" />
            @error('log.action') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Data -->
        <div class="col-span-6 sm:col-span-4">
            <label for="data">{{ __('log::logQueue.Data') }}</label>
            <textarea id="data" type="text" class="form-textarea input-text" wire:model.defer="log.data" ></textarea>
            @error('log.data') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- Log -->
        <div class="col-span-6 sm:col-span-4">
            <label for="log">{{ __('log::logQueue.Log') }}</label>
            <input id="log" type="text" class="form-input input-text" wire:model.defer="log.log" />
            @error('log.log') <span class="text-error">{{ $message }}</span> @enderror
        </div>

        <!-- State -->
        {{-- TODO Select --}}
        <div class="col-span-6 sm:col-span-4">
            <label for="state">{{ __('log::logQueue.State') }}</label>
            <input id="state" type="text" class="form-input input-text" wire:model.defer="log.state" />
            @error('log.state') <span class="text-error">{{ $message }}</span> @enderror
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
            @livewire('components.alert', ['elId' => 'log-queue-settings-form-alert-success', 'type' => 'alert-success'])
        </div>
    </x-jet-action-message>
</x-jet-form-section>

@include('log::livewire.log-queue.form.update-settings-form-js')
