<?php /* ...existing code... */ ?>
<div>
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
            <a href="{{ route('customer.dashboard') }}" class="ml-3 text-sm text-gray-600">Cancel</a>
        </div>
    </form>
</div>