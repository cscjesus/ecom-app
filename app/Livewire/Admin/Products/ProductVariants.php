<?php

namespace App\Livewire\Admin\Products;

use App\Models\Feature;
use App\Models\Option;
use Livewire\Attributes\Computed;
use Livewire\Component;
// php artisan make:livewire Admin/Products/ProductVariants
class ProductVariants extends Component
{
    public $product;
    public $variant = [
        'option_id' => '',
        'features' => [
            [
                'id' => '',
                'value' => '',
                'description' => ''
            ],
        ]
    ];
    public $openModal = false;
    public $options;
    public function mount()
    {
        $this->options = Option::all();
    }
    #[Computed()]
    public function features()
    {
        //dd($this->variant['option_id']);
        return Feature::where('option_id', $this->variant['option_id'])
            ->get();
    }
    function addFeature()
    {
        $this->variant['features'][] = [
            'id' => '',
            'value' => '',
            'description' => ''
        ];
    }
    function removeFeature($index)
    {
        // dd($index);

        unset($this->variant['features'][$index]);
        $this->variant['features'] = array_values($this->variant['features']);
    }
    public function save()
    {
        // dd($this->variant);
        $this->validate([
            'variant.option_id' => 'required',
            // 'variant.features' => 'required|array',
            'variant.features.*.id' => 'required|exists:features,id',
            'variant.features.*.value' => 'required|string|max:255',
            'variant.features.*.description' => 'required|string|max:500',
        ]);
        $this->product->options()->attach($this->variant['option_id'], [
            'features' => $this->variant['features']
        ]);
        $this->product = $this->product->fresh();

        $this->reset('variant', 'openModal');
    }
    public function feature_change($index)
    {
        $id = $this->variant['features'][$index]['id'];
        $feature = Feature::find($id);
        // dd($feature);
        if ($feature) {
            $this->variant['features'][$index]['value'] = $feature->value;
            $this->variant['features'][$index]['description'] = $feature->description;
        }
    }
    public function updatedVariantOptionId()
    {
        // dd('pureba');
        $this->variant['features'] = [];
        $this->addFeature();
    }
    public function deleteFeature($optionId, $featureId)
    {

        $this->product->options()->updateExistingPivot($optionId, [
            'features' => array_filter($this->product->options->find($optionId)->pivot->features, function ($feature) use ($featureId) {
                return $feature['id'] != $featureId;
            })
        ]);
        $this->product = $this->product->fresh();
    }
    public function deleteOption($optionId)  {
        $this->product->options()->detach($optionId);
        $this->product = $this->product->fresh();
    }
    public function render()
    {
        return view('livewire.admin.products.product-variants');
    }
}
