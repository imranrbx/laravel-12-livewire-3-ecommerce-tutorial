<?php /* ...existing code... */ ?>
<div>
    <h1 class="text-2xl font-semibold mb-4">My Addresses</h1>

    <a href="{{ route('customer.addresses.form') }}" class="inline-block mb-4 text-indigo-600">+ Add Address</a>

    @if ($addresses->isEmpty())
        <p class="text-gray-500">No saved addresses.</p>
    @else
        <div class="space-y-3">
            @foreach ($addresses as $address)
                <div class="bg-white p-4 rounded shadow flex justify-between items-start">
                    <div>
                        <div class="font-medium">{{ $address->full_name }}</div>
                        <div class="text-sm text-gray-500">{{ $address->street }}, {{ $address->city }}, {{ $address->country }}</div>
                        <div class="text-xs text-gray-400">Phone: {{ $address->phone }}</div>
                    </div>
                    <div class="space-x-2 text-sm">
                        <a href="{{ route('customer.addresses.form', ['id' => $address->id]) }}" class="text-indigo-600">Edit</a>
                        <button wire:click="delete({{ $address->id }})" class="text-red-600">Delete</button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>