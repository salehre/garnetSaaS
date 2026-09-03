@extends('admin.layouts.app')

@section('title', 'مشتریان')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <h2 style="margin:0;">مشتریان</h2>
            <a href="{{ route('admin.customers.create') }}" class="btn btn-primary"> مشتری جدید</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>نام</th>
                    <th>واحد قیمت</th>
                    <th>تعداد ارزهای مجاز</th>
                    <th>وضعیت</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->price_unit === 'rial' ? 'ریال' : 'تومن' }}</td>
                        <td>{{ $customer->currencies_count }}</td>
                        <td>
                            <span class="badge {{ $customer->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $customer->is_active ? 'فعال' : 'غیرفعال' }}
                            </span>
                        </td>
                        <td style="display:flex; gap:6px;">
                            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-secondary">ویرایش</a>
                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST"
                                  onsubmit="return confirm('مطمئنی می‌خوای این مشتری حذف بشه؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">حذف</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">هنوز مشتری‌ای ثبت نشده.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div style="margin-top:16px;">{{ $customers->links() }}</div>
    </div>
@endsection
