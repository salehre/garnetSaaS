<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Customer;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'customersCount' => Customer::count(),
            'currenciesCount' => Currency::count(),
            'activeCurrenciesCount' => Currency::where('is_active', true)->count(),
        ]);
    }
}
