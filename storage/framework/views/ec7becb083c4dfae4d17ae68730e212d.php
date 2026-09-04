<?php $__env->startSection('title', 'ویرایش ارز'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <h2 style="margin-top:0; text-align:left;"> <?php echo e($currency->code); ?> </h2>
        <form action="<?php echo e(route('admin.currencies.update', $currency)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <label for="label">نام نمایشی</label>
            <input type="text" id="label" name="label" value="<?php echo e(old('label', $currency->label)); ?>" required>

            <label>
                <input type="checkbox" name="is_active" value="1"
                       <?php echo e(old('is_active', $currency->is_active) ? 'checked' : ''); ?>>
                فعال
            </label>

            <div style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">ذخیره</button>
                <a href="<?php echo e(route('admin.currencies.index')); ?>" class="btn btn-secondary">انصراف</a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projects\garnetSaaS\resources\views/admin/currencies/edit.blade.php ENDPATH**/ ?>