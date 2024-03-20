<x-layout>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Category Filter Dropdown
            const categorySelect = document.getElementById('category');
            categorySelect.addEventListener('change', function() {
                
                const categoryId = this.value;
                const filterProductsUrl = "{{ route('services.filterProducts') }}"; // Make sure this route is defined in your web.php

                fetch(`${filterProductsUrl}?category_id=${categoryId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    renderProducts(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });


   

            // Search Function
            document.getElementById('searchForm').addEventListener('submit', function(e) {
                e.preventDefault();
                let searchTerm = document.getElementById('search_term').value;
                fetch("{{ route('services.searchProducts') }}?search_term=" + searchTerm)
                    .then(response => response.json())
                    .then(data => {
                        renderProducts(data);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            function renderProducts(data) {
            const productsContainer = document.getElementById('products-container'); // Ensure this is the ID of your container
            productsContainer.innerHTML = ''; // Clear existing content

            let productsHtml = '';
data.forEach(product => {
    const createdAtFormatted = product.created_at; // Adjust this to format date as needed
    productsHtml += `
        <div class="mb-3">
            <div class="card h-100 bg-white border-0 rounded-4 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5 class="card-title display-8 fw-bold mb-0">
                                <a href="/services/${product.id}/edit" class="stretched-link text-decoration-none text-dark">
                                    ${product.product_name}
                                </a>
                            </h5>
                        </div>
                        <div class="text-end text-secondary fst-italic">
                            <p class="mb-1">Date Created: ${createdAtFormatted}</p>
                            <p>Created by: ${product.created_by}</p>
                        </div>
                    </div>
                    <p class="card-text mt-2">${product.description || product.product_description}</p>
                    <div class="mt-auto text-end fw-bold">
                        $ ${product.price}
                    </div>
                </div>
            </div>
        </div>
    `;
});
productsContainer.innerHTML = productsHtml;

        }
    });
    </script>

<div class="content">
    <div class="container my-3">
        <div class="row justify-content-center">
            <div class="col-lg-10">
        <div class="my-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="display-6 py-2 fw-bold">
                    <i class="bi bi-box-seam-fill me-3"></i>Services
                </h2>
            </div>
        </div>

        <div class="p-4 rounded-4 bg-blue">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fs-4 py-2 fw-bold text-white">Categories</h3>
                <div>
                    <a href="{{ route('index-category') }}" class="btn secondary-btn rounded-pill fw-bold px-5">Edit Category List</a>
                    <a href="{{ route('categories.createCategory') }}" class="btn secondary-btn rounded-pill text-uppercase fw-bold px-5 ms-2">Create New</a>
                </div>
            </div>
            <form id="filterForm" action="{{ route('services.filterProducts') }}" class="mt-3" method="GET">
                <select name="category_id" id="category" class="form-select" required>
                    <option value="">Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ (request()->category_id == $category->id) ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
          
        <div class="bg-gray p-4 rounded-4 mt-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fs-4 py-2 fw-bold text-dark ">Services</h3>
                <div>
                    <a href="{{ route('services.createProduct') }}" class="btn primary-btn text-white rounded-pill text-uppercase fw-bold px-5 ms-2">Create New</a>
                </div>
            </div>
            <div class="container mt-3">
                <form id="searchForm" action="{{ route('services.searchProducts') }}" method="GET">
                    <div class="input-group mb-4 border-2 rounded-pill bg-white">
                        <input type="text" id="search_term" name="search_term" class="form-control border-0 rounded-start-pill " placeholder="Search">
                        <button id="search_button" class="btn text-white primary-btn fw-bold px-5 rounded-pill" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div id="products-container" class="container mt-3">
                @foreach ($products as $product)
                <div class="mb-3">
                    <div class="card h-100 bg-white border-0 rounded-4 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <!-- Top row for metadata -->
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5 class="card-title display-8 fw-bold mb-0">
                                        <a href="{{ route('services.edit', $product) }}" class="stretched-link text-decoration-none text-dark">
                                            {{ $product->product_name }}
                                        </a>
                                    </h5>
                                </div>
                                <div class="text-end text-secondary fst-italic">
                                    <p class="mb-1">Date Created: {{ $product->created_at}}</p> <!-- Adjust date format as needed -->
                                    <p>Created by: {{ $product->created_by }}</p>
                                </div>
                            </div>
                
                            <!-- Main content -->
                            <p class="card-text mt-2">{{ $product->product_description }}</p>
                
                            <!-- Bottom row for price, aligns to the bottom right -->
                            <div class="mt-auto text-end fw-bold">
                                $ {{ $product->price }}
                            </div>
                        </div>
                    </div>
                </div>
                
                @endforeach
            </div>
            <div id="pagination-container">
                {{ $products->appends(['category_id' => request()->category_id])->links() }}
            </div>
        </div>
        
            </div>
        </div>
    </div>
</div>
</x-layout>