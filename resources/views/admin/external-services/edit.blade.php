@extends('admin.layouts.app')

@section('title', 'ویرایش سرویس')

@section('content')
    <div class="card">
        <h2 style="margin-top:0;">ویرایش سرویس: {{ $service->label }}</h2>

        <p style="font-size:13px; color:#6b7280;">
            Slug: <code>{{ $service->slug }}</code> (غیرقابل‌تغییر، چون به کد پردازش‌کننده وصله)
        </p>

        <form action="{{ route('admin.external-services.update', $service) }}" method="POST">
            @method('PUT')
            @csrf

            <label for="price">قیمت هر Call (تومن)</label>
            <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', $service->price) }}" required>

            <label>
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                فعال
            </label>

            <button type="submit" class="btn btn-primary" style="margin-top:16px;">ذخیره تغییرات</button>
        </form>
    </div>
@endsection