<div class="modal-container hidden" id="{{ $elModal }}">
    <div class="modal-card @if ($size == 'sm') min-w-25 @elseif($size == 'lg') min-w-75 @else min-w-50 @endif">
        <!--body-->
        <div class="modal-body">
            <!--header-->
            <div class="modal-header">
                <h3 class="modal-title">
                    {{ $title }}
                </h3>
                <button class="btn-toggle-modal btn-modal-header" type="button">
                        <span>
                            <i class="fa fa-times"></i>
                        </span>
                </button>
            </div>
            <!--content-->
            <div class="modal-content">
                {{ $slot }}
            </div>
            <!--footer-->
            <div class="modal-footer">
                {{ $footer }}
                <button class="btn-toggle-modal btn-modal-footer btn-default" type="button">
                    {{ __('Close') }}
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop-container hidden" id="{{ $elModal }}-backdrop"></div>

@include('livewire.components.modal-js')