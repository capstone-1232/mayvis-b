<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'disabled' => false,
    'name',
    'placeholder' => 'YYYY-MM-DD', // Default placeholder if none provided
    'value' => '' // Default value if none provided
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'disabled' => false,
    'name',
    'placeholder' => 'YYYY-MM-DD', // Default placeholder if none provided
    'value' => '' // Default value if none provided
]); ?>
<?php foreach (array_filter(([
    'disabled' => false,
    'name',
    'placeholder' => 'YYYY-MM-DD', // Default placeholder if none provided
    'value' => '' // Default value if none provided
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<input type="date"
       name="<?php echo e($name); ?>"
       placeholder="<?php echo e($placeholder); ?>"
       class="w-full"
       autocomplete="off"
       :value="old($name, $value)" 
       <?php if($disabled): ?> disabled <?php endif; ?> 
>

<?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
       <div class="text-red-600 text-sm"><?php echo e($message); ?></div>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
<?php /**PATH /var/www/html/resources/views/components/date-input.blade.php ENDPATH**/ ?>