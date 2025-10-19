
<div class="space-y-6">
    <h2 class="text-2xl font-semibold dark:text-white">Your Cart</h2>

    @if(empty($cart))
        <p class="text-gray-500 dark:text-gray-400">Your cart is empty.</p>
    @else
        <div class="space-y-4">
            @foreach($cart as $id => $item)
                <div class="flex justify-between items-center bg-white dark:bg-zinc-900 shadow rounded p-4 border border-gray-200 dark:border-zinc-700">
                    <div>
                        <h4 class="font-semibold dark:text-white">{{ $item['name'] }}</h4>
                        <p class="text-gray-500 dark:text-gray-400">Qty: {{ $item['quantity'] }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="text-indigo-600 dark:text-indigo-400 font-bold">${{ number_format($item['price'], 2) }}</span>
                        <button wire:click="remove({{ $id }})" 
                                class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-medium">
                            Remove
                        </button>
                    </div>
                </div>
            @endforeach

            <!-- Coupon Code Section -->
            <div class="bg-white dark:bg-zinc-900 shadow rounded p-4 border border-gray-200 dark:border-zinc-700">
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        wire:model.defer="couponCode" 
                        placeholder="Enter coupon code"
                        class="flex-1 px-3 py-2 border rounded-md bg-white text-black placeholder-gray-500 border-gray-200 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400 dark:border-zinc-700"
                    >
                    <button 
                        wire:click="applyCoupon"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600"
                    >
                        Apply
                    </button>
                </div>
                @error('couponCode') 
                    <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
                @enderror
                @if(session()->has('coupon-error'))
                    <span class="text-red-600 text-sm mt-1">{{ session('coupon-error') }}</span>
                @endif
            </div>

            <!-- Order Summary -->
            <div class="bg-white dark:bg-zinc-900 shadow rounded p-4 border border-gray-200 dark:border-zinc-700">
                <h3 class="font-semibold mb-3 dark:text-white">Order Summary</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-gray-600 dark:text-gray-400">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    @if($discount > 0)
                    <div class="flex justify-between text-green-600 dark:text-green-400">
                        <span>Discount</span>
                        <span>-${{ number_format($discount, 2) }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between font-bold text-lg border-t border-gray-200 dark:border-zinc-700 pt-2 dark:text-white">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="text-right mt-6">
                <a href="{{ route('store.checkout') }}" 
                   class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @endif
</div>