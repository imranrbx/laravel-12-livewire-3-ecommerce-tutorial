<div class="p-6">
  <div class="flex items-center justify-between mb-4">
    <div class="flex gap-3">
      <flux:input placeholder="Search categories..." wire:model.debounce.500ms="search" />
    </div>

    <div>
      <flux:button variant="primary" x-on:click="$wire.create()">New Category</flux:button>
    </div>
  </div>

<div class="overflow-x-auto dark:bg-black bg-white shadow-md rounded-lg dark:text-white">
    <table class="min-w-full text-sm text-left text-gray-700 border dark:border-black border-gray-200">
        <thead class="dark:bg-black dark:text-white text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-6 py-3">#</th>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Slug</th>
                <th class="px-6 py-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr class="border-b dark:bg-black dark:text-white hover:bg-gray-800">
                    <td class="px-6 py-3">{{ $category->id }}</td>
                    <td class="px-6 py-3">{{ $category->name }}</td>
                    <td class="px-6 py-3">{{ $category->slug }}</td>
                    <td class="px-6 py-3 space-x-2">
                        <button wire:click="edit({{ $category->id }})" 
                                class="text-blue-500 hover:text-blue-700 font-semibold hover:cursor-pointer">Edit</button>
                        <button wire:click="confirmDelete({{ $category->id }})" 
                                class="text-red-500 hover:text-red-700 font-semibold hover:cursor-pointer">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center dark:text-white text-gray-500">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="fixed top-4 right-4 z-50 space-y-2">
    @if (session()->has('success'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-transition 
            x-init="setTimeout(() => show = false, 3000)"
            class="flex items-center p-4 mb-2 text-green-800 border border-green-300 rounded-lg bg-green-50 shadow-md"
            role="alert">
            <svg class="flex-shrink-0 w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" 
                      d="M16.707 5.293a1 1 0 010 1.414L8.414 15 4.293 10.879a1 1 0 011.414-1.414L8.414 12.172l7.293-7.293a1 1 0 011.414 0z" 
                      clip-rule="evenodd"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-transition 
            x-init="setTimeout(() => show = false, 3000)"
            class="flex items-center p-4 mb-2 text-red-800 border border-red-300 rounded-lg bg-red-50 shadow-md"
            role="alert">
            <svg class="flex-shrink-0 w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" 
                      d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zM9 4a1 1 0 012 0v4a1 1 0 01-2 0V4zm1 8a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" 
                      clip-rule="evenodd"></path>
            </svg>
            <span class="font-medium">{{ session('error') }}</span>
        </div>
    @endif
</div>
  <div class="mt-4">
    {{ $categories->links() }}
  </div>

  <!-- Form Modal -->
  <flux:modal wire:model.self="showFormModal" name="category-form" class="md:w-96">
    <form wire:submit.prevent="save">
      <flux:heading>
        <h3 class="text-lg font-medium">{{ $editingId ? 'Edit Category' : 'New Category' }}</h3>
      </flux:heading>

      <flux:text>
        <flux:input label="Name" wire:model.defer="name" />
        <flux:input label="Slug" wire:model.defer="slug" />
        <flux:select label="Parent Category" wire:model.defer="parent_id" placeholder="None">
          <flux:select.option value="">None</flux:select.option>
          @foreach($parents as $p)
            <flux:select.option value="{{ $p->id }}">{{ $p->name }}</flux:select.option>
          @endforeach
        </flux:select>
      </flux:text>

      <flux:text>
        <flux:button type="button" variant="ghost" x-on:click="$wire.showFormModal = false">Cancel</flux:button>
        <flux:button type="submit" variant="primary">{{ $editingId ? 'Update' : 'Create' }}</flux:button>
      </flux:text>
    </form>
  </flux:modal>

  <!-- Delete Modal -->
  <flux:modal wire:model.self="showDeleteModal" name="confirm-delete" class="md:w-96">
    <flux:heading>Confirm delete</flux:heading>
    <flux:text>
      Are you sure you want to delete this category? This action cannot be undone.
    </flux:text>
    <flux:text>
      <flux:button variant="ghost" x-on:click="$wire.showDeleteModal = false">Cancel</flux:button>
      <flux:button variant="danger" x-on:click="$wire.delete()">Delete</flux:button>
    </flux:text>
  </flux:modal>
</div>
