<div x-data="{ dropdownMonitoring: false }" :class="{'hidden': ! open, '': open }">
    @supadm
    <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/monitoring/work-site">
        <a href="{{ url('/monitoring/work-site') }}">
            <div class="flex-auto">
                {{ __('monitoring::work-site.workSite') }}
            </div>
        </a>
    </div>

    {{-- <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/monitoring/lot">
        <a href="{{ url('/monitoring/lot') }}">
            <div class="flex-auto">
                {{ __('monitoring::lot.Lot') }}
            </div>
        </a>
    </div>

    <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/monitoring">
        <a href="{{ url('/monitoring') }}">
            <div class="flex-auto">
                {{ __('monitoring::monitoring.Monitoring') }}
            </div>
        </a>
    </div> --}}

@elseadmin
<div class="flex items-center justify-end nav-item nav-item-inactive"
     data-route="/monitoring/work-site">
    <a href="{{ url('/monitoring/work-site') }}">
        <div class="flex-auto">
            {{ __('monitoring::work-site.workSite') }}
        </div>
    </a>
</div>

{{-- <div class="flex items-center justify-end nav-item nav-item-inactive"
     data-route="/monitoring/lot">
    <a href="{{ url('/monitoring/lot') }}">
        <div class="flex-auto">
            {{ __('monitoring::lot.Lot') }}
        </div>
    </a>
</div>

<div class="flex items-center justify-end nav-item nav-item-inactive"
     data-route="/monitoring">
    <a href="{{ url('/monitoring') }}">
        <div class="flex-auto">
            {{ __('monitoring::monitoring.Monitoring') }}
        </div>
    </a>
</div> --}}

@elsemanager
<div class="flex items-center justify-end nav-item nav-item-inactive"
     data-route="/monitoring/work-site">
    <a href="{{ url('/monitoring/work-site') }}">
        <div class="flex-auto">
            {{ __('monitoring::work-site.workSite') }}
        </div>
    </a>
</div>

{{-- <div class="flex items-center justify-end nav-item nav-item-inactive"
     data-route="/monitoring/lot">
    <a href="{{ url('/monitoring/lot') }}">
        <div class="flex-auto">
            {{ __('monitoring::lot.Lot') }}
        </div>
    </a>
</div>

<div class="flex items-center justify-end nav-item nav-item-inactive"
     data-route="/monitoring">
    <a href="{{ url('/monitoring') }}">
        <div class="flex-auto">
            {{ __('monitoring::monitoring.Monitoring') }}
        </div>
    </a>
</div> --}}

@elseuser
@else
@endsupadm

</div>
