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

    public function mount($id = null): void
    {
        if ($id) {
            $this->review = Review::where('user_id', auth()->id())->findOrFail($id);
            $this->rating = $this->review->rating;
            $this->comment = $this->review->comment;
        }
    }

    public function save(): void
    {
        $data = $this->validated();

        if ($this->review) {
            $this->review->update($data);
            session()->flash('success', 'Review updated');
        } else {
            Review::create(array_merge($data, ['user_id' => auth()->id()]));
            session()->flash('success', 'Review created');
        }

        $this->redirect(route('customer.dashboard'));
    }

    public function render()
    {
        return view('livewire.customers.reviews');
    }
}