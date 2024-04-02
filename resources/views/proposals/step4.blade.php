<x-layout>    
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
                    <div class="bg-white rounded-5 p-4 mb-2">
                        <div class="product-card-title fw-bold">
                            <a class="d-flex justify-content-between" href="javascript:void(0);" onclick="addToContainer('${product.id}', '${product.product_name}', '${product.price}')">
                                <div>${product.product_name}</div> <div>$ ${product.price}</div>
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
                    <div class="rounded-5 p-4 mb-3 custom-hover shadow-sm">
                        <div class="product-card-title fw-bold">
                            <a class="d-flex justify-content-between" href="javascript:void(0);" onclick="addToContainer('${product.id}', '${product.product_name}', '${product.price}')">
                                <div>${product.product_name}</div> <div>$ ${product.price}</div>
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
                <div class="p-2 fs-6">
                    <div class="d-flex justify-content-between">
                        <div><p class="align-items-center fw-bold"><i class="bi bi-circle-fill me-2"></i>${productName}</p></div> 
                        <div><p class="align-items-center">$ ${price.toFixed(2)}
                            <button class="no-style" onclick="deleteSelectedProduct('${productId}', ${price})"><i class="bi bi-trash3-fill ms-2"></i></button> </p>
                        </div>
                    </div>
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
        <div class="my-4">
            <div class="container my-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="fs-2 py-2 fw-bold mb-2">
                        <i class="bi bi-file-earmark-plus-fill"></i>
                        Proposal
                    </h2>
                </div>
                <div>
                    <ul class="step-progress-bar">
                        <li class="bg-lblue py-3">Client</li>
                        <li class="bg-lblue py-3">Title</li>
                        <li class="bg-lblue py-3">Message</li>
                        <li class="text-white bg-blue py-3">Deliverables</li>
                        <li class="bg-lblue py-3">Finalize</li>
                      </ul>
                </div>
            </div>
    
                    <div class="container my-4">
                        <div class="row">
                            <div class="col-md-8 pe-md-2">
                                <div class="bg-dgray rounded-5 p-4">
                        <div class="container">
                            @csrf
                            <form id="searchForm" action="{{ route('proposals.searchProducts') }}" method="GET">
                                <div class="input-group mb-4 border-2 rounded-pill bg-white">
                                    <input type="text" id="search_term" name="search_term" class="form-control border-0 rounded-start-pill " placeholder="Search for products">
                                    <button id="search_button" class="btn text-white primary-btn fw-bold px-5 rounded-pill" type="submit">Search</button>
                                </div>
                            </form>
                        </div>
                        <div class="container">
                            @csrf
                            <form id="filterForm" action="{{ route('proposals.filterProducts') }}" method="GET">
                                <h3 class="mb-2 fs-5 py-2 fw-bold">Choose a category</h3>
                                <select name="category_id" id="category" class="form-select rounded-pill" required>
                                    <option value="" disabled selected>Choose a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ (request()->category_id == $category->id) ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <div>
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
                                    <h3 class="mb-2 fs-5 py-2 fw-bold">Choose a service</h3>
                                        <div id="products-container">
                                            @foreach($products as $product)
                                                <div class="bg-white rounded-5 p-4 mb-2">
                                                    <div class="product-card-title fw-bold">
                                                        <a class="d-flex justify-content-between" href="javascript:void(0);" onclick="addToContainer('{{ $product->id }}', '{{ $product->product_name }}', '{{ $product->price }}')">
                                                           <div>{{ $product->product_name }}</div> <div>$ {{ $product->price }}</div>
                                                            
                                                        </a>
                                                    </div>
                                                    <div class="product-card-description">
                                                        {{ $product->product_description }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-4 pt-sm-3 pt-md-0">
                        <div class="bg-white rounded-5 p-4">
                                                    <!-- Totals Area -->
                                                    <div id="selectedProductsContainer" class="">
                                                        <h3 class="mb-2 fs-5 py-2 fw-bold">Summary:</h3>
                    
                                                    </div>
                                                    
                                                    <div class="bg-gray rounded-5 mt-3 p-3">
                                                        <div class="mb-2 border-bottom border-dark pb-2">
                                                            <h3 class="d-flex justify-content-between"><span>Project Total:</span> <div>$ <span id="totalPrice">0</span></div></h3>
                                                        </div>
                                                        
                                                        <div class="">
                                                            <h3 class="fw-bold d-flex justify-content-between"><span>Proposal Total:</span> <div>$ <span id="proposalTotal">0</span></div></h3>
                                                        </div>
                                                    </div>
                    
                                            <input type="hidden" name="selectedProducts" id="selectedProducts" value="">
                                            <x-text-input type="hidden" name="totalPrice" id="formTotalPrice" value="0"></x-text-input>
                                            <input type="hidden" name="proposalTotal" id="formProposalTotal" value="0">
                                    </div>
                                </div>
                            </div>
                        

                            <div class="d-flex justify-content-end align-items-center mt-3">
                                <a href="{{ route('proposals.step3') }}" class="fs-7 fw-bold me-2 btn btn-secondary rounded-pill btn-width">Prev</a>
                                <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill px-4 btn-width fw-bold">Next</x-primary-button>
                            </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>