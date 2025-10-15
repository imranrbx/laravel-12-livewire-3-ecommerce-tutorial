<div>
    <!-- Display all reviews -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold mb-4">Product Reviews</h2>
        
        @if($productReviews->count() > 0)
            @foreach($productReviews as $productReview)
                <div class="border-b pb-4 mb-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-semibold">{{ $productReview->user->name }}</p>
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-yellow-400">
                                        @if($i <= $productReview->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    </span>
                                @endfor
                            </div>
                        </div>
                        @auth
                            @if(auth()->user()->id === $productReview->user_id)
                                <button wire:click="editReview({{ $productReview->id }})" 
                                        class="text-blue-600 hover:text-blue-800">
                                    Edit Review
                                </button>
                            @endif
                        @endauth
                    </div>
                    <p class="mt-2 text-gray-600">{{ $productReview->comment }}</p>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $productReview->created_at->diffForHumans() }}
                    </p>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">No reviews yet.</p>
        @endif
    </div>

    <!-- Review form -->
    @auth
        @if($showReviewForm)
            <h1 class="text-2xl font-semibold mb-4">{{ $review ? 'Edit Review' : 'Write a Review' }}</h1>
            <form wire:submit.prevent="save" class="max-w-lg space-y-3">
                <label class="block">
                    <div class="text-sm text-gray-600">Rating</div>
                    <select wire:model.defer="rating" class="border p-2 rounded w-full">
                        @for($i=1;$i<=5;$i++)
                            <option value="{{ $i }}">{{ $i }} star{{ $i>1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </label>

                <label>
                    <div class="text-sm text-gray-600">Comment</div>
                    <textarea wire:model.defer="comment" rows="4" class="border p-2 rounded w-full"></textarea>
                </label>

                <div>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save Review</button>
                    <button type="button" wire:click="cancelEdit" class="ml-3 text-sm text-gray-600">Cancel</button>
                </div>
            </form>
        @else
            @if(!$hasUserReview)
                <button wire:click="showReviewForm" class="px-4 py-2 bg-indigo-600 text-white rounded">
                    Write a Review
                </button>
            @endif
        @endif
    @else
        <p>To write a Review Kindly Login First <a class="text-red-500" href="{{ route('login') }}">Login</a></p>
    @endauth
</div>