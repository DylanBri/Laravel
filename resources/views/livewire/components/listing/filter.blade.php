<script id="inputSearch-tpl" type="text/x-handlebars-template">
    <div class="flex justify-center items-center mb-4">
        @{{#each filters}}
        @component('components.input-search')
            @slot('id')
                @{{ this.id }}
            @endslot

            @slot('placeholder')
                @{{ this.name }}
            @endslot
        @endcomponent
        @{{/each}}

        <button class="btn-primary-border btnClear" type="button">
            <i class="fa fa-close"></i>
        </button>
    </div>
</script>
