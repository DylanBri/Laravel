<script id="headerCell-tpl" type="text/x-handlebars-template">
    <th scope="col" class="grid-header-column">
        <label>
            @{{#if hasSort}}
            <a class="toggleSort" data-name="@{{ name }}" data-field="@{{ filterName }}" data-sort="-1" href="#">
                <span>@{{ label }}</span>
            </a>
            <span class="fa fa-sort-down hidden"></span>
            <span class="fa fa-sort-up hidden"></span>
            @{{else}}
            <span>@{{ label }}</span>
            @{{/if}}
        </label>

        @{{#if hasFilter}}
        @{{#if hasFilterStr}}
        <input type="text" class="form-input filter filterStr" data-name="@{{ name }}"
               data-type="@{{ filterType }}" data-field="@{{ filterName }}">
        @{{/if}}
        @{{#if hasFilterBool}}
        <select class="form-select filter filterBool" data-name="@{{ name }}"
                data-type="@{{ filterType }}" data-field="@{{ filterName }}">
            <option value="">{{ __('Select') }}</option>
            <option value="1">{{ __('Yes') }}</option>
            <option value="0">{{ __('No') }}</option>
        </select>
        @{{/if}}
        @{{#if hasFilterSelect}}
        <select class="form-select filter filterSelect" data-name="@{{ name }}"
                data-type="@{{ filterType }}" data-field="@{{ filterName }}">
            <option value="">{{ __('Select') }}</option>
            @{{#each filterValues}}
            <option value="@{{ this.value }}" data-i18n="@{{ this.i18n }}">@{{ this.label }}</option>
            @{{/each}}
        </select>
        @{{/if}}
        @{{#if hasFilterAuto}}
        <input type="text" class="form-input filter filterAuto" data-name="@{{ name }}"
               data-type="@{{ filterType }}" data-field="@{{ filterName }}" id="@{{ autocompleteId }}">
        @{{/if}}
        @{{#if hasFilterNum}}
        <input type="number" class="form-input filter filterNum" data-name="@{{ name }}"
               data-type="@{{ filterType }}_min" data-field="@{{ filterName }}">
        <input type="number" class="form-input filter filterNum" data-name="@{{ name }}"
               data-type="@{{ filterType }}_max" data-field="@{{ filterName }}">
        @{{/if}}
        @{{#if hasFilterDate}}
        <input type="date" class="form-input filter filterDate" data-name="@{{ name }}"
               data-type="@{{ filterType }}_min" data-field="@{{ filterName }}">
        <input type="date" class="form-input filter filterDate" data-name="@{{ name }}"
               data-type="@{{ filterType }}_max" data-field="@{{ filterName }}">
        @{{/if}}
        @{{/if}}
    </th>
</script>

@include('livewire.components.grid.header-js')