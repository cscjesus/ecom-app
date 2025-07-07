<?php

namespace App\Livewire\Admin\Options;

use App\Livewire\Forms\Admin\Options\NewOptionForm;
use App\Models\Feature;
use App\Models\Option;
use Livewire\Attributes\On;
use Livewire\Component;
//php artisan make:livewire admin.options.manage-options
class ManageOptions extends Component
{
    public $options;
    public NewOptionForm $newOption;
    public function mount()
    {
        $this->options = Option::with('features')->get();
    }
    #[On('featureAdded')]
    public function updateOptionList()
    {
        $this->options = Option::with('features')->get();
    }
    function addFeature()
    {
        $this->newOption->addFeature();
    }
    public function deleteFeature(Feature $feature): void
    {
       $feature->delete();
       $this->options = Option::with('features')->get();
    }
    function removeFeature($index): void
    {
        $this->newOption->removeFeature($index);
    }
    function addOption(): void
    {
        $name = $this->newOption->name;
        $this->newOption->save();

        $this->options = Option::with('features')->get();
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Creación exitosa',
            'html' => "Opción <b>$name</b> creada correctamente",
        ]);
    }
    public function render()
    {
        return view('livewire.admin.options.manage-options');
    }
}
