<?php

namespace App\Livewire\Customers;

use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Address;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.store')]
class Dashboard extends Component
{
    public int $ordersCount = 0;
    public int $wishlistCount = 0;
    public int $addressesCount = 0;
    public $recentOrders = [];

    public function mount(): void
    {
        $userId = auth()->id();
        $this->ordersCount = Order::where('user_id', $userId)->count();
        $this->wishlistCount = Wishlist::where('user_id', $userId)->count();
        $this->addressesCount = Address::where('user_id', $userId)->count();
        $this->recentOrders = Order::where('user_id', $userId)->latest()->limit(5)->get();
    }

    public function render()
    {
        return view('livewire.customers.dashboard');
    }
}