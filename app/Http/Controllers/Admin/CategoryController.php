<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Family;
use Illuminate\Http\Request;
//php artisan make:controller Admin\CategoryController --model=Category
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::orderBy('id', 'desc')
            ->with('family')//precargar la relación family, para no hacer N+1 consultas
            ->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $families = Family::all();
        return view('admin.categories.create', compact('families'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'family_id' => 'required|exists:families,id',
        ]);
        $category = Category::create(
            $request->all()
        );
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Creación exitosa',
            'html' => "Categoría <b>$category->name</b> creada correctamente",

        ]);
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'families' => Family::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
         $request->validate([
            'name' => 'required|string',
            'family_id' => 'required|exists:families,id',
        ]);
        $category->update($request->all());
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Actualización exitosa',
            'html' => "Categoría <b>$category->name</b> actualizada correctamente",
        ]);
        return redirect()->route('admin.categories.edit',$category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->subcategories->count() > 0) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => '¡Ops!',
                'html' => "La categoría <strong>$category->name</strong> no se puede eliminar porque tiene subcategorías asociadas.",
            ]);
            return redirect()->route('admin.categories.edit', $category);
        }
        $category->delete();
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Eliminación exitosa',
            'html' => "Categoría <strong>$category->name</strong> eliminada correctamente",
        ]);
        return redirect()->route('admin.categories.index');
    }
}
