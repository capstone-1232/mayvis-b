<x-layout>
    <div class="content">
        <div class="container my-3">
            <div class="row justify-content-center">
                <div class="col-lg-8">
            <h2 class="display-6 py-2 fw-bold">
                <i class="bi bi-pencil-square me-3"></i>Edit Product
            </h2>
            <div class="bg-white p-4 rounded-5 mt-2">
                <form action="{{ route('services.updateProduct', $product->id) }}" method="POST">

                    @csrf
                    @method('PUT')
            
                    <div class="form-group mb-3">
                        <x-input-label for="product_name" :value="__('Product Name')" />
                        <x-text-input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}"></x-text-input>
                    </div>
                    <x-input-error class="mt-2 productserr" :messages="$errors->get('product_name')" />
            
                    <div class="form-group mb-3">
                        <x-input-label for="product_description" :value="__('Product Description')" />
                        <textarea class="form-control" id="product_description" name="product_description" value="{{ $product->product_description }}"></textarea>
                    </div>
                    <x-input-error class="mt-2 productserr" :messages="$errors->get('product_description')" />
    
                    <div class="form-group mb-3">
                        <x-input-label for="product_notes" :value="__('Product Notes')" />
                        <x-text-input class="form-control" id="product_notes" name="product_notes">{{ $product->product_notes }}</x-text-input>
                    </div>
    
                    <div class="form-group mb-3">
                        <x-input-label for="price" :value="__('Price')" />
                        <x-text-input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}" />
                    </div>
                    <x-input-error class="mt-2 productserr" :messages="$errors->get('price')" />

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <x-danger-button type="button" class="btn btn-danger rounded-pill fw-bold" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this product?')) document.getElementById('delete-form').submit();">Delete</x-danger-button>
                            <!-- Ensure there's space between buttons if needed with margin or padding -->
                            <div>
                                <a href="{{ route('servicesIndex') }}" class="fs-7 fw-bold me-2">Cancel</a>
                                <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill me-2">Update Product</x-primary-button>
                            </div>
                        </div>
                    </form>

                    <!-- Deletion form, now outside the update form but visually appears together -->
                    <form id="delete-form" action="{{ route('services.destroyProduct', $product->id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layout>