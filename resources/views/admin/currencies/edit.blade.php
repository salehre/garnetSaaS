@extends('admin.layouts.app')

@section('title', 'ویرایش ارز')

@section('content')
    <div class="card">
        <h2 style="margin-top:0; text-align:left;"> {{ $currency->code }} </h2>
        <form action="{{ route('admin.currencies.update', $currency) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="label">نام نمایشی</label>
            <input type="text" id="label" name="label" value="{{ old('label', $currency->label) }}" required>

            <label>
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $currency->is_active) ? 'checked' : '' }}>
                فعال
            </label>

            <div style="margin-top:20px;">
                <button type="submit" class="btn btn-primary">ذخیره</button>
                <a href="{{ route('admin.currencies.index') }}" class="btn btn-secondary">انصراف</a>
            </div>
        </form>
    </div>
@endsection
