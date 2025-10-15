<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.store')]
class FetchProducts extends Component
{
    public $products = [];

    public $loading = false;

    public function mount()
    {
        // You can also trigger this manually with a button click.
        $this->fetchProductsFromApi();
    }

    private function createSlug($string)
    {
        // Convert to lowercase
        $slug = strtolower($string);

        // Remove special characters
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);

        // Replace multiple spaces or dashes with a single dash
        $slug = preg_replace('/[\s-]+/', '-', $slug);

        // Trim dashes from both ends
        $slug = trim($slug, '-');

        return $slug;
    }

    public function fetchProductsFromApi()
    {
        $this->loading = true;

        try {
            $response = Http::get('https://dummyjson.com/products');
            // dd($response->getReasonPhrase());
            if ($response->getReasonPhrase() == 'OK') {
                $data = $response->json()['products'];
              
                // Map API data to your Product model fields
                foreach($data as $item) {
                    $category = Category::where('slug', strtolower($item['category'])->$item['category'])->first();
                   
                    $slug = $this->createSlug($item['title']);
                   
                    $product = Product::updateOrCreate( [
                        'name' => $item['title'],
                        'slug' => $slug,
                        'price' => $item['price'],
                        'sku' => $item['sku'],
                        'stock' => $item['stock'],
                        'description' => $item['description'],
                        'category_id' => $category->id,
                    ]);
                    ProductImage::updateOrCreate( [
                        'product_id' => $product->id,
                        'image_path' => $item['thumbnail'],
                        'is_primary' => false,
                    ]);
                };
               
                // Optionally, sync to your database
                // foreach ($this->products as $productData) {
                //     Product::updateOrCreate(
                //         $productData
                //     );
                // }
            }
        } catch (\Exception $e) {
            logger('Error fetching products: '.$e->getMessage());
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.fetch-products', [
            'dbProducts' => Product::latest()->get(),
        ]);
    }
}
