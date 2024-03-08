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
                productsHtml += `
                    <div class="mb-3"> <!-- Removed col-md-4 for full width -->
                        <div class="card h-100 bg-zinc">
                            <div class="card-body">
                                <h5 class="card-title display-8 fw-bold">
                                    <a href="/services/${product.id}/edit" class="stretched-link">
                                        ${product.product_name}
                                    </a>
                                </h5>
                                <p class="card-text">${product.description || product.product_description}</p>
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
        <div class="navbar">
            <h1>Services</h1>
        </div>

        <div class="container ">
            <form id="filterForm" action="{{ route('services.filterProducts') }}" method="GET">
                <h2 class="mt-2">Choose a category</h2>
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
        

        <div class="container mt-2">
            <form id="searchForm" action="{{ route('services.searchProducts') }}" method="GET">
                <div class="input-group">
                    <input type="text" id="search_term" name="search_term" class="form-control" placeholder="Search for products...">
                    <button id="search_button" class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
          
        <div class="category-section">
            <a href="{{ route('index-category') }}" class="btn btn-primary">EDIT CATEGORY LIST</a>
            <a href="{{ route('categories.createCategory') }}" class="btn btn-primary">CREATE NEW CATEGORY</a>
        </div>
          
        <div class="services-section">
            <div class="services-flex">
                <h2>Services</h2>
                <a href="{{ route('services.createProduct') }}" class="btn btn-primary">CREATE NEW</a>
            </div>
            <div id="products-container" class="container mt-3">
                @foreach ($products as $product)
                    <div class="mb-3"> 
                        <div class="card h-100 bg-zinc">
                            <div class="card-body">
                                <h5 class="card-title display-8 fw-bold">
                                    <a href="{{ route('services.edit', $product) }}" class="stretched-link">
                                        {{ $product->product_name }}
                                    </a>
                                </h5>
                                <p class="card-text">{{ $product->product_description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div id="pagination-container">
            {{ $products->appends(['category_id' => request()->category_id])->links() }}
        </div>
        
    </div>
</div>
</x-layout>