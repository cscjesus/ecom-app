<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
//php artisan make:controller Admin\SubcategoryController --model=Subcategory
class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.subcategories.index', [
            'subcategories' => Subcategory::orderBy('id', 'desc')
                ->orderBy('id', 'desc') // Order by ID in descending order
                ->with('category.family') // Preload relationships to avoid N+1 queries
                ->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);
        $subcategory = Subcategory::create(
            $request->all()
        );
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Creación exitosa',
            'html' => "Subcategoría <b>$subcategory->name</b> creada correctamente",

        ]);
        return redirect()->route('admin.subcategories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        //
    }
}
