<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Category;
use App\Models\Family;
use App\Models\Subcategory;
use Livewire\Attributes\Computed;
use Livewire\Component;
//php artisan make:livewire admin.subcategories.subcategory-create
class SubcategoryCreate extends Component
{
    public $families ;
    public $subcategory = [
        'family_id'=>'',
        'category_id' => '',
        'name' => '',
    ];
    public function mount()
    {
        $this->families =Family::all();
    }
    public function updatedSubcategoryFamilyId()
    {
        $this->subcategory['category_id'] = '';
        
    }
    #[Computed()]
    public function categories()  {
        return Category::where('family_id', $this->subcategory['family_id'])
            ->orderBy('name')
            ->get();
    }
    public function save(){
        $this->validate([
            'subcategory.family_id' => 'required|exists:categories,id',
            'subcategory.category_id' => 'required|exists:categories,id',
            'subcategory.name' => 'required|string',
        ],[],[
            'subcategory.family_id' => 'familia',
            'subcategory.category_id' => 'categoría',
            'subcategory.name' => 'nombre',
        ]);
        $subcategory = Subcategory::create($this->subcategory);
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Creación exitosa',
            'html' => "Subcategoría <b>$subcategory->name</b> creada correctamente",
        ]);
        return redirect()->route('admin.subcategories.index');
    }
    public function render()
    {
        return view('livewire.admin.subcategories.subcategory-create');
    }
}
