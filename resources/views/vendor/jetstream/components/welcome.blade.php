<section class="m-10 text-gray-700 ">
    {{--<div class="text-center md:max-w-xl lg:max-w-3xl mx-auto">
        <h3 class="text-3xl font-bold mb-6 text-gray-800">Testimonials</h3>
        <p class="mb-6 pb-2 md:mb-12 md:pb-0">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit, error amet numquam
            iure provident voluptate esse quasi, veritatis totam voluptas nostrum quisquam eum
            porro a pariatur veniam.
        </p>
    </div>--}}

    <div class="grid md:grid-cols-2 gap-6 text-center">
        <div>
            @component('components.short-frame',
                [
                    'bgColorHeader' => 'bg-emerald-600',
                    'icon' => 'fa-user',
                    'iconColor' => 'text-emerald-400',
                    'label' => 'customer::customer.List',
                    'buttons' => [[
                        'url' => '/customer',
                        'classes' => 'bg-emerald-400 hover:bg-emerald-600',
                        'label' => 'actions.See'
                    ]]
                ])
            @endcomponent
        </div>
        {{-- <div>
            @component('components.short-frame',
                [
                    'bgColorHeader' => 'bg-cyan-600',
                    'icon' => 'fa-user',
                    'iconColor' => 'text-cyan-400',
                    'label' => 'customer::user.List',
                    'buttons' => [[
                        'url' => '/customer/user',
                        'classes' => 'bg-cyan-400 hover:bg-cyan-600',
                        'label' => 'actions.See'
                    ]]
                ])
            @endcomponent
        </div> --}} 
        <div>
            @component('components.short-frame',
                [
                    'bgColorHeader' => 'bg-blue-600',
                    'icon' => 'fa-wrench',
                    'iconColor' => 'text-blue-400',
                    'label' => 'monitoring::work-site.List',
                    'buttons' => [[
                        'url' => '/monitoring/work-site',
                        'classes' => 'bg-blue-400 hover:bg-blue-600',
                        'label' => 'actions.See'
                    ]]
                ])
            @endcomponent
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6 text-center mt-5">
        <div>
            @component('components.short-frame',
                [
                    'bgColorHeader' => 'bg-violet-600',
                    'icon' => 'fa-building',
                    'iconColor' => 'text-violet-400',
                    'label' => 'company::company.List',
                    'buttons' => [[
                        'url' => '/company',
                        'classes' => 'bg-violet-400 hover:bg-violet-600',
                        'label' => 'actions.See'
                    ]]
                ])
            @endcomponent
        </div>
        <div>
            @component('components.short-frame',
                [
                    'bgColorHeader' => 'bg-red-600',
                    'icon' => 'fa-credit-card',
                    'iconColor' => 'text-red-400',
                    'label' => 'company::payment.List',
                    'buttons' => [[
                        'url' => '/company/payment',
                        'classes' => 'bg-red-400 hover:bg-red-600',
                        'label' => 'actions.See'
                    ]]
                ])
            @endcomponent
        </div>
        {{-- <div>
            @component('components.short-frame',
                [
                    'bgColorHeader' => 'bg-amber-600',
                    'icon' => 'fa-file-text',
                    'iconColor' => 'text-amber-400',
                    'label' => 'document::document.List',
                    'buttons' => [[
                        'url' => '/document/propal',
                        'classes' => 'bg-amber-400 hover:bg-amber-600',
                        'label' => 'document::propal.Propal'
                    ],[
                        'url' => '/document/invoice',
                        'classes' => 'bg-amber-400 hover:bg-amber-600',
                        'label' => 'document::invoice.Invoice'
                    ]]
                ])
            @endcomponent
        </div> --}}
    </div>
</section>