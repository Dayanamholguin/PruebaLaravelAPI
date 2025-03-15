<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class ShowProduct extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $product;
    public $variableOrder = "id";
    public $typeOrder = "desc";
    public $amount = '10';

    protected $queryString = [
        'search' => ['except' => ''],
        'variableOrder' => ['except' => 'id'],
        'typeOrder' => ['except' => 'desc'],
        'amount' => ['except' => 10],
    ];

    protected $listeners = [
        'refreshProductList' => 'render'
        // 'jsDeleteProduct'
    ];

    public $productIdToDelete;

    public function render()
    {
        $this->amount = is_numeric($this->amount) ? intval($this->amount) : 10;

        $products = Product::where('name', 'like', '%' . $this->search . '%')
        ->orderBy($this->variableOrder, $this->typeOrder)
        ->paginate($this->amount);

        $empty = Product::count() === 0;

        return view('livewire.products.show-product', compact("products", "empty"));
    }

    public function order($variable)
    {
        if ($this->variableOrder == $variable) {
            if ($this->typeOrder == 'desc') {
                $this->typeOrder = 'asc';
            } else {
                $this->typeOrder = 'desc';
            }
        } else {
            $this->variableOrder = $variable;
        }
    }

    public function deleteState()
    {

        $product = Product::find($this->productIdToDelete);
        if (!$product) {
            $this->dispatch('alert', detail: [
                'title' => 'Error!',
                'message' => sprintf('Product %s not found',$product),
                'icon' => 'error'
            ]);
            return;
        }

        $isProductInPurchase = $product->buyProducts()->exists();
        if ($isProductInPurchase) {
            $this->dispatch('refreshProductList')->to('products.show-product');
            $this->dispatch('alert', detail: [
                'title' => 'Error!',
                'message' => 'The product cannot be deleted because it has been associated with a purchase or purchase details',
                'icon' => 'error'
            ]);
        } else {

            $product->delete();
            $this->dispatch('refreshProductList')->to('products.show-product');
            $this->dispatch('alert', detail: [
                'title' => 'success!',
                'message' => sprintf("The product %s was successfully removed.", $product->name),
                'icon' => 'success'
            ]);
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingAmount()
    {
        $this->resetPage();
    }
}
