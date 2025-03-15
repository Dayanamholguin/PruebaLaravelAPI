<div>
    {{-- create product  --}}
    <a href="#" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#create-product">Create</a>

    <x-layouts.modal>
        <x-slot name="idModal">
            create-product
        </x-slot>

        <x-slot name="titleModal">
            Create product
        </x-slot>

        {{-- Contenido del modal --}}
        <form id="form" wire:submit.prevent="save" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <label for="name">Name product<b style="color: red" data-toggle="tooltip"
                                data-placement="top" title="Requerido"> *</b></label>
                        <input id="name" type="text" name="name" class="form-control" name="name"
                            wire:model.live="name" />
                        @error('name')
                            <span class="text-danger text-sm" style="--bs-text-opacity: .5;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="price">Price<b style="color: red" data-toggle="tooltip" data-placement="top"
                                title="Requerido"> *</b></label>
                        <input id="price" type="text" name="price" class="form-control" name="price"
                            wire:model.lazy="price" oninput="formatNumber(this)" />
                        @error('price')
                            <span class="text-danger text-sm" style="--bs-text-opacity: .5;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="amount_available">Amount available<b style="color: red" data-toggle="tooltip"
                                data-placement="top" title="Requerido"> *</b></label>
                        <input id="amount_available" type="number" name="amount_available" class="form-control"
                            name="amount_available" wire:model.live="amount_available" />
                        @error('amount_available')
                            <span class="text-danger text-sm" style="--bs-text-opacity: .5;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-12 d-flex justify-content-between align-items-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary tipoletra" wire:loading.remove
                        wire:target="save">Create</button>
                    <button type="submit" class="btn btn-primary tipoletra" wire:loading
                        wire:target="save">Loading...</button>
                </div>
            </div>
        </form>
    </x-layouts.modal>

    @section('script')
        <x-layouts.alert></x-layouts.alert>
        <script>
            window.addEventListener('jsCloseModalCreate', event => {
                $('#create-product').modal('hide');
            });
        </script>
    @endsection
</div>
