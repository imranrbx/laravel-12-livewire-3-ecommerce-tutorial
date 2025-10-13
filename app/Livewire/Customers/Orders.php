<?php

namespace App\Livewire\Customers;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.store')]
class Orders extends Component
{
    use WithPagination;

    public function render()
    {
        $orders = Order::with('items')->where('user_id', auth()->id())->latest()->paginate(10);

        return view('livewire.customers.orders', ['orders' => $orders]);
    }
}