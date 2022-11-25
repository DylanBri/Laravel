<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('monitoring::work-site-lot-company.workSiteLotCompany') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                @livewire('monitoring::monitoring.work-site-lot-company.form.update-settings-form',[0])
            </div>
        </div>

        <div>
            {{-- @can('viewAny', Modules\Monitoring\Entities\WorkSite::class) --}}
            <div class="body-content" id="monitoringGrid">
                @livewire('components.grid')
            </div>
            {{-- @canelse
                {{ __('You must be allowed to see this page') }}
            @endcan --}}
        </div>
    
        @livewire('components.loading')
    
        <div id="monitoringModalContainer">
            @component('livewire.components.modal', ['elModal' => 'monitoringModal', 'size' => 'md', 'title' => ''])
                @livewire('monitoring::monitoring.form.update-settings-form', [0, true])
    
                @slot('footer')
                    @livewire('components.alert', ['elId' => 'monitoring-form-alert-success', 'type' => 'alert-success'])
                    <button class="btn-form-save btn-primary ml-3 mr-3" type="button">{{ __('Save') }}</button>
                @endslot
            @endcomponent
        </div>

        @livewire('components.alert', ['elId' => 'work-site-lot-company-form-alert-success', 'type' => 'alert-success'])
    </div>

    @include('monitoring::livewire.monitoring.work-site-lot-company.form-js')
    @include('monitoring::livewire.monitoring.grid-js')

    @section('style')
    <link href="{{ asset('css/monitoring.css') }}" rel="stylesheet">
    @endsection

    @section('script')
    <script src="{{ mix('js/monitoring.js') }}"></script>
    @endsection
</x-app-layout>