<?php

namespace Database\Seeders;

use App\Models\PolicyType;
use Illuminate\Database\Seeder;

class PolicyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'name' => 'General Insurance',
                'description' => 'Coverage for various general risks.',
                'standard_price' => 100.00,
                'premium_price' => 200.00,
                'default_terms' => 'Standard terms for general insurance.',
            ],
            [
                'name' => 'Life Insurance',
                'description' => 'Coverage for life-related risks.',
                'standard_price' => 150.00,
                'premium_price' => 300.00,
                'default_terms' => 'Standard terms for life insurance.',
            ],
            [
                'name' => 'Loans',
                'description' => 'Insurance coverage for loans.',
                'standard_price' => 50.00,
                'premium_price' => 100.00,
                'default_terms' => 'Standard terms for loan insurance.',
            ],
            [
                'name' => 'Asset Management',
                'description' => 'Coverage for asset management risks.',
                'standard_price' => 200.00,
                'premium_price' => 400.00,
                'default_terms' => 'Standard terms for asset management insurance.',
            ],
        ];

        foreach ($types as $type) {
            PolicyType::updateOrCreate(['name' => $type['name']], $type);
        }
    }
}
