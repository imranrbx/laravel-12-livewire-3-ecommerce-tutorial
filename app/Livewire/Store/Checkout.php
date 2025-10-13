<?php

namespace App\Livewire\Store;

use Livewire\Component;

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
        return view('livewire.store.checkout')->layout('components.layouts.store', ['title' => 'Checkout']);
    }
}
