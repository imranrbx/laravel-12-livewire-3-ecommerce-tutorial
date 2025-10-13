<?php /* ...existing code... */ ?>
<div>
    <h1 class="text-2xl font-semibold mb-4">My Wishlist</h1>

    @if($items->isEmpty())
        <p class="text-gray-500">Your wishlist is empty.</p>
    @else
        <div class="grid grid-cols-1 gap-4">
            @foreach ($items as $row)
                <div class="bg-white p-4 rounded shadow flex justify-between items-center">
                    <div>
                        <div class="font-medium">{{ $row->product?->name ?? 'Product removed' }}</div>
                        <div class="text-sm text-gray-500">${{ number_format($row->product?->price ?? 0, 2) }}</div>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('store.product.details', $row->product?->slug) }}" class="text-indigo-600">View</a>
                        <button wire:click="remove({{ $row->id }})" class="text-red-600">Remove</button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>