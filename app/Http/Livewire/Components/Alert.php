<?php

namespace App\Http\Livewire\Components;

use Livewire\Component;

class Alert extends Component
{
    public $elId;
    public $type;
    public $title;
    public $slot;
    public $color;

    private $colors = [
        'alert-danger' => ['icon' => 'text-red-700', 'bg' => 'bg-red-100', 'txt' => 'text-red-600'],
        'alert-warning' => ['icon' => 'text-yellow-700', 'bg' => 'bg-yellow-100', 'txt' => 'text-yellow-600'],
        'alert-success' => ['icon' => 'text-green-700', 'bg' => 'bg-green-100', 'txt' => 'text-green-600'],
        'alert-info' => ['icon' => 'text-blue-700', 'bg' => 'bg-blue-100', 'txt' => 'text-blue-600'],
    ];

    private $defaultTitles = [];

    public function mount($elId, $type, $slot = '') {
        $this->defaultTitles = [
            'alert-danger' => __('alert.An unexpected error occurred.'),
            'alert-warning' => __('alert.Warning !'),
            'alert-success' => __('alert.Successful saving.'),
            'alert-info' => __('alert.Information !'),
        ];
        $this->elId = $elId;
        $this->type = $type;
        $this->slot = $slot;
        $this->title = $this->defaultTitles[$type];
        $this->color = $this->colors[$type];
    }

    public function render()
    {
        return view('livewire.components.alert');
    }
}
