@extends('admin.layouts.app')

@section('title', 'ویرایش سرویس')

@section('content')
    <div class="card">
        <h2 style="margin-top:0;">{{ $service->label }}</h2>

        <table style="width:100%; border-collapse:collapse; font-size:13px; color:#374151; margin-bottom:16px;">
            <tr>
                <td style="padding:8px 12px; border:1px solid #e5e7eb; color:#6b7280; width:40%;">قیمت خام (از اکسل)</td>
                <td style="padding:8px 12px; border:1px solid #e5e7eb;"><strong>{{ number_format($service->price) }} تومن</strong></td>
            </tr>
            <tr>
                <td style="padding:8px 12px; border:1px solid #e5e7eb; color:#6b7280;">مبلغی که از مشتری کسر می‌شه (×{{ \App\Models\ExternalService::MARKUP_MULTIPLIER }})</td>
                <td style="padding:8px 12px; border:1px solid #e5e7eb;"><strong>{{ number_format($service->chargePrice()) }} تومن</strong></td>
            </tr>
            <tr>
                <td style="padding:8px 12px; border:1px solid #e5e7eb; color:#6b7280;">کد پیاده‌سازی (slug)</td>
                <td style="padding:8px 12px; border:1px solid #e5e7eb;">
                    @if ($service->slug)
                        <code>{{ $service->slug }}</code>
                    @else
                        <span style="color:#9ca3af;">هنوز پیاده‌سازی نشده — تا کد این سرویس نوشته نشه، فعال کردنش اثری نداره.</span>
                    @endif
                </td>
            </tr>
        </table>

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