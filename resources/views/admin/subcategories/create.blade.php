<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Subcategorías',
        'route' => route('admin.subcategories.index'),
    ],
    [
        'name' => 'Nuevo',
    ],
]">
    <form action="{{ route('admin.subcategories.store') }}" method="POST">
        @csrf
        <div class="card">
            <x-validation-errors class="mb-4" />
            <div class="mb-4">
                <x-label class="mb-2">
                    categorías
                </x-label>
                <x-select name="category_id" class="w-full">
                    {{-- <option value="">Seleccione una familia</option> --}}
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach

                </x-select>
            </div>

            <div class="mb-4">
                <x-label for="name" value="Nombre" class="mb-2" />
                <x-input class="w-full" placeholder="Ingrese el nombre de la subcategoría" name="name"
                    value="{{ old('name') }}" />
            </div>

            <div class="flex justify-end">
                <x-button>
                    Guardar
                </x-button>
            </div>
        </div>
    </form>
</x-admin-layout>
