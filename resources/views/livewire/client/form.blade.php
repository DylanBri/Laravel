<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('client.Client') }}
        </h2>
    </x-slot>

    <div>
        <div class="body-content" id="clientForm">
            <div class="mt-10 sm:mt-0">
                @livewire('client.form.update-settings-form',[0])
            </div>

            <x-jet-section-border/>

            <div class="mt-10 sm:mt-0">
                @livewire('client.form.update-address-form',[0])
            </div>
        </div>

        @livewire('components.alert', ['elId' => 'client-form-alert-success', 'type' => 'alert-success'])
    </div>

    @include('livewire.client.form-js')
</x-app-layout>