<script id="btnAlphabet-tpl" type="text/x-handlebars-template">
    <div class="{{--flex--}} justify-center items-center mb-4">
        {{--<button class="listing-alpha listing-alpha-left btnAlpha" type="button" data-value="A">A</button>--}}
        @{{#each letters}}
        <button class="btn-primary-border {{--listing-alpha--}} btnAlpha" type="button" data-value="@{{ this }}">@{{ this }}</button>
        @{{/each}}
        {{--<button class="listing-alpha listing-alpha-right btnAlpha" type="button" data-value="Z">Z</button>--}}
    </div>
</script>