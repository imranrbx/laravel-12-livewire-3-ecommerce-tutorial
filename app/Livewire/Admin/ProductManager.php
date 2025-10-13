<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public ?int $editingId = null;

    // product fields
    public $name = '';
    public $slug = '';
    public $description = '';
    public $sku = '';
    public $price = null;
    public $stock = 0;
    public $category_id = null;

    // uploads
    public array $images = []; // new uploads
    public array $existingImages = []; // urls / model ids for edit display

    // modals
    public bool $showFormModal = false;
    public bool $showDeleteModal = false;
    public ?int $deleteId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:products,slug',
        'sku' => 'required|string|max:255|unique:products,sku',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'images.*' => 'nullable|image|max:5120',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::with('category')->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy('created_at','desc')->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('livewire.admin.product-manager', compact('products','categories'));
    }

    public function create()
    {
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = true;
    }

    public function edit(int $id)
    {
        $product = Product::with('images')->findOrFail($id);
        $this->editingId = $product->id;
        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->category_id = $product->category_id;
        $this->existingImages = $product->images->map(fn($i) => ['id'=>$i->id,'path'=>$i->image_path])->toArray();
        $this->showFormModal = true;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->editingId) {
            $rules['slug'] = 'required|string|max:255|unique:products,slug,' . $this->editingId;
        }
        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->slug ?: $this->name),
            'sku' => $this->sku,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'category_id' => $this->category_id,
        ];

        if ($this->editingId) {
            $product = Product::findOrFail($this->editingId);
            $product->update($data);
            session()->flash('success','Product updated.');
        } else {
            $product = Product::create($data);
            session()->flash('success','Product created.');
        }

        // handle new uploads
        if (!empty($this->images)) {
            foreach ($this->images as $file) {
                $path = $file->store('products', 'public'); // storage/app/public/products
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => false,
                ]);
            }
        }

        $this->showFormModal = false;
        $this->resetForm();
    }

    public function confirmDelete(int $id)
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->deleteId) {
            $product = Product::findOrFail($this->deleteId);
            // delete images files
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img->image_path);
            }
            $product->delete();
            session()->flash('success','Product deleted.');
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function removeExistingImage(int $imageId)
    {
        $img = ProductImage::findOrFail($imageId);
        Storage::disk('public')->delete($img->image_path);
        $img->delete();
        // update local copy for UI
        $this->existingImages = array_filter($this->existingImages, fn($e) => $e['id'] !== $imageId);
    }

    private function resetForm()
    {
        $this->reset(['name','slug','sku','description','price','stock','category_id','images','existingImages','editingId']);
    }
}
