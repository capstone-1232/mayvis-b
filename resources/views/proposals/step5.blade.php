<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Proposals') }}
        </h2>
    </x-slot>      

    <script>
        function editPrice(productId) {
            // Toggle visibility for editing price and quantity
            document.getElementById('price-display-' + productId).style.display = 'none';
            document.getElementById('price-input-' + productId).style.display = 'inline';
            document.getElementById('quantity-display-' + productId).style.display = 'none';
            document.getElementById('quantity-input-' + productId).style.display = 'inline';
            document.getElementById('description-display-' + productId).style.display = 'none';
            document.getElementById('description-input-' + productId).style.display = 'inline';
            document.getElementById('edit-button-' + productId).style.display = 'none';
            document.getElementById('save-button-' + productId).style.display = 'inline';
        }
        
        function savePrice(productId) {
           // Get the input value, removing any formatting like commas or currency symbols
            var priceInputValue = document.getElementById('price-input-' + productId).value.replace(/[^0-9.]/g, '');
            var quantityInputValue = document.getElementById('quantity-input-' + productId).value;
            var descriptionInputValue = document.getElementById('description-input-' + productId).value;

            var newPrice = priceInputValue ? parseFloat(priceInputValue) : 0; // default to 0 if empty
            var newQuantity = quantityInputValue ? parseInt(quantityInputValue) : 1; // default to 1 if empty

            // Update the display with new values
            document.getElementById('price-value-' + productId).innerText = newPrice.toFixed(2);
            document.getElementById('quantity-value-' + productId).innerText = newQuantity;
            document.getElementById('description-value-' + productId).innerText = descriptionInputValue;
            
            // Toggle visibility back to normal
            document.getElementById('price-display-' + productId).style.display = 'inline';
            document.getElementById('price-input-' + productId).style.display = 'none';
            document.getElementById('quantity-display-' + productId).style.display = 'inline';
            document.getElementById('quantity-input-' + productId).style.display = 'none';
            document.getElementById('description-display-' + productId).style.display = 'inline';
            document.getElementById('description-input-' + productId).style.display = 'none';
            document.getElementById('edit-button-' + productId).style.display = 'inline';
            document.getElementById('save-button-' + productId).style.display = 'none';

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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 mt-2 bg-white border-b border-gray-200 shadow-sm sm:rounded-lg">
                <div class="container my-4">
                    <ul class="step-progress-bar">
                        <li>Client</li>
                        <li>Title</li>
                        <li>Message</li>
                        <li>Deliverables</li>
                        <li>Finalize</li>
                    </ul>
                </div>

                <div class="my-4">
                    <div>
                        <h1 class="text-3xl">Customize and Review</h1>
                    </div>
                </div>
                
                <form action="{{ route('proposals.storeStep5') }}" method="POST">
                    @csrf
                    {{-- Your loop to display product details --}}
                    @foreach($step4Data['selectedProducts'] as $productId => $productDetails)
                    <div id="product-{{ $productId }}">
                        {{ $productDetails['name'] }} - 
                        <span id="price-display-{{ $productId }}">
                            @if($productDetails['price'] !== 'No Price')
                                $<span id="price-value-{{ $productId }}">{{ number_format($productDetails['price'], 2) }}</span>
                            @else
                                Price not available
                            @endif
                        </span>
                        <!-- These inputs are now part of the form submission -->
                        <input type="number" name="products[{{ $productId }}][price]" id="price-input-{{ $productId }}" style="display:none;" value="{{ $productDetails['price'] }}" step="0.01">
                        <span id="quantity-display-{{ $productId }}"> x <span id="quantity-value-{{ $productId }}">{{ $productDetails['quantity'] ?? 1 }}</span></span>
                        <input type="number" name="products[{{ $productId }}][quantity]" id="quantity-input-{{ $productId }}" style="display:none;" value="{{ $productDetails['quantity'] ?? 1 }}" min="1">
                        <br>
                        <span id="description-display-{{ $productId }}"><span id="description-value-{{ $productId }}">{{ $productDetails['description'] ?? '' }}</span></span>
                        <textarea name="products[{{ $productId }}][description]" id="description-input-{{ $productId }}" style="display:none;">{{ $productDetails['description'] ?? '' }}</textarea>
                        
                        <!-- Edit and Save buttons -->
                        <x-primary-button type="button" onclick="editPrice('{{ $productId }}')" id="edit-button-{{ $productId }}">Edit</x-primary-button>
                        <x-primary-button type="button" onclick="savePrice('{{ $productId }}')" id="save-button-{{ $productId }}" style="display:none;">Save</x-primary-button>
                    </div>
                    @endforeach

                    {{-- Display totals and other information --}}
                    <p>Total Price: $<span id="totalPriceDisplay">{{ number_format($step4Data['totalPrice'] ?? 0, 2, '.', ',') }}</span></p>
                    <p>Proposal Total: $<span id="proposalTotalDisplay">{{ number_format($step4Data['proposalTotal'] ?? 0, 2, '.', ',') }}</span></p>


                    <a href="{{ route('proposals.step4') }}" class="btn">Previous</a>
                    <x-primary-button type="submit" class="btn btn-primary mt-6">Next</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
