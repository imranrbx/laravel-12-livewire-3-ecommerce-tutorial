<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Category;

class CategoryManager extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $editingId = null;
    public string $name = '';
    public string $slug = '';
    public ?int $parent_id = null;

    // modal flags
    public bool $showFormModal = false;
    public bool $showDeleteModal = false;
    public ?int $deleteId = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:categories,slug',
        'parent_id' => 'nullable|exists:categories,id',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::with('parent')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy('name')
            ->paginate(10);

        $parents = Category::orderBy('name')->get();

        return view('livewire.admin.category-manager', compact('categories','parents'));
    }

    public function create()
    {
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = true;
    }

    public function edit(int $id)
    {
        $cat = Category::findOrFail($id);
        $this->editingId = $cat->id;
        $this->name = $cat->name;
        $this->slug = $cat->slug;
        $this->parent_id = $cat->parent_id;
        $this->showFormModal = true;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->editingId) {
            $rules['slug'] = 'required|string|max:255|unique:categories,slug,' . $this->editingId;
        }
        $data = $this->validate($rules);

        if ($this->editingId) {
            Category::find($this->editingId)->update($data);
            session()->flash('success', 'Category updated.');
        } else {
            Category::create($data);
            session()->flash('success', 'Category created.');
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
            Category::findOrFail($this->deleteId)->delete();
            session()->flash('success', 'Category deleted.');
        }
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    private function resetForm()
    {
        $this->reset(['name','slug','parent_id','editingId']);
    }
}

