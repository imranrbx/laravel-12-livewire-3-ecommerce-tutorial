<?php /* ...existing code... */ ?>
<div>
    <h1 class="text-2xl font-semibold mb-4">Your Orders</h1>

    @if($orders->isEmpty())
        <p class="text-gray-500">You have no orders yet.</p>
    @else
        <div class="space-y-4">
            @foreach ($orders as $order)
                <div class="bg-white rounded shadow p-4 flex justify-between items-center">
                    <div>
                        <div class="font-medium">Order #{{ $order->id }}</div>
                        <div class="text-sm text-gray-500">Total: ${{ number_format($order->total_amount, 2) }}</div>
                        <div class="text-xs text-gray-400">Status: {{ $order->status }}</div>
                    </div>
                    <div>
                        <a href="{{ route('customer.orders.show', $order->id) }}" class="text-indigo-600">Details</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>