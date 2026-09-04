<?php $__env->startSection('title', 'ارزها'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <h2 style="margin-top:0;">ارزها</h2>
        <p style="color:#6b7280; font-size:13px;">
            لیست ارزها به‌صورت خودکار از پاسخ سرویس تابان گوهر ساخته میشود. این‌جا فقط میتونید نام نمایشی
            و وضعیت هر ارز رو تغییر بدید.
        </p>

        <table>
            <thead>
                <tr>
                    <th>کد (provider)</th>
                    <th>نام نمایشی</th>
                    <th>وضعیت</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><code><?php echo e($currency->code); ?></code></td>
                        <td><?php echo e($currency->label); ?></td>
                        <td>
                            <span class="badge <?php echo e($currency->is_active ? 'badge-active' : 'badge-inactive'); ?>">
                                <?php echo e($currency->is_active ? 'فعال' : 'غیرفعال'); ?>

                            </span>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.currencies.edit', $currency)); ?>" class="btn btn-secondary">ویرایش</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="4">هنوز ارزی ثبت نشده — بعد از اولین اجرای <code>prices:fetch</code> یا seeder اینجا پر می‌شه.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projects\garnetSaaS\resources\views/admin/currencies/index.blade.php ENDPATH**/ ?>