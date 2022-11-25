<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('company::payment.List') }}
        </h2>
    </x-slot>

    <div>
        {{-- @can('viewAny', Modules\Company\Entities\Payment::class) --}}
        <div class="body-content" id="paymentGrid">
            @livewire('components.grid')
        </div>
        {{-- @canelse
            {{ __('You must be allowed to see this page') }}
        @endcan --}}
    </div>

    @livewire('components.loading')

    <div id="paymentModalContainer">
        @component('livewire.components.modal', ['elModal' => 'paymentModal', 'size' => 'lg', 'title' => ''])
            @livewire('company::company.payment.form.update-settings-form', [0, true])

            @slot('footer')
                @livewire('components.alert', ['elId' => 'payment-form-alert-success', 'type' => 'alert-success'])
                <button class="btn-form-save btn-primary ml-3 mr-3" type="button">{{ __('Save') }}</button>
            @endslot
        @endcomponent
    </div>

    @include('company::livewire.company.payment.grid-js')

    @section('style')
        <link href="{{ asset('css/company.css') }}" rel="stylesheet">
    @endsection

    @section('script')
        <script src="{{ mix('js/company.js') }}"></script>
    @endsection
</x-app-layout>
