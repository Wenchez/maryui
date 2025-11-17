<div class="grid lg:grid-cols-2 gap-8 mt-8">
    {{-- Top usuarios --}}
    <div class="col-span-1">
        <x-card class="bg-base-100 rounded-lg p-5 shadow-xs">
            <div class="text-xl font-bold pb-5">Top categorías</div>
            <div class="divide-y divide-gray-200">
                @foreach($categories as $category)
                    <div class="flex justify-start items-center gap-4 px-3 hover:bg-base-200 cursor-pointer">
                        <div class="py-3">
                            <div class="avatar">
                                <div class="w-11 rounded-full">
                                    <img src="https://picsum.photos/200?x={{ $category->product_type_id }}" />
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 overflow-hidden whitespace-nowrap truncate">
                            <div class="font-semibold truncate">{{ $category->product_type_name }}</div>
                            <div class="text-base-content/50 text-sm truncate">Ventas: {{ $category->total_sold }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>

    {{-- Top productos --}}
    <div class="col-span-1">
        <x-card class="bg-base-100 rounded-lg p-5 shadow-xs">
            <div class="text-xl font-bold pb-5">Top productos</div>
            <div class="divide-y divide-gray-200">
                @foreach($products as $product)
                    <div class="flex justify-start items-center gap-4 px-3 hover:bg-base-200 cursor-pointer">
                        <div class="py-3">
                            <div class="avatar">
                                <div class="w-11 rounded-full">
                                    <img src="https://picsum.photos/200?x={{ $product->product_id }}" />
                                </div>
                            </div>
                        </div>
                        <div class="flex-1 overflow-hidden whitespace-nowrap truncate">
                            <div class="font-semibold truncate">{{ $product->product_name }}</div>
                            <div class="text-base-content/50 text-sm truncate">Vendidos: {{ $product->total_sold }}</div>
                        </div>
                        <div class="py-3 flex items-center gap-3">
                            <div class="badge badge-ghost badge-sm">${{ number_format($product->revenue, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>
</div>
