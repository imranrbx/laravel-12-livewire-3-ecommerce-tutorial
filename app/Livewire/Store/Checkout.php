<?php

namespace App\Livewire\Store;

use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

#[Layout('components.layouts.store')]
#[Title('Checkout Page')]
class Checkout extends Component
{
    public $name, $email, $address;

    public function placeOrder()
    {
        session()->forget('cart');
        session()->flash('success', 'Order placed successfully!');
        return redirect()->route('store.order.confirmation');
    }

    public function render()
    {
        return view('livewire.store.checkout');
    }
}
