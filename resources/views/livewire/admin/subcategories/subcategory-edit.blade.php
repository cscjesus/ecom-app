 <div>
     <form wire:submit="save">
         <div class="card">
             <x-validation-errors class="mb-4" />

             <div class="mb-4">
                 <x-label class="mb-2">
                     Familias
                 </x-label>
                 <x-select name="family_id" class="w-full" wire:model.live="subcategoryEdit.family_id">
                     <option value="" disabled>Seleccione una familia</option>
                     @foreach ($families as $family)
                         <option value="{{ $family->id }}">
                             {{ $family->name }}
                         </option>
                     @endforeach
                 </x-select>
             </div>
             <div class="mb-4">
                <x-label class="mb-2">
                    Categorías
                </x-label>
                <x-select class="w-full" wire:model.live="subcategoryEdit.category_id">
                    <option value="" disabled>
                        Seleccione una categoría
                    </option>
                    @foreach ($this->categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach

                </x-select>
            </div>

             <div class="mb-4">
                 <x-label for="name" value="Nombre" class="mb-2" />
                 <x-input class="w-full" placeholder="Ingrese el nombre de la subcategoría" wire:model.live="subcategoryEdit.name"/>
             </div>

             <div class="flex justify-end">
                 <x-button>
                     Actualizar
                 </x-button>
             </div>
         </div>
     </form>
     {{-- @dump($this->categories) --}}
     {{-- @dump(@subcategoryEdit) --}}
 </div>
