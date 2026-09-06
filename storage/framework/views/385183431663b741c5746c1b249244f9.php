<?php $__env->startSection('title', 'سرویس‌های بیرونی'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <h2 style="margin-top:0;">به‌روزرسانی قیمت‌ها از اکسل api.ir</h2>
        <form action="<?php echo e(route('admin.external-services.import')); ?>" method="POST" enctype="multipart/form-data"
              style="display:flex; gap:8px; align-items:flex-end; flex-wrap:wrap;">
            <?php echo csrf_field(); ?>
            <div style="flex:1; min-width:240px;">
                <label for="file">فایل اکسل (.xlsx)</label>
                <input type="file" id="file" name="file" accept=".xlsx,.xls" required>
            </div>
            <button type="submit" class="btn btn-primary">آپلود و به‌روزرسانی</button>
        </form>
        <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:12px; margin-top:6px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <p style="font-size:12px; color:#6b7280; margin-top:8px;">
            سرویس‌های جدید که توی لیست ما نیستن، به‌صورت غیرفعال اضافه می‌شن. سرویس‌های موجود فقط قیمتشون آپدیت می‌شه — وضعیت فعال/غیرفعال و کدشون دست نمی‌خوره.
        </p>
    </div>

    <div class="card">
        <h2 style="margin-top:0;">سرویس‌های بیرونی (api.ir)</h2>

        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align:right; border-bottom:1px solid #e5e7eb;">
                    <th style="padding:8px;">نام</th>
                    <th style="padding:8px;">قیمت هر Call (تومن)</th>
                    <th style="padding:8px;">کد پیاده‌سازی</th>
                    <th style="padding:8px;">وضعیت</th>
                    <th style="padding:8px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:8px;"><?php echo e($service->label); ?></td>
                        <td style="padding:8px;">
                            <?php echo e(number_format($service->price)); ?>

                            <span style="color:#9ca3af; font-size:11px;">(مشتری: <?php echo e(number_format($service->chargePrice())); ?>)</span>
                        </td>
                        <td style="padding:8px;">
                            <?php if($service->slug): ?>
                                <span style="color:#16a34a; font-family:monospace; font-size:12px;"><?php echo e($service->slug); ?></span>
                            <?php else: ?>
                                <span style="color:#9ca3af; font-size:12px;">هنوز پیاده‌سازی نشده</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding:8px;">
                            <?php if($service->is_active): ?>
                                <span style="color:#16a34a;">فعال</span>
                            <?php else: ?>
                                <span style="color:#dc2626;">غیرفعال</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding:8px; text-align:left;">
                            <a href="<?php echo e(route('admin.external-services.edit', $service)); ?>" class="btn btn-secondary">ویرایش</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" style="padding:16px; text-align:center; color:#6b7280;">
                            هنوز هیچ سرویسی وارد نشده — از فرم بالا یه اکسل آپلود کن.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div style="margin-top:16px;">
            <?php echo e($services->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\projects\garnetSaaS\resources\views/admin/external-services/index.blade.php ENDPATH**/ ?>