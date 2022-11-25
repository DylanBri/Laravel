<script id="btnStd-tpl" type="text/x-handlebars-template">
    <li>
        <a href="#" id="@{{ id }}" class="@{{ btnClass }}">
            <span class="@{{ imgClass }}" title="@{{ title }}"></span>
        </a>
    </li>
</script>

<script id="btnPageSize-tpl" type="text/x-handlebars-template">
    <select class="form-select block text-xs mt-1" id="pageSize">
        @{{#each pageSizes}}
        <option value='@{{ this }}'>@{{ this }}</option>
        @{{/each}}
    </select>
</script>