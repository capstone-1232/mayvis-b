<x-layout>
    <div class="content">
        <div class="container my-3">
            <h1 class="display-6 mb-2">Edit Category</h1>
            <form action="{{ route('categories.updateCategory', $category->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- This is important for the update method --}}
        
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="{{ $category->category_name }}">
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('category_name')" />

                <div class="form-group">
                    <label for="notes">Category Notes</label>
                    <textarea class="form-control" id="notes" name="notes">{{ $category->notes }}</textarea>
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('notes')" />

        
                <x-primary-button type="submit" class="btn btn-primary">Update Category</x-primary-button>
            </form>

            <!-- Deletion form -->
            <form action="{{ route('categories.destroyCategory', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-danger-button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">Delete</x-danger-button>
            </form>
        </div>
    </div>
</x-layout>