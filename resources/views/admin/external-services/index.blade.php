@extends('admin.layouts.app')

@section('title', 'سرویس‌های بیرونی')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h2 style="margin:0;">سرویس‌های بیرونی (api.ir)</h2>
            <a href="{{ route('admin.external-services.create') }}" class="btn btn-primary">+ سرویس جدید</a>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align:right; border-bottom:1px solid #e5e7eb;">
                    <th style="padding:8px;">نام</th>
                    <th style="padding:8px;">Slug</th>
                    <th style="padding:8px;">قیمت هر Call (تومن)</th>
                    <th style="padding:8px;">وضعیت</th>
                    <th style="padding:8px;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:8px;">{{ $service->label }}</td>
                        <td style="padding:8px; font-family:monospace; color:#6b7280;">{{ $service->slug }}</td>
                        <td style="padding:8px;">{{ number_format($service->price) }}</td>
                        <td style="padding:8px;">
                            @if ($service->is_active)
                                <span style="color:#16a34a;">فعال</span>
                            @else
                                <span style="color:#dc2626;">غیرفعال</span>
                            @endif
                        </td>
                        <td style="padding:8px; text-align:left;">
                            <a href="{{ route('admin.external-services.edit', $service) }}" class="btn btn-secondary">ویرایش</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:16px; text-align:center; color:#6b7280;">
                            هنوز هیچ سرویسی اضافه نشده.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection