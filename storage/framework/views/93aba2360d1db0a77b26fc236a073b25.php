

<?php $__env->startSection('title', 'سرویس‌های بیرونی'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h2 style="margin:0;">سرویس‌های بیرونی - API.ir</h2>
            <a href="<?php echo e(route('admin.external-services.create')); ?>" class="btn btn-primary">سرویس جدید</a>
        </div>

        <?php if(session('status')): ?>
            <div class="alert alert-success"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align:right; border-bottom:1px solid #e5e7eb;">
                    <th style="padding:8px;">نام</th>
                    <th style="padding:8px;">Slug</th>
                    <th style="padding:8px;">قیمت هر Call (تومن)</th>
                    <th style="padding:8px;">وضعیت</th>
                    <th style="padding:8px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:8px;"><?php echo e($service->label); ?></td>
                        <td style="padding:8px; font-family:monospace; color:#6b7280;"><?php echo e($service->slug); ?></td>
                        <td style="padding:8px;"><?php echo e(number_format($service->price)); ?></td>
                        <td style="padding:8px;">
                            <!-- <?php if($service->is_active): ?>
                                <span style="color:#16a34a;">فعال</span>
                            <?php else: ?>
                                <span style="color:#dc2626;">غیرفعال</span>
                            <?php endif; ?> -->
                            <span class="badge <?php echo e($service->is_active ? 'badge-active' : 'badge-inactive'); ?>">
                                <?php echo e($service->is_active ? 'فعال' : 'غیرفعال'); ?>

</span>
                        </td>
                        <td style="padding:8px; text-align:left;">
                            <a href="<?php echo e(route('admin.external-services.edit', $service)); ?>" class="btn btn-secondary">ویرایش</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" style="padding:16px; text-align:center; color:#6b7280;">
                            هنوز هیچ سرویسی اضافه نشده.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projects\garnetSaaS\resources\views/admin/external-services/index.blade.php ENDPATH**/ ?>