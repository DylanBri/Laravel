<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('profile::admin.List') }}
        </h2>
    </x-slot>

    <div>
        @can('viewAny', Modules\Profile\Entities\Administrator::class)
            <div class="body-content" id="adminGrid">
                @livewire('components.grid')
            </div>
        @elsecan
            {{ __('You must be allowed to see this page') }}
        @endcan
    </div>

    @livewire('components.loading')

    <div id="adminModalContainer">
        @component('livewire.components.modal', ['elModal' => 'adminModal', 'size' => 'md', 'title' => ''])
            <h3>{{ __('profile::admin.Settings Information') }}</h3>
            <div class="mt-10 sm:mt-0">
                @livewire('profile::layouts.form.update-settings-form', [0, 'admin', true])
            </div>

            {{--<x-jet-section-border/>--}}

            <h3>{{ __('profile::user.Address Information') }}</h3>
            <div class="mt-10 sm:mt-0">
                @livewire('profile::layouts.form.update-address-form', [0, true])
            </div>

            @slot('footer')
                @livewire('components.alert', ['elId' => 'admin-form-alert-success', 'type' => 'alert-success'])
                <button class="btn-form-save btn-primary ml-3 mr-3" type="button">{{ __('Save') }}</button>
            @endslot
        @endcomponent
    </div>

    @include('profile::livewire.admin.grid-js')

    @section('style')
        <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    @endsection

    @section('script')
        <script src="{{ mix('js/profile.js') }}"></script>
    @endsection
</x-app-layout>
