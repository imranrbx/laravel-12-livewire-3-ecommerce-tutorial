<?php

namespace App\Livewire\Store;

use Livewire\Attributes\{Layout,Title};
use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

#[Layout('components.layouts.store')]
#[Title('Products List')]
class ProductList extends Component
{
    use WithPagination;
    
    public $search = '';
      protected $queryString = ['search'];

    public function mount()
    {
        
    }
       public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        
        $products = $this->products =  Product::with('images')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%')
                ->paginate(9);
        return view('livewire.store.product-list', compact('products'));
    }
}
