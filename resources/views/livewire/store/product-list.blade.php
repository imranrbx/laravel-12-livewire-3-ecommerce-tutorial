<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-semibold">All Products</h2>
        <input type="text" wire:model.live.debounce.100ms="search" placeholder="Search..."
            class="px-3 py-2 border rounded-lg w-64 focus:ring-2 focus:ring-indigo-500 focus:outline-none" />
    </div>

    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($products as $product)
            <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                 <div class="relative product-card ">
                        {{-- Existing product card content --}}
                        <livewire:store.wish-list-button :product="$product" :key="$product->id" />
                    </div>

                <img src="{{ asset($product->image_path) ?? 'https://via.placeholder.com/300' }}" alt="{{ $product->name }}"
                    class="rounded-md w-full h-48 object-cover">
                <div class="mt-4">
                    <h3 class="font-semibold text-lg">{{ $product->name }}</h3>

                   
                    <p class="text-gray-500 text-sm">{{ Str::limit($product->description, 60) }}</p>
                    <p class="text-indigo-600 font-bold mt-2">${{ number_format($product->price, 2) }}</p>
                    <a href="{{ route('store.product.details', $product->slug) }}"
                        class="mt-3 inline-block text-sm bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                        View Details
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-600 col-span-full text-center">No products found.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</div>