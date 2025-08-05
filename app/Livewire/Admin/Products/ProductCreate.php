<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Family;
use App\Models\Product;
use App\Models\Subcategory;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

//php artisan make:livewire Admin\Products\ProductCreate
class ProductCreate extends Component
{
    use WithFileUploads;
    public $families;
    public $family_id = '';
    public $category_id = '';
    public $image;
    public $product = [
        'sku' => '',
        'name' => '',
        'description' => '',
        'image_path' => '',
        'price' => '',
        'subcategory_id' => '',
        'stock' => '',
    ];
    public function mount()
    {
        $this->families = Family::all();
    }
    public function boot(){
        $this->withValidator(function ($validator) {
           if($validator->fails()){
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
        $this->product['subcategory_id'] = '';
    }
    public function updatedCategoryId($value)
    {
        $this->product['subcategory_id'] = '';
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
        $this->validate([
            'image' => 'image|max:1024', // 1MB Max
            'product.sku' => 'required|unique:products,sku',
            'product.name' => 'required',
            'product.description' => 'nullable',
            'product.price' => 'required|numeric|min:0',
            'product.subcategory_id' => 'required|exists:subcategories,id',
            'product.stock' => 'required|numeric|min:0',
        ],[],
        [
        'product.sku' => 'sku',
            'product.name' => 'nombre',
            'product.description' => 'descripción',
            'product.price' => 'precio',
            'product.subcategory_id' => 'subcategoría',
            'product.stock' => 'stock',
        ]);

        $this->product['image_path'] = $this->image ? $this->image->store('products') : null;

        $product = Product::create($this->product);
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Creación exitosa',
            'html' => "Producto <b>$product->name</b> creado correctamente",
        ]);
        return redirect()->route('admin.products.edit', $product);
    }
    public function render()
    {
        return view('livewire.admin.products.product-create');
    }
}
