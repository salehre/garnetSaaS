<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminLogController extends Controller
{
    public function index(Request $request): View
    {
        $adminId = $request->query('admin_id');

        $logs = AdminLog::with('admin')
            ->when($adminId, fn ($query) => $query->where('admin_id', $adminId))
            ->latest()
            ->paginate(30)
            ->withQueryString();

        $admins = Admin::orderBy('name')->get();

        return view('admin.logs.index', compact('logs', 'admins', 'adminId'));
    }
}