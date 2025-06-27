<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

//php artisan make:livewire admin.products.product-edit 
class ProductEdit extends Component
{
    use WithFileUploads;

    public $families;
    public $family_id = '';
    public $category_id = '';
    public $image;

    public $product;
    public $productEdit;
    public function mount($product)
    {
        $this->productEdit = $product->only(['id', 'sku', 'name', 'description', 'image_path', 'price', 'subcategory_id', 'stock']);
        $this->families = Family::all();
        $this->category_id = $product->subcategory->category->id;
        $this->family_id = $product->subcategory->category->family->id;
    }
    public function boot()
    {
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {
                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => 'Error de validación',
                    'html' => implode('<br>', $validator->errors()->all()),
                ]);
            }
        });
    }
    public function updatedFamilyId($value)
    {
        $this->category_id = '';
        $this->productEdit['subcategory_id'] = '';
    }
    public function updatedCategoryId($value)
    {
        $this->productEdit['subcategory_id'] = '';
    }
    #[Computed()]
    public function categories()
    {
        return Category::where('family_id', $this->family_id)
            ->get();
    }
    #[Computed()]
    public function subcategories()
    {
        return Subcategory::where('category_id', $this->category_id)
            ->get();
    }
    public function store()
    {
        $this->validate(
            [
                'image' => 'nullable|image|max:1024', // 1MB Max
                'productEdit.sku' => 'required|unique:products,sku,' . $this->product->id,
                'productEdit.name' => 'required',
                'productEdit.description' => 'nullable',
                'productEdit.price' => 'required|numeric|min:0',
                'productEdit.subcategory_id' => 'required|exists:categories,id',
                'productEdit.stock' => 'required|numeric|min:0',
            ],
            [],
            [
                'productEdit.sku' => 'sku',
                'productEdit.name' => 'nombre',
                'productEdit.description' => 'descripción',
                'productEdit.price' => 'precio',
                'productEdit.subcategory_id' => 'categoría',
                'productEdit.stock' => 'stock',
            ]
        );

        if ($this->image) {
            // Delete the old image if a new one is uploaded
            Storage::delete($this->productEdit['image_path']);
            $this->productEdit['image_path'] = $this->image ? $this->image->store('products') : null;
        }

        $this->product->update($this->productEdit);
        $name = $this->productEdit['name'];
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Actualización exitosa',
            'html' => "Producto <b>$name</b> actualizado correctamente",
        ]);
        return redirect()->route('admin.products.edit', $this->product);
    }
    public function render()
    {
        return view('livewire.admin.products.product-edit');
    }
}
