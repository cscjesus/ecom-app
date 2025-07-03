<?php

namespace App\Livewire\Admin\Options;

use App\Models\Option;
use Livewire\Component;
//php artisan make:livewire admin.options.manage-options
class ManageOptions extends Component
{
    public $options;
    public $openModal = true;
    public $newOption = [
        'name' => '',
        'type' => 2,
        'features' => [
            [
                'value' => '',
                'description' => '',
            ],
        ],
    ];
    public function mount()
    {
        $this->options = Option::with('features')->get();
    }
    function addFeature()
    {
        $this->newOption['features'][] = [
            'value' => '',
            'description' => '',
        ];
    }
    function removeFeature($index) : void {
        unset($this->newOption['features'][$index]);
        $this->newOption['features'] = array_values($this->newOption['features']);
    }

    public function render()
    {
        return view('livewire.admin.options.manage-options');
    }
}
