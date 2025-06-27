<div>
    <form wire:submit='save'>
        <figure class="mb-4 relative ">

            <div class="absolute top-8 right-8">
                <label
                    class="flex items-center px-4 py-2 rounded-lg bg-white cursor-pointer shadow-md hover:shadow-lg transition-all text-gray-700 hover:text-gray-900">
                    <i class="fas fa-camera mr-2"></i>
                    Actualizar imagen
                    <input type="file" wire:model='image' accept="image/*" class="hidden" />
                </label>
            </div>

            <img class="aspect-[16/9] object-cover object-center w-full"
                src="{{ $image ? $image->temporaryUrl() : asset('img/no-image.png') }}" alt="No image">
        </figure>
        <x-validation-errors class="mb-4" />
        
        <div class="card">
            {{-- sku --}}
            <div class="mb-4">
                <x-label class="mb-1">
                    Código
                </x-label>
                <x-input wire:model='product.sku' class="w-full"
                    placeholder="Por favor ingrese el código del producto" />
            </div>
            {{-- name --}}
            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input wire:model='product.name' class="w-full"
                    placeholder="Por favor ingrese el nombre del producto" />
            </div>
            {{-- description --}}
            <div class="mb-4">
                <x-label class="mb-1">
                    Descripción
                </x-label>
                <x-textarea wire:model='product.description' class="w-full"
                    placeholder="Por favor ingrese la descripción del producto">
                </x-textarea>
            </div>
            {{-- familias select --}}
            <div class="mb-4">
                <x-label class="mb-1">
                    Familia
                </x-label>
                <x-select wire:model.live='family_id' class="w-full">
                    <option value="" disabled>Seleccione una familia</option>
                    @foreach ($families as $family)
                        <option value="{{ $family->id }}">{{ $family->name }}</option>
                    @endforeach
                </x-select>
            </div>
            {{-- categorias select --}}
            <div class="mb-4">
                <x-label class="mb-1">
                    Categoría
                </x-label>
                <x-select wire:model.live='category_id' class="w-full">
                    <option value="" disabled>Seleccione una categoría</option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </x-select>
            </div>
            {{-- subcategorias select --}}
            <div class="mb-4">
                <x-label class="mb-1">
                    Subcategoría
                </x-label>
                <x-select wire:model.live='product.subcategory_id' class="w-full">
                    <option value="" disabled>Seleccione una subcategoría</option>
                    @foreach ($this->subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                    @endforeach
                </x-select>
            </div>
            {{-- price --}}
            <div class="mb-4">
                <x-label class="mb-1">
                    Precio
                </x-label>
                <x-input wire:model='product.price' class="w-full"
                    placeholder="Por favor ingrese el precio del producto" type="number" step="0.01" />
            </div>
            {{-- stock --}}
            <div class="mb-4">
                <x-label class="mb-1">
                    Stock
                </x-label>
                <x-input wire:model='product.stock' class="w-full"
                    placeholder="Por favor ingrese el stock del producto" type="number"  step="0.01"/>
        </div>
        <div class="flex justify-end">
            <x-button>
                <i class="fas fa-save mr-2"></i>
                Guardar
            </x-button>

        </div>

</div>
</form>
</div>
