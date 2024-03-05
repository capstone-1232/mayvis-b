<x-layout>
    <div class="content">
        <div class="container mt-5">
            <h2 class="display-6 py-2">Edit Category</h2>
            <table class="table px-5">
                <thead>
                    <tr>
                        <th scope="col">Category Name</th>
                        <th scope="col">Note</th>
                        <th scope="col">Delete</th>
                        <th scope="col">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->category_name }}</td>
                            <td>{{ $category->notes }}</td>
                            <td>
                                <form action="{{ route('categories.destroyCategory', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?');">
                                        Delete
                                    </x-danger-button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('categories.editCategory', $category->id) }}" class="btn btn-primary">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>