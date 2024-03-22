<x-layout>
    <script>
        function editPrice(productId) {
            // Toggle visibility for editing price and quantity
            document.getElementById('price-display-' + productId).style.display = 'inline';
            document.getElementById('price-input-' + productId).style.display = 'inline';
            document.getElementById('quantity-display-' + productId).style.display = 'inline';
            document.getElementById('quantity-input-' + productId).style.display = 'inline';
            document.getElementById('description-display-' + productId).style.display = 'none';
            document.getElementById('description-input-' + productId).style.display = 'inline';
            document.getElementById('edit-button-' + productId).style.display = 'inline';
            document.getElementById('save-button-' + productId).style.display = 'inline';
            // add
            document.getElementById('hidden-price-' + productId).style.display = 'inline';
            document.getElementById('hidden-quantity-' + productId).style.display = 'inline';
            document.getElementById('hidden-description-' + productId).style.display = 'inline';
        }
        
        function savePrice(productId) {
            // Get the input values, removing any formatting like commas or currency symbols
            var priceInputValue = document.getElementById('price-input-' + productId).value.replace(/[^0-9.-]/g, '');
            var quantityInputValue = document.getElementById('quantity-input-' + productId).value;

            // Ensure price is not negative; default to 0 if it is
            var newPrice = Math.max(0, parseFloat(priceInputValue || 0));

            // Ensure quantity is at least 1; default to 1 if it is less
            var newQuantity = Math.max(1, parseInt(quantityInputValue || 1));

            var descriptionInputValue = document.getElementById('description-input-' + productId).value;

            // Update the display with new values
            document.getElementById('price-value-' + productId).innerText = newPrice.toFixed(2);
            document.getElementById('quantity-value-' + productId).innerText = newQuantity;
            document.getElementById('description-value-' + productId).innerText = descriptionInputValue;
            
            // Toggle visibility back to normal
            document.getElementById('price-display-' + productId).style.display = 'inline';
            document.getElementById('price-input-' + productId).style.display = 'none';
            document.getElementById('quantity-display-' + productId).style.display = 'inline';
            document.getElementById('quantity-input-' + productId).style.display = 'none';
            document.getElementById('description-display-' + productId).style.display = 'none';
            document.getElementById('description-input-' + productId).style.display = 'none';
            document.getElementById('edit-button-' + productId).style.display = 'inline';
            document.getElementById('save-button-' + productId).style.display = 'none';
            // add
            document.getElementById('hidden-price-' + productId).style.display = 'none';
            document.getElementById('hidden-quantity-' + productId).style.display = 'none';
            document.getElementById('hidden-description-' + productId).style.display = 'none';

            // Update the input fields to reflect the corrected values (for submission)
            document.getElementById('price-input-' + productId).value = newPrice.toFixed(2);
            document.getElementById('quantity-input-' + productId).value = newQuantity;

            // Recalculate and update total prices
            updateTotalPrice();
        }


        function updateTotalPrice() {
            let totalPrice = 0;
            document.querySelectorAll('span[id^="price-value-"]').forEach(function(span) {
                var productId = span.id.replace('price-value-', '');
                // Remove any formatting from the text content
                var priceText = span.textContent.replace(/[^0-9.]/g, '');
                var quantityText = document.getElementById('quantity-value-' + productId).textContent.replace(/[^0-9]/g, '');

                var price = priceText ? parseFloat(priceText) : 0;
                var quantity = quantityText ? parseInt(quantityText) : 1;

                totalPrice += price * quantity;
            });

            // Format total price with 2 decimal places and commas
            document.getElementById('totalPriceDisplay').textContent = totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

            // Set proposal total equal to total price since there's no recurring total
            document.getElementById('proposalTotalDisplay').textContent = totalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
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
                            <div class="row p-2 my-2">
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
                            {{-- <div class="">
                            <input type="number" name="products[{{ $productId }}][price]" id="price-input-{{ $productId }}" style="display:none;" value="{{ $productDetails['price'] }}" step="0.01">
                            </div> --}}

                            {{-- Quantity --}}
                            <div class="col-2">
                            <span class="align-items-center" id="quantity-display-{{ $productId }}"> x <span id="quantity-value-{{ $productId }}">{{ $productDetails['quantity'] ?? 1 }}</span></span>
                            </div>
                            {{-- Edit Quantity --}}
                            {{-- <div>
                            <input type="number" name="products[{{ $productId }}][quantity]" id="quantity-input-{{ $productId }}" style="display:none;" value="{{ $productDetails['quantity'] ?? 1 }}" min="1">
                            </div> --}}

                            {{-- Product Description --}}
                            <div class="d-none">
                            <span id="description-display-{{ $productId }}"><span id="description-value-{{ $productId }}">{{ $productDetails['description'] ?? '' }}</span></span>
                            </div>
                            {{-- Edit Product Description --}}
                            {{-- <div>
                            <textarea name="products[{{ $productId }}][description]" id="description-input-{{ $productId }}" style="display:none;">{{ $productDetails['description'] ?? '' }}</textarea>
                            </div> --}}
                            
                            <!-- Edit and Save buttons -->
                            <x-primary-button class="bg-transparent col-1 fs-5 align-items-center" type="button" onclick="editPrice('{{ $productId }}')" id="edit-button-{{ $productId }}"><i class="bi bi-pencil-square"></i></x-primary-button>
                            {{-- <x-primary-button type="button" onclick="savePrice('{{ $productId }}')" id="save-button-{{ $productId }}" style="display:none;">Save</x-primary-button> --}}
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

                        <div class="col-md-8 bg-white rounded-xl">
                        @foreach($step4Data['selectedProducts'] as $productId => $productDetails)
                        {{-- EDIT SUMMARY DIV --}}
                        <div class="px-4 pt-4"  id="product-{{ $productId }}">
                                {{-- Edit Title --}}
                                {{-- <div class="">
                                    <label for="products[{{ $productId }}][name]" id="hidden-name-{{ $productId }}"  class="fw-bold d-hide">Sender</label>
                                    <input class="d-hide" type="text" name="products[{{ $productId }}][name]" id="name-input-{{ $productId }}"  value="{{ $productDetails['name'] }}" step="0.01">
                                </div> --}}
                                {{-- Edit Amount --}}
                                <div class="mb-3">
                                    <label for="products[{{ $productId }}][price]" id="hidden-price-{{ $productId }}"  class="fw-bold d-hide">Price</label>
                                    <input class="d-hide w-100 border-2 rounded-pill px-2 py-1" type="number" name="products[{{ $productId }}][price]" id="price-input-{{ $productId }}"  value="{{ $productDetails['price'] }}" step="0.01">
                                </div>
                                {{-- Edit Quantity --}}
                                <div class="mb-3">
                                    <label for="products[{{ $productId }}][quantity]" id="hidden-quantity-{{ $productId }}"  class="fw-bold d-hide">Quantity</label>
                                    <input class="d-hide w-100 border-2 rounded-pill px-2 py-1" type="number" name="products[{{ $productId }}][quantity]" id="quantity-input-{{ $productId }}" value="{{ $productDetails['quantity'] ?? 1 }}" min="1">
                                </div>
                                {{-- Edit Product Description --}}
                                <div class="mb-3">
                                    <label for="products[{{ $productId }}][description]" id="hidden-description-{{ $productId }}"  class="fw-bold d-hide">Scope of Work</label>
                                    <textarea name="products[{{ $productId }}][description]" id="description-input-{{ $productId }}">{{ $productDetails['description'] ?? '' }}</textarea>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <x-primary-button class="btn primary-btn text-white rounded-pill px-4 btn-width fw-bold d-hide" type="button" onclick="savePrice('{{ $productId }}')" id="save-button-{{ $productId }}">Save</x-primary-button>
                                </div>
                                

                        </div>
                        @endforeach
                    </div>
                        </div>

    
                        <div class="d-flex justify-content-end align-items-center mt-3">
                            <a href="{{ route('proposals.step4') }}" class="fs-7 fw-bold me-2 btn btn-secondary rounded-pill btn-width">Previous</a>
                            <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill px-4 btn-width fw-bold">Next</x-primary-button>
                        </div>
                    </form>
                </div>
        </div>
        </div>
    </div>
    </div>
</x-layout>