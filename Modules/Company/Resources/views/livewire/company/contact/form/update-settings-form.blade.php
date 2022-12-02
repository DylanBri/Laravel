<x-jet-form-simple id="contactSettingsForm" submit="validateContactSettingsInformation">
    <x-slot name="form">
        @csrf
        <div class="md:grid md:gap-6 md:grid-cols-3">
            <div class="mt-5 md:mt-0">
                <!-- Id -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="id">{{ __('company::contact.Id') }}</label>
                    <input id="id" type="text" class="form-input input-text input-disabled" disabled wire:model.defer="contact.id"/>
                    @error('contact.id') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <!-- Firstname -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="firstname">{{ __('company::contact.Firstname') }}</label>
                    <input id="firstname" type="number" class="form-input input-text" wire:model.defer="contact.firstname" step=".01"/>
                    @error('contact.firstname') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <!-- Lastname -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="lasstname">{{ __('company::contact.Laststname') }}</label>
                    <input id="lasstname" type="number" class="form-input input-text" wire:model.defer="contact.lasstname" step=".01"/>
                    @error('contact.lasstname') <span class="text-error">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="mt-5 md:mt-0">
                <!-- Company_name -->
                <div class="col-span-6 sm:col-span-4">
                    <input id="company_id" type="hidden" wire:model.defer="contact.company_id"/>
                    <label for="company_name">{{ __('company::contact.Company_name') }}</label>
                    <input id="company_name" type="text" class="form-input input-text" wire:model.defer="contact.company_name"/>
                    @error('contact.company_name') <span class="text-error">{{ $message }}</span> @enderror
                </div>

                <!-- Phone -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="phone">{{ __('company::contact.Phone') }}</label>
                    <input id="phone" type="text" class="form-input input-text" wire:model.defer="contact.phone"/>
                    @error('contact.phone') <span class="text-error">{{ $message }}</span> @enderror
                </div>
                
                <!-- Email -->
                <div class="col-span-6 sm:col-span-4">
                    <label for="email">{{ __('company::contact.Email') }}</label>
                    <input id="email" type="text" class="form-input input-text" wire:model.defer="contact.email"/>
                    @error('contact.email') <span class="text-error">{{ $message }}</span> @enderror
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
            @livewire('components.alert', ['elId' => 'contact-form-alert-success', 'type' => 'alert-success'])
        </div>
    </x-jet-action-message>
</x-jet-form-simple>

@include('company::livewire.company.contact.form.update-settings-form-js')
