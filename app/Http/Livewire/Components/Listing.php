<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class Listing extends Component
{
    public $height;

    public function mount($height = '75vh') {
        $this->height = $height;
    }

    public function render()
    {
        return view('livewire.components.listing');
    }
}
