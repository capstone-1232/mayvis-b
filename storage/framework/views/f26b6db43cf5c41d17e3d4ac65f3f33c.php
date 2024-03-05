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
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            <?php echo e(__('Proposals')); ?>

        </h2>
     <?php $__env->endSlot(); ?>      

    <script>
        function editPrice(productId) {
            // Toggle visibility for editing price and quantity
            document.getElementById('price-display-' + productId).style.display = 'none';
            document.getElementById('price-input-' + productId).style.display = 'inline';
            document.getElementById('quantity-display-' + productId).style.display = 'none';
            document.getElementById('quantity-input-' + productId).style.display = 'inline';
            document.getElementById('edit-button-' + productId).style.display = 'none';
            document.getElementById('save-button-' + productId).style.display = 'inline';
        }
        
        function savePrice(productId) {
           // Get the input value, removing any formatting like commas or currency symbols
            var priceInputValue = document.getElementById('price-input-' + productId).value.replace(/[^0-9.]/g, '');
            var quantityInputValue = document.getElementById('quantity-input-' + productId).value;

            var newPrice = priceInputValue ? parseFloat(priceInputValue) : 0; // default to 0 if empty
            var newQuantity = quantityInputValue ? parseInt(quantityInputValue) : 1; // default to 1 if empty

            // Update the display with new values
            document.getElementById('price-value-' + productId).innerText = newPrice.toFixed(2);
            document.getElementById('quantity-value-' + productId).innerText = newQuantity;
            
            // Toggle visibility back to normal
            document.getElementById('price-display-' + productId).style.display = 'inline';
            document.getElementById('price-input-' + productId).style.display = 'none';
            document.getElementById('quantity-display-' + productId).style.display = 'inline';
            document.getElementById('quantity-input-' + productId).style.display = 'none';
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

        let recurringTotalText = document.getElementById('recurringTotalDisplay').textContent.replace('$', '').replace(',', '');
        let recurringTotal = parseFloat(recurringTotalText) || 0;

        let proposalTotal = totalPrice + recurringTotal;
        // Format proposal total with 2 decimal places and commas
        document.getElementById('proposalTotalDisplay').textContent = proposalTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
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
                
                <form action="<?php echo e(route('proposals.storeStep5')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <?php $__currentLoopData = $step4Data['selectedProducts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productId => $productDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div id="product-<?php echo e($productId); ?>">
                        <?php echo e($productDetails['name']); ?> - 
                        <span id="price-display-<?php echo e($productId); ?>">
                            <?php if($productDetails['price'] !== 'No Price'): ?>
                                $<span id="price-value-<?php echo e($productId); ?>"><?php echo e(number_format($productDetails['price'], 2)); ?></span>
                            <?php else: ?>
                                Price not available
                            <?php endif; ?>
                        </span>
                        <!-- These inputs are now part of the form submission -->
                        <input type="number" name="products[<?php echo e($productId); ?>][price]" id="price-input-<?php echo e($productId); ?>" style="display:none;" value="<?php echo e($productDetails['price']); ?>" step="0.01">
                        <span id="quantity-display-<?php echo e($productId); ?>"> x <span id="quantity-value-<?php echo e($productId); ?>"><?php echo e($productDetails['quantity'] ?? 1); ?></span></span>
                        <input type="number" name="products[<?php echo e($productId); ?>][quantity]" id="quantity-input-<?php echo e($productId); ?>" style="display:none;" value="<?php echo e($productDetails['quantity'] ?? 1); ?>" min="1">
                        
                        <!-- Edit and Save buttons -->
                        <button type="button" onclick="editPrice('<?php echo e($productId); ?>')" id="edit-button-<?php echo e($productId); ?>">Edit</button>
                        <button type="button" onclick="savePrice('<?php echo e($productId); ?>')" id="save-button-<?php echo e($productId); ?>" style="display:none;">Save</button>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <p>Total Price: $<span id="totalPriceDisplay"><?php echo e(number_format($step4Data['totalPrice'] ?? 0, 2, '.', ',')); ?></span></p>
                    <p>Recurring Total: $<span id="recurringTotalDisplay"><?php echo e(number_format($step4Data['recurringTotal'] ?? 0, 2, '.', ',')); ?></span></p>
                    <p>Proposal Total: $<span id="proposalTotalDisplay"><?php echo e(number_format($step4Data['proposalTotal'] ?? 0, 2, '.', ',')); ?></span></p>


                    <a href="<?php echo e(route('proposals.step4')); ?>" class="btn">Previous</a>
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
<?php /**PATH /var/www/html/resources/views/proposals/step5.blade.php ENDPATH**/ ?>