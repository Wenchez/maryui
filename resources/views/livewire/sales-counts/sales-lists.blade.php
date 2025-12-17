<div class="space-y-4 mt-4">

    @foreach ($sales as $sale)
        <x-collapse separator class="bg-base-200 rounded-xl" wire:key="sale-collapse-{{ $sale->sale_id }}">

            {{-- HEADER --}}
            <x-slot:heading>
                <div class="flex items-center justify-between w-full">

                    <div>
                        <div class="font-semibold text-sm">
                            {{ $sale->sale_reference }}
                        </div>

                        <div class="text-xs opacity-70">
                            {{ $sale->user->name ?? 'N/A' }} ·
                            {{ $sale->sale_date->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="text-base font-semibold">
                            ${{ number_format($sale->sale_total, 2) }}
                        </span>
                    </div>

                </div>
            </x-slot:heading>

            {{-- CONTENT --}}
            <x-slot:content>

                <div class="divide-y">

                    @foreach ($sale->details as $detail)
                        <x-list-item no-hover no-separator :item="(object) [
                            'name' => $detail->product->product_name,
                            'avatar' => $detail->product->product_image_url ?? 'https://placehold.co/64x64?text=IMG',
                        ]">
                            {{-- SUBTÍTULO (cantidad) --}}
                            <x-slot:sub-value>
                                Cantidad: {{ $detail->quantity }}
                            </x-slot:sub-value>

                            {{-- ACCIONES (derecha) --}}
                            <x-slot:actions>
                                <div class="text-right leading-tight">
                                    <div class="text-sm font-semibold">
                                        ${{ number_format($detail->line_total, 2) }}
                                    </div>

                                    <div class="text-xs opacity-60">
                                        ${{ number_format($detail->unit_price, 2) }} c/u
                                    </div>
                                </div>
                            </x-slot:actions>
                        </x-list-item>
                    @endforeach
                </div>

                <div class="flex justify-start mt-3">
                    <x-button type="button" size="sm" color="success" {{-- Notar las comillas simples ' ' dentro del wire:click --}}
                        wire:click="downloadPdf('{{ $sale->sale_id }}')" wire:loading.attr="disabled">
                        Descargar PDF
                    </x-button>

                </div>

            </x-slot:content>

        </x-collapse>
    @endforeach

    {{-- PAGINACIÓN --}}
    <div class="mt-4">
        {{ $sales->links() }}
    </div>
</div>
