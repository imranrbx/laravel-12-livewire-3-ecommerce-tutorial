<?php

namespace App\Livewire\Store;

use Livewire\Component;

class OrderConfirmation extends Component
{
    public function render()
    {
        return view('livewire.store.order-confirmation')
            ->layout('components.layouts.store', ['title' => 'Order Confirmation']);
    }
}
