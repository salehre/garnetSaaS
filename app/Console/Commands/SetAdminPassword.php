<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SetAdminPassword extends Command
{
    protected $signature = 'admin:set-password {email} {password}';
    protected $description = 'Create or update an admin account with the given email/password';

    public function handle(): int
    {
        $admin = Admin::updateOrCreate(
            ['email' => $this->argument('email')],
            [
                'name' => 'Admin',
                'password' => Hash::make($this->argument('password')),
            ]
        );

        $this->info("Admin ready: {$admin->email}");

        return self::SUCCESS;
    }
}
