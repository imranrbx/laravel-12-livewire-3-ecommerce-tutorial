<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex gap-2">
            <input
                wire:model.debounce.300ms="search"
                type="text"
                placeholder="Search coupons..."
                class="px-3 py-2 border rounded-md bg-white text-black placeholder-gray-500 border-gray-200 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400 dark:border-zinc-700"
            />
            <button wire:click="create"
                class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                New Coupon
            </button>
        </div>

        @if (session()->has('success'))
            <div class="text-green-700 dark:text-green-300">{{ session('success') }}</div>
        @endif
    </div>

    <div class="bg-white shadow rounded border border-gray-200 dark:bg-zinc-900 dark:border-zinc-700">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
            <thead class="bg-gray-50 dark:bg-zinc-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-zinc-300">Code</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-zinc-300">Type</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-zinc-300">Value</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-zinc-300">Uses</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-zinc-300">Expires</th>
                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-zinc-300">Status</th>
                    <th class="px-4 py-2 text-right text-sm font-medium text-gray-700 dark:text-zinc-300">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-zinc-900 dark:divide-zinc-700">
                @forelse($coupons as $c)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $c->code }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ ucfirst($c->discount_type) }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">
                            {{ $c->discount_value }}{{ $c->discount_type === 'percentage' ? '%' : '' }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $c->usage_limit ?? '∞' }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $c->expires_at ? $c->expires_at->format('Y-m-d') : '—' }}</td>
                        <td class="px-4 py-2 text-sm text-gray-800 dark:text-gray-200">{{ $c->status ? 'Active' : 'Inactive' }}</td>
                        <td class="px-4 py-2 text-sm text-right">
                            <button wire:click="edit({{ $c->id }})" class="mr-2 px-2 py-1 bg-yellow-400 rounded hover:bg-yellow-500 dark:bg-yellow-500 dark:hover:bg-yellow-600">Edit</button>
                            <button wire:click="confirmDelete({{ $c->id }})" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-zinc-400">No coupons found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $coupons->links() }}
        </div>
    </div>

    <!-- Form Modal -->
    @if($showFormModal)
        <div class="fixed inset-0 z-40 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/40 dark:bg-black/50"></div>
            <form wire:submit.prevent="save" class="relative bg-white w-full max-w-xl rounded shadow-lg p-6 z-50 dark:bg-zinc-900">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ $editingId ? 'Edit Coupon' : 'Create Coupon' }}</h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm text-gray-700 dark:text-zinc-300">Code</label>
                        <input wire:model.defer="code" type="text" class="w-full px-3 py-2 border rounded bg-white text-black border-gray-200 dark:bg-zinc-800 dark:text-white dark:border-zinc-700" />
                        @error('code') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex gap-3">
                        <div class="w-1/2">
                            <label class="block text-sm text-gray-700 dark:text-zinc-300">Type</label>
                            <select wire:model.defer="discount_type" class="w-full px-3 py-2 border rounded bg-white text-black border-gray-200 dark:bg-zinc-800 dark:text-white dark:border-zinc-700">
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Fixed</option>
                            </select>
                            @error('discount_type') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="w-1/2">
                            <label class="block text-sm text-gray-700 dark:text-zinc-300">Value</label>
                            <input wire:model.defer="discount_value" type="number" step="0.01" class="w-full px-3 py-2 border rounded bg-white text-black border-gray-200 dark:bg-zinc-800 dark:text-white dark:border-zinc-700" />
                            @error('discount_value') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 dark:text-zinc-300">Usage limit (optional)</label>
                        <input wire:model.defer="usage_limit" type="number" min="0" class="w-full px-3 py-2 border rounded bg-white text-black border-gray-200 dark:bg-zinc-800 dark:text-white dark:border-zinc-700" />
                        @error('usage_limit') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 dark:text-zinc-300">Expires at (optional)</label>
                        <input wire:model.defer="expires_at" type="date" class="w-full px-3 py-2 border rounded bg-white text-black border-gray-200 dark:bg-zinc-800 dark:text-white dark:border-zinc-700" />
                        @error('expires_at') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="inline-flex items-center text-gray-700 dark:text-zinc-300">
                            <input wire:model.defer="status" checked="{{ $status ? 'active':'inactive' }}" type="checkbox" class="form-checkbox text-blue-600 dark:text-blue-400" />
                            <span class="ml-2 text-sm">Active</span>
                        </label>
                    </div>
                </div>

                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" wire:click="$set('showFormModal', false)" class="px-3 py-2 rounded border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-gray-700 dark:text-zinc-200">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">{{ $editingId ? 'Update' : 'Create' }}</button>
                </div>
            </form>
        </div>
    @endif

    <!-- Delete Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-40 flex items-center justify-center">
            <div class="absolute inset-0 bg-black/40 dark:bg-black/50"></div>
            <div class="relative bg-white w-full max-w-md rounded shadow-lg p-6 z-50 dark:bg-zinc-900">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Confirm Delete</h3>
                <p class="text-sm text-gray-700 dark:text-zinc-300">Are you sure you want to delete this coupon?</p>

                <div class="mt-4 flex justify-end gap-2">
                    <button wire:click="$set('showDeleteModal', false)" class="px-3 py-2 rounded border border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 text-gray-700 dark:text-zinc-200">Cancel</button>
                    <button wire:click="delete" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>