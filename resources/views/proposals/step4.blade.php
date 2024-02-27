<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Proposals') }}
        </h2>
    </x-slot>
    
    <!-- Feel free to place this in an external script. -->
    <script>
        
        let totalPrice = 0;

        function addToContainer(productId, productName, productPrice) {
            // Convert productPrice to a number
            const price = Number(productPrice);

            // Update the total price
            totalPrice += price;

            // Update the display of the total price
            document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);

            // Add the product to the selected products container
            const container = document.getElementById('selectedProductsContainer');
            const productDiv = document.createElement('div');
            productDiv.innerHTML = `<p>${productName} - $${price.toFixed(2)}</p>`;
            container.appendChild(productDiv);

            // Update proposal total after adding a product
            updateProposalTotal();
        }

        function updateProposalTotal() {
            const recurringTotalElement = document.getElementById('recurringTotal');
            const recurringTotal = Number(recurringTotalElement.value);
            
            // Update the display of the recurring total
            document.getElementById('displayRecurringTotal').textContent = recurringTotal.toFixed(2);

            // Calculate and display the proposal total
            const proposalTotal = totalPrice + recurringTotal;
            document.getElementById('proposalTotal').textContent = proposalTotal.toFixed(2);
        }
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="my-6 p-6 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg mt-2">

                <!-- Deliverables should be highlighted here -->
                <div class="container my-4">
                    <ul class="step-progress-bar">
                      <li>Client</li>
                      <li>Title</li>
                      <li>Message</li>
                      <li>Deliverables</li>
                      <li>Finalize</li>
                    </ul>
                </div>

                <!-- Search Form -->
                <div class="container my-4">
                    <form action="{{ route('proposals.searchProducts') }}" method="GET">
                        <div class="input-group">
                            <input type="text" name="search_term" class="form-control" placeholder="Search for products..." aria-label="Search for products" aria-describedby="button-addon2">
                            <x-primary-button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</x-primary-button>
                        </div>
                    </form>
                </div>
                
               <!-- This form will be routed to the storeStep4 function inside 'ProposalController.php' -->
               <form action="{{ route('proposals.filterProducts') }}" method="GET" class="container mt-4">
                <h2 class="mt-5">Choose a category</h2>
                {{-- Category dropdown --}}
                <select name="category_id" id="category" class="form-select" required onchange="this.form.submit()">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ (request()->category_id == $category->id) ? 'selected' : '' }}>
                            {{ $category->category_name }}
                        </option>
                    @endforeach
                </select>
            
                {{-- Products list --}}
                <h2 class="mt-5">Choose a service</h2>
                @if (isset($products) && $products->isNotEmpty())
                    <div id="products-container">
                        <!-- Products Display -->
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

                        <!-- Container for Selected Products -->
                        <div id="selectedProductsContainer" class="selected-products-container">
                            <h3>Summary:</h3>
                            <!-- Selected products will be added here -->
                        </div>
                        <div class="project-total">
                            <h3>Project Total: $<span id="totalPrice">0</span></h3>
                        </div>
                        <div class="recurring-total">
                            <h3>Recurring Total: $<span id="displayRecurringTotal">0</span></h3>
                            <input type="number" id="recurringTotal" placeholder="$0.00" onkeydown="return event.key !== 'Enter'" onchange="updateProposalTotal()">
                        </div>
                        <div class="proposal-total">
                            <h3>Proposal Total: $<span id="proposalTotal">0</span></h3>
                        </div>
                    </div>
                @endif
                
                {{-- Rest of the form --}}
                <div class="row mb-3">
                    <div class="col-sm-10 offset-sm-2">
                        <a href="{{ route('proposals.step3') }}">Cancel</a>
                        <x-primary-button class="mt-6">Next</x-primary-button>
                    </div>
                </div> 
            </form>
            
                
            </div>
        </div>
    </div>
</x-app-layout>
    