<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExternalService;
use App\Services\ExternalApi\ExternalServiceRegistry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExternalServiceController extends Controller
{
    public function index(): View
    {
        $services = ExternalService::orderBy('label')->paginate(30);

        return view('admin.external-services.index', compact('services'));
    }

    public function edit(ExternalService $externalService): View
    {
        return view('admin.external-services.edit', ['service' => $externalService]);
    }

    public function update(Request $request, ExternalService $externalService): RedirectResponse
    {
        $externalService->update([
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('admin.external-services.index')
            ->with('status', 'تغییرات ذخیره شد.');
    }

    /**
     * Import/update prices from the api.ir price sheet.
     * Matches purely on the "نام سرویس (کلید مچ کردن)" column — creates a new
     * (inactive, slug-less) row for anything we don't have yet, and just
     * refreshes the price for rows that already exist. Never touches
     * `slug` or `is_active` on existing rows.
     */
    public function importPrices(Request $request): RedirectResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ]);

        $spreadsheet = IOFactory::load($request->file('file')->getRealPath());
        $rows = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);

        $created = 0;
        $updated = 0;

        foreach ($rows as $row) {
            // Columns: [0]=ردیف, [1]=نام سرویس (کلید مچ کردن), [2]=قیمت هر Call, [3]=نام API
            $matchKey = trim((string) ($row[1] ?? ''));
            $price = $row[2] ?? null;

            if ($matchKey === '' || !is_numeric($price)) {
                continue; // title/subtitle/header rows, or malformed lines
            }

            $service = ExternalService::where('match_key', $matchKey)->first();
            $slug = ExternalServiceRegistry::slugForMatchKey($matchKey);

            if ($service) {
                $service->update([
                    'price' => (float) $price,
                    'slug' => $slug ?? $service->slug,
                ]);
                $updated++;
            } else {
                ExternalService::create([
                    'match_key' => $matchKey,
                    'label' => $matchKey,
                    'price' => (float) $price,
                    'slug' => $slug,
                    'is_active' => false,
                ]);
                $created++;
            }
        }

        return redirect()
            ->route('admin.external-services.index')
            ->with('status', "وارد شد: {$created} سرویس جدید، {$updated} سرویس قیمتش آپدیت شد.");
    }
}
