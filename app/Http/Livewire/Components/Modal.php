<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class Modal extends Component
{
    public $elModal;
    public $size; // sm, md, lg
    public $title;
    public $slot;
    public $footer;

    public function mount($elModal, $size = '', $title = '', $slot = '', $footer = '') {
        $this->elModal = $elModal;
        $this->size = $size;
        $this->title = $title;
        $this->slot = $slot;
        $this->footer = $footer;
    }

    public function render()
    {
        return view('livewire.components.modal');
    }
}
