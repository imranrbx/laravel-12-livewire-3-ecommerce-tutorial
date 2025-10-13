<?php

namespace App\Livewire\Customers;

use App\Models\Address;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.store')]
class Addresses extends Component
{
    public $addresses = [];

    public function mount(): void
    {
        $this->load();
    }

    public function load(): void
    {
        $this->addresses = Address::where('user_id', auth()->id())->get();
    }

    public function delete(int $id): void
    {
        Address::where('user_id', auth()->id())->where('id', $id)->delete();
        session()->flash('success', 'Address deleted');
        $this->load();
    }

    public function render()
    {
        return view('livewire.customers.addresses', ['addresses' => $this->addresses]);
    }
}