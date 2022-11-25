<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('client.List') }}
        </h2>
    </x-slot>

    <div>
        @can('viewAny', App\Models\Client::class)
            <div class="body-content" id="clientGrid">
                @livewire('components.grid')
            </div>
        @elsecan
            {{ __('You must be allowed to see this page') }}
        @endcan
    </div>

    @livewire('components.loading')

    <div id="clientModalContainer">
        @component('livewire.components.modal', ['elModal' => 'clientModal', 'size' => 'md', 'title' => ''])
            <h3>{{ __('client.Settings Information') }}</h3>
            <div class="mt-10 sm:mt-0">
                @livewire('client.form.update-settings-form', [0, true])
            </div>

            {{--<x-jet-section-border/>--}}

            <h3>{{ __('client.Address Information') }}</h3>
            <div class="mt-10 sm:mt-0">
                @livewire('client.form.update-address-form', [0, true])
            </div>

            @slot('footer')
                @livewire('components.alert', ['elId' => 'client-form-alert-success', 'type' => 'alert-success'])
                <button class="btn-form-save btn-primary ml-3 mr-3" type="button">{{ __('Save') }}</button>
            @endslot
        @endcomponent
    </div>

    @include('livewire.client.grid-js')
</x-app-layout>
