<x-modal wire:model="showModal" size="sm">
    <x-card title="👜 Ximena Bags" subtitle="Ticket de Venta" separator class="max-w-md mx-auto">
        @if ($sale)
            {{-- Referencia y fecha --}}
            <div class="text-center mb-2 text-xs text-gray-500">
                <p>{{ $sale->sale_reference }}</p>
                <p>{{ $sale->sale_date->format('d/m/Y H:i') }}</p>
            </div>

            {{-- Detalles de productos --}}
            <div class="text-sm space-y-1 mb-2">
                @foreach ($sale->details as $item)
                    <div class="flex justify-between">
                        <span>{{ $item->product->product_name }} x{{ $item->quantity }}</span>
                        <span>${{ number_format($item->line_total, 2) }}</span>
                    </div>
                @endforeach
            </div>


            {{-- Totales --}}
            <div class="text-sm text-right mb-2">
                <p>Subtotal: ${{ number_format($sale->sale_subtotal, 2) }}</p>
                <p>IVA (16%): ${{ number_format($sale->sale_tax, 2) }}</p>
                <p class="font-bold">Total: ${{ number_format($sale->sale_total, 2) }}</p>
            </div>

            {{-- Mensaje de agradecimiento --}}
            <div class="text-center text-xs text-gray-500 mb-2">
                ¡Gracias por su compra!
            </div>

            {{-- Footer con acciones --}}
            <x-slot:actions separator>
                <x-button wire:click="close" flat>Cerrar</x-button>
                <x-button color="success" onclick="window.print()">Imprimir</x-button>
                <x-button wire:click="downloadPdf">Descargar PDF</x-button>
            </x-slot:actions>
        @endif
    </x-card>

</x-modal>
