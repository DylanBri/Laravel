<div class="toggle-container">
    <input type="checkbox" name="{{ $id }}" id="{{ $id }}" wire:model.defer="{{ $modelField }}"
           class="toggle-checkbox"/>
    <label for="{{ $id }}" class="toggle-label"></label>
</div>
<label for="{{ $id }}" class="toggle-show-label">{{ __($label) }}</label>