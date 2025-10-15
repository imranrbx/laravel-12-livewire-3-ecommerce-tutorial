<?php

namespace App\Livewire\Store;

use Livewire\Attributes\{Layout, Title};
use Livewire\Component;
#[Layout('components.layouts.store')]
#[Title('Order Confirmation Page')]
class OrderConfirmation extends Component
{
    public function render()
    {
        return view('livewire.store.order-confirmation');
    }
}
