<x-layout>
    <div class="content">
        <div class="container my-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 mb-4">
            <h2 class="display-6 py-2 fw-bold">
                <i class="bi bi-pencil-square me-3"></i>Edit Category
            </h2>
            <div class="bg-white p-4 rounded-4 mt-2">
            <form action="{{ route('categories.updateCategory', $category->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- This is important for the update method --}}
        
                <div class="form-group mb-3">
                    <label for="category_name">Category Name</label>

                    <input type="text" class="form-control rounded-pill" id="category_name" name="category_name" value="{{ $category->category_name }}">

                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('category_name')" />

                <div class="form-group">
                    <label for="notes">Category Notes</label>
                    <textarea class="form-control" id="notes" name="notes">{{ $category->notes }}</textarea>
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('notes')" />

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