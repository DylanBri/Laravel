<label class="multiselect-label" id="{{ $id }}">
    <span class="multiselect-span">{{ __($label) }}</span>
    <select class="form-multiselect multiselect" multiple id="{{ $selectId }}">
        @foreach($options as $option)
            <option class="multiselect-option" value="{{ $option->id }}" {{ $option->selected }}>{{ $option->name }}</option>
        @endforeach
    </select>
</label>