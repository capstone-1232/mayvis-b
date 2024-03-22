<x-layout>
    <div class="content">
        <div class="container my-4">
            <div class="row justify-content-center">
                <div class="col-lg-8 mb-4">
            <h2 class="display-6 py-2 fw-bold">
                <i class="bi bi-bookmark-plus-fill me-3"></i>Create Category
            </h2>
            <div class="bg-white p-4 rounded-4 mt-2">
            <form action="{{ route('categories.storeCategory') }}" method="POST">
                @csrf
                <!-- Form fields for product creation -->
                <div class="form-group mb-3">
                    <label for="category_name">Category Name</label>
                    <x-text-input type="text" name="category_name" class="form-control rounded-pill" :value="old('category_name')"></x-text-input>
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('category_name')" />

                <div class="form-group mb-3">
                    <label for="notes">Category Notes (Optional)</label>
                    <textarea class="form-control" id="notes" name="notes"></textarea>
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('notes')" />

                <div class="form-group mb-3">
                    <label for="created_by">Created By</label>
                    <x-text-input type="text" name="created_by" class="form-control rounded-pill" value="{{ Auth::user()->name }}"></x-text-input>
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('created_by')" />


                <!-- Add other necessary form fields -->
                <div class="d-flex justify-content-end align-items-center mt-3">
                    <a href="{{ route('index-category') }}" class="fs-7 fw-bold me-2">Cancel</a>
                    <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill">Save Category</x-primary-button>
                </div>
            </form>
            </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
