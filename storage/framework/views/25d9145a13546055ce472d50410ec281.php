<?php $__env->startSection('title', 'ویرایش مشتری'); ?>

<?php $__env->startSection('content'); ?>
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="margin-top:0;">ویرایش مشتری: <?php echo e($customer->name); ?></h2>
            <a href="<?php echo e(route('admin.customers.chart', $customer)); ?>" class="btn btn-secondary">مشاهده نمودار</a>
        </div>
        <form action="<?php echo e(route('admin.customers.update', $customer)); ?>" method="POST">
            <?php echo method_field('PUT'); ?>
            <?php echo $__env->make('admin.customers._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </div>

    <div class="card">
        <h3 style="margin-top:0;">API Key</h3>

        <?php if(session('status')): ?>
            <div class="alert alert-success"><?php echo e(session('status')); ?></div>
        <?php endif; ?>

        <p style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">
            این کلید ثابت است و تا وقتی که دستی از نو صادر نکنی تغییر نمی‌کند.
            همین را در اختیار مشتری بگذار تا با هدر <code>X-API-KEY</code> در درخواست‌هایش استفاده کند.
        </p>

        <div style="display:flex; gap:8px; align-items:stretch;">
            <input type="text" id="api-key-input" readonly value="<?php echo e($customer->api_key); ?>"
                   style="flex:1; font-family: monospace; background:#f3f4f6; padding:8px; border-radius:6px; border:1px solid #d1d5db;"
                   onclick="this.select();">
            <button type="button" id="copy-api-key-btn" class="btn btn-secondary" onclick="copyApiKey()" title="کپی">
                📋
            </button>
        </div>

        <p style="font-size: 13px; color: #6b7280; margin-top: 12px;">
            دامنه‌ی مجاز فعلی:
            <strong><?php echo e($customer->allowed_domain ?: 'تنظیم نشده (بدون محدودیت دامنه)'); ?></strong>
            — از فرم بالا قابل تغییره.
        </p>

        <form action="<?php echo e(route('admin.customers.regenerate-key', $customer)); ?>" method="POST"
              onsubmit="return confirm('کلید فعلی از کار می‌افتد و مشتری باید کلید جدید را دریافت کند. ادامه می‌دهید؟');"
              style="margin-top: 12px;">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-primary">صدور کلید جدید</button>
        </form>
    </div>

    <div class="card">
        <h3 style="margin-top:0;">کیف‌پول</h3>

        <div style="font-size:28px; font-weight:700; margin-bottom:12px;">
            <?php echo e(number_format($customer->balance)); ?> <span style="font-size:14px; color:#6b7280;">تومن</span>
        </div>

        <form action="<?php echo e(route('admin.customers.credit', $customer)); ?>" method="POST"
              style="display:flex; gap:8px; align-items:flex-end; flex-wrap:wrap;">
            <?php echo csrf_field(); ?>
            <div>
                <label for="amount" style="display:block; font-size:13px; margin-bottom:4px;">مبلغ شارژ (تومن)</label>
                <input type="number" id="amount" name="amount" step="0.01" min="0.01" required style="width:160px;">
            </div>
            <div style="flex:1; min-width:200px;">
                <label for="description" style="display:block; font-size:13px; margin-bottom:4px;">توضیح (اختیاری)</label>
                <input type="text" id="description" name="description" placeholder="مثلاً: واریز نقدی">
            </div>
            <button type="submit" class="btn btn-primary">شارژ موجودی</button>
        </form>
        <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:#dc2626; font-size:12px; margin-top:6px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <?php if($recentTransactions->isNotEmpty()): ?>
            <table style="width:100%; border-collapse:collapse; margin-top:20px;">
                <thead>
                    <tr style="text-align:right; border-bottom:1px solid #e5e7eb; font-size:13px; color:#6b7280;">
                        <th style="padding:6px;">تاریخ</th>
                        <th style="padding:6px;">نوع</th>
                        <th style="padding:6px;">مبلغ</th>
                        <th style="padding:6px;">موجودی پس از تراکنش</th>
                        <th style="padding:6px;">توضیح</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tx): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr style="border-bottom:1px solid #f3f4f6; font-size:13px;">
                            <td style="padding:6px;"><?php echo e($tx->created_at->format('Y-m-d H:i')); ?></td>
                            <td style="padding:6px;">
                                <?php if($tx->type === 'credit'): ?>
                                    <span style="color:#16a34a;">شارژ</span>
                                <?php else: ?>
                                    <span style="color:#dc2626;">کسر</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding:6px;"><?php echo e(number_format($tx->amount)); ?></td>
                            <td style="padding:6px;"><?php echo e(number_format($tx->balance_after)); ?></td>
                            <td style="padding:6px; color:#6b7280;"><?php echo e($tx->description); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="font-size:13px; color:#6b7280; margin-top:16px;">هنوز هیچ تراکنشی ثبت نشده.</p>
        <?php endif; ?>
    </div>

    <script>
        function copyApiKey() {
            const input = document.getElementById('api-key-input');
            const btn = document.getElementById('copy-api-key-btn');
            const original = btn.innerHTML;

            navigator.clipboard.writeText(input.value).then(() => {
                btn.innerHTML = '✅';
                setTimeout(() => { btn.innerHTML = original; }, 1500);
            }).catch(() => {
                input.select();
                document.execCommand('copy');
                btn.innerHTML = '✅';
                setTimeout(() => { btn.innerHTML = original; }, 1500);
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\projects\garnetSaaS\resources\views/admin/customers/edit.blade.php ENDPATH**/ ?>