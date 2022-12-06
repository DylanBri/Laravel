<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('company::company.Company') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="mt-10 sm:mt-0">
                @livewire('company::company.form.update-settings-form',[0])
            </div>
        </div>

        <div>
            <div class="body-content" id="contactGrid">
                @livewire('components.grid')
            </div>
        </div>
    
        @livewire('components.loading')
    
        <div id="contactModalContainer">
            @component('livewire.components.modal', ['elModal' => 'contactModal', 'size' => 'md', 'title' => ''])
                @livewire('company::company.contact.form.update-settings-form', [0, true])
    
                @slot('footer')
                    @livewire('components.alert', ['elId' => 'contact-form-alert-success', 'type' => 'alert-success'])
                    <button class="btn-form-save btn-primary ml-3 mr-3" type="button">{{ __('Save') }}</button>
                @endslot
            @endcomponent
        </div>

        @livewire('components.alert', ['elId' => 'company-form-alert-success', 'type' => 'alert-success'])
    </div>

    @include('company::livewire.company.form-js')
    @include('company::livewire.company.contact.grid-js')

    @section('style')
    <link href="{{ asset('css/company.css') }}" rel="stylesheet">
    @endsection

    @section('script')
    <script src="{{ mix('js/company.js') }}"></script>
    @endsection
</x-app-layout>