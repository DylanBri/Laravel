<div x-data="{ dropdownSettings: false }" :class="{'hidden': ! open, '': open }">
    <div class="flex items-center justify-end nav-item nav-item-inactive"
         data-route="">
        <a @click="dropdownSettings = ! dropdownSettings">
            <div class="flex-auto">
                <div class="flex justify-between">
                    {{ __('profile::profile.Settings') }}
                    <i class="fa fa-chevron-down mt-1"
                       :class="{'fa-chevron-down': ! dropdownSettings, 'fa-chevron-up': dropdownSettings }"></i>
                </div>
            </div>
        </a>
    </div>
    <div :class="{'hidden': ! dropdownSettings, '': dropdownSettings }">
        <div class="flex items-center justify-end nav-item nav-item-inactive mt-1"
        data-route="/monitoring/lot">
       <a href="{{ url('/monitoring/lot') }}">
           <div class="flex-auto">
               &nbsp;&nbsp;&nbsp; {{ __('monitoring::lot.Lot') }}
           </div>
       </a>
   </div>
    </div>
</div>
