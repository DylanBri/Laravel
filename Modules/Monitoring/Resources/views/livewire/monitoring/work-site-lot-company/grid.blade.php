<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('monitoring::work-site-lot-company.List') }}
        </h2>
    </x-slot>

    <div>
        {{-- @can('viewAny', Modules\Monitoring\Entities\Lot::class) --}}
        <div class="body-content" id="workSiteLotCompanyGrid">
            @livewire('components.grid')
        </div>
        {{-- @canelse
            {{ __('You must be allowed to see this page') }}
        @endcan --}}
    </div>

    @livewire('components.loading')

    <div id="workSiteLotCompanyModalContainer">
        @component('livewire.components.modal', ['elModal' => 'workSiteLotCompanyModal', 'size' => 'md', 'title' => ''])
            @livewire('monitoring::monitoring.work-site-lot-company.form.update-settings-form', [0, true])

            @slot('footer')
                @livewire('components.alert', ['elId' => 'work-site-lot-company-form-alert-success', 'type' => 'alert-success'])
                <button class="btn-form-save btn-primary ml-3 mr-3" type="button">{{ __('Save') }}</button>
            @endslot
        @endcomponent
    </div>

    @include('monitoring::livewire.monitoring.work-site-lot-company.grid-js')

    @section('style')
        <link href="{{ asset('css/monitoring.css') }}" rel="stylesheet">
    @endsection

    @section('script')
        <script src="{{ mix('js/monitoring.js') }}"></script>
    @endsection
</x-app-layout>
