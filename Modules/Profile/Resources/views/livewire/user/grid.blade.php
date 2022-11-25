<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('profile::user.List') }}
        </h2>
    </x-slot>

    <div>
        @can('viewAny', Modules\Profile\Entities\User::class)
            <div class="body-content" id="userGrid">
                @livewire('components.grid')
            </div>
        @elsecan
            {{ __('You must be allowed to see this page') }}
        @endcan
    </div>

    @livewire('components.loading')

    <div id="userModalContainer">
        @component('livewire.components.modal', ['elModal' => 'userModal', 'size' => 'md', 'title' => ''])
            <h3>{{ __('profile::user.Settings Information') }}</h3>
            <div class="mt-10 sm:mt-0">
                @livewire('profile::layouts.form.update-settings-form', [0, 'user', true])
            </div>

            {{--<x-jet-section-border/>--}}

            <h3>{{ __('profile::user.Address Information') }}</h3>
            <div class="mt-10 sm:mt-0">
                @livewire('profile::layouts.form.update-address-form', [0, true])
            </div>

            @slot('footer')
                @livewire('components.alert', ['elId' => 'user-form-alert-success', 'type' => 'alert-success'])
                <button class="btn-form-save btn-primary ml-3 mr-3" type="button">{{ __('Save') }}</button>
            @endslot
        @endcomponent
    </div>

    @include('profile::livewire.user.grid-js')

    @section('style')
        <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    @endsection

    @section('script')
        <script src="{{ mix('js/profile.js') }}"></script>
    @endsection
</x-app-layout>
