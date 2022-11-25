<div class="multicheckbox-label mt-3">{{ __($label) }}</div>
<div class="mt-1" id="{{ $id }}">
    @foreach($options as $option)
        <div class="form-check">
            <input class="form-check-input multicheckbox-input" type="checkbox" id="{{ $option['id'] }}" value="1" wire:model.defer="contract.{{ $option['id'] }}">
            <label class="form-check-label inline-block multicheckbox-sub-label mt-0 ml-1" for="{{ $option['id'] }}">{{ __($option['label']) }}</label>
        </div>
    @endforeach
</div>