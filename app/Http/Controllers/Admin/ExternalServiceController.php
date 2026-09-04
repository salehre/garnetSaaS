<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExternalService;
use App\Services\ExternalApi\ExternalServiceRegistry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExternalServiceController extends Controller
{
    public function index(): View
    {
        $services = ExternalService::orderBy('label')->get();

        return view('admin.external-services.index', compact('services'));
    }

    public function create(): View
    {
        $existingSlugs = ExternalService::pluck('slug')->toArray();

        // Only offer slugs that (a) we actually have a handler for, and
        // (b) don't already have a row in the table (slug is unique).
        $availableSlugs = array_diff_key(ExternalServiceRegistry::all(), array_flip($existingSlugs));

        return view('admin.external-services.create', compact('availableSlugs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'slug' => ['required', 'string', 'unique:external_services,slug'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if (!ExternalServiceRegistry::has($validated['slug'])) {
            return back()->withErrors(['slug' => 'این سرویس هنوز در کد پیاده‌سازی نشده.'])->withInput();
        }

        ExternalService::create([
            'slug' => $validated['slug'],
            'label' => ExternalServiceRegistry::labelFor($validated['slug']),
            'price' => $validated['price'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.external-services.index')
            ->with('status', 'سرویس با موفقیت اضافه شد.');
    }

    public function edit(ExternalService $externalService): View
    {
        return view('admin.external-services.edit', ['service' => $externalService]);
    }

    public function update(Request $request, ExternalService $externalService): RedirectResponse
    {
        $validated = $request->validate([
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $externalService->update([
            'price' => $validated['price'],
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.external-services.index')
            ->with('status', 'تغییرات ذخیره شد.');
    }

    public function destroy(ExternalService $externalService): RedirectResponse
    {
        $externalService->delete();

        return redirect()
            ->route('admin.external-services.index')
            ->with('status', 'سرویس حذف شد.');
    }
}