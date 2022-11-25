<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('customer::customer.Customer') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                @livewire('customer::customer.form.update-settings-form',[0])
            </div>
        </div>

        <div>
            {{-- @can('viewAny', Modules\Monitoring\Entities\WorkSite::class) --}}
            <div class="body-content" id="workSiteGrid">
                @livewire('components.grid')
            </div>
            {{-- @canelse
                {{ __('You must be allowed to see this page') }}
            @endcan --}}
        </div>
    
        @livewire('components.loading')
    
        <div id="workSiteModalContainer">
            @component('livewire.components.modal', ['elModal' => 'workSiteModal', 'size' => 'md', 'title' => ''])
                @livewire('monitoring::monitoring.work-site.form.update-settings-form', [0, true])
    
                @slot('footer')
                    @livewire('components.alert', ['elId' => 'work-site-form-alert-success', 'type' => 'alert-success'])
                    <button class="btn-form-save btn-primary ml-3 mr-3" type="button">{{ __('Save') }}</button>
                @endslot
            @endcomponent
        </div>

        @livewire('components.alert', ['elId' => 'customer-form-alert-success', 'type' => 'alert-success'])
    </div>

    @include('customer::livewire.customer.form-js')
    @include('monitoring::livewire.monitoring.work-site.grid-js')

    @section('style')
    <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
    <link href="{{ asset('css/monitoring.css') }}" rel="stylesheet">
    @endsection

    @section('script')
    <script src="{{ mix('js/customer.js') }}"></script>
    <script src="{{ mix('js/monitoring.js') }}"></script>
    @endsection
</x-app-layout>