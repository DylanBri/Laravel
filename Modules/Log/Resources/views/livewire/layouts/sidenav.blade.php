<div x-data="{ dropdownLog: false }" :class="{'hidden': ! open, '': open }">
    <div class="flex items-center justify-end nav-item nav-item-inactive mt-1"
         data-route="/logQueue">
        <a href="{{ route('logQueue.index') }}">
            <div class="flex-auto">
                {{ __('log::logQueue.Log Queue') }}
            </div>
        </a>
    </div>

    {{--<div class="flex items-center justify-end nav-item nav-item-inactive mt-1"
         data-route="/logQueue">
        <a @click="dropdownLog = ! v">
            <div class="flex-auto">
                <div class="flex justify-between">
                    {{ __('log::logQueue.Management API') }}
                    <i class="fa fa-chevron-down mt-1"
                       :class="{'fa-chevron-down': ! dropdownLog, 'fa-chevron-up': dropdownLog }"></i>
                </div>
            </div>
        </a>
    </div>
    <div :class="{'hidden': ! dropdownLog, '': dropdownLog }">
        <div class="flex items-center justify-end nav-item nav-item-inactive mt-1"
         data-route="/logQueue">
        <a href="{{ route('logQueue.index') }}">
            <div class="flex-auto">
                {{ __('log::logQueue.Log Queue') }}
            </div>
        </a>
    </div>
    </div>--}}
</div>