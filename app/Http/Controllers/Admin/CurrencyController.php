<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CurrencyController extends Controller
{
    public function index(): View
    {
        $currencies = Currency::orderBy('label')->get();

        return view('admin.currencies.index', compact('currencies'));
    }

    public function edit(Currency $currency): View
    {
        return view('admin.currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency): RedirectResponse
    {
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $currency->update([
            'label' => $validated['label'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.currencies.index')
            ->with('status', 'ارز به‌روزرسانی شد.');
    }
}
