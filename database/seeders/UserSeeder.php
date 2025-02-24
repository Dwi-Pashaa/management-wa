<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            "name" => "Administrator",
            "email" => "admin@gmail.com",
            "slug" => Str::slug("Administrator"),
            "password" => Hash::make(12345678)
        ]);
        $user->assignRole("Admin");
    }
}
