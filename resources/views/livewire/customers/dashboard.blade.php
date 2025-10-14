<?php /* ...existing code... */ ?>
<div class="max-w-4xl mx-auto space-y-6">
    <h1 class="text-2xl font-semibold">My Account ({{ auth()->user()->name }})</h1>

    <div class="grid grid-cols-3 gap-4">
        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Orders</div>
            <div class="text-xl font-bold">{{ $ordersCount }}</div>
            <a href="{{ route('customer.orders') }}" class="text-indigo-600 text-sm">View orders →</a>
        </div>

        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Wishlist</div>
            <div class="text-xl font-bold">{{ $wishlistCount }}</div>
            <a href="{{ route('customer.wishlist') }}" class="text-indigo-600 text-sm">Manage wishlist →</a>
        </div>

        <div class="p-4 bg-white rounded shadow">
            <div class="text-sm text-gray-500">Addresses</div>
            <div class="text-xl font-bold">{{ $addressesCount }}</div>
            <a href="{{ route('customer.addresses') }}" class="text-indigo-600 text-sm">Manage addresses →</a>
        </div>
    </div>

    <div class="bg-white rounded shadow p-4">
        <h2 class="font-medium">Recent orders</h2>
        @if ($recentOrders->isEmpty())
            <p class="text-sm text-gray-500 mt-2">No recent orders.</p>
        @else
            <ul class="mt-2 space-y-2">
                @foreach ($recentOrders as $order)
                    <li class="flex justify-between items-center">
                        <div>
                            <div class="text-sm text-gray-700">Order #{{ $order->id }}</div>
                            <div class="text-xs text-gray-500">Placed: {{ $order->created_at->format('Y-m-d') }}</div>
                        </div>
                        <a href="{{ route('customer.orders.detail', $order->id) }}" class="text-indigo-600 text-sm">View</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>