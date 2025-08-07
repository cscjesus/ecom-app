<div>
    <section class="rounded-lg bg-white shadow-lg border border-gray-100">
        <header class="border-b border-gray-200 px-6 py-2">
            <div class="flex justify-between">
                <h1 class=" text-lg font-semibold text-gray-700">
                    Variantes
                </h1>
                <x-button wire:click="$set('openModal', true)">
                    Nuevo
                </x-button>
            </div>
        </header>

        <div class="p-6">
            @if ($product->options->count())
                <div class="space-y-6">
                    @foreach ($product->options as $option)
                        <div wire:key="product-option-{{ $option->id }}"
                            class="relative border border-gray-200 rounded-lg p-6">
                            <div class="absolute -top-3 px-4 bg-white">
                                {{-- eliminar option (variante) --}}
                                <button onclick="confirmDeleteOption({{ $option->id }})"
                                    class="text-red-500 hover:text-red-600">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                <span class="ml-2">{{ $option->name }}</span>
                            </div>
                            {{-- valores --}}
                            <div class="flex flex-wrap ">
                                @foreach ($option->pivot->features as $feature)
                                    {{-- si es un color -}}
                                {{-- dependiendo del tipo de caracteristica --}}
                                    @switch($option->type)
                                        @case(1)
                                            {{-- texto --}}
                                            <span
                                                class="bg-gray-100 text-gray-800 text-sm font-medium me-2 pl-2.5 pr-1.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-gray-300">{{ $feature['description'] }}
                                                {{-- eliminar feature --}}
                                                <button class="ml-0.5"
                                                    onclick="confirmDeleteFeature({{ $option->id }},{{ $feature['id'] }} )"
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
                                                    style="background-color: {{ $feature['value'] }};">
                                                </span>
                                                <button
                                                    class="absolute z-10 left-4 -top-2 rounded-full h-4 w-4 flex justify-center items-center"
                                                    onclick="confirmDeleteFeature({{ $option->id }},{{ $feature['id'] }} )">
                                                    <i class="fa-solid fa-trash-can hover:text-red-500 text-sm" "></i>
                                                                </button>
                                                            </div>
    @break
@endswitch
 @endforeach
                                    </div>

                            </div>
                    @endforeach
                </div>
            @else
                {{-- no hay opciones creadas --}}
                <div class="flex items-center p-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                    role="alert">
                    <svg class="shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                    </svg>
                    <span class="sr-only">Info</span>
                    <div>
                        <span class="font-medium">Info alert!</span> No hay opciones creadas para este producto.
                    </div>
                </div>
            @endif
        </div>

    </section>
    <x-dialog-modal wire:model="openModal">

        <x-slot name="title">
            Agregar Nueva Opción
        </x-slot>

        <x-slot name="content">
            <x-validation-errors class="mb-4" />
            <div class="mb-4">
                <x-label value="Nombre de la Opción" class="mb-1" />
                <x-select class="block w-full" wire:model.live="variant.option_id">
                    <option value="" disabled>Seleccione una opción</option>
                    @foreach ($options as $option)
                        <option value="{{ $option->id }}">{{ $option->name }}</option>
                    @endforeach
                </x-select>
            </div>

            <div class="flex items-center mb-6">
                <hr class="flex-1">
                <span class="mx-4">Valores</span>
                <hr class="flex-1">

            </div>
            <ul class="mb-4 space-y-4">
                @foreach ($variant['features'] as $index => $feature)
                    <li wire:key="variant-feature-{{ $index }}"
                        class="relative border border-gray-200 rounded-lg p-6">
                        <div class="absolute -top-3 px-4 bg-white">
                            <button wire:click="removeFeature({{ $index }})">
                                <i class="fa-solid fa-trash-can text-red-500 hover:text-red-600"></i>
                            </button>
                        </div>
                        <div>
                            <x-label value="Valores" class="mb-1" />
                            <x-select class="block w-full" wire:model="variant.features.{{ $index }}.id"
                                wire:change="feature_change({{ $index }})">
                                <option value="" disabled>Seleccione un valor</option>
                                @foreach ($this->features as $feature)
                                    <option value="{{ $feature->id }}">{{ $feature->description }}</option>
                                @endforeach
                            </x-select>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="flex justify-end">
                <x-button wire:click="addFeature">
                    <i class="fa-solid fa-plus"></i> Agregar Valor
                </x-button>
            </div>

        </x-slot>

        <x-slot name="footer">
            <x-danger-button wire:click="$set('openModal', false)">
                Cancelar
            </x-danger-button>
            <x-button class="ml-2" wire:click="save">
                Guardar
            </x-button>
        </x-slot>

    </x-dialog-modal>
    @push('js')
        <script>
            function confirmDeleteFeature(option_id, feature_id) {
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
                        @this.call('deleteFeature', option_id, feature_id);
                    }
                });
            }

            function confirmDeleteOption(option_id) {
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
                        @this.call('deleteOption', option_id);
                    }
                });
            }
        </script>
    @endpush
</div>
