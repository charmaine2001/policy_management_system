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
        $this->call([
            PolicyTypeSeeder::class,
        ]);

        // Admin
        User::create([
            'name' => 'Staff Administrator',
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
        $lifeInsurance = \App\Models\PolicyType::where('name', 'Life Insurance')->first();

        Policy::create([
            'policy_number' => 'ZIM-POL-001',
            'user_id' => $client->id,
            'policy_type_id' => $lifeInsurance->id,
            'plan_type' => 'Standard',
            'final_price' => 150.00,
            'start_date' => now()->subMonths(6),
            'renewal_date' => now()->addMonths(6),
            'status' => 'Active',
        ]);
    }
}
