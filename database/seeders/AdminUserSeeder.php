<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@cntt.edu.vn'],
            ['fullname'=>'Quản trị','password'=>Hash::make('Admin@123!'),'role'=>'Admin']
        );
    }
}
