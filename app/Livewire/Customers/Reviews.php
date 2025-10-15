<?php

namespace App\Livewire\Customers;

use App\Models\Review;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.store')]
class Reviews extends Component
{
    public ?Review $review = null;

    #[Validate('required|integer|min:1|max:5')]
    public int $rating = 5;

    #[Validate('nullable|string|max:2000')]
    public string $comment = '';

    #[validate('required')]
    public int $productId;

    public $showReviewForm = false;

    public $hasUserReview = false;

    public function mount($productId)
    {
        $this->productId = $productId;
        $this->checkUserReview();
    }

    public function checkUserReview()
    {
        if (auth()->check()) {
            $this->hasUserReview = Review::where('product_id', $this->productId)
                ->where('user_id', auth()->id())
                ->exists();
        }
    }

    public function showReviewForm()
    {
        $this->showReviewForm = true;
    }

    public function editReview($reviewId)
    {
        $this->review = Review::findOrFail($reviewId);
        $this->rating = $this->review->rating;
        $this->comment = $this->review->comment;
        $this->showReviewForm = true;
    }

    public function cancelEdit()
    {
        $this->reset(['review', 'rating', 'comment']);
        $this->showReviewForm = false;
    }

    public function save(): void
    {

        $this->validate();
        if ($this->review) {
            $this->review->update([
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);
        } else {
            Review::create([
                'user_id' => auth()->id(),
                'product_id' => $this->productId,
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]);
        }

        $this->reset(['review', 'rating', 'comment']);
        $this->showReviewForm = false;
        $this->checkUserReview();
        session()->flash('message', 'Review saved successfully!');
    }

    public function render()
    {
        $productReviews = Review::with('user')
            ->where('product_id', $this->productId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.customers.reviews', compact('productReviews'));
    }
}
