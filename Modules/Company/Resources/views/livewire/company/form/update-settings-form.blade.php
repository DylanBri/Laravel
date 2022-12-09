<x-jet-form-simple id="companySettingsForm" submit="validateCompanySettingsInformation">
    <x-slot name="form">
        @csrf
        <div class="md:grid md:gap-6 md:grid-cols-1">
            <div class="mt-5 md:mt-0">
                <div class="col-span-6 sm:col-span-4 flex">
                    <div class="flex">
                        <!-- Id -->
                        <div class="w-20 mr-2">
                            <label for="id">{{ __('company::company.Id') }}</label>
                            <input id="id" type="text" class="form-input input-text input-disabled" disabled wire:model.defer="company.id"/>
                            @error('company.id') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Title -->
                        <div class="flex-1 mr-2">
                            <label for="title">{{ __('company::company.Title') }}</label>
                            <input id="title" type="text" class="form-input input-text" wire:model.defer="company.title"/>
                            @error('company.title') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="flex-1 flex">
                        <!-- Name -->
                        <div class="flex-1 mr-2">
                            <label for="name">{{ __('company::company.Name') }}</label>
                            <input id="name" type="text" class="form-input input-text" wire:model.defer="company.name"/>
                            @error('company.name') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Supervisor -->
                        <div class="flex-1 mr-2">
                            <label for="supervisor">{{ __('company::company.Supervisor') }}</label>
                            <input id="supervisor" type="text" class="form-input input-text"
                                wire:model.defer="company.supervisor"/>
                                @error('company.supervisor') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4 flex"> 
                    <div class="flex-1 flex">
                        <!-- Phone -->
                        <div class="flex-1 mr-2">
                            <label for="phone">{{ __('company::company.Phone') }}</label>
                            <input id="phone" type="text" class="form-input input-text" wire:model.defer="company.phone"/>
                            @error('company.phone') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- Classification -->
                        <div class="flex-1 mr-2">
                            <label for="classification">{{ __('company::company.Classification') }}</label>
                            <input id="classification" type="text" class="form-input input-text" 
                                wire:model.defer="company.classification"/>
                            @error('company.classification') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <!-- siret -->
                        <div class="flex-1 mr-2">
                            <label for="siret">{{ __('company::company.Siret') }}</label>
                            <input id="siret" type="text" class="form-input input-text"
                            wire:model.defer="company.siret"/>
                            @error('company.siret') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- code_ape -->
                        <div class="w-20 mr-2">
                            <label for="code_ape">{{ __('company::company.Code_ape') }}</label>
                            <input id="code_ape" type="text" class="form-input input-text" 
                                wire:model.defer="company.code_ape"/>
                            @error('company.code_ape') <span class="text-error">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
                <div class="col-span-6 sm:col-span-4 flex">
                    <!-- Address -->
                    <div class="flex-1 mr-2">
                        <label for="address_1">{{ __('company::company.Address 1') }}</label>
                        <input id="address_1" type="text" class="form-input input-text"
                            wire:model.defer="company.address_1"/>
                        @error('company.address_1') <span class="text-error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Address 2 -->
                    <div class="flex-1 mr-2">
                        <label for="address_2">{{ __('company::company.Address 2') }}</label>
                        <input id="address_2" type="text" class="form-input input-text"
                            wire:model.defer="company.address_2"/>
                        @error('company.address_2') <span class="text-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex-1 flex">
                        <!-- Zip Code -->
                        <div class="flex-1 mr-2">
                            <label for="zip_code">{{ __('company::company.Zip Code') }}</label>
                            <input id="zip_code" type="text" class="form-input input-text"
                                wire:model.defer="company.zip_code"/>
                            @error('company.zip_code') <span class="text-error">{{ $message }}</span> @enderror
                        </div>

                        <!-- City -->
                        <div class="flex-1 mr-2">
                            <label for="city">{{ __('company::company.City') }}</label>
                            <input id="city" type="text" class="form-input input-text" 
                                wire:model.defer="company.city"/>
                            @error('company.city') <span class="text-error">{{ $message }}</span> @enderror
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
            @livewire('components.alert', ['elId' => 'company-form-alert-success', 'type' => 'alert-success'])
        </div>
    </x-jet-action-message>
</x-jet-form-simple>

@include('company::livewire.company.form.update-settings-form-js')
