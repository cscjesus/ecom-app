<div>

    <form wire:submit="addFeature" class="flex space-x-4">


        <div class="flex-1">
            <x-label value="Valor" class="mb-1" />


            @switch($option->type)
                @case(1)
                    <x-input wire:model="newFeature.value" class=" block w-full" placeholder="Ingrese el valor de la opción" />
                @break

                @case(2)
                    <div class="border border-gray-300 rounded-md h-[42px] flex items-center px-3 justify-between">

                        {{ $newFeature['value'] ?: 'Seleccione un color' }}

                        <input type="color" wire:model.live="newFeature.value" />

                    </div>
                @break
            @endswitch
        </div>

        <div class="flex-1">
            <x-label value="Descripción" class="mb-1" />
            <x-input wire:model="newFeature.description" class=" block w-full" placeholder="Ingrese una descripción" />
        </div>

        <div class="pt-7">

            <x-button class="self-end">
                <i class="fa-solid fa-plus"></i> Agregar
            </x-button>

        </div>
    </form>

</div>
