

<?php $__env->startSection('title', 'سرویس جدید'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <h2 style="margin-top:0;">افزودن سرویس جدید</h2>

        <?php if($errors->any()): ?>
            <div class="alert alert-error">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <?php if(empty($availableSlugs)): ?>
            <p style="color:#6b7280;">
                همه‌ی سرویس‌هایی که در کد پیاده‌سازی شدن، از قبل به لیست اضافه شدن.
            </p>
        <?php else: ?>
            <form action="<?php echo e(route('admin.external-services.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <label for="slug">سرویس</label>
                <select id="slug" name="slug" required>
                    <option value="">— انتخاب کنید —</option>
                    <?php $__currentLoopData = $availableSlugs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($slug); ?>" <?php echo e(old('slug') === $slug ? 'selected' : ''); ?>>
                            <?php echo e($label); ?> (<?php echo e($slug); ?>)
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>

                <label for="price">قیمت هر Call (تومن)</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo e(old('price')); ?>" required>

                <label>
                    <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                    فعال
                </label>

                <button type="submit" class="btn btn-primary" style="margin-top:16px;">ذخیره</button>
            </form>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projects\garnetSaaS\resources\views/admin/external-services/create.blade.php ENDPATH**/ ?>