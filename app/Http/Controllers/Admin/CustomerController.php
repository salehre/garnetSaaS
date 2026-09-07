<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customer;
use App\Models\CustomerWalletTransaction;
use App\Models\ExternalService;
use App\Services\AdminLogger;
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
        $externalServices = ExternalService::where('is_active', true)->orderBy('label')->get();

        return view('admin.customers.create', compact('currencies', 'externalServices'));
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
            'external_service_ids' => ['nullable', 'array'],
            'external_service_ids.*' => ['exists:external_services,id'],
        ]);

        $customer = Customer::create([
            'name' => $validated['name'],
            'price_unit' => $validated['price_unit'],
            'is_active' => $request->boolean('is_active'),
            'allowed_domain' => $validated['allowed_domain'] ?? null,
        ]);

        $customer->currencies()->sync($validated['currency_ids'] ?? []);
        $customer->externalServices()->sync($validated['external_service_ids'] ?? []);

        AdminLogger::log('customer.created', "مشتری «{$customer->name}» ساخته شد.");

        return redirect()
            ->route('admin.customers.index')
            ->with('status', 'مشتری با موفقیت ایجاد شد.');
    }

    public function edit(Request $request, Customer $customer): View
    {
        $currencies = Currency::where('is_active', true)->orderBy('label')->get();
        $selectedCurrencyIds = $customer->currencies()->pluck('currencies.id')->toArray();

        $externalServices = ExternalService::where('is_active', true)->orderBy('label')->get();
        $selectedServiceIds = $customer->externalServices()->pluck('external_services.id')->toArray();

        $txType = $request->query('tx_type');
        $txDescription = $request->query('tx_description');

        $transactionsQuery = $customer->walletTransactions()->latest();

        if (in_array($txType, ['credit', 'debit'], true)) {
            $transactionsQuery->where('type', $txType);
        }

        if (filled($txDescription)) {
            $transactionsQuery->where('description', $txDescription);
        }

        $recentTransactions = $transactionsQuery->limit(50)->get();

        // Every distinct description this customer has ever had a transaction
        // for — populates the "توضیح" filter dropdown with real values only.
        $transactionDescriptions = $customer->walletTransactions()
            ->select('description')
            ->distinct()
            ->whereNotNull('description')
            ->orderBy('description')
            ->pluck('description');

        return view('admin.customers.edit', compact(
            'customer',
            'currencies',
            'selectedCurrencyIds',
            'externalServices',
            'selectedServiceIds',
            'recentTransactions',
            'transactionDescriptions',
            'txType',
            'txDescription'
        ));
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
            'external_service_ids' => ['nullable', 'array'],
            'external_service_ids.*' => ['exists:external_services,id'],
        ]);

        $customer->update([
            'name' => $validated['name'],
            'price_unit' => $validated['price_unit'],
            'is_active' => $request->boolean('is_active'),
            'allowed_domain' => $validated['allowed_domain'] ?? null,
        ]);

        $customer->currencies()->sync($validated['currency_ids'] ?? []);
        $customer->externalServices()->sync($validated['external_service_ids'] ?? []);

        AdminLogger::log('customer.updated', "مشتری «{$customer->name}» ویرایش شد.");

        return redirect()
            ->route('admin.customers.index')
            ->with('status', 'تغییرات ذخیره شد.');
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        $name = $customer->name;
        $customer->delete();

        AdminLogger::log('customer.deleted', "مشتری «{$name}» حذف شد.");

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

        AdminLogger::log('customer.api_key_regenerated', "کلید API مشتری «{$customer->name}» صادر مجدد شد.");

        return redirect()
            ->route('admin.customers.edit', $customer)
            ->with('status', 'API key جدید صادر شد.');
    }

    /**
     * Manually add credit to this customer's wallet (e.g. after an offline payment).
     */
    public function creditBalance(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $customer->creditBalance(
            (float) $validated['amount'],
            $validated['description'] ?: 'شارژ دستی توسط ادمین'
        );

        AdminLogger::log(
            'customer.wallet_credited',
            "کیف‌پول مشتری «{$customer->name}» به مبلغ " . number_format((float) $validated['amount']) . ' تومن شارژ شد.'
        );

        return redirect()
            ->route('admin.customers.edit', $customer)
            ->with('status', 'موجودی با موفقیت شارژ شد.');
    }

    /**
     * Delete a wallet transaction and undo its effect on the balance.
     */
    public function deleteTransaction(Customer $customer, CustomerWalletTransaction $transaction): RedirectResponse
    {
        abort_if($transaction->customer_id !== $customer->id, 404);

        $customer->reverseTransaction($transaction);

        AdminLogger::log(
            'customer.wallet_transaction_deleted',
            "یک تراکنش کیف‌پول مشتری «{$customer->name}» حذف و موجودی برگردانده شد."
        );

        return redirect()
            ->route('admin.customers.edit', $customer)
            ->with('status', 'تراکنش حذف و موجودی برگردانده شد.');
    }
}