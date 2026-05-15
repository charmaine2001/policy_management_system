<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Policy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@zimnat.co.zw',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Policy Officer
        User::create([
            'name' => 'Policy Officer',
            'email' => 'officer@zimnat.co.zw',
            'password' => Hash::make('password'),
            'role' => 'policy_officer',
        ]);

        // Client
        $client = User::create([
            'name' => 'John Client',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        // Initial Policy for Client
        Policy::create([
            'policy_number' => 'ZIM-POL-001',
            'client_id' => $client->id,
            'insurance_type' => 'Life Insurance',
            'premium_amount' => 150.00,
            'start_date' => now()->subMonths(6),
            'renewal_date' => now()->addMonths(6),
            'status' => 'Active',
        ]);
    }
}
