<x-layout>
    <div class="content">
        <div class="container my-3">
            <div class="row justify-content-center">
                <div class="col-lg-8">
            <h2 class="display-6 py-2 fw-bold">
                <i class="bi bi-boxes me-3"></i>Create New Product
            </h2>
            <div class="bg-white p-4 rounded-4 mt-2">
                <form action="{{ route('services.storeProduct') }}" method="POST">
                    @csrf
                    <!-- Form fields for product creation -->
                    <div class="form-group mb-3">
                        <label for="product_name">Product Name</label>
                        <x-text-input type="text" name="product_name" class="form-control" :value="old('product_name')"></x-text-input>
                        <x-input-error class="mt-2 productserr" :messages="$errors->get('product_name')" />
                    </div>
    
                    <div class="form-group mb-3">
                        <label for="product_description">Product Description</label>
                        <x-text-input type="text" name="product_description" class="form-control" :value="old('product_description')"></x-text-input>
                        <x-input-error class="mt-2 productserr" :messages="$errors->get('product_description')" />
                    </div>
    
                    <div class="form-group mb-3">
                        <label for="product_notes">Product Notes (Optional)</label>
                        <x-text-input type="text" name="product_notes" class="form-control"></x-text-input>
                    </div>
    
                    <div class="form-group mb-3">
                        <label for="price">Product Price</label>
                        <x-text-input type="text" name="price" class="form-control" :value="old('price')"></x-text-input>
                        <x-input-error class="mt-2 productserr" :messages="$errors->get('price')" />
                    </div>
    
                    <div class="form-group mb-3">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="form-group mb-3">
                        <label for="created_by">Created By</label>
                        <x-text-input type="text" name="created_by" class="form-control" value="{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}"></x-text-input>
                        <x-input-error class="mt-2 productserr" :messages="$errors->get('created_by')" />
                    </div>
    
    
                    <!-- Add other necessary form fields -->
                    <div class="d-flex justify-content-end align-items-center mt-3">
                        <a href="{{ route('servicesIndex') }}" class="fs-7 fw-bold me-2">Cancel</a>
                        <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill">Save Product</x-primary-button>
                    </div>
                </form>
            </div>
            
                </div>
            </div>
        </div>
    </div>
</x-layout>
