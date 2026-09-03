@extends('admin.layouts.app')

@section('title', 'ارزها')

@section('content')
    <div class="card">
        <h2 style="margin-top:0;">ارزها</h2>
        <p style="color:#6b7280; font-size:13px;">
            لیست ارزها به‌صورت خودکار از پاسخ سرویس تابان گوهر ساخته میشود. این‌جا فقط میتونید نام نمایشی
            و وضعیت هر ارز رو تغییر بدید.
        </p>

        <table>
            <thead>
                <tr>
                    <th>کد (provider)</th>
                    <th>نام نمایشی</th>
                    <th>وضعیت</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($currencies as $currency)
                    <tr>
                        <td><code>{{ $currency->code }}</code></td>
                        <td>{{ $currency->label }}</td>
                        <td>
                            <span class="badge {{ $currency->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $currency->is_active ? 'فعال' : 'غیرفعال' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.currencies.edit', $currency) }}" class="btn btn-secondary">ویرایش</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">هنوز ارزی ثبت نشده — بعد از اولین اجرای <code>prices:fetch</code> یا seeder اینجا پر می‌شه.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
