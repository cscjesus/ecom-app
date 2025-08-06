<div>

    <section class="rounded-lg bg-white shadow-lg">
        <header class="border-b border-gray-200 px-6 py-2">
            <div class="flex justify-between">
                <h1 class=" text-lg font-semibold text-gray-700">
                    Opciones
                </h1>
                <x-button wire:click="$set('newOption.openModal', true)">
                    <i class="fas fa-plus"></i> Agregar opción
                </x-button>
            </div>
        </header>
        <div class="p-6">
            <div class="space-y-6">
                @foreach ($options as $option)
                    <div class="p-6 rounded-lg border-gray-200 border relative" wire:key="option-{{ $option->id }}">
                        <div class="absolute px-4 -top-3 bg-white">
                            <button class="mr-1" onclick="confirmDelete({{  $option->id  }},'option')">
                                <i class="fa-solid fa-trash-can text-red-500 hover:text-red-600"></i>
                            </button>
                            <span>{{ $option->name }}</span>
                        </div>
                        {{-- valores --}}
                        <div class="flex flex-wrap mb-4">
                            @foreach ($option->features as $feature)
                                {{-- si es un color -}}
                                {{-- dependiendo del tipo de caracteristica --}}
                                @switch($option->type)
                                    @case(1)
                                        {{-- texto --}}
                                        <span
                                            class="bg-gray-100 text-gray-800 text-sm font-medium me-2 pl-2.5 pr-1.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-gray-300">{{ $feature->description }}
                                            {{-- eliminar feature --}}
                                            <button class="ml-0.5" onclick="confirmDelete({{ $feature->id}} ,'feature')"
                                                {{-- wire:click="deleteFeature({{ $feature->id }})" --}}>
                                                <i class="fa-solid fa-xmark hover:text-red-500"></i>
                                            </button>

                                        </span>
                                    @break

                                    @case(2)
                                        {{-- color --}}
                                        <div class="relative">
                                            <span
                                                class="inline-block h-6 w-6 shadow-lg rounded-full border-2 border-gray-300 mr-4"
                                                style="background-color: {{ $feature->value }};">
                                            </span>
                                            <button
                                                class="absolute z-10 left-4 -top-2 rounded-full h-4 w-4 flex justify-center items-center"
                                                onclick="confirmDelete({{ $feature->id }},'feature')">
                                                {{-- wire:click="deleteFeature({{ $feature->id }})"> --}}
                                                <i class="fa-solid fa-trash-can hover:text-red-500 text-sm" "></i>
                                            </button>
                                        </div>
    @break

    @default
@endswitch
 @endforeach
                                </div>

                                <div>
                                    @livewire('admin.options.add-new-feature', ['option' => $option], key('add-new-feature-' . $option->id))
                                </div>

                        </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- modal --}}
    <x-dialog-modal wire:model="newOption.openModal">
        <x-slot name="title">
            Crear nueva opción
        </x-slot>
        <x-slot name="content">
            <x-validation-errors class="mb-4" />
            <div class="grid grid-cols-2 gap-6 mb-4">
                <div>
                    <x-label value="Nombre de la opción" class="mt-1" />
                    <x-input class="mt-1 block w-full" placeholder="Ejemplo: Color, Tamaño, etc."
                        wire:model="newOption.name" />
                    {{-- <x-input-error for="name" class="mt-2" /> --}}
                </div>
                <div>
                    <x-label value="Tipo" class="mt-1" />
                    <x-select class="mt-1 block w-full" wire:model.live="newOption.type">
                        <option value="1">Texto</option>
                        <option value="2">Color</option>
                    </x-select>
                    {{-- <x-input-error for="type" class="mt-2" /> --}}
                </div>
            </div>

            <div class="flex items-center mb-4">
                <hr class="flex-1">
                <span class="mx-4">Valores</span>
                <hr class="flex-1">
            </div>
            <div class="mb-4 space-y-4">

                @foreach ($newOption->features as $index => $feature)
                    <div class="p-6 rounded-lg border border-gray-200 relative" wire:key="features-{{ $index }}">

                        <div class="absolute -top-3 px-4 bg-white">
                            <button wire:click="removeFeature({{ $index }})">
                                <i class="fa-solid fa-trash-can text-red-500 hover:text-red-600"></i>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-label value="Valor" class="mt-1" />


                                @switch($newOption->type)
                                    @case(1)
                                        <x-input wire:model="newOption.features.{{ $index }}.value" class=" block w-full"
                                            placeholder="Ingrese el valor de la opción" />
                                    @break

                                    @case(2)
                                        <div
                                            class="border border-gray-300 rounded-md h-[42px] flex items-center px-3 justify-between">

                                            {{ $newOption->features[$index]['value'] ?: 'Seleccione un color' }}

                                            <input type="color"
                                                wire:model.live="newOption.features.{{ $index }}.value" />

                                        </div>
                                    @break
                                @endswitch

                            </div>

                            <div>
                                <x-label value="Descripción" class="mt-1" />
                                <x-input wire:model="newOption.features.{{ $index }}.description"
                                    class=" block w-full" placeholder="Ingrese una descripción" />
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end">
                <x-button wire:click="addFeature">
                    <i class="fas fa-plus"></i> Agregar valor
                </x-button>

            </div>
        </x-slot>
        <x-slot name="footer">
            <button class="btn btn-blue" wire:click="addOption">
                <i class="fas fa-save"></i>
                Agregar
            </button>
        </x-slot>
    </x-dialog-modal>
    @push('js')
        <script>
            function confirmDelete(id, type = 'feature') {
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, ¡eliminar!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        switch (type) {
                            case 'feature':
                                @this.call('deleteFeature', id);
                                break;
                           case 'option':
                                @this.call('deleteOption', id);
                                break;
                        }
                    }
                });
            }
        </script>
    @endpush
</div>
