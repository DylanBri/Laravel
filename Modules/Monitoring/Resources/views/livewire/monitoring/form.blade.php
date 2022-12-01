<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('monitoring::monitoring.Monitoring') }}
        </h2>
    </x-slot>

    <div id="monitoringForm">
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                @livewire('monitoring::monitoring.form.update-settings-form',[0])
            </div>
        </div>
                
        <button type="button" class="btn btn-primary btnBack ml-6">{{ __('Return') }}</button>

        <div>
            <div class="body-content" id="workSiteLotCompanyGrid">
                @livewire('components.grid')
            </div>
        </div>
    
        @livewire('components.loading')
    
        <div id="workSiteLotCompanyModalContainer">
            @component('livewire.components.modal', ['elModal' => 'workSiteLotCompanyModal', 'size' => 'md', 'title' => ''])
                @livewire('monitoring::monitoring.work-site-lot-company.form.update-settings-form', [0, true])
    
                @slot('footer')
                    @livewire('components.alert', ['elId' => 'work-site-lot-comapny-form-alert-success', 'type' => 'alert-success'])
                    <button class="btn-form-save btn-primary ml-3 mr-3" type="button">{{ __('Save') }}</button>
                @endslot
            @endcomponent
        </div>

        @livewire('components.alert', ['elId' => 'monitoring-form-alert-success', 'type' => 'alert-success'])
    </div>

    @include('monitoring::livewire.monitoring.form-js')
    @include('monitoring::livewire.monitoring.work-site-lot-company.grid-ts-js')

    @section('style')
    <link href="{{ asset('css/monitoring.css') }}" rel="stylesheet">
    @endsection

    @section('script')
    <script src="{{ mix('js/monitoring.js') }}"></script>
    @endsection
</x-app-layout>