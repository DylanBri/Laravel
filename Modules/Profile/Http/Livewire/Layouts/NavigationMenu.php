<?php

namespace Modules\Profile\Http\Livewire\Layouts;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NavigationMenu extends Component
{
    Use AuthorizesRequests;

    public function render()
    {
        return view('profile::livewire.layouts.navigation-menu');
    }
}
