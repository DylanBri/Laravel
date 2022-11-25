<script id="itemContent-tpl" type="text/x-handlebars-template">
    @{{#each items}}
    <li>
        <div class="flex justify-between items-center">
            <div class="small text-gray-400">{{ __('customer::customer.Created At') }}: @{{formatDate this.attributes.created_at "lll"}}</div>
            <div class="small text-gray-400">{{ __('customer::customer.Updated At') }}: @{{formatDate this.attributes.updated_at "lll"}}</div>
        </div>
        <div class="flex justify-between items-center">
            <div class="small text-gray-400">@{{ this.attributes.created_user_name }}</div>
            <div class="small text-gray-400">@{{ this.attributes.updated_user_name }}</div>
        </div>
        <div class="flex justify-between items-center mt-1">
            <div>
                <h6>@{{ this.attributes.name }}</h6>
                <div>@{{ this.attributes.code }}</div>
                <div>@{{ this.attributes.email }}</div>
            </div>
            <div>
                <div>{{ __('customer::customer.User Name') }}: @{{ this.attributes.user_name }}</div>
                <div>{{ __('customer::customer.Old User Name') }}: @{{ this.attributes.old_user_name }}</div>
                <div>{{ __('customer::customer.Contact Name') }}: @{{ this.attributes.contact_name }}</div>
            </div>
            <div>
                <div>@{{ this.attributes.address_1 }}</div>
                <div>@{{ this.attributes.address_2 }}</div>
                <div>@{{ this.attributes.zip_code }} @{{ this.attributes.city }}</div>
            </div>
        </div>
        <div class="flex justify-end items-center mt-2">
            <button type="button" class="btn-primary btnShow">{{ __('Show') }} ...</button>
        </div>
        <div class="item-content hidden">
            @component('components.section-small-border')@endcomponent
            <div class="flex justify-between items-center">
                <div>@{{{ this.attributes.document_notes }}}</div>
            </div>
            @component('components.section-small-border')@endcomponent
            <div class="flex justify-between items-center">
                <div>@{{{ this.attributes.general_notes }}}</div>
            </div>
            @component('components.section-small-border')@endcomponent
            <div class="flex justify-between items-center">
                <div>@{{{ this.attributes.technical_notes }}}</div>
            </div>
            @component('components.section-small-border')@endcomponent
        </div>
    </li>
    @{{/each}}
</script>
