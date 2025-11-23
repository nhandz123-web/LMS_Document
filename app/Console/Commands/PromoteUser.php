<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PromoteUser extends Command
{
    /**
     * Lệnh: php artisan user:promote email role
     */
    protected $signature = 'user:promote {email} {role : SV|GV|ADMIN}';

    protected $description = 'Gán vai trò (SV/GV/ADMIN) cho user theo email';

    public function handle(): int
    {
        $email = $this->argument('email');
        $role  = strtoupper($this->argument('role'));

        if (!in_array($role, ['SV','GV','ADMIN'], true)) {
            $this->error('Role phải là SV | GV | ADMIN');
            return self::FAILURE;
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            $this->error("Không tìm thấy user với email {$email}");
            return self::FAILURE;
        }

        $user->role = $role;
        $user->save();

        $this->info("✅ Đã gán {$email} => {$role}");
        return self::SUCCESS;
    }
}
