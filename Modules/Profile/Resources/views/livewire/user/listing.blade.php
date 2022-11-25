<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('profile::user.Listing') }}
        </h2>
    </x-slot>

    <div>
        <div class="body-content" id="userList">
            <input type="hidden" id="office_id" value="{{ $officeId }}">
            @livewire('components.listing', ['60vh'])
        </div>
    </div>

    @livewire('components.loading')
    @livewire('profile::user.listing.item')

    @livewire('conversation::conversation.modal.create')

    @include('profile::livewire.user.listing-js')

    @section('style')
        <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
        <link href="{{ asset('css/conversation.css') }}" rel="stylesheet">
    @endsection

    @section('script')
        <script src="{{ mix('js/profile.js') }}"></script>
        <script src="{{ mix('js/conversation.js') }}"></script>
    @endsection
</x-app-layout>
