<?php

namespace Modules\Profile\Http\Livewire\User;

use Livewire\Component;

class Listing extends Component
{
    /**
     * @var int
     */
    public $officeId;

    /**
     * Prepare the component.
     * @param int $officeId
     *
     * @return void
     */
    public function mount(int $officeId = 0) {
        $this->officeId = $officeId;
    }

    public function render()
    {
        return view('profile::livewire.user.listing');
    }
}
