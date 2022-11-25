<script id="btnAction-tpl" type="text/x-handlebars-template">
    <div class="grid-action">
        <ul>
            @{{#each buttons}}
            <li>
                <a href="#" class="@{{ this.btnClass }}" data-id="@{{ this.modelId }}">
                    <span class="@{{ this.imgClass }}" title="@{{ this.title }}"></span>
                </a>
            </li>
            @{{/each}}
        </ul>
    </div>
</script>

@include('livewire.components.grid.content-js')