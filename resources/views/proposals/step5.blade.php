<x-layout>

<script>
    function editPrice(productId) {
        // Show the edit container
        document.getElementById('edit-container-' + productId).style.display = 'block';
        // Hide the display elements
        document.getElementById('price-display-' + productId).style.display = 'none';
        document.getElementById('quantity-display-' + productId).style.display = 'none';
        document.getElementById('edit-button-' + productId).style.display = 'none';
    }

    function savePrice(productId) {
        // Get the input values
        var priceInput = document.getElementById('price-input-' + productId);
        var quantityInput = document.getElementById('quantity-input-' + productId);
        var descriptionInput = document.getElementById('description-input-' + productId);

        // Validate and parse input values
        var newPrice = Math.max(0, parseFloat(priceInput.value || 0));
        var newQuantity = Math.max(1, parseInt(quantityInput.value || 1));

        // Update the display with new values formatted with commas and two decimal places
        document.getElementById('price-value-' + productId).innerText = newPrice.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.getElementById('quantity-value-' + productId).innerText = newQuantity.toString();
        document.getElementById('description-value-' + productId).innerText = descriptionInput.value;

        // Hide the edit container
        document.getElementById('edit-container-' + productId).style.display = 'none';

        // Show the display elements again
        document.getElementById('price-display-' + productId).style.display = 'inline';
        document.getElementById('quantity-display-' + productId).style.display = 'inline';
        document.getElementById('edit-button-' + productId).style.display = 'inline';

        // Recalculate and update total prices
        updateTotalPrice();
    }

    function updateTotalPrice() {
        let totalPrice = 0;
        document.querySelectorAll('span[id^="price-value-"]').forEach(function(span) {
            var price = parseFloat(span.innerText.replace(/[^0-9.-]+/g, ''));
            var quantityId = 'quantity-value-' + span.id.split('-').pop();
            var quantity = parseInt(document.getElementById(quantityId).innerText);
            totalPrice += price * quantity;
        });

        // Format the total price with commas and two decimal places
        document.getElementById('totalPriceDisplay').textContent = totalPrice.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        document.getElementById('proposalTotalDisplay').textContent = totalPrice.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
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
                        <li class="bg-lblue py-3">Deliverables</li>
                        <li class="text-white bg-blue py-3">Finalize</li>
                      </ul>
                </div>
            </div>
    
            <div class="container">
            <div class="">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="fs-3 py-2 fw-bold mb-2">
                        Customize and Review
                    </h2>
                </div>
            </div>
                    <div class="">
                    <form action="{{ route('proposals.storeStep5') }}" method="POST">
                        @csrf
                        {{-- loop to display product details --}}
                        <div class="row">
                            <div class="col-md-4 pe-md-3">
                                <div class="bg-white rounded-xl p-2">
                        @foreach($step4Data['selectedProducts'] as $productId => $productDetails)
                        {{-- PRODUCT SUMMARY DIV --}}
                        <div id="product-{{ $productId }}">
                            <div class="row p-2 my-2 mx-1">
                            {{-- Product Title --}}
                            <div class="col-6">
                                <p class="align-items-center"><i class="bi bi-circle-fill me-2"></i>{{$productDetails['name']}}</p>
                            </div>
                            {{-- Product Price --}}
                            <div class="col-3">
                                <span class="align-items-center" id="price-display-{{ $productId }}">
                                    @if($productDetails['price'] !== 'No Price')
                                        $<span id="price-value-{{ $productId }}">{{ number_format($productDetails['price'], 2) }}</span>
                                    @else
                                        Price not available
                                    @endif
                                </span>
                            </div>
                            {{-- Edit Product Price --}}

                            {{-- Quantity --}}
                            <div class="col-2">
                            <span class="align-items-center " id="quantity-display-{{ $productId }}"> x <span id="quantity-value-{{ $productId }}">{{ $productDetails['quantity'] ?? 1 }}</span></span>
                            </div>
                        

                            {{-- Product Description --}}
                            <div class="d-none">
                                <span id="description-display-{{ $productId }}"><span id="description-value-{{ $productId }}">{{ $productDetails['description'] ?? '' }}</span></span>
                            </div>

                            
                            <!-- Edit and Save buttons -->
                            <x-primary-button class="bg-transparent col-1 fs-5 align-items-center" type="button" onclick="editPrice('{{ $productId }}')" id="edit-button-{{ $productId }}"><i class="bi bi-pencil-square"></i></x-primary-button>
                            </div>
                        </div>
                        @endforeach
                                                            
                    </div>
                        {{-- Display totals and other information --}}
                        <div class="bg-dgray rounded-xl my-3 p-3">
                            <div class="mb-2 border-bottom border-dark pb-2">
                                <p class="d-flex justify-content-between">
                                    <span>Total Price:</span> 
                                    <span>$<span id="totalPriceDisplay">{{ number_format($step4Data['totalPrice'] ?? 0, 2, '.', ',') }}</span></span>
                                </p>
                            </div>
                            <div>
                                <p class="fw-bold d-flex justify-content-between">
                                    <span>Proposal Total:</span> 
                                    <span>$<span id="proposalTotalDisplay">{{ number_format($step4Data['proposalTotal'] ?? 0, 2, '.', ',') }}</span></span>
                                </p>
                            </div>
                        </div>
                        
                            </div>

                        <div class="col-md-8 bg-white rounded-xl pb-3">
                            @foreach($step4Data['selectedProducts'] as $productId => $productDetails)
                            {{-- EDIT SUMMARY DIV --}}
                            <div class="px-4 pt-4 edit-container" id="edit-container-{{ $productId }}">
                                {{-- Edit Amount --}}
                                <div class="mb-3">
                                    <label for="products[{{ $productId }}][price]" class="fw-bold">Price</label>
                                    <input class="w-100 border-2 rounded-pill px-2 py-1" type="number" name="products[{{ $productId }}][price]" id="price-input-{{ $productId }}" value="{{ $productDetails['price'] }}" step="0.01">
                                </div>
                                {{-- Edit Quantity --}}
                                <div class="mb-3">
                                    <label for="products[{{ $productId }}][quantity]" class="fw-bold">Quantity</label>
                                    <input class="w-100 border-2 rounded-pill px-2 py-1" type="number" name="products[{{ $productId }}][quantity]" id="quantity-input-{{ $productId }}" value="{{ $productDetails['quantity'] ?? 1 }}" min="1">
                                </div>
                                {{-- Edit Product Description --}}
                                <div class="mb-3">
                                    <label for="products[{{ $productId }}][description]" class="fw-bold">Scope of Work</label>
                                    <textarea name="products[{{ $productId }}][description]" id="description-input-{{ $productId }}">{{ $productDetails['description'] ?? '' }}</textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <x-primary-button class="btn primary-btn text-white rounded-pill px-4 btn-width fw-bold" type="button" onclick="savePrice('{{ $productId }}')" id="save-button-{{ $productId }}">Save</x-primary-button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                        </div>

    
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <a href="{{ route('proposals.step4') }}" class="fs-7 fw-bold me-2 btn btn-secondary rounded-pill btn-width">Prev</a>
                            <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill px-4 btn-width fw-bold">Next</x-primary-button>
                        </div>
                    </form>
                </div>
        </div>
        </div>
    </div>
    </div>
</x-layout>