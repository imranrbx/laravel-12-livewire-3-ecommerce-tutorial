<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-2xl font-semibold mb-4">Checkout</h2>

    <form wire:submit.prevent="placeOrder" class="space-y-4">
        <div>
            <label class="block text-gray-700">Full Name</label>
            <input type="text" wire:model="name" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700">Email</label>
            <input type="email" wire:model="email" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700">Address</label>
            <textarea wire:model="address" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <button type="submit" 
                class="w-full bg-indigo-600 text-white py-3 rounded hover:bg-indigo-700 transition">
            Place Order
        </button>
    </form>
</div>
