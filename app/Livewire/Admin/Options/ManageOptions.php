<?php

namespace App\Livewire\Admin\Options;

use App\Models\Option;
use Livewire\Component;
//php artisan make:livewire admin.options.manage-options
class ManageOptions extends Component
{
    public $options;
    public $openModal = false;
    public $newOption = [
        'name' => '',
        'type' => 1,
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
    function removeFeature($index): void
    {
        unset($this->newOption['features'][$index]);
        $this->newOption['features'] = array_values($this->newOption['features']);
    }
    function addOption(): void
    {
        $rules = [
            'newOption.name' => 'required',
            'newOption.type' => 'required|in:1,2',
            'newOption.features' => 'required|array|min:1'
        ];
        foreach ($this->newOption['features'] as $index => $feature) {
            // $rules["newOption.features.$index.value"] = 'required';
            if($this->newOption['type'] == 1) {
                $rules["newOption.features.$index.value"] = 'required';
            } else {
                $rules["newOption.features.$index.value"] = 'required|regex:/^#[0-9a-fA-F]{6}$/';
            }
            $rules["newOption.features.$index.description"] = 'required|max:255';      
        }
        $this->validate($rules);
        $option = Option::create([
            'name' => $this->newOption['name'],
            'type' => $this->newOption['type'],
        ]);

        foreach ($this->newOption['features'] as $feature) {
            $option->features()->create([
                'value' => $feature['value'],
                'description' => $feature['description'],
                //'option_id' => $option->id,//ocurre por la relacion
            ]);
        }
        $this->options = Option::with('features')->get();
        $this->reset('openModal', 'newOption');
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Creación exitosa',
            'html' => "Opción <b>$option->name</b> creada correctamente",
        ]);
    }
    public function render()
    {
        return view('livewire.admin.options.manage-options');
    }
}
