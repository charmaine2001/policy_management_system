<?php

namespace Tests\Feature;

use App\Models\Policy;
use App\Models\Query;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_displays_stats_and_recent_policies(): void
    {
        $user = User::factory()->create();
        
        // Create some policies
        $client = User::factory()->create();
        $policyType = \App\Models\PolicyType::factory()->create(['name' => 'Motor']);
        Policy::factory()->count(10)->create([
            'user_id' => $client->id,
            'status' => 'Active',
            'policy_type_id' => $policyType->id
        ]);

        // Create some queries
        Query::factory()->count(3)->create([
            'client_id' => $client->id,
            'status' => 'Open'
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertViewHas('stats');
        $response->assertViewHas('recentPolicies');
        
        $stats = $response->viewData('stats');
        $this->assertEquals(10, $stats['total_policies']);
        $this->assertEquals(10, $stats['active_policies']);
        $this->assertEquals(3, $stats['pending_queries']);
        
        $recentPolicies = $response->viewData('recentPolicies');
        $this->assertCount(5, $recentPolicies);
    }
}
