<?php $__env->startSection('title', 'ورود به پنل مدیریت'); ?>

<?php $__env->startSection('content'); ?>
    <div class="login-box">
        <h2>ورود به پنل مدیریت</h2>

        <?php if($errors->any()): ?>
            <div class="alert alert-error">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('admin.login')); ?>">
            <?php echo csrf_field(); ?>

            <label for="email">ایمیل</label>
            <input type="text" id="email" name="email" value="<?php echo e(old('email')); ?>" autofocus>

            <label for="password">رمز عبور</label>
            <input type="password" id="password" name="password">

            <label style="display:flex; align-items:center; gap:6px; margin-top:16px;">
                <input type="checkbox" name="remember" style="width:auto;"> مرا به خاطر بسپار
            </label>

            <button type="submit" class="btn btn-primary" style="width:100%; margin-top:20px; padding:10px;">
                ورود
            </button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\projects\garnetSaaS\resources\views/admin/auth/login.blade.php ENDPATH**/ ?>