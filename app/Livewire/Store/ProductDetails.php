<?php

namespace App\Livewire\Store;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.store')]
class ProductDetails extends Component
{
    public Product $product;

    public function mount($slug)
    {
        $this->product = Product::where('slug', $slug)->firstOrFail();

    }

    public function addToCart()
    {

        $cart = session()->get('cart', []);
        $cart[$this->product->id] = [
            'name' => $this->product->name,
            'price' => $this->product->price,
            'quantity' => ($cart[$this->product->id]['quantity'] ?? 0) + 1,
        ];
        session()->put('cart', $cart);
         session()->flash('success', 'Product added to cart!');
    }

    protected function getTitle(): string
    {
        return $this->product->name.' - Store';
    }

    public function render()
    {
        return view('livewire.store.product-details')->title($this->product->name);
    }
}
