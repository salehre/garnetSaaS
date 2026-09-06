<?php $__env->startSection('title', 'مشتریان'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h2 style="margin:0;">مشتریان</h2>
            <a href="<?php echo e(route('admin.customers.create')); ?>" class="btn btn-primary"> مشتری جدید</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>نام</th>
                    <th>واحد قیمت</th>
                    <th>تعداد ارزهای مجاز</th>
                    <th>وضعیت</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($customer->name); ?></td>
                        <td><?php echo e($customer->price_unit === 'rial' ? 'ریال' : 'تومن'); ?></td>
                        <td><?php echo e($customer->currencies_count); ?></td>
                        <td>
                            <span class="badge <?php echo e($customer->is_active ? 'badge-active' : 'badge-inactive'); ?>">
                                <?php echo e($customer->is_active ? 'فعال' : 'غیرفعال'); ?>

                            </span>
                        </td>
                        <td style="display:flex; gap:6px;">
                            <a href="<?php echo e(route('admin.customers.edit', $customer)); ?>" class="btn btn-secondary">ویرایش</a>
                            <form action="<?php echo e(route('admin.customers.destroy', $customer)); ?>" method="POST"
                                  onsubmit="return confirm('مطمئنی می‌خوای این مشتری حذف بشه؟');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5">هنوز مشتری‌ای ثبت نشده.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div style="margin-top:16px;"><?php echo e($customers->links()); ?></div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\projects\garnetSaaS\resources\views/admin/customers/index.blade.php ENDPATH**/ ?>