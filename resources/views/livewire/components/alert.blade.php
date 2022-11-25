<div id="{{ $elId }}" class="alert-container {{ $type }} mt-5"></div>

<script id="alert-tpl" type="text/x-handlebars-templates">
    <div class="alert-card {{ $color['txt'] }} {{ $color['bg'] }}" role="alert">
        <div>
            <div class="alert-icon {{ $color['icon'] }}">
                <i class="fa fa-exclamation-triangle fa-1x"></i>
            </div>
            <div class="alert-body">
                <p class="alert-title">@{{ title }} {{ $title }}</p>
                <p class="alert-content">
                    @{{ slot }} {{ $slot }}
                </p>
            </div>
            <button class="btn-alert-close {{ $color['icon'] }}" type="button">
                <i class="fa fa-close fa-1x"></i>
            </button>
        </div>
    </div>
</script>

@include('livewire.components.alert-js')