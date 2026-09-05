<?php $__env->startSection('title', 'داشبورد'); ?>

<?php $__env->startSection('content'); ?>
    <h2 style="margin-bottom: 16px;">داشبورد</h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <div class="card">
            <div style="font-size: 13px; color: #6b7280;">تعداد مشتریان</div>
            <div style="font-size: 28px; font-weight: 700; margin-top: 6px;"><?php echo e($customersCount); ?></div>
        </div>
        <div class="card">
            <div style="font-size: 13px; color: #6b7280;">تعداد کل ارزها</div>
            <div style="font-size: 28px; font-weight: 700; margin-top: 6px;"><?php echo e($currenciesCount); ?></div>
        </div>
        <div class="card">
            <div style="font-size: 13px; color: #6b7280;">ارزهای فعال</div>
            <div style="font-size: 28px; font-weight: 700; margin-top: 6px;"><?php echo e($activeCurrenciesCount); ?></div>
        </div>
        <div class="card">
            <div style="font-size: 13px; color: #6b7280;">سرویس‌های فعال</div>
            <div style="font-size: 28px; font-weight: 700; margin-top: 6px;"><?php echo e($activeServicesCount); ?></div>
        </div>
    </div>

    <div class="card" style="margin-top: 20px;">
        <a href="<?php echo e(route('admin.customers.index')); ?>" class="btn btn-primary">مدیریت مشتریان</a>
        <a href="<?php echo e(route('admin.currencies.index')); ?>" class="btn btn-secondary" style="margin-inline-start: 8px;">مدیریت ارزها</a>
        <a href="<?php echo e(route('admin.external-services.index')); ?>" class="btn btn-secondary" style="margin-inline-start: 8px;">مدیریت سرویس‌ها</a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\projects\garnetSaaS\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>