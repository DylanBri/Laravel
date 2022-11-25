<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('customer::customer.List') }}
        </h2>
    </x-slot>

    <div>
        {{-- @can('viewAny', Modules\Customer\Entities\Customer::class) --}}
        <div class="body-content" id="customerGrid">
            @livewire('components.grid')
        </div>
        {{-- @canelse
            {{ __('You must be allowed to see this page') }}
        @endcan --}}
    </div>

    @livewire('components.loading')

    <div id="customerModalContainer">
        @component('livewire.components.modal', ['elModal' => 'customerModal', 'size' => 'lg', 'title' => ''])
            @livewire('customer::customer.form.update-settings-form', [0, true])

            @slot('footer')
                @livewire('components.alert', ['elId' => 'customer-form-alert-success', 'type' => 'alert-success'])
                <button class="btn-form-save btn-primary ml-3 mr-3" type="button">{{ __('Save') }}</button>
            @endslot
        @endcomponent
    </div>

    @include('customer::livewire.customer.grid-js')

    @section('style')
        <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
    @endsection

    @section('script')
        <script src="{{ mix('js/customer.js') }}"></script>
    @endsection
</x-app-layout>
