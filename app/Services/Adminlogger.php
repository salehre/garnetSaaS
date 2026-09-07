<?php

namespace App\Services;

use App\Models\AdminLog;
use Illuminate\Support\Facades\Auth;

class AdminLogger
{
    /**
     * Record one log entry for the currently logged-in admin.
     * $action is a short machine-readable tag (e.g. "customer.updated"),
     * $description is the human-readable Persian sentence shown in the log list.
     */
    public static function log(string $action, string $description = ''): void
    {
        AdminLog::create([
            'admin_id' => Auth::guard('admin')->id(),
            'action' => $action,
            'description' => $description,
        ]);
    }
}