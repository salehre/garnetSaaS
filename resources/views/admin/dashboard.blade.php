@extends('admin.layouts.app')

@section('title', 'داشبورد')

@section('content')
    <h2 style="margin-bottom: 16px;">داشبورد</h2>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <div class="card">
            <div style="font-size: 13px; color: #6b7280;">تعداد مشتریان</div>
            <div style="font-size: 28px; font-weight: 700; margin-top: 6px;">{{ $customersCount }}</div>
        </div>
        <div class="card">
            <div style="font-size: 13px; color: #6b7280;">تعداد کل ارزها</div>
            <div style="font-size: 28px; font-weight: 700; margin-top: 6px;">{{ $currenciesCount }}</div>
        </div>
        <div class="card">
            <div style="font-size: 13px; color: #6b7280;">ارزهای فعال</div>
            <div style="font-size: 28px; font-weight: 700; margin-top: 6px;">{{ $activeCurrenciesCount }}</div>
        </div>
        <div class="card">
            <div style="font-size: 13px; color: #6b7280;">سرویس‌های فعال</div>
            <div style="font-size: 28px; font-weight: 700; margin-top: 6px;">{{ $activeServicesCount }}</div>
        </div>
    </div>

    <div class="card" style="margin-top: 20px;">
        <a href="{{ route('admin.customers.index') }}" class="btn btn-primary">مدیریت مشتریان</a>
        <a href="{{ route('admin.currencies.index') }}" class="btn btn-secondary" style="margin-inline-start: 8px;">مدیریت ارزها</a>
        <a href="{{ route('admin.external-services.index') }}" class="btn btn-secondary" style="margin-inline-start: 8px;">مدیریت سرویس‌ها</a>
    </div>
@endsection
