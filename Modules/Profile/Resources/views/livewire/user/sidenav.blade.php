<div x-data="{ dropdown: false }" :class="{'hidden': ! open, '': open }">
   <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/customer/list/search">
        <a @click="dropdown = ! dropdown">
            <div class="flex-auto">
                <div class="flex justify-between">
                    {{ __('profile::user.Search') }}
                    <i class="fa fa-chevron-down mt-1"
                       :class="{'fa-chevron-down': ! dropdown, 'fa-chevron-up': dropdown }"></i>
                </div>
            </div>
        </a>
    </div>
    <div :class="{'hidden': ! dropdown, '': dropdown }">
        <div class="flex items-center justify-end nav-item nav-item-inactive"
             data-route="/customer/list/search">
            <a href="{{ route('customer.listing') }}">
                <div class="flex-auto">
                    &nbsp;&nbsp;&nbsp; {{ __('customer::customer.Listing') }}
                </div>
            </a>
        </div>
    </div>

    {{--<div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/user/user">
        <a href="--}}{{--{{ route('user.index') }}--}}{{--">
                <div class="flex-auto">
                    &nbsp;&nbsp;&nbsp; {{ __('profile::user.User') }}
                </div>
            </a>
        </div>
    </div>--}}
    {{--<div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="/client|/user">
        <a @click="dropdown = ! dropdown">
            <div class="flex-auto">
                <div class="flex justify-between">
                    {{ __('profile::user.Management User') }}
                    <i class="fa fa-chevron-down mt-1"
                       :class="{'fa-chevron-down': ! dropdown, 'fa-chevron-up': dropdown }"></i>
                </div>
            </div>
        </a>
    </div>
    <div :class="{'hidden': ! dropdown, '': dropdown }">
        <div class="flex items-center justify-end nav-item nav-item-inactive"
             data-route="/user/user">
            <a href="--}}{{--{{ route('user.index') }}--}}{{--">
                <div class="flex-auto">
                    &nbsp;&nbsp;&nbsp; {{ __('profile::user.User') }}
                </div>
            </a>
        </div>
    </div>--}}
</div>