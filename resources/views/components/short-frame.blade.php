<div class="short-frame-body">
    <div class="short-frame-bg {{ $bgColorHeader }}"></div>
    <div class="short-frame-content">
        <span class="fa-stack fa-3x">
            <i class="fa fa-circle fa-stack-2x {{ $iconColor }}"></i>
            <i class="fa {{ $icon }} fa-stack-1x fa-inverse"></i>
        </span>
    </div>
    <div class="p-6">
        <h4 class="short-frame-title">{{ __($label) }}</h4>
        <hr />
        <p class="mt-4">
            @foreach($buttons as $button)
                <a href="{{ $button['url'] }}" class="btn btn-default {{ $button['classes'] }}">{{ __($button['label']) }}</a>
            @endforeach
        </p>
    </div>
</div>