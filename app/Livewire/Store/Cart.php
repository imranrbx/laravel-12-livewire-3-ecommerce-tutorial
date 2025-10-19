<?php

namespace App\Livewire\Store;

use App\Models\Coupon;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.store')]
class Cart extends Component
{
    public $cart = [];

    public $couponCode = '';

    public $discount = 0;

    public $subtotal = 0;

    public $total = 0;

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        // Get active coupon from session if exists
        $sessionCoupon = session()->get('coupon');
        if ($sessionCoupon) {
            $this->calculateDiscount($sessionCoupon);
        }

        $this->total = $this->subtotal - $this->discount;
    }

    public function applyCoupon()
    {
        $this->validate([
            'couponCode' => 'required|string|min:3',
        ]);

        $coupon = Coupon::where('code', $this->couponCode)
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            })
            ->first();

        if (! $coupon) {
            session()->flash('coupon-error', 'Invalid or expired coupon code.');

            return;
        }

        session()->put('coupon', $coupon);
        $this->calculateDiscount($coupon);
        $this->calculateTotals();

        session()->flash('success', 'Coupon applied successfully!');
        $this->couponCode = '';
    }

    protected function calculateDiscount($coupon)
    {
        if ($coupon->discount_type === 'percentage') {
            $this->discount = ($this->subtotal * $coupon->discount_value) / 100;
        } else {
            $this->discount = $coupon->discount_value;
        }
    }

    public function remove($productId)
    {
        unset($this->cart[$productId]);
        session()->put('cart', $this->cart);
        $this->calculateTotals();
    }

    public function render()
    {
        return view('livewire.store.cart');
    }
}
