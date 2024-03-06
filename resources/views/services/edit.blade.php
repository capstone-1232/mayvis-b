<x-layout>
    <div class="content">
        <div class="container my-3">
            <h1 class="display-6 mb-2">Edit Product</h1>
            <form action="{{ route('services.updateProduct', $product->id) }}" method="POST">

                @csrf
                @method('PUT')
        
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <x-text-input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}"></x-text-input>
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('product_name')" />
        
                <div class="form-group">
                    <label for="product_description">Product Description</label>
                    <input class="form-control" id="product_description" name="product_description" value="{{ $product->product_description }}"></input>
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('product_description')" />

                <div class="form-group">
                    <label for="product_notes">Product Notes</label>
                    <textarea class="form-control" id="product_notes" name="product_notes">{{ $product->product_notes }}</textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" name="price" value="{{ $product->price }}">
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('price')" />
        
                <!-- Include other fields as necessary -->
        
                <x-primary-button type="submit" class="btn btn-primary">Update Product</x-primary-button>
            </form>

            <!-- Deletion form -->
            <form action="{{ route('services.destroyProduct', $product->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-danger-button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</x-danger-button>
            </form>
        </div>
    </div>
</x-layout>