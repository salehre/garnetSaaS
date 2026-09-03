<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(): View
    {
        $customers = Customer::withCount('currencies')->latest()->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    public function create(): View
    {
        $currencies = Currency::where('is_active', true)->orderBy('label')->get();

        return view('admin.customers.create', compact('currencies'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price_unit' => ['required', 'in:toman,rial'],
            'is_active' => ['nullable', 'boolean'],
            'allowed_domain' => ['nullable', 'string', 'max:255'],
            'currency_ids' => ['nullable', 'array'],
            'currency_ids.*' => ['exists:currencies,id'],
        ]);

        $customer = Customer::create([
            'name' => $validated['name'],
            'price_unit' => $validated['price_unit'],
            'is_active' => $request->boolean('is_active'),
            'allowed_domain' => $validated['allowed_domain'] ?? null,
        ]);

        $customer->currencies()->sync($validated['currency_ids'] ?? []);

        return redirect()
            ->route('admin.customers.index')
            ->with('status', 'مشتری با موفقیت ایجاد شد.');
    }

    public function edit(Customer $customer): View
    {
        $currencies = Currency::where('is_active', true)->orderBy('label')->get();
        $selectedCurrencyIds = $customer->currencies()->pluck('currencies.id')->toArray();

        return view('admin.customers.edit', compact('customer', 'currencies', 'selectedCurrencyIds'));
    }

    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price_unit' => ['required', 'in:toman,rial'],
            'is_active' => ['nullable', 'boolean'],
            'allowed_domain' => ['nullable', 'string', 'max:255'],
            'currency_ids' => ['nullable', 'array'],
            'currency_ids.*' => ['exists:currencies,id'],
        ]);

        $customer->update([
            'name' => $validated['name'],
            'price_unit' => $validated['price_unit'],
            'is_active' => $request->boolean('is_active'),
            'allowed_domain' => $validated['allowed_domain'] ?? null,
        ]);

        $customer->currencies()->sync($validated['currency_ids'] ?? []);

        return redirect()
            ->route('admin.customers.index')
            ->with('status', 'تغییرات ذخیره شد.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()
            ->route('admin.customers.index')
            ->with('status', 'مشتری حذف شد.');
    }

    /**
     * Replace this customer's fixed API key with a new one.
     * Unlike the old Sanctum tokens, this key does NOT change on its own —
     * it only changes when an admin explicitly clicks this action (e.g. the
     * old key leaked). The key stays visible on the edit page at all times
     * (it's not a one-time-reveal secret), since the customer needs to be
     * able to look it up again.
     */
    public function regenerateApiKey(Customer $customer): RedirectResponse
    {
        $customer->api_key = Customer::generateUniqueApiKey();
        $customer->save();

        return redirect()
            ->route('admin.customers.edit', $customer)
            ->with('status', 'API key جدید صادر شد.');
    }
}
