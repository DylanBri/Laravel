<div x-data="{ dropdownCustomer: false }" :class="{'hidden': ! open, '': open }">
    @supadm
    <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/customer">
        <a href="{{ url('/customer') }}">
            <div class="flex-auto">
                {{ __('customer::customer.Customer') }}
            </div>
        </a>
    </div>

@elseadmin
    <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/customer">
        <a href="{{ url('/customer') }}">
            <div class="flex-auto">
                {{ __('customer::customer.Customer') }}
            </div>
        </a>
    </div>

@elsemanager
    <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/customer">
        <a href="{{ url('/customer') }}">
            <div class="flex-auto">
                {{ __('customer::customer.Customer') }}
            </div>
        </a>
    </div>

@elseuser
@else
@endsupadm
</div>
