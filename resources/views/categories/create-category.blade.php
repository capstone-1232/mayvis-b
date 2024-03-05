<x-layout>
    <div class="content">
        <div class="container my-3">
            <h1 class="display-6">Create New Category</h1>
            <form action="{{ route('categories.storeCategory') }}" method="POST">
                @csrf
                <!-- Form fields for product creation -->
                <div class="form-group">
                    <label for="category_name">Category Name</label>
                    <x-text-input type="text" name="category_name" class="form-control" :value="old('category_name')"></x-text-input>
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('category_name')" />

                <div class="form-group">
                    <label for="notes">Category Notes (Optional)</label>
                    <input type="text" name="notes" class="form-control">
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('notes')" />

                <div class="form-group">
                    <label for="created_by">Created By</label>
                    <x-text-input type="text" name="created_by" class="form-control" value="{{ Auth::user()->name }}"></x-text-input>
                </div>
                <x-input-error class="mt-2 productserr" :messages="$errors->get('created_by')" />


                <!-- Add other necessary form fields -->
                <x-primary-button type="submit" class="btn btn-primary">Save Category</x-primary-button>
            </form>
        </div>
    </div>
</x-layout>
