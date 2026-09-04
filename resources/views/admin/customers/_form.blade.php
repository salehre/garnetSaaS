@csrf

<label for="name">نام مشتری</label>
<input type="text" id="name" name="name" value="{{ old('name', $customer->name ?? '') }}" required>
@error('name') <div style="color:#dc2626; font-size:12px;">{{ $message }}</div> @enderror

<label for="price_unit">واحد قیمت</label>
<select id="price_unit" name="price_unit">
    <option value="toman" {{ old('price_unit', $customer->price_unit ?? 'toman') === 'toman' ? 'selected' : '' }}>تومن</option>
    <option value="rial" {{ old('price_unit', $customer->price_unit ?? '') === 'rial' ? 'selected' : '' }}>ریال</option>
</select>

<label>
    <input type="checkbox" name="is_active" value="1"
           {{ old('is_active', $customer->is_active ?? true) ? 'checked' : '' }}>
    فعال
</label>

<label for="allowed_domain">دامنه‌ی مجاز (اختیاری)</label>
<input type="text" id="allowed_domain" name="allowed_domain"
       value="{{ old('allowed_domain', $customer->allowed_domain ?? '') }}"
       placeholder="example.com">
<div style="font-size:12px; color:#6b7280; margin-top:2px;">
    اگه پر بشه، فقط درخواست‌هایی که Origin/Referer‌شون این دامنه باشه قبول می‌شن. خالی = بدون محدودیت دامنه.
</div>
@error('allowed_domain') <div style="color:#dc2626; font-size:12px;">{{ $message }}</div> @enderror

<label>ارزهای مجاز برای این مشتری</label>
<div class="checkbox-grid">
    @foreach ($currencies as $currency)
        <label>
            <input type="checkbox" name="currency_ids[]" value="{{ $currency->id }}"
                   {{ in_array($currency->id, old('currency_ids', $selectedCurrencyIds ?? [])) ? 'checked' : '' }}>
            {{ $currency->label }}
        </label>
    @endforeach
</div>

<label style="margin-top:16px; display:block;">سرویس‌های بیرونی مجاز برای این مشتری</label>
<div class="checkbox-grid">
    @forelse ($externalServices as $service)
        <label>
            <input type="checkbox" name="external_service_ids[]" value="{{ $service->id }}"
                   {{ in_array($service->id, old('external_service_ids', $selectedServiceIds ?? [])) ? 'checked' : '' }}>
            {{ $service->label }} ({{ number_format($service->price) }} تومن)
        </label>
    @empty
        <span style="color:#6b7280; font-size:13px;">هنوز هیچ سرویسی تعریف نشده.</span>
    @endforelse
</div>

<div style="margin-top:20px;">
    <button type="submit" class="btn btn-primary">ذخیره</button>
    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">انصراف</a>
</div>