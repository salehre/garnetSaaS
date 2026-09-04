@extends('admin.layouts.app')

@section('title', 'سرویس جدید')

@section('content')
    <div class="card">
        <h2 style="margin-top:0;">افزودن سرویس جدید</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (empty($availableSlugs))
            <p style="color:#6b7280;">
                همه‌ی سرویس‌هایی که در کد پیاده‌سازی شدن، از قبل به لیست اضافه شدن.
            </p>
        @else
            <form action="{{ route('admin.external-services.store') }}" method="POST">
                @csrf

                <label for="slug">سرویس</label>
                <select id="slug" name="slug" required>
                    <option value="">— انتخاب کنید —</option>
                    @foreach ($availableSlugs as $slug => $label)
                        <option value="{{ $slug }}" {{ old('slug') === $slug ? 'selected' : '' }}>
                            {{ $label }} ({{ $slug }})
                        </option>
                    @endforeach
                </select>

                <label for="price">قیمت هر Call (تومن)</label>
                <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price') }}" required>

                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    فعال
                </label>

                <button type="submit" class="btn btn-primary" style="margin-top:16px;">ذخیره</button>
            </form>
        @endif
    </div>
@endsection