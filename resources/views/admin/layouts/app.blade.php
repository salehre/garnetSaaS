<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'پنل مدیریت قیمت‌ها')</title>
    <link rel="icon" type="image/png" href="/favicon.png">
    <style>
                @font-face {
            font-family: 'Peyda Web';
            src: url('{{ asset('fonts/peyda/PeydaWeb-Regular.woff2') }}') format('woff2');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Peyda Web';
            src: url('{{ asset('fonts/peyda/PeydaWeb-Medium.woff2') }}') format('woff2');
            font-weight: 500;
            font-style: normal;
            font-display: swap;
        }
        @font-face {
            font-family: 'Peyda Web';
            src: url('{{ asset('fonts/peyda/PeydaWeb-Bold.woff2') }}') format('woff2');
            font-weight: 700;
            font-style: normal;
            font-display: swap;
        }
        body { font-family: 'Peyda Web', Tahoma, sans-serif; background: #f4f5f7; margin: 0; padding: 0; }
        button, input, select, textarea { font-family: inherit; }
        nav { background: #1f2937; padding: 14px 24px; display: flex; gap: 20px; }
        nav a { color: #e5e7eb; text-decoration: none; font-size: 14px; }
        nav a:hover { color: #fff; }
        .container { max-width: 960px; margin: 24px auto; padding: 0 16px; }
        .card { background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,.08); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px 8px; text-align: right; border-bottom: 1px solid #eee; font-size: 14px; }
        th { color: #6b7280; font-weight: 600; }
        .btn { display: inline-block; padding: 6px 14px; border-radius: 6px; text-decoration: none; font-size: 13px; border: none; cursor: pointer; }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-secondary { background: #e5e7eb; color: #111827; }
        .btn-danger { background: #dc2626; color: #fff; }
        .badge { padding: 2px 8px; border-radius: 999px; font-size: 12px; }
        .badge-active { background: #dcfce7; color: #166534; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
        label { display: block; margin: 12px 0 4px; font-size: 13px; color: #374151; }
        input[type=text] { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; }
        select { width: 100%; padding: 10px 14px; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; }
        .checkbox-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 8px; margin-top: 8px; }
        .checkbox-grid label { display: flex; align-items: center; gap: 6px; font-size: 13px; margin: 0; }
        .alert { padding: 10px 14px; border-radius: 6px; margin-bottom: 16px; font-size: 13px; }
        .alert-success { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>
    <nav style="justify-content: space-between; align-items: center;">
        <div style="display: flex; gap: 20px;">
            <a href="{{ route('admin.dashboard') }}">داشبورد</a>
            <a href="{{ route('admin.customers.index') }}">مشتریان</a>
            <a href="{{ route('admin.currencies.index') }}">ارزها</a>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" style="background:none; border:none; color:#e5e7eb; cursor:pointer; font-size:14px;">خروج</button>
        </form>
    </nav>
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>
