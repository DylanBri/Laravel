<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('customer::customer.Listing') }}
        </h2>
    </x-slot>

    <div class="grid md:grid-flow-col">
        <div id="customerList">
            @livewire('components.listing', ['60vh'])
        </div>
    </div>

    @livewire('components.loading')
    @livewire('customer::customer.listing.item')

    @include('customer::livewire.customer.listing-js')

    @section('style')
        <link href="{{ asset('css/customer.css') }}" rel="stylesheet">
    @endsection

    @section('script')
        <script src="{{ mix('js/customer.js') }}"></script>
    @endsection
</x-app-layout>
