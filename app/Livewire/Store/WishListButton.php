<?php

namespace App\Livewire\Store;

use App\Models\Product;
use App\Models\Wishlist;
use Livewire\Component;

class WishlistButton extends Component
{
    public Product $product;
    public bool $isWishlisted;

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->isWishlisted = $product->isWishlisted();
    }

    public function toggleWishlist()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('product_id', $this->product->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $this->isWishlisted = false;
            session()->flash('removed','Product Removed from Wishlist');
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'product_id' => $this->product->id
            ]);
             session()->flash('added','Product Added to Wishlist');
            $this->isWishlisted = true;
        }
    }

    public function render()
    {
        return view('livewire.store.wish-list-button');
    }
}