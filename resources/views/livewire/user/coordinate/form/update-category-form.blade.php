<x-jet-form-section id="userCategoryForm" submit="validateUserCategory">
    <x-slot name="title">
        {{ __('user-coordinates.Category Information') }}
    </x-slot>

    <x-slot name="description">
        @supadm
            {{ __('user-coordinates.Update your account\'s category information.') }}
        @else
            {{ __('user-coordinates.Show your account\'s category information.') }}
        @endsupadm
    </x-slot>

    <x-slot name="form">
        @csrf
        <!-- CategoryName -->
        <div class="col-span-6 sm:col-span-4">
            <input id="categoryId" type="hidden" wire:model.defer="category.id" />
            <label for="categoryName">{{ __('user-coordinates.CategoryName') }}</label>
            <input id="categoryName" type="text" class="form-input input-text" wire:model.defer="category.name" />
            @error('category.name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
    </x-slot>

    @supadm
    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
    @endsupadm
</x-jet-form-section>

@include('livewire.user.coordinate.form.update-category-form-js')