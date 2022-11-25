<div id="sidenav-container" class="flex flex-col h-full w-auto bg-1 text-gray-800">
    <div x-data="{ open: true }" class="mt-1">
        <div class="flex items-center justify-end">
            <div class="flex-auto" :class="{'hidden': ! open, '': open }">
                @supadm
                    <a href="{{ route('supadm.dashboard') }}" data-route="/supadm/dashboard"
                       class="nav-item nav-item-inactive">
                        {{ __('Dashboard') }}
                    </a>
                @elseadmin
                    <a href="{{ route('admin.dashboard') }}" data-route="/admin/dashboard"
                       class="nav-item nav-item-inactive">
                        {{ __('Dashboard') }}
                    </a>
                @elsemanager
                    <a href="{{ route('manager.dashboard') }}" data-route="/manager/dashboard"
                       class="nav-item nav-item-inactive">
                        {{ __('Dashboard') }}
                    </a>
                @elseuser
                    <a href="{{ route('user.dashboard') }}" data-route="/user/dashboard" class="nav-item nav-item-inactive">
                        {{ __('Dashboard') }}
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" data-route="/dashboard" class="nav-item nav-item-inactive">
                        {{ __('Dashboard') }}
                    </a>
                @endsupadm
            </div>
            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"></path>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        @livewire('customer::customer.layouts.sidenav')

        @livewire('monitoring::monitoring.layouts.sidenav')

        @livewire('company::company.layouts.sidenav')

        {{-- @livewire('profile::user.sidenav') --}}

        @supadm
            <div class="border-t border-gray-100 mt-2"></div>

            @livewire('profile::supadm.sidenav')

            @livewire('profile::layouts.settings.sidenav')

            @livewire('log::layouts.sidenav')
        @elseadmin
            <div class="border-t border-gray-100 mt-2"></div>

            @livewire('profile::admin.sidenav')

            @livewire('profile::layouts.settings.sidenav') 

            @livewire('log::layouts.sidenav')
        @elsemanager
            <div class="border-t border-gray-100 mt-2"></div>

            @livewire('profile::manager.sidenav')

            @livewire('profile::layouts.settings.sidenav') 

            @livewire('log::layouts.sidenav')
        @elseuser
        @else
        @endsupadm

    </div>
</div>

@include('profile::livewire.layouts.sidenav-js')