<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Proposals') }}
        </h2>
    </x-slot>
    
    <script>
        let selectedProducts = [];
        let totalPrice = 0;

        // This is where the Category and search Filters are loaded
        document.addEventListener('DOMContentLoaded', function() {


            // SEARCH FILTER
            const searchForm = document.getElementById('searchForm'); // Make sure to add this id to your search form

            searchForm.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting normally

            // Extract the search term from the form input
            const searchTerm = this.elements['search_term'].value;

            // Use the correct route for the search AJAX request
            const searchProductsUrl = "{{ route('proposals.searchProducts') }}";
            fetch(`${searchProductsUrl}?search_term=${encodeURIComponent(searchTerm)}`, {
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
                const productsContainer = document.getElementById('products-container');
                // Clear current products
                productsContainer.innerHTML = '';

                // Iterate over each product and add it to the DOM
                data.forEach(product => {
                    // Build your product card element string or element here
                    const productHTML = `
                        <div class="product-card">
                            <div class="product-card-title">
                                <a href="javascript:void(0);" onclick="addToContainer('${product.id}', '${product.product_name}', '${product.price}')">
                                    ${product.product_name} - $${product.price}
                                </a>
                            </div>
                            <div class="product-card-description">
                                ${product.description}
                            </div>
                        </div>
                    `;
                    productsContainer.innerHTML += productHTML; // Append new product card
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });


            // CATEGORY FILTER
        const categorySelect = document.getElementById('category');
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;

            // Route the AJAX URL
            const filterProductsUrl = "{{ route('proposals.filterProducts') }}";

            fetch(`${filterProductsUrl}?category_id=${categoryId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json', // This specifies that you're expecting JSON response
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    const productsContainer = document.getElementById('products-container');
                    // console.log('productsContainer:', productsContainer); // Check if this logs null (For Debugging Purposes -- Currently Working)
                    // console.log('Data received:', data); // Log the received data (For Debugging Purposes -- Currently Working)

                    // Clear the container before adding new content
                    productsContainer.innerHTML = '';

                    // Generate the HTML for each product and append it to the productsContainer
                    const productsHtml = data.map(product => `
                    <div class="product-card">
                        <div class="product-card-title">
                            <a href="javascript:void(0);" onclick="addToContainer('${product.id}', '${product.product_name}', '${product.price}')">
                                ${product.product_name} - $${product.price}
                            </a>
                        </div>
                        <div class="product-card-description">
                            ${product.description}
                        </div>
                    </div>
                `).join('');

                    productsContainer.innerHTML = productsHtml;
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    
        // This function will be run everytime a product is added to the products-container
        function addToContainer(productId, productName, productPrice) {
            // Check if the product has already been selected
            if (selectedProducts.includes(productId)) {
                alert('This product has already been selected.'); // Alert the user or handle as you wish
                return; // Exit the function to prevent adding the product again
            }
            
            const price = Number(productPrice);
            totalPrice += price;
            document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
            document.getElementById('formTotalPrice').value = totalPrice; // Update hidden field

            const container = document.getElementById('selectedProductsContainer');
            const productDiv = document.createElement('div');
            productDiv.classList.add('selected-product');
            productDiv.dataset.productId = productId; // Use data attributes to store product ID
            productDiv.innerHTML = `
                <div class="product-and-delete">
                    <p>${productName} - $${price.toFixed(2)}</p>
                    <button onclick="deleteSelectedProduct('${productId}', ${price})">Delete</button>
                </div>
            `;

            container.appendChild(productDiv);

            // Store selected product IDs
            selectedProducts.push(productId);
            document.getElementById('selectedProducts').value = selectedProducts.join(','); // Update hidden field

            updateProposalTotal();
        }

        // This needs to be called everytime something happens within the container so our prices update.
        function updateProposalTotal() {
    
            const proposalTotal = totalPrice;
            document.getElementById('proposalTotal').textContent = proposalTotal.toFixed(2);
            document.getElementById('formProposalTotal').value = proposalTotal; // Update hidden field
        }

        // Delete the Product
        function deleteSelectedProduct(productId, productPrice) {
        // Remove the product from the UI
        const productDiv = document.querySelector(`.selected-product[data-product-id="${productId}"]`);
        if (productDiv) {
            productDiv.remove();
        }
        // Remove the product from the selectedProducts array and update totalPrice
        const index = selectedProducts.indexOf(productId);
        if (index !== -1) {
            selectedProducts.splice(index, 1);
            totalPrice -= productPrice; // Subtract the price of the removed product
            document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
            document.getElementById('formTotalPrice').value = totalPrice;
        }
        // Update the hidden input and other totals
        document.getElementById('selectedProducts').value = selectedProducts.join(',');
        updateProposalTotal();
    }
    </script>
    

    <div class="content">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg mt-2">
                    <div class="container my-4">
                        <ul class="step-progress-bar">
                            <li>Client</li>
                            <li>Title</li>
                            <li>Message</li>
                            <li>Deliverables</li>
                            <li>Finalize</li>
                        </ul>
                    </div>
    
                    <div class="container my-4">
                        @csrf
                        <form id="searchForm" action="{{ route('proposals.searchProducts') }}" method="GET">
                            <div class="input-group">
                                <input type="text" id="search_term" class="form-control" placeholder="Search for products...">
                                <button id="search_button" class="btn btn-outline-secondary">Search</button>
                            </div>
                        </form>
    
                        
                    </div>
                    
                    <div class="container mt-4">
                        @csrf
                        <form id="filterForm" action="{{ route('proposals.filterProducts') }}" method="GET">
                            <h2 class="mt-5">Choose a category</h2>
                            <select name="category_id" id="category" class="form-select" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ (request()->category_id == $category->id) ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>  
    
                    <form action="{{ route('proposals.storeStep4') }}" method="POST">
                        @csrf
                        {{-- Error message for selectedProducts --}}
                        @if ($errors->has('selectedProducts'))
                            <div class="alert alert-danger productserr">
                                {{ $errors->first('selectedProducts') }}
                            </div>
                        @endif
                        
                        <!-- Products Result Area -->
                        <div class="container mt-4">
                            <h2 class="mt-5">Choose a service</h2>
                                <div id="products-container">
                                    @foreach($products as $product)
                                        <div class="product-card">
                                            <div class="product-card-title">
                                                <a href="javascript:void(0);" onclick="addToContainer('{{ $product->id }}', '{{ $product->product_name }}', '{{ $product->price }}')">
                                                    {{ $product->product_name }} - ${{ $product->price }}
                                                    
                                                </a>
                                            </div>
                                            <div class="product-card-description">
                                                {{ $product->product_description }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
    
                            <!-- Totals Area -->
                                    <div id="selectedProductsContainer" class="selected-products-container">
                                        <h3>Summary:</h3>
    
                                    </div>
                                    
                                    <div class="project-total">
                                        <h3>Project Total: $<span id="totalPrice">0</span></h3>
                                    </div>
                                    
                                    <div class="proposal-total">
                                        <h3>Proposal Total: $<span id="proposalTotal">0</span></h3>
                                    </div>
                                
    
    
                            <input type="hidden" name="selectedProducts" id="selectedProducts" value="">
                            <x-text-input type="hidden" name="totalPrice" id="formTotalPrice" value="0"></x-text-input>
                            <input type="hidden" name="proposalTotal" id="formProposalTotal" value="0">
                            
                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2">
                                    <a href="{{ route('proposals.step3') }}">Previous</a>
                                    <x-primary-button type="submit" class="btn btn-primary mt-6">Next</x-primary-button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
