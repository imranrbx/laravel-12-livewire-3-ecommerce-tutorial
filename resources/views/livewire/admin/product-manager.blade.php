<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <flux:input placeholder="Search products..." wire:model.debounce.500ms="search" />
        <flux:button variant="primary" x-on:click="$wire.create()">New Product</flux:button>
    </div>
    <div class="overflow-x-auto dark:bg-black shadow-md rounded-lg dark:text-white">
        <table class="min-w-full text-sm text-left text-gray-700 border dark:border-black border-gray-200">
            <thead class="dark:bg-black dark:text-white text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Image</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Category</th>
                    <th class="px-6 py-3">Price</th>
                    <th class="px-6 py-3">Stock</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">
                            @if($p->images->first())
                                <img src="{{ asset($p->images->first()->image_path) }}"
                                    class="w-16 h-12 object-cover rounded" />
                            @else
                                <div class="w-16 h-12 bg-gray-100 flex items-center justify-center">—</div>
                            @endif
                        </td>
                        <td class="px-6 py-3">{{ $p->name }}</td>
                        <td class="px-6 py-3">{{ $p->category?->name }}</td>
                        <td class="px-6 py-3">{{ number_format($p->price, 2) }}</td>
                        <td class="px-6 py-3">{{ $p->stock }}</td>
                        <td class="flex gap-2">
                            <flux:button size="sm" variant="outline" x-on:click="$wire.edit({{ $p->id }})">Edit
                            </flux:button>
                            <flux:button size="sm" variant="danger" x-on:click="$wire.confirmDelete({{ $p->id }})">Delete
                            </flux:button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center dark:text-white text-gray-500">No Products Found Yet!.
                        </td>
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
    <div class="mt-4">{{ $products->links() }}</div>

    <!-- Product Form Modal -->
    <flux:modal wire:model.self="showFormModal" name="product-form" class="lg:w-[900px]">
        <form wire:submit.prevent="save" class="space-y-4">
            <flux:heading>
                <h3 class="text-lg font-medium">{{ $editingId ? 'Edit Product' : 'New Product' }}</h3>
            </flux:heading>

            <flux:text>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <flux:input label="Name" wire:model.defer="name" />
                        <flux:input label="Slug" wire:model.defer="slug" />
                        <flux:input label="Sku" wire:model.defer="sku" />
                        <flux:select label="Category" wire:model.defer="category_id">
                            <flux:select.option value="">Select category</flux:select.option>
                            @foreach($categories as $cat)
                                <flux:select.option value="{{ $cat->id }}">{{ $cat->name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <flux:input label="Price" wire:model.defer="price" />
                        <flux:input label="Stock" wire:model.defer="stock" />
                    </div>

                    <div>
                        <flux:textarea wire:model.defer="description" />
                        <div class="mt-3">
                            <label class="block text-sm font-medium text-gray-700">Upload Images</label>
                            <input type="file" wire:model="images" multiple class="mt-2" />
                            <div class="mt-2 flex gap-2">
                                @foreach($images as $file)
                                    <div class="w-20 h-20 overflow-hidden rounded">
                                        <img src="{{ $file->temporaryUrl() }}" alt="preview"
                                            class="object-cover w-full h-full" />
                                    </div>
                                @endforeach
                            </div>

                            @if(!empty($existingImages))
                                <div class="mt-3">
                                    <div class="text-sm font-medium mb-2">Existing Images</div>
                                    <div class="flex gap-2 flex-wrap">
                                        @foreach($existingImages as $img)
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $img['path']) }}"
                                                    class="w-24 h-24 object-cover rounded" />
                                                <button type="button"
                                                    class="absolute top-0 right-0 bg-red-500 text-white px-1 py-0.5 rounded"
                                                    x-on:click="$wire.removeExistingImage({{ $img['id'] }})">x</button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </flux:text>

            <flux:text>
                <flux:button variant="ghost" x-on:click="$wire.showFormModal = false">Cancel</flux:button>
                <flux:button type="submit" variant="primary">{{ $editingId ? 'Update' : 'Create' }}</flux:button>
            </flux:text>
        </form>
    </flux:modal>

    <!-- Delete Modal -->
    <flux:modal wire:model.self="showDeleteModal" name="confirm-delete" class="md:w-96">
        <flux:heading>Confirm delete</flux:heading>
        <flux:text>
            Are you sure you want to delete this product? All its images will be deleted too.
        </flux:text>
        <flux:text>
            <flux:button variant="ghost" x-on:click="$wire.showDeleteModal = false">Cancel</flux:button>
            <flux:button variant="danger" x-on:click="$wire.delete()">Delete</flux:button>
        </flux:text>
    </flux:modal>
</div>