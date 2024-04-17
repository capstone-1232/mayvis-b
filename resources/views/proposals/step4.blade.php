<x-layout>
    <script>
       let selectedProducts = [];
       let totalPrice = 0;
       
       document.addEventListener('DOMContentLoaded', function() {
            function truncateDescription(description, maxLength) {
                if (description && description.length > maxLength) {
                    return description.substring(0, maxLength) + '...';
                }
                return description;
            }
        
            const searchForm = document.getElementById('searchForm');
        
            searchForm.addEventListener('submit', function(event) {
                event.preventDefault();    
            
                const searchTerm = this.elements['search_term'].value;
            
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
                
                    productsContainer.innerHTML = '';
                
                    data.forEach(product => {
                        const productHTML = `
                            <div class="rounded-4 p-4 mb-3 custom-hover border">
                                <a href="javascript:void(0);" onclick="addToContainer('${product.id}', '${escapeHTML(product.product_name)}', '${product.price}')">
                                    <div class="product-card-title fw-bold">
                                        <div class="d-flex justify-content-between">
                                            <div>${escapeHTML(product.product_name)}</div> <div>$ ${product.price}</div>
                                        </div>
                                    </div>
                                    <div class="product-card-description ms-2">
                                        ${truncateDescription(product.description, 100)}
                                    </div>
                                </a>
                            </div>
                        `;
                        productsContainer.innerHTML += productHTML;
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        
            const categorySelect = document.getElementById('category');
            categorySelect.addEventListener('change', function() {
                const categoryId = this.value;
            
                const filterProductsUrl = "{{ route('proposals.filterProducts') }}";
            
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
                        const productsContainer = document.getElementById('products-container');
                    
                        productsContainer.innerHTML = '';
                    
                        const productsHtml = data.map(product => `
                            <div class="rounded-4 p-4 mb-3 custom-hover border">
                            <a href="javascript:void(0);" onclick="addToContainer('${product.id}', '${escapeHTML(product.product_name)}', '${product.price}')">
                                <div class="product-card-title fw-bold">
                                    <div class="d-flex justify-content-between">
                                        <div>${escapeHTML(product.product_name)}</div> <div>$ ${product.price}</div>
                                    </div>
                                </div>
                                <div class="product-card-description ms-2">
                                    ${truncateDescription(product.description, 100)}
                                </div>
                            </a>
                            </div>
                        `).join('');
                        
                        productsContainer.innerHTML = productsHtml;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
        });

        function escapeHTML(str) {
            return str.replace(/[&<>"']/g, function(match) {
                return {'&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'}[match];
            });
        }

       
       function addToContainer(productId, productName, productPrice) {
       
       if (selectedProducts.includes(productId)) {
       showToast('This product has already been selected.');
       return;
       }
       
       const price = Number(productPrice);
       totalPrice += price;
       document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
       document.getElementById('formTotalPrice').value = totalPrice;
       
       const container = document.getElementById('selectedProductsContainer');
       const productDiv = document.createElement('div');
       productDiv.classList.add('selected-product');
       productDiv.dataset.productId = productId;
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
       selectedProducts.push(productId);
       document.getElementById('selectedProducts').value = selectedProducts.join(',');
       updateProposalTotal();
       showToast('Product added successfully!');
       }
       
       function showToast(message) {
       const toast = document.getElementById('toast');
       toast.textContent = message;
       toast.className = "toast show";
       
       setTimeout(function() { toast.className = toast.className.replace("show", ""); }, 2000);
       }
       
       function updateProposalTotal() {
       
           const proposalTotal = totalPrice;
           document.getElementById('proposalTotal').textContent = proposalTotal.toFixed(2);
           document.getElementById('formProposalTotal').value = proposalTotal;
       }
       
       function deleteSelectedProduct(productId, productPrice) {
       
       const productDiv = document.querySelector(`.selected-product[data-product-id="${productId}"]`);
       if (productDiv) {
           productDiv.remove();
       }
       
       const index = selectedProducts.indexOf(productId);
       if (index !== -1) {
           selectedProducts.splice(index, 1);
           totalPrice -= productPrice;
           document.getElementById('totalPrice').textContent = totalPrice.toFixed(2);
           document.getElementById('formTotalPrice').value = totalPrice;
       }
       
       document.getElementById('selectedProducts').value = selectedProducts.join(',');
       updateProposalTotal();
       }
    </script>
    <div class="content">
       <div class="my-4">
          <div class="container my-4">
             <div id="toast" class="toast">Added to Proposal List</div>
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
             <div class="row mt-5">
                <div class="col-md-8 pe-md-2">
                   <div class="bg-dgray rounded-5 shadow p-4">
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
                            @if ($errors->has('selectedProducts'))
                            <div class="alert alert-danger productserr">
                               {{ $errors->first('selectedProducts') }}
                            </div>
                            @endif
                            <div class="container mt-4">
                                <h3 class="mb-2 fs-5 py-2 fw-bold">Scope of Work</h3>
                                <div id="products-container">
                                    @foreach($products as $product)
                                    <a class="" href="javascript:void(0);" onclick="addToContainer('{{ $product->id }}', '{{ addslashes($product->product_name) }}', '{{ $product->price }}')">
                                        <div class="bg-white rounded-4 p-4 mb-2 border">
                                            <div class="product-card-title fw-bold">
                                                <div class="d-flex justify-content-between">
                                                    <div>{{ $product->product_name }}</div>
                                                    <div>$ {{ $product->price }}</div>
                                                </div>
                                            </div>
                                            <div class="product-card-description ms-2">
                                                {{ Illuminate\Support\Str::limit($product->product_description, 100, '...') }}
                                            </div>
                                        </div>
                                    </a>
                                    @endforeach
                                </div>
                            </div>                            
                      </div>
                   </div>
                </div>
                <div class="col-md-4 pt-sm-3 pt-md-0">
                    <div class="bg-white rounded-5 shadow p-4">
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
                    <div class="d-flex justify-content-end align-items-center mt-3">
                        <a href="{{ route('proposals.step3') }}" class="fs-7 fw-bold me-2 btn btn-secondary rounded-pill btn-width">Prev</a>
                        <x-primary-button type="submit" class="btn primary-btn text-white rounded-pill px-4 btn-width fw-bold">Next</x-primary-button>
                    </div>
                </div>
             </div>
             </form>
          </div>
       </div>
    </div>
    </div>
 </x-layout>