<?php

namespace App\Livewire\Admin\Options;

use Livewire\Component;
// php artisan make:livewire Admin\Options\AddNewFeature
class AddNewFeature extends Component
{

    public $option;
    public $newFeature = [
        'value' => '',
        'description' => '',
    ];
    public function addFeature(){
       $this->validate([
            'newFeature.value' => 'required',
            'newFeature.description' => 'required|string|max:255',
        ]);

        $this->option->features()->create($this->newFeature);

        $this->dispatch('featureAdded');
        // Reset the new feature input
        $this->reset('newFeature');

    }
    public function render()
    {
        return view('livewire.admin.options.add-new-feature');
    }
}
