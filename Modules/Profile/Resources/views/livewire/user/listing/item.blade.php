<script id="itemContent-tpl" type="text/x-handlebars-template">
    @{{#each items}}
    <li>
        <div class="flex justify-between items-center">
            <div class="w-2/5">
                @{{ this.attributes.category_name }} <br />
                @{{ this.attributes.name }} <br />
                @{{ this.attributes.phone }} <br />
                @{{ this.attributes.email }}
            </div>
            <div class="w-2/5">
                @{{ this.attributes.address }} <br />
                @{{#if this.attributes.address2 }}@{{ this.attributes.address2 }} <br />@{{/if}}
                @{{ this.attributes.zip_code }} - @{{ this.attributes.city }} <br />
                @{{ this.attributes.country }}
            </div>
        </div>
    </li>
    @{{/each}}
</script>
