<?php

namespace App\Livewire\Forms\Admin\Options;

use App\Models\Option;
use Livewire\Attributes\Validate;
use Livewire\Form;
//php artisan livewire:form Admin\Options\NewOptionForm
class NewOptionForm extends Form
{
    public $name = '';
    public $type = 1;
    public $openModal = false;

    public $features = [
        [
            'value' => '',
            'description' => '',
        ],
    ];
    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'type' => 'required|in:1,2',
            'features' => 'required|array|min:1'
        ];
        foreach ($this->features as $index => $feature) {
            if ($this->type == 1) {
                $rules["features.$index.value"] = 'required';
            } else {
                $rules["features.$index.value"] = 'required|regex:/^#[0-9a-fA-F]{6}$/';
            }
            $rules["features.$index.description"] = 'required|max:255';
        }
        return $rules;
    }
    public function validationAttributes(): array
    {
        $attributes = [
            'name' => 'nombre',
            'type' => 'tipo',
            'features' => 'valores',
            'features.*.value' => 'Valor de la característica',
            'features.*.description' => 'Descripción de la característica',
        ];
        foreach ($this->features as $index => $feature) {
            $attributes["features.$index.value"] = "valor ".($index + 1);
            $attributes["features.$index.description"] = "descripción ".($index + 1);
        }
        return $attributes;
    }
    function addFeature()
    {
        $this->features[] = [
            'value' => '',
            'description' => '',
        ];
    }
    function removeFeature($index): void
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
    }
    public function save()
    {
        $this->validate();
        $option = Option::create([
            'name' => $this->name,
            'type' => $this->type,
        ]);

        foreach ($this->features as $feature) {
            $option->features()->create([
                'value' => $feature['value'],
                'description' => $feature['description'],
                //'option_id' => $option->id,//ocurre por la relacion
            ]);
        }
        $this->reset();
    }
}
