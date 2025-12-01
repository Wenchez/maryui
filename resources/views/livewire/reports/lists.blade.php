<div class="grid lg:grid-cols-3 gap-8 mt-8">

    {{-- Top categorías --}}
    <div class="col-span-1">
        <x-card title="Top categorías" class="bg-base-100 rounded-lg p-5 shadow-xs">
            <x-slot:menu>
                <x-button title="Categorías" tooltip="Categorías" icon="o-tag" :link="route('product-types.index')" />
            </x-slot:menu>
            <div class="divide-y divide-gray-200">
                @foreach ($categories as $category)
                    <div class="flex justify-between items-center gap-4 px-3 hover:bg-base-200 cursor-pointer py-2">
                        {{-- Avatar de texto --}}
                        <x-avatar placeholder="{{ strtoupper(substr($category->product_type_name, 0, 2)) }}"
                            class="w-11! h-11! text-base!" />
                        {{-- Texto --}}
                        <div class="flex-1 overflow-hidden whitespace-nowrap truncate pl-3">
                            <div class="font-semibold truncate">{{ $category->product_type_name }}</div>
                            <div class="text-base-content/50 text-sm truncate">
                                Vendidos: {{ $category->total_sold }}
                            </div>
                        </div>
                        {{-- Ingresos --}}
                        <div class="flex items-center gap-3">
                            <div class="badge badge-ghost badge-sm">${{ number_format($category->revenue, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>

    {{-- Top productos --}}
    <div class="col-span-1">
        <x-card title="Top productos" class="bg-base-100 rounded-lg p-5 shadow-xs">
            <div class="divide-y divide-gray-200">
                @foreach ($products as $product)
                    <div class="flex justify-between items-center gap-4 px-3 hover:bg-base-200 cursor-pointer py-2">
                        <x-avatar placeholder="{{ strtoupper(substr($product->product_name, 0, 2)) }}"
                            class="w-11! h-11! text-base!" />
                        <div class="flex-1 overflow-hidden whitespace-nowrap truncate pl-3">
                            <div class="font-semibold truncate">{{ $product->product_name }}</div>
                            <div class="text-base-content/50 text-sm truncate">
                                Vendidos: {{ $product->total_sold }}
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="badge badge-ghost badge-sm">${{ number_format($product->revenue, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <x-slot:menu>
                <x-button title="Productos" tooltip="Productos" icon="o-shopping-bag" :link="route('products.index')" />
            </x-slot:menu>
        </x-card>
    </div>

    {{-- Top marcas --}}
    <div class="col-span-1">
        <x-card title="Top marcas" class="bg-base-100 rounded-lg p-5 shadow-xs">
            <div class="divide-y divide-gray-200">
                @foreach ($brands as $brand)
                    <div class="flex justify-between items-center gap-4 px-3 hover:bg-base-200 cursor-pointer py-2">
                        <x-avatar placeholder="{{ strtoupper(substr($brand->brand_name, 0, 2)) }}"
                            class="w-11! h-11! text-base!" />
                        <div class="flex-1 overflow-hidden whitespace-nowrap truncate pl-3">
                            <div class="font-semibold truncate">{{ $brand->brand_name }}</div>
                            <div class="text-base-content/50 text-sm truncate">
                                Vendidos: {{ $brand->total_sold }}
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="badge badge-ghost badge-sm">${{ number_format($brand->revenue, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <x-slot:menu>
                <x-button title="Marcas" tooltip="Marcas" icon="o-percent-badge" :link="route('brands.index')" />
            </x-slot:menu>
        </x-card>
    </div>

</div>
