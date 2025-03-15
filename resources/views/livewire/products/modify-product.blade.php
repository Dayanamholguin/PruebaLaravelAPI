<div>
    <x-layouts.modal>
        <x-slot name="idModal">
            modifyProductModal
        </x-slot>

        <x-slot name="titleModal">
            Edit Product > {{ $product?->name ?? 'Unknown Product' }}
        </x-slot>

        <form id="form" wire:submit.prevent="modify" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="name">Name product<b style="color: red" data-toggle="tooltip" data-placement="top"
                                title="Requerido"> *</b></label>
                        <input type="text" class="form-control" wire:model.live="name" />
                        @error('name')
                            <span class="text-danger text-sm" style="--bs-text-opacity: .5;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="price">Price<b style="color: red" data-toggle="tooltip" data-placement="top"
                                title="Requerido"> *</b></label>
                        <input type="text" class="form-control" wire:model.live="price"
                            oninput="formatNumber(this)" />
                        @error('price')
                            <span class="text-danger text-sm" style="--bs-text-opacity: .5;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="amount_available">Amount Available<b style="color: red" data-toggle="tooltip"
                                data-placement="top" title="Requerido"> *</b></label>
                        <input type="text" class="form-control" wire:model.live="amount_available" />
                        @error('amount_available')
                            <span class="text-danger text-sm" style="--bs-text-opacity: .5;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-12 d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary tipoletra" wire:loading.remove
                        wire:target="modify">Modify</button>
                    <button type="submit" class="btn btn-primary tipoletra" wire:loading
                        wire:target="modify">Loading...</button>
                </div>
            </div>
        </form>
    </x-layouts.modal>
    @section('script')
        <x-layouts.alert></x-layouts.alert>
    @endsection
</div>
