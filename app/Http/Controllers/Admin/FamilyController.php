<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use Illuminate\Http\Request;
//php artisan make:controller Admin\FamilyController --model=Family
class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.families.index', [
            'families' => Family::orderBy('id', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.families.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return $request->all();
        $request->validate([
            'name' => 'required|string',
        ]);
        $family = Family::create(
            $request->all()
        );
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Creación exitosa',
            'html' => "Familia <b>$family->name</b> creada correctamente",

        ]);
        return redirect()->route('admin.families.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Family $family)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Family $family)
    {
        return view('admin.families.edit', compact('family'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Family $family)
    {
        $request->validate([
            'name' => 'required|string',
        ]);
        $family->update(
            $request->all()
        );
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Actualización exitosa',
            'html' => "Familia <b>$family->name</b> actualizada correctamente",

        ]);
        return redirect()->route('admin.families.edit', $family);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Family $family)
    {
        if ($family->categories()->count() > 0) {
            session()->flash('swal', [
                'icon' => 'error',
                'title' => '¡Ops!',
                'html' => "La familia <strong>$family->name</strong> no se puede eliminar porque tiene categorias asociadas.",
            ]);
            return redirect()->route('admin.families.edit', $family);
        }
        $family->delete();
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Eliminación exitosa',
            'html' => "Familia <strong>$family->name</strong> eliminada correctamente",
        ]);
        return redirect()->route('admin.families.index');
    }
}
