<x-app-layout>
    <x-slot name="header">
        <h2>
            {{ __('user-coordinates.Coordinates') }}
        </h2>
    </x-slot>

    <div>
        <div class="body-content">
            <div class="mt-10 sm:mt-0">
                @livewire('user.coordinate.form.update-address-form', [Auth::user()->id])
            </div>

            {{--<x-jet-section-border/>--}}
        </div>
    </div>
</x-app-layout>