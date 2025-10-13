<?php

namespace App\Livewire\Customers;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.store')]
class OrderDetails extends Component
{
    public Order $order;

    public function mount($id)
    {
        $this->order = Order::with(['items.product', 'billingAddress', 'shippingAddress', 'payment'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.customers.order-details', ['order' => $this->order]);
    }
}