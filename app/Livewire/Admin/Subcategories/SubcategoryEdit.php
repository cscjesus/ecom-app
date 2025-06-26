<?php

namespace App\Livewire\Admin\Subcategories;

use App\Models\Category;
use App\Models\Family;
use Livewire\Attributes\Computed;
use Livewire\Component;
//php artisan make:livewire admin.subcategories.subcategory-edit
class SubcategoryEdit extends Component
{
    public $subcategory;
    public $families ;

     public $subcategoryEdit ;
     public function mount($subcategory)
    {
        $this->families =Family::all();
        $this->subcategoryEdit =[
            'family_id' => $subcategory->category->family_id,
            'category_id' => $subcategory->category_id,
            'name' => $subcategory->name,
        ];
    }

    public function updatedSubcategoryEditFamilyId()
    {
        $this->subcategoryEdit['category_id'] = '';
        
    }
     #[Computed()]
    public function categories()  {
        return Category::where('family_id', $this->subcategoryEdit['family_id'])
            ->orderBy('name')
            ->get();
    }
    public function save(){
        $this->validate([
            'subcategoryEdit.family_id' => 'required|exists:families,id',
            'subcategoryEdit.category_id' => 'required|exists:categories,id',
            'subcategoryEdit.name' => 'required|string',
        ]);

        $this->subcategory->update($this->subcategoryEdit);
        $name = $this->subcategoryEdit['name'];
        //   session()->flash('swal', [
        //     'icon' => 'success',
        //     'title' => 'Actualización exitosa',
        //     'html' => "Subcategoría <b> $name </b> actualizada correctamente",
        // ]);
        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Actualización exitosa',
            'html' => "Subcategoría <b> $name </b> actualizada correctamente",
        ]);
        // return redirect()->route('admin.subcategories.index');
    }
    public function render()
    {
        return view('livewire.admin.subcategories.subcategory-edit');
    }
}
