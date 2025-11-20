<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('0000'),
            'phone_number' => '0711637755',
            'role' => 'admin',
            'first_login' => false
        ]);

        // $admin = User::where('email', 'admin@admin.com')->first();
        // $admin->phone_number = '0711637755';
        // $admin->centy_plus_otp = null;
        // $admin->centy_plus_otp_verified = 0;
        // $admin->save();

       $user = User::create([
            'name' => 'Teacher admin',
            'email' => 'teacher@admin.com',
            'password' => bcrypt('0011'),
            'phone_number' => '0711637755',
            'role' => 'teacher',
            'first_login' => false
        ]);

        
    }
}
