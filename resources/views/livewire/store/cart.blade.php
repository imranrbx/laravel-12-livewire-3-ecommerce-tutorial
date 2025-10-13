<div class="space-y-6">
    <h2 class="text-2xl font-semibold">Your Cart</h2>

    @if(empty($cart))
        <p class="text-gray-500">Your cart is empty.</p>
    @else
        <div class="space-y-4">
            @foreach($cart as $id => $item)
                <div class="flex justify-between items-center bg-white shadow rounded p-4">
                    <div>
                        <h4 class="font-semibold">{{ $item['name'] }}</h4>
                        <p class="text-gray-500">Qty: {{ $item['quantity'] }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-indigo-600 font-bold">${{ number_format($item['price'], 2) }}</span>
                        <button wire:click="remove({{ $id }})" 
                                class="text-red-600 hover:text-red-800 font-medium">Remove</button>
                    </div>
                </div>
            @endforeach

            <div class="text-right mt-6">
                <a href="{{ route('store.checkout') }}" 
                   class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @endif
</div>
