

<?php $__env->startSection('title', 'لاگ فعالیت‌ها'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <h2 style="margin-top:0;">لاگ فعالیت ادمین‌ها</h2>

        <form action="<?php echo e(route('admin.logs.index')); ?>" method="GET"
              style="display:flex; gap:8px; align-items:flex-end; flex-wrap:wrap; margin-bottom:16px;">
            <div>
                <label for="admin_id" style="display:block; font-size:13px; margin-bottom:4px;">ادمین</label>
                <select id="admin_id" name="admin_id" style="min-width:200px;">
                    <option value="">همه</option>
                    <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($admin->id); ?>" <?php echo e((string) $adminId === (string) $admin->id ? 'selected' : ''); ?>>
                            <?php echo e($admin->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">فیلتر</button>
            <?php if($adminId): ?>
                <a href="<?php echo e(route('admin.logs.index')); ?>" class="btn btn-secondary">پاک کردن فیلتر</a>
            <?php endif; ?>
        </form>

        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align:right; border-bottom:1px solid #e5e7eb;">
                    <th style="padding:8px;">تاریخ</th>
                    <th style="padding:8px;">ادمین</th>
                    <th style="padding:8px;">عملیات</th>
                    <th style="padding:8px;">توضیحات</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:8px; white-space:nowrap;"><?php echo e($log->created_at->format('Y-m-d H:i:s')); ?></td>
                        <td style="padding:8px;"><?php echo e($log->admin->name ?? 'حذف‌شده'); ?></td>
                        <td style="padding:8px; font-family:monospace; font-size:12px; color:#6b7280;"><?php echo e($log->action); ?></td>
                        <td style="padding:8px;"><?php echo e($log->description); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="4" style="padding:16px; text-align:center; color:#6b7280;">
                            هنوز هیچ لاگی ثبت نشده.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div style="margin-top:16px;">
            <?php echo e($logs->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\projects\garnetSaaS\resources\views/admin/logs/index.blade.php ENDPATH**/ ?>