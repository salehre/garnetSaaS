<?php echo csrf_field(); ?>

<label for="name">نام مشتری :</label>
<input type="text" id="name" name="name" value="<?php echo e(old('name', $customer->name ?? '')); ?>" required>
<?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:12px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

<label for="price_unit">واحد قیمت :</label>
<select id="price_unit" name="price_unit">
    <option value="toman" <?php echo e(old('price_unit', $customer->price_unit ?? 'toman') === 'toman' ? 'selected' : ''); ?>>تومن</option>
    <option value="rial" <?php echo e(old('price_unit', $customer->price_unit ?? '') === 'rial' ? 'selected' : ''); ?>>ریال</option>
</select>

<label>
    <input type="checkbox" name="is_active" value="1"
           <?php echo e(old('is_active', $customer->is_active ?? true) ? 'checked' : ''); ?>>
    فعال
</label>

<label for="allowed_domain">دامنه‌ی مجاز :</label>
<input type="text" id="allowed_domain" name="allowed_domain"
       value="<?php echo e(old('allowed_domain', $customer->allowed_domain ?? '')); ?>"
       placeholder="example.com" dir="ltr">
<div style="font-size:12px; color:#6b7280; margin-top:2px;">
  اگه پر بشه، فقط درخواست‌هایی که Origin/Referer‌ شون این دامنه باشه قبول می‌شن (خالی = بدون محدودیت دامنه).
</div>
<?php $__errorArgs = ['allowed_domain'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:12px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

<label style="font-size: 15px;">ارزهای مجاز برای این مشتری</label>
<div class="checkbox-grid">
    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <label>
            <input type="checkbox" name="currency_ids[]" value="<?php echo e($currency->id); ?>"
                   <?php echo e(in_array($currency->id, old('currency_ids', $selectedCurrencyIds ?? [])) ? 'checked' : ''); ?>>
            <?php echo e($currency->label); ?>

        </label>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<label style="margin-top:40px; font-size: 15px; display:block;">سرویس‌های بیرونی مجاز برای این مشتری</label>
<div class="checkbox-grid">
    <?php $__empty_1 = true; $__currentLoopData = $externalServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <label>
            <input type="checkbox" name="external_service_ids[]" value="<?php echo e($service->id); ?>"
                   <?php echo e(in_array($service->id, old('external_service_ids', $selectedServiceIds ?? [])) ? 'checked' : ''); ?>>
            <?php echo e($service->label); ?> (<?php echo e(number_format($service->price)); ?> تومن)
        </label>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <span style="color:#6b7280; font-size:13px;">هنوز هیچ سرویسی تعریف نشده.</span>
    <?php endif; ?>
</div>

<div style="margin-top:20px;">
    <button type="submit" class="btn btn-primary">ذخیره</button>
    <a href="<?php echo e(route('admin.customers.index')); ?>" class="btn btn-secondary">انصراف</a>
</div><?php /**PATH D:\projects\garnetSaaS\resources\views/admin/customers/_form.blade.php ENDPATH**/ ?>