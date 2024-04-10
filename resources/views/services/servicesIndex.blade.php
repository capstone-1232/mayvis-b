<x-layout>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const paginationContainer = document.getElementById('pagination-container');
            const categorySelect = document.getElementById('category');
            const searchForm = document.getElementById('searchForm');

            function togglePaginationVisibility() {
                if (categorySelect.value || searchForm.search_term.value) {
                    paginationContainer.style.display = 'none';
                } else {
                    paginationContainer.style.display = 'block';
                }
            }

            categorySelect.addEventListener('change', function() {
                togglePaginationVisibility();

                const categoryId = this.value;
                const filterProductsUrl = "{{ route('services.filterProducts') }}"; 

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

            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                togglePaginationVisibility();

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
            const productsContainer = document.getElementById('products-container');
            productsContainer.innerHTML = ''; 

            function formatDate(dateString) {
                const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
                const date = new Date(dateString);
                return `${months[date.getMonth()]} ${date.getDate()}, ${date.getFullYear()}`;
            }

            let productsHtml = '';
            data.forEach(product => {
                const createdAtFormatted = formatDate(product.created_at);
                const updatedAtFormatted = formatDate(product.updated_at);
                productsHtml += `
                    <div class="mb-3">
                        <div class="card h-100 border rounded-4 shadow-sm custom-hover">
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
                                        <p class="mb-1">Updated At: ${updatedAtFormatted}</p>
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
        togglePaginationVisibility();
    });
    </script>

<div class="content">
    <div class="container mb-3 mt-2">
        <div class="row justify-content-center">
            <div class="col-lg-10">
        <div class="my-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="display-6 py-2 fw-bold">
                    <i class="bi bi-boxes me-3"></i>Services
                </h2>
            </div>
        </div>

        <div class="p-4 rounded-5 shadow bg-head">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fs-4 py-2 fw-semibold text-white">Categories</h3>
                <div>
                    <a href="{{ route('index-category') }}" class="btn secondary-btn rounded-pill fw-bold px-5">Edit Category List</a>
                    <a href="{{ route('categories.createCategory') }}" class="btn secondary-btn rounded-pill fw-bold px-5 ms-2">Create New</a>
                </div>
            </div>
            <form id="filterForm" action="{{ route('services.filterProducts') }}" class="mt-3" method="GET">
                <select name="category_id" id="category" class="form-select rounded-pill" required>
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
          
        <div class="bg-white p-4 rounded-5 shadow mt-3">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fs-4 py-2 fw-semibold text-dark ">Scope of Work</h3>
                <div>
                    <a href="{{ route('services.createProduct') }}" class="btn primary-btn text-white rounded-pill fw-bold px-5 ms-2">Create New</a>
                </div>
            </div>
            <div class="container mt-3">
                <form id="searchForm" action="{{ route('services.searchProducts') }}" method="GET">
                    <div class="input-group mb-4 border-2 rounded-pill bg-white">
                        <input type="text" id="search_term" name="search_term" class="form-control border-0 rounded-start-pill " placeholder="Search scope of work">
                        <button id="search_button" class="btn text-white primary-btn fw-bold px-5 rounded-pill" type="submit">Search</button>
                    </div>
                </form>
            </div>
            <div id="products-container" class="container mt-3">
                @foreach ($products as $product)
                <div class="mb-3">
                    <div class="card h-100 border rounded-4 shadow-sm custom-hover">
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
                                    <p class="mb-1">Date Created: {{ \Carbon\Carbon::parse($product->created_at)->format('F j, Y') }}</p>
                                    <p class="mb-1">Updated At: {{ \Carbon\Carbon::parse($product->updated_at)->format('F j, Y') }}</p>



                                    <p>Created by: {{ $product->created_by }}</p>
                                </div>
                            </div>
                
                            <!-- Main content -->
                            <p class="card-text mt-2">{!! $product->product_description !!}
                            </p>
                
                            <!-- Bottom row for price, aligns to the bottom right -->
                            <div class="mt-auto text-end fw-bold">
                                $ {{ $product->price }}
                            </div>
                        </div>
                    </div>
                </div>
                
                @endforeach
            </div>
                @if(!request()->has('category_id') && !request()->has('search_term'))
                    <div id="pagination-container">
                        {{ $products->appends(['category_id' => request()->category_id])->links() }}
                    </div>
                @endif
        </div>
        
            </div>
        </div>
    </div>
</div>
</x-layout>