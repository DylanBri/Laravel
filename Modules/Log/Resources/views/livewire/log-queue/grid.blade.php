<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('log::logQueue.List') }}
        </h2>
    </x-slot>

    <div>
        {{--@can('viewAny', Modules\Log\Entities\LogQueue::class)--}}
        <div class="body-content" id="logQueueGrid">
            @livewire('components.grid')
        </div>
        {{--@elsecan
            {{ __('You must be allowed to see this page') }}
        @endcan--}}
    </div>

    @livewire('components.loading')

    <div id="logQueueModalContainer">
        @component('livewire.components.modal', ['elModal' => 'logQueueModal', 'size' => 'lg', 'title' => ''])
            <h3>{{ __('log::logQueue.Log Queue Settings') }}</h3>
            <div class="mt-10 sm:mt-0">
                @livewire('log::log-queue.form.update-settings-form', [0, true])
            </div>

            @slot('footer')
                @livewire('components.alert', ['elId' => 'log-queue-form-alert-success', 'type' => 'alert-success'])
                <button class="btn-form-save btn-primary ml-3 mr-3" type="button">{{ __('Save') }}</button>
            @endslot
        @endcomponent
    </div>

    @include('log::livewire.log-queue.grid-js')

    @section('style')
        <link href="{{ asset('css/log.css') }}" rel="stylesheet">
    @endsection

    @section('script')
        <script src="{{ mix('js/log.js') }}"></script>
    @endsection
</x-app-layout>
