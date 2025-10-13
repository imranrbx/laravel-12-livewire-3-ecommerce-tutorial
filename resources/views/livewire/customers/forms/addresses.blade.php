<?php /* ...existing code... */ ?>
<div>
    <h1 class="text-2xl font-semibold mb-4">{{ $address ? 'Edit Address' : 'Add Address' }}</h1>

    <form wire:submit.prevent="save" class="grid grid-cols-1 gap-3 max-w-lg">
        <input wire:model.defer="full_name" placeholder="Full name" class="border p-2 rounded" />
        <input wire:model.defer="phone" placeholder="Phone" class="border p-2 rounded" />
        <input wire:model.defer="street" placeholder="Street address" class="border p-2 rounded" />
        <input wire:model.defer="city" placeholder="City" class="border p-2 rounded" />
        <input wire:model.defer="state" placeholder="State" class="border p-2 rounded" />
        <input wire:model.defer="country" placeholder="Country" class="border p-2 rounded" />
        <input wire:model.defer="postal_code" placeholder="Postal code" class="border p-2 rounded" />

        <div>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
            <a href="{{ route('customer.addresses') }}" class="ml-3 text-sm text-gray-600">Cancel</a>
        </div>
    </form>
</div>