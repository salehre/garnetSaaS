<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title', 'پنل مدیریت قیمت‌ها'); ?></title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
            @font-face {
            font-family: 'Peyda Web';
            src: url('<?php echo e(asset('fonts/peyda/PeydaWeb-Regular.woff2')); ?>') format('woff2');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Peyda Web';
            src: url('<?php echo e(asset('fonts/peyda/PeydaWeb-Medium.woff2')); ?>') format('woff2');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Peyda Web';
            src: url('<?php echo e(asset('fonts/peyda/PeydaWeb-Bold.woff2')); ?>') format('woff2');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }
        body {
            font-family: 'Peyda Web', Tahoma, sans-serif;
            background: #111827;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        button, input, select, textarea { font-family: inherit; }
        .login-box {
            background: #fff;
            border-radius: 10px;
            padding: 32px;
            width: 100%;
            max-width: 360px;
            box-shadow: 0 10px 30px rgba(0,0,0,.25);
        }
        .login-box h2 { margin: 0 0 20px; font-size: 18px; color: #111827; }
        label { display: block; margin: 12px 0 4px; font-size: 13px; color: #374151; }
        input[type=text], input[type=password] {
            width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box;
         }
        .btn { display: inline-block; border-radius: 6px; text-decoration: none; font-size: 14px; border: none; cursor: pointer; }
        .btn-primary { background: #2563eb; color: #fff; }
        .alert-error { background: #fee2e2; color: #991b1b; padding: 10px 14px; border-radius: 6px; margin-bottom: 12px; font-size: 13px; }
    </style>
</head>
<body>
    <?php echo $__env->yieldContent('content'); ?>
</body>
</html>
<?php /**PATH D:\projects\garnetSaaS\resources\views/admin/layouts/guest.blade.php ENDPATH**/ ?>