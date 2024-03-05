<x-layout>

    <script>

        /* Search function to search products */
        document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the form from submitting traditionally
    
        let searchTerm = document.getElementById('search_term').value;
    
        // Corrected the route in the fetch call
        fetch("{{ route('services.searchProducts') }}?search_term=" + searchTerm)
            .then(response => response.json())
            .then(data => {
                let productsContainer = document.querySelector('.row');
                productsContainer.innerHTML = ''; // Clear current products
    
                data.forEach(product => {
                    productsContainer.innerHTML += `
                        <div class="col-md-4 mb-3">
                            <div class="card h-100 bg-zinc">
                                <div class="card-body">
                                    <h5 class="card-title display-8 fw-bold">
                                        <a href="/services/${product.id}/edit" class="stretched-link">
                                            ${product.product_name}
                                        </a>
                                    </h5>
                                    <p class="card-text">${product.product_description}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
            })
            .catch(error => console.error('Error:', error));
        });
    });
    </script>        

    <div class="content">
        <div class="container my-3">
            <div class="navbar">
                <h1>Services</h1>
              </div>
              
              <div class="container my-4">
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
              <div>
                
              </div>
              <div class="services-section">
                <div class="services-flex">
                    <h2>Services</h2>
                    <a href="{{ route('services.createProduct') }}" class="btn btn-primary">CREATE NEW</a>
                </div>
                <div class="container mt-5">
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 bg-zinc">
                                    <div class="card-body">
                                        <!-- Make the title a link to the edit page -->
                                        <h5 class="card-title display-8 fw-bold">
                                            <a href="{{ route('services.edit', $product) }}" class="stretched-link">
                                                {{ $product->product_name }}
                                            </a>
                                        </h5>
                                        <p class="card-text">{{ $product->product_description }}</p>
                                        <!-- Other fields can include price, button, etc. -->
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                </div>
              </div>
        </div>
          
    </div>
</x-layout>