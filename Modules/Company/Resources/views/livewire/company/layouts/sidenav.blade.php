<div x-data="{ dropdownCompany: false }" :class="{'hidden': ! open, '': open }">
    @supadm
    <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/company">
        <a href="{{ url('/company') }}">
            <div class="flex-auto">
                {{ __('company::company.Company') }}
            </div>
        </a>
    </div>

    <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/company/payment">
        <a href="{{ url('/company/payment') }}">
            <div class="flex-auto">
                {{ __('company::payment.Payment') }}
            </div>
        </a>
    </div>

@elseadmin
    <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/company">
        <a href="{{ url('/company') }}">
            <div class="flex-auto">
                {{ __('company::company.Company') }}
            </div>
        </a>
    </div>

    <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/company/payment">
        <a href="{{ url('/company/payment') }}">
            <div class="flex-auto">
                {{ __('company::payment.Payment') }}
            </div>
        </a>
    </div>

@elsemanager
    <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/company">
        <a href="{{ url('/company') }}">
            <div class="flex-auto">
                {{ __('company::company.Company') }}
            </div>
        </a>
    </div>

    <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/company/payment">
        <a href="{{ url('/company/payment') }}">
            <div class="flex-auto">
                {{ __('company::payment.Payment') }}
            </div>
        </a>
    </div>

@elseuser
@else
@endsupadm

</div>
