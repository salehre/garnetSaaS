<?php $__env->startSection('title', 'ویرایش سرویس'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <h2 style="margin-top:0;"><?php echo e($service->label); ?></h2>

        <table style="width:100%; border-collapse:collapse; font-size:13px; color:#374151; margin-bottom:16px;">
            <tr>
                <td style="padding:8px 12px; border:1px solid #e5e7eb; color:#6b7280; width:40%;">قیمت خام (از اکسل)</td>
                <td style="padding:8px 12px; border:1px solid #e5e7eb;"><strong><?php echo e(number_format($service->price)); ?> تومن</strong></td>
            </tr>
            <tr>
                <td style="padding:8px 12px; border:1px solid #e5e7eb; color:#6b7280;">مبلغی که از مشتری کسر می‌شه (×<?php echo e(\App\Models\ExternalService::MARKUP_MULTIPLIER); ?>)</td>
                <td style="padding:8px 12px; border:1px solid #e5e7eb;"><strong><?php echo e(number_format($service->chargePrice())); ?> تومن</strong></td>
            </tr>
            <tr>
                <td style="padding:8px 12px; border:1px solid #e5e7eb; color:#6b7280;">کد پیاده‌سازی (slug)</td>
                <td style="padding:8px 12px; border:1px solid #e5e7eb;">
                    <?php if($service->slug): ?>
                        <code><?php echo e($service->slug); ?></code>
                    <?php else: ?>
                        <span style="color:#9ca3af;">هنوز پیاده‌سازی نشده — تا کد این سرویس نوشته نشه، فعال کردنش اثری نداره.</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <form action="<?php echo e(route('admin.external-services.update', $service)); ?>" method="POST">
            <?php echo method_field('PUT'); ?>
            <?php echo csrf_field(); ?>

            <label>
                <input type="checkbox" name="is_active" value="1" <?php echo e(old('is_active', $service->is_active) ? 'checked' : ''); ?>>
                فعال
            </label>

            <button type="submit" class="btn btn-primary" style="margin-top:16px;">ذخیره تغییرات</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\projects\garnetSaaS\resources\views/admin/external-services/edit.blade.php ENDPATH**/ ?>