<?php

namespace App\Livewire\Store;

use Livewire\Component;

class Cart extends Component
{
    public $cart = [];

    public function mount()
    {
        $this->cart = session('cart', []);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        $this->cart = $cart;
        session()->flash('success', 'Item removed from cart!');
    }

    public function render()
    {
        return view('livewire.store.cart')->layout('components.layouts.store', ['title' => 'Your Cart']);
    }
}
