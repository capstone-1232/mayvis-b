<x-layout>
    <div class="content">
        <div class="container my-3">
            <h1 class="display-6">Create New Product</h1>
            <form action="{{ route('services.storeProduct') }}" method="POST">
                @csrf
                <!-- Form fields for product creation -->
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <x-text-input type="text" name="product_name" class="form-control" :value="old('product_name')"></x-text-input>
                    <x-input-error class="mt-2 productserr" :messages="$errors->get('product_name')" />
                </div>

                <div class="form-group">
                    <label for="product_description">Product Description</label>
                    <x-text-input type="text" name="product_description" class="form-control" :value="old('product_description')"></x-text-input>
                    <x-input-error class="mt-2 productserr" :messages="$errors->get('product_description')" />
                </div>

                <div class="form-group">
                    <label for="product_notes">Product Notes (Optional)</label>
                    <x-text-input type="text" name="product_notes" class="form-control"></x-text-input>
                </div>

                <div class="form-group">
                    <label for="price">Product Price</label>
                    <x-text-input type="text" name="price" class="form-control" :value="old('price')"></x-text-input>
                    <x-input-error class="mt-2 productserr" :messages="$errors->get('price')" />
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="created_by">Created By</label>
                    <x-text-input type="text" name="created_by" class="form-control" value="{{ Auth::user()->name }}"></x-text-input>
                    <x-input-error class="mt-2 productserr" :messages="$errors->get('created_by')" />
                </div>


                <!-- Add other necessary form fields -->
                <x-primary-button type="submit" class="btn btn-primary">Save Product</x-primary-button>
            </form>
        </div>
    </div>
</x-layout>
