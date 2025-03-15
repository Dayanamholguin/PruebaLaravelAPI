<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ModifyProduct extends Component
{
    public Product $product;
    public $productId;
    public $name;
    public $price;
    public $amount_available;

    public function mount($productId = null)
    {
        if ($productId) {
            $this->product = Product::find($productId);
            if (!$this->product) {
                abort(404);
            }
        }
    }

    protected $listeners = ['openModifyProduct'];

    public function openModifyProduct($productId)
    {
        $this->productId = $productId;
        $this->product = Product::find($this->productId);

        if (!$this->product) {
            return;
        }

        $this->name = $this->product->name;
        $this->price = number_format($this->product->price, $this->product->price == floor($this->product->price) ? 0 : 2, ',', '.');
        $this->amount_available = $this->product->amount_available;

        $this->js("bootstrap.Modal.getOrCreateInstance(document.getElementById('modifyProductModal')).show()");
    }


    public function render()
    {
        return view('livewire.products.modify-product');
    }

    protected function rules()
    {
        return [
            'name' => 'required|max:100|unique:products,name,' . ($this->product->id ?? 'NULL'),
            'price' => 'required|numeric|min:1|max:999999.99',
            'amount_available' => 'required|integer|min:1|max:100'
        ];
    }

    protected function messages()
    {
        return [
            'name.required' => 'The product name is required.',
            'name.unique' => 'The product name already exists. Please choose another.',
            'name.max' => 'The product name cannot exceed 100 characters.',
            'price.required' => 'The product price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price cannot be a negative value.',
            'price.max' => 'The price cannot exceed 999,999.99.',
            'amount_available.required' => 'The available quantity is required.',
            'amount_available.integer' => 'The available quantity must be an integer.',
            'amount_available.min' => 'The available quantity must be at least 1.',
            'amount_available.max' => 'The available quantity cannot exceed 100.'
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function modify()
    {
        $this->validate();

        try {
            DB::beginTransaction();
            $price = preg_replace('/[^0-9,]/', '', $this->price);
            $price = str_replace(',', '.', $price);

            $this->product->update([
                'name' => $this->name,
                'price' => $price,
                'amount_available' => $this->amount_available,
            ]);

            // Log::info("Emitido evento closeModalModifyProduct con ID: " . $this->productId);

            $this->dispatch('refreshProductList')->to('products.show-product');

            $this->dispatch('alert', detail: [
                'title' => 'Success!',
                'message' => sprintf("The product %s has been updated successfully", $this->name),
                'icon' => 'success'
            ]);
            $this->js(<<<JS
                setTimeout(() => {
                    let modal = document.querySelector('#modifyProductModal');
                    if (modal) {
                        $(modal).modal('hide');
                    }
                }, 1);
            JS);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            $this->dispatch('alert', detail: [
                'title' => 'Error!',
                'message' => sprintf("Error updating product: %s", $th->getMessage()),
                'icon' => 'danger'
            ]);
        }
    }
}
