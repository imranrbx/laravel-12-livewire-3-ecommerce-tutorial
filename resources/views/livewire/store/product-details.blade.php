<div class="grid md:grid-cols-2 gap-8">
    <img src="{{ asset($product->image_path) ?? 'https://via.placeholder.com/500' }}" alt="{{ $product->name }}"
        class="rounded-lg shadow">

    <div>
        <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
        <p class="text-gray-600 mt-3">{{ $product->description }}</p>
        <p class="text-indigo-600 font-bold text-2xl mt-4">${{ number_format($product->price, 2) }}</p>
        <button type="button" wire:click="addToCart"
            class="mt-6 px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition hover:cursor-pointer">
            Add to Cart
        </button>
    </div>
    <div class="fixed bottom-4 right-4 z-50">
        @if (session()->has('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
    </div>
    @livewire('customers.reviews' , ['productId' => $product->id])
</div>