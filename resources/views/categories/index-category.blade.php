<x-layout>
    <div class="content">
        <div class="container my-3">
            <div class="d-flex justify-content-between align-items-center my-4">
                <h2 class="display-6 py-2 fw-bold">
                    <i class="bi bi-tags me-3"></i>Category List
                </h2>
                <div>
                    <a href="{{ route('categories.createCategory') }}" class="btn primary-btn rounded-pill fw-bold px-5 ms-2 text-white">Create New</a>
                </div>
            </div>
            <div class="bg-white p-4 rounded-5 shadow mt-3">
                <table class="table">
                    <thead class="border-bottom border-secondary-subtle">
                        <tr class="fs-5 text-center text-dark">
                            <th scope="col">Category Name</th>
                            <th scope="col" class="d-none d-md-table-cell">Note</th>
                            <th scope="col">Delete</th>
                            <th scope="col">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td class="align-middle ps-5 fw-medium">{{ $category->category_name }}</td>
                                <td class="align-middle d-none d-md-table-cell text-center fst-italic">{!! $category->notes !!}</td>
                                <td class="align-middle text-center">
                                    <form action="{{ route('categories.destroyCategory', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-danger-button type="submit" class="no-style fs-3" onclick="return confirm('Are you sure you want to delete this category?');">
                                            <i class="bi bi-trash3-fill"></i>
                                        </x-danger-button>
                                    </form>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="{{ route('categories.editCategory', $category->id) }}" class="fs-3">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-start align-items-center mt-4">
                <a href="{{ route('servicesIndex') }}" class="fs-7 fw-semibold me-2"><i class="bi bi-caret-left-fill me-2"></i>Back to Service</a>
            </div>
        </div>
    </div>
</x-layout>