@extends('admin.layouts.app')

@section('title', 'لاگ فعالیت‌ها')

@section('content')
    <div class="card">
        <h2 style="margin-top:0;">لاگ فعالیت ادمین‌ها</h2>

        <form action="{{ route('admin.logs.index') }}" method="GET"
              style="display:flex; gap:8px; align-items:flex-end; flex-wrap:wrap; margin-bottom:16px;">
            <div>
                <label for="admin_id" style="display:block; font-size:13px; margin-bottom:4px;">ادمین</label>
                <select id="admin_id" name="admin_id" style="min-width:200px;">
                    <option value="">همه</option>
                    @foreach ($admins as $admin)
                        <option value="{{ $admin->id }}" {{ (string) $adminId === (string) $admin->id ? 'selected' : '' }}>
                            {{ $admin->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">فیلتر</button>
            @if ($adminId)
                <a href="{{ route('admin.logs.index') }}" class="btn btn-secondary">پاک کردن فیلتر</a>
            @endif
        </form>

        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align:right; border-bottom:1px solid #e5e7eb;">
                    <th style="padding:8px;">تاریخ</th>
                    <th style="padding:8px;">ادمین</th>
                    <th style="padding:8px;">عملیات</th>
                    <th style="padding:8px;">توضیحات</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:8px; white-space:nowrap;">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                        <td style="padding:8px;">{{ $log->admin->name ?? 'حذف‌شده' }}</td>
                        <td style="padding:8px; font-family:monospace; font-size:12px; color:#6b7280;">{{ $log->action }}</td>
                        <td style="padding:8px;">{{ $log->description }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding:16px; text-align:center; color:#6b7280;">
                            هنوز هیچ لاگی ثبت نشده.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:16px;">
            {{ $logs->links() }}
        </div>
    </div>
@endsection