<x-jet-form-simple id="contactSettingsForm" submit="validateContactSettingsInformation">
    <x-slot name="form">
        @csrf
        <div class="md:grid md:gap-6 md:grid-cols-1">
            <div class="mt-5 md:mt-0">
                <div class="col-span-6 sm:col-span-4 flex">
                    <div class="flex">
                        <!-- Id -->
                        <div class="w-20 mr-2">
                            <label for="id">{{ __('company::contact.Id') }}</label>
                            <input id="id" type="text" class="form-input input-text input-disabled" disabled 
                                wire:model.defer="contact.id"/>
                            @error('contact.id') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Firstname -->
                        <div class="flex-1 mr-2">
                            <label for="firstname">{{ __('company::contact.Firstname') }}</label>
                            <input id="firstname" type="text" class="form-input input-text" 
                                wire:model.defer="contact.firstname"/>
                            @error('contact.firstname') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                        <!-- Lastname -->
                        <div class="flex-1 mr-2">
                            <label for="lastname">{{ __('company::contact.Lastname') }}</label>
                            <input id="lastname" type="text" class="form-input input-text" 
                                wire:model.defer="contact.lastname"/>
                            @error('contact.lastname') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Company_name -->
                        <div class="flex-1 mr-2">
                            <input id="company_id" type="hidden" wire:model.defer="contact.company_id"/>
                            <label for="company_name">{{ __('company::contact.Company_name') }}</label>
                            <input id="company_name" type="text" class="form-input input-text" 
                                wire:model.defer="contact.company_name"/>
                            @error('contact.company_name') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                </div>
                <div class="col-span-6 sm:col-span-4 flex">
                    <div class="flex-1 flex">
                        <!-- Email -->
                        <div class="flex-1 mr-2">
                            <label for="email">{{ __('company::contact.Email') }}</label>
                            <input id="email" type="text" class="form-input input-text" 
                                wire:model.defer="contact.email"/>
                            @error('contact.email') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex-2 flex">
                        <!-- Phone -->
                        <div class="flex-1 mr-2">
                            <label for="phone">{{ __('company::contact.Phone') }}</label>
                            <input id="phone" type="text" class="form-input input-text" 
                                awire:model.defer="contact.phone"/>
                            @error('contact.phone') <span class="text-error">{{ $message }}</span> @enderror
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
            @livewire('components.alert', ['elId' => 'contact-form-alert-success', 'type' => 'alert-success'])
        </div>
    </x-jet-action-message>
</x-jet-form-simple>

@include('company::livewire.company.contact.form.update-settings-form-js')
