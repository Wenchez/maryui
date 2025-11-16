<div>
    <h2 class="text-lg font-bold">Resumen de la venta</h2>

    {{-- Totales --}}
    <div class="flex flex-col gap-2">
        <div class="flex justify-between">
            <span>Subtotal:</span>
            <span class="font-medium">${{ number_format($subtotal, 2) }}</span>
        </div>
        <div class="flex justify-between">
            <span>IVA (16%):</span>
            <span class="font-medium">${{ number_format($tax, 2) }}</span>
        </div>
        <div class="flex justify-between border-t pt-2 mt-2 font-bold">
            <span>Total:</span>
            <span>${{ number_format($total, 2) }}</span>
        </div>
    </div>

    {{-- Botones --}}
    <div class="flex gap-2 mt-4">
        <x-button class="flex-1 btn-ghost text-red-500" wire:click="cancelSale">
            Cancelar
        </x-button>

        <x-button class="flex-1 btn-primary" wire:click="processSale">
            Procesar Venta
        </x-button>
    </div>

    {{-- Mensajes de aviso (opcional, si usas Alpine o Livewire events) --}}
    <div x-data @notify.window="alert($event.detail)">
        {{-- Los eventos 'notify' disparan alertas --}}
    </div>
</div>
