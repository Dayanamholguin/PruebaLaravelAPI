<div>
    @section('titulo')
        Products
    @endsection
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <div class="flex items-center">
                <select wire:model.live="amount" class="form-control">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <livewire:products.create-product />

            <div class="input-group" style="height: 42px;">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" wire:model.live="search" placeholder="Search product">
            </div>
        </div>
    </div>
    <x-layouts.table>
        @if (count($products))
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="cursor-pointer text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                            wire:click="order('id')">
                            Id
                            @if ($variableOrder == 'id')
                                @if ($typeOrder == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt"></i>
                                @endif
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </th>
                        <th class="cursor-pointer text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                            wire:click="order('name')">Name
                            @if ($variableOrder == 'name')
                                @if ($typeOrder == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt"></i>
                                @endif
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </th>
                        <th class="cursor-pointer text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                            wire:click="order('price')">Price
                            @if ($variableOrder == 'price')
                                @if ($typeOrder == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt"></i>
                                @endif
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </th>
                        <th class="cursor-pointer text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                            wire:click="order('amount_available')">Amount Available
                            @if ($variableOrder == 'amount_available')
                                @if ($typeOrder == 'asc')
                                    <i class="fas fa-sort-alpha-up-alt"></i>
                                @else
                                    <i class="fas fa-sort-alpha-down-alt"></i>
                                @endif
                            @else
                                <i class="fas fa-sort"></i>
                            @endif
                        </th>
                        <th class="cursor-pointer text-secondary opacity-7"></th>
                        <th class="cursor-pointer text-secondary opacity-7"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $product->id }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm"
                                            style="word-break: break-all; text-overflow: ellipsis;">
                                            {{ $product->name }}
                                        </h6>
                                        <span
                                            class="text-xs fw-bold
                                            @if ($product->amount_available > 10) text-success
                                            @elseif ($product->amount_available > 0 && $product->amount_available <= 10) text-warning
                                            @else text-danger @endif">
                                            @if ($product->amount_available > 10)
                                                Disponible
                                            @elseif ($product->amount_available > 0 && $product->amount_available <= 10)
                                                Casi agotado
                                            @else
                                                Agotado
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">
                                            {{ number_format($product->price, $product->price == floor($product->price) ? 0 : 2, ',', '.') }}
                                        </h6>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $product->amount_available }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <a href="#"
                                    wire:click="$dispatch('openModifyProduct', { productId: {{ $product->id }} })"
                                    data-bs-toggle="modal" style="cursor: pointer;" class="titulo">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                            <td class="align-middle">
                                <a class="text-secondary font-weight-bold text-xs iconDelete"
                                    wire:click="$dispatch('jsDeleteProduct', {{ $product->id }})"
                                    style="cursor: pointer;">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
            @if ($products->hasPages())
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        {{ $products->links() }}
                    </ul>
                </nav>
            @endif
        @else
            <div class="d-flex justify-content-center p-5">
                <div class="load-1" wire:loading.delay wire:target="loadProduct">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
                @if ($empty)
                    <div class="text-center p-3">
                        <p>There are no registered products</p>
                    </div>
                @else
                    <div class="text-center p-3" wire:loading.remove wire:target="loadProduct">
                        <p>No product found with the name "{{ $search }}"</p>
                    </div>
                @endif
            </div>
        @endif
    </x-layouts.table>
    <livewire:products.modify-product />
    @push('js')
        <script>
            Livewire.on('jsDeleteProduct', product => {
                Swal.fire({
                    title: 'Delete product',
                    text: 'Do you want to delete this doctor?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yeah'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.set('productIdToDelete', product);
                        @this.call('deleteState');
                        // Livewire.emit('deleteState', product.id);
                    }
                })
            });
        </script>
    @endpush
</div>
