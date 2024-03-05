<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <?php echo e(__('Proposals')); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    
    <script>
        let selectedProducts = [];


        let totalPrice = 0;
    
        function addToContainer(productId, productName, productPrice) {
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
            const recurringTotal = Number(document.getElementById('recurringTotal').value);
            document.getElementById('displayRecurringTotal').textContent = recurringTotal.toFixed(2);
            document.getElementById('formRecurringTotal').value = recurringTotal; // Update hidden field
    
            const proposalTotal = totalPrice + recurringTotal;
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
                    <?php echo csrf_field(); ?>
                    <form action="<?php echo e(route('proposals.searchProducts')); ?>" method="GET">
                        <div class="input-group">
                            <input type="text" name="search_term" class="form-control" placeholder="Search for products..." aria-label="Search for products" aria-describedby="button-addon2">
                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                        </div>
                    </form>
                </div>
                
                <div class="container mt-4">
                    <?php echo csrf_field(); ?>
                    <form action="<?php echo e(route('proposals.filterProducts')); ?>" method="GET">
                        <h2 class="mt-5">Choose a category</h2>
                        <select name="category_id" id="category" class="form-select" required onchange="this.form.submit()">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e((request()->category_id == $category->id) ? 'selected' : ''); ?>>
                                    <?php echo e($category->category_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </form>
                </div>

                <form action="<?php echo e(route('proposals.storeStep4')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <?php if($errors->has('selectedProducts')): ?>
                        <div class="alert alert-danger productserr">
                            <?php echo e($errors->first('selectedProducts')); ?>

                        </div>
                    <?php endif; ?>
                    
                    <div class="container mt-4">
                        <h2 class="mt-5">Choose a service</h2>
                        <?php if(isset($products) && $products->isNotEmpty()): ?>
                            <div id="products-container">
                                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="product-card">
                                        <div class="product-card-title">
                                            <a href="javascript:void(0);" onclick="addToContainer('<?php echo e($product->id); ?>', '<?php echo e($product->product_name); ?>', '<?php echo e($product->price); ?>')">
                                                <?php echo e($product->product_name); ?> - $<?php echo e($product->price); ?>


                                                
                                            </a>
                                        </div>
                                        <div class="product-card-description">
                                            <?php echo e($product->product_description); ?>

                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <div id="selectedProductsContainer" class="selected-products-container">
                                    <h3>Summary:</h3>

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
                        <?php endif; ?>


                        <input type="hidden" name="selectedProducts" id="selectedProducts" value="">
                        <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['type' => 'hidden','name' => 'totalPrice','id' => 'formTotalPrice','value' => '0']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'hidden','name' => 'totalPrice','id' => 'formTotalPrice','value' => '0']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                        <input type="hidden" name="recurringTotal" id="formRecurringTotal" value="0">
                        <input type="hidden" name="proposalTotal" id="formProposalTotal" value="0">
                        
                        <div class="row mb-3">
                            <div class="col-sm-10 offset-sm-2">
                                <a href="<?php echo e(route('proposals.step3')); ?>">Previous</a>
                                <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['type' => 'submit','class' => 'btn btn-primary mt-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'btn btn-primary mt-6']); ?>Next <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/proposals/step4.blade.php ENDPATH**/ ?>