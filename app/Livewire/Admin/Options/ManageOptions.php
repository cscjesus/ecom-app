<?php

namespace App\Livewire\Admin\Options;

use App\Models\Option;
use Livewire\Component;
//php artisan make:livewire admin.options.manage-options
class ManageOptions extends Component
{
    public $options;
    public function mount() {
        $this->options= Option::with('features')->get();
    }
    public function render()
    {
        return view('livewire.admin.options.manage-options');
    }
}
