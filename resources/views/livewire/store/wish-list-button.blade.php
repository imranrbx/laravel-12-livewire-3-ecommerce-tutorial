<div>
<button 
    wire:click="toggleWishlist"
    class="wishlist-btn border-2 shadow rounded-lg bg-red-500 "
    title="{{ $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}"
>
    <i class="fa-heart {{ $isWishlisted ? 'fas text-red-500' : 'far' }}"></i>
</button>
    <div class="fixed bottom-4 right-4 z-50">
        @if (session()->has('added'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('added') }}</span>
            </div>
        @endif
             @if (session()->has('removed'))
            <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('removed') }}</span>
            </div>
        @endif
    </div>
</div>