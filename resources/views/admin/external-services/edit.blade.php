@extends('admin.layouts.app')

@section('title', 'ویرایش سرویس')

@section('content')
    <div class="card">
        <h2 style="margin-top:0;">{{ $service->label }}</h2>

        <p style="font-size:13px; color:#6b7280;">
            قیمت خام (از اکسل): <strong>{{ number_format($service->price) }} تومن</strong><br>
            مبلغی که از مشتری کسر می‌شه (×{{ \App\Models\ExternalService::MARKUP_MULTIPLIER }}): <strong>{{ number_format($service->chargePrice()) }} تومن</strong>
            (اینجا قابل‌ویرایش نیست، از اکسل میاد)
        </p>

        <p style="font-size:13px; color:#6b7280;">
            کد پیاده‌سازی (slug):
            @if ($service->slug)
                <code>{{ $service->slug }}</code>
            @else
                <span style="color:#9ca3af;">هنوز پیاده‌سازی نشده — تا کد این سرویس نوشته نشه، فعال کردنش اثری نداره.</span>
            @endif
        </p>

        <form action="{{ route('admin.external-services.update', $service) }}" method="POST">
            @method('PUT')
            @csrf

            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                فعال
            </label>

            <button type="submit" class="btn btn-primary" style="margin-top:16px;">ذخیره تغییرات</button>
        </form>
    </div>
@endsection