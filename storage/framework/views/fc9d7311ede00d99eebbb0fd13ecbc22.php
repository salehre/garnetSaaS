<?php $__env->startSection('title', 'ویرایش سرویس'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <h2 style="margin-top:0;">ویرایش سرویس: <?php echo e($service->label); ?></h2>

        <p style="font-size:13px; color:#6b7280;">
            Slug: <code><?php echo e($service->slug); ?></code> (غیرقابل‌تغییر، چون به کد پردازش‌کننده وصله)
        </p>

        <form action="<?php echo e(route('admin.external-services.update', $service)); ?>" method="POST">
            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>

            <label for="price">قیمت هر Call (تومن)</label>
            <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo e(old('price', $service->price)); ?>" required>

            <label>
                <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $service->is_active) ? 'checked' : ''); ?>>
                فعال
            </label>

            <button type="submit" class="btn btn-primary" style="margin-top:16px;">ذخیره تغییرات</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\projects\garnetSaaS\resources\views/admin/external-services/edit.blade.php ENDPATH**/ ?>