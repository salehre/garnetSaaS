@extends('admin.layouts.app')

@section('title', 'ویرایش مشتری')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h3 style="margin-top:0;">ویرایش مشتری</h3>
            <a href="{{ route('admin.customers.chart', $customer) }}" class="btn btn-secondary">مشاهده نمودار</a>
        </div>
        <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
            @method('PUT')
            @include('admin.customers._form')
        </form>
    </div>

    <div class="card">
        <h3 style="margin-top:0;">API Key</h3>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <p style="font-size: 13px; color: #6b7280; margin-bottom: 4px;">
            این کلید ثابت است و تا وقتی که دستی از نو صادر نکنی تغییر نمی‌کند.
            همین را در اختیار مشتری بگذار تا با هدر <code>X-API-KEY</code> در درخواست‌هایش استفاده کند.
        </p>

        <div style="position:relative; display:flex; align-items:center;">
            <input id="apiKeyInput" type="text" readonly value="{{ $customer->api_key }}"
                   style="width:100%; font-family: monospace; background:#f3f4f6; padding:8px 40px 8px 8px; border-radius:6px; border:1px solid #d1d5db; box-sizing:border-box;"
                   onclick="this.select();">
            <button type="button" onclick="copyApiKey(this)"
                    title="کپی کلید"
                    style="position:absolute; left:6px; background:none; border:none; cursor:pointer; padding:4px; display:flex; align-items:center; color:#6b7280;">
                <svg id="copyIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="9" y="9" width="13" height="13" rx="2"></rect>
                    <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                </svg>
            </button>
        </div>
        <script>
            function copyApiKey(btn) {
                const input = document.getElementById('apiKeyInput');
                input.select();
                navigator.clipboard.writeText(input.value).then(() => {
                    const icon = document.getElementById('copyIcon');
                    const original = icon.innerHTML;
                    icon.innerHTML = '<polyline points="20 6 9 17 4 12"></polyline>';
                    btn.style.color = '#16a34a';
                    setTimeout(() => {
                        icon.innerHTML = original;
                        btn.style.color = '#6b7280';
                    }, 1500);
                });
            }
        </script>

        <p style="font-size: 13px; color: #6b7280; margin-top: 12px;">
            دامنه‌ی مجاز فعلی:
            <strong>{{ $customer->allowed_domain ?: 'تنظیم نشده (بدون محدودیت دامنه)' }}</strong>
            — از فرم بالا قابل تغییر است
        </p>

        <form action="{{ route('admin.customers.regenerate-key', $customer) }}" method="POST"
              onsubmit="return confirm('کلید فعلی از کار می‌افتد و مشتری باید کلید جدید را دریافت کند. ادامه می‌دهید؟');"
              style="margin-top: 12px;">
            @csrf
            <button type="submit" class="btn btn-primary">صدور کلید جدید</button>
        </form>
    </div>
@endsection