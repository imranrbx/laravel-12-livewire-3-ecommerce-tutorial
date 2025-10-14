<?php

namespace App\Livewire\Customers;

use App\Models\Wishlist as WishlistModel;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.store')]
#[Title("Wish list")]
class Wishlists extends Component
{
    public $items = [];

    public function mount(): void
    {
        $this->loadItems();
    }

    public function loadItems(): void
    {
        $this->items = WishlistModel::with('product')->where('user_id', auth()->id())->get();
    }

    public function remove(int $id): void
    {
        WishlistModel::where('user_id', auth()->id())->where('id', $id)->delete();
        session()->flash('success', 'Removed from wishlist');
        $this->loadItems();
    }

    public function render()
    {
        return view('livewire.customers.wishlists', ['items' => $this->items]);
    }
}