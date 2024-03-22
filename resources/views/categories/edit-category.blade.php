<x-layout>
    <div class="content">
        <div class="container my-3">
            <div class="row justify-content-center">
                <div class="col-lg-8">
            <h2 class="display-6 py-2 fw-bold">

                <i class="bi bi-pencil-square me-3"></i>Edit Category
            </h2>
            <div class="bg-white p-4 rounded-4 mt-2">
            <form action="{{ route('categories.updateCategory', $category->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- This is important for the update method --}}
        
                <div class="form-group mb-3">
                    <label for="category_name">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $category->category_name }}">

                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('first_name')" />

                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control mb-3" id="last_name" name="last_name" value="{{ $client->last_name }}">
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('last_name')" />


                    <div class="d-flex justify-content-end align-items-center mt-3">
                        <a href="{{ route('index-category') }}" class="fs-7 fw-bold me-2">Cancel</a>
                        <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill">Update Category</x-primary-button>
                    </div>
            </form>                
        </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>