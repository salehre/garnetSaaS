@extends('admin.layouts.app')

@section('title', 'سرویس‌های بیرونی')

@section('content')
    <div class="card">
        <h2 style="margin-top:0;">به‌روزرسانی قیمت‌ها از اکسل api.ir</h2>
        <form action="{{ route('admin.external-services.import') }}" method="POST" enctype="multipart/form-data"
              style="display:flex; gap:8px; align-items:flex-end; flex-wrap:wrap;">
            @csrf
            <div style="flex:1; min-width:240px;">
                <input type="file" id="file" name="file" accept=".xlsx,.xls" required>
            </div>
            <button type="submit" class="btn btn-primary">آپلود</button>
        </form>
        @error('file') <div style="color:#dc2626; font-size:12px; margin-top:6px;">{{ $message }}</div> @enderror
        <p style="font-size:14px; color:#6b7280; margin-top:8px;">
           فقط سرویس‌های جدید که توی لیست ما نیستن به‌صورت غیرفعال اضافه می‌شن 
        </p>
    </div>

    <div class="card">
        <h2 style="margin-top:0;">سرویس‌های بیرونی - api.ir</h2>

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
                @forelse ($services as $service)
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:8px;">{{ $service->label }}</td>
                        <td style="padding:8px;">{{ number_format($service->price) }}</td>
                        <td style="padding:8px;">
                            @if ($service->slug)
                                <span style="color:#16a34a; font-family:monospace; font-size:12px;">{{ $service->slug }}</span>
                            @else
                                <span style="color:#9ca3af; font-size:12px;">هنوز پیاده‌سازی نشده</span>
                            @endif
                        </td>
                        <td style="padding:8px;">
                            <span class="badge {{ $service->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $service->is_active ? 'فعال' : 'غیرفعال' }}
                            </span>
                        </td>
                        <td style="padding:8px; text-align:left;">
                            <a href="{{ route('admin.external-services.edit', $service) }}" class="btn btn-secondary">ویرایش</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:16px; text-align:center; color:#6b7280;">
                            هنوز هیچ سرویسی وارد نشده — از فرم بالا یه اکسل آپلود کن.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:16px;">
            {{ $services->links() }}
        </div>
    </div>
@endsection