<?php /* ...existing code... */ ?>
<div>
    <h1 class="text-2xl font-semibold mb-4">Order #{{ $order->id }}</h1>

    <div class="bg-white rounded shadow p-4 mb-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <h3 class="font-medium">Items</h3>
                <ul class="mt-2 space-y-2">
                    @foreach ($order->items as $item)
                        <li class="flex justify-between">
                            <div>
                                <div class="text-sm">{{ $item->product->name ?? 'Product removed' }}</div>
                                <div class="text-xs text-gray-500">Qty: {{ $item->quantity }}</div>
                            </div>
                            <div class="text-sm">${{ number_format($item->total, 2) }}</div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="font-medium">Summary</h3>
                <div class="mt-2 text-sm">Total: ${{ number_format($order->total_amount, 2) }}</div>
                <div class="text-sm">Payment: {{ $order->payment?->provider ?? '—' }}</div>
                <div class="text-sm">Status: {{ $order->status }}</div>
            </div>
        </div>
    </div>

    <a href="{{ route('customer.orders') }}" class="text-indigo-600">← Back to orders</a>
</div>