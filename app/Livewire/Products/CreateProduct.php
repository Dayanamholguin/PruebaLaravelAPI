<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class CreateProduct extends Component
{
    public $name;
    public $price;
    public $amount_available;

    public function render()
    {
        return view('livewire.products.create-product');
    }

    protected $rules = [
        'name' => 'required|unique:products,name|max:100',
        'price' => 'required|numeric|min:1|max:999999.99',
        'amount_available' => 'required|integer|min:1|max:100'
    ];

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
            'amount_available.integer' => 'The available quantity must be a number integer.',
            'amount_available.min' => 'The available quantity must be at least 1.',
            'amount_available.max' => 'The available quantity cannot exceed 100.'
        ];
    }

    public function updated($propertyName){
        $this->validateOnly($propertyName);
    }

    public function save() {
        $this->validate();
        try {
            DB::beginTransaction();
            $price = preg_replace('/[^0-9,]/', '', $this->price);
            $price = str_replace(',', '.', $price);
            Product::create([
                'name' => $this->name,
                'price' => $price,
                'amount_available' => $this->amount_available,
            ]);

            $this->dispatch('jsCloseModalCreate');

            $this->dispatch('refreshProductList')->to('products.show-product');

            $this->dispatch('alert', detail: [
                'title' => 'Excellent!',
                'message' => sprintf("The product %s has been registered satisfactorily", $this->name),
                'icon' => 'success'
            ]);

            $this->reset();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            $this->dispatch('alert', detail: [
                'title' => 'Error!',
                'message' => sprintf("Product registration error %s", $th),
                'icon' => 'danger'
            ]);
            $this->reset();
        }

    }
}
