<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AclTest extends TestCase
{
    use DatabaseTransactions;

    public function test_industri_user_cannot_access_admin_panel(): void
    {
        $user = User::role('Industri')->first();
        $this->assertNotNull($user, 'No Industri user seeded');

        $response = $this->actingAs($user)->get('/admin');
        // Should be 403 or redirect (Filament returns 403 when canAccessPanel is false)
        $this->assertContains($response->getStatusCode(), [302, 403]);
    }

    public function test_officer_can_access_admin_panel(): void
    {
        $officer = User::role('Pegawai Pendaftaran')->first();
        $this->assertNotNull($officer, 'No Pegawai Pendaftaran user seeded');

        $response = $this->actingAs($officer)->get('/admin');
        // Should be 200 or redirect to dashboard
        $this->assertContains($response->getStatusCode(), [200, 302]);
    }

    public function test_unauthenticated_user_redirected_from_industri_dashboard(): void
    {
        $response = $this->get('/industri');
        // Should redirect to login
        $response->assertRedirect();
    }
}
