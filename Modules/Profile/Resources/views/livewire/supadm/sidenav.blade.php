<div x-data="{ dropdown: false }" :class="{'hidden': ! open, '': open }">
    <div class="flex items-center justify-end nav-item nav-item-inactive mt-1"
         data-route="/client|/supadm|/admin|/manager|/user">
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
        <div class="flex items-center justify-end nav-item nav-item-inactive mt-1"
             data-route="/client">
            <a href="{{ route('client.index') }}">
                <div class="flex-auto">
                    &nbsp;&nbsp;&nbsp; {{ __('client.Client') }}
                </div>
            </a>
        </div>

        <div class="flex items-center justify-end nav-item nav-item-inactive mt-1"
             data-route="/supadm">
            <a href="{{ route('supadm.index') }}">
                <div class="flex-auto">
                    &nbsp;&nbsp;&nbsp; {{ __('profile::user.Supadm') }}
                </div>
            </a>
        </div>

        <div class="flex items-center justify-end nav-item nav-item-inactive mt-1"
             data-route="/admin">
            <a href="{{ route('admin.index') }}">
                <div class="flex-auto">
                    &nbsp;&nbsp;&nbsp; {{ __('profile::user.Admin') }}
                </div>
            </a>
        </div>

        <div class="flex items-center justify-end nav-item nav-item-inactive mt-1"
             data-route="/manager">
            <a href="{{ route('manager.index') }}">
                <div class="flex-auto">
                    &nbsp;&nbsp;&nbsp; {{ __('profile::user.Manager') }}
                </div>
            </a>
        </div>

        <div class="flex items-center justify-end nav-item nav-item-inactive mt-1"
             data-route="/user">
            <a href="{{ route('user.index') }}">
                <div class="flex-auto">
                    &nbsp;&nbsp;&nbsp; {{ __('profile::user.User') }}
                </div>
            </a>
        </div>
    </div>
</div>
