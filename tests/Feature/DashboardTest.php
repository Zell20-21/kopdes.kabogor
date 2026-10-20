<?php

namespace Tests\Feature;

use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_dashboard_page_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Dashboard KMP Kabupaten Bogor');
        $response->assertSee('435 Koperasi Terbentuk');
        $response->assertSee('CISARUA');
        $response->assertSee('CIBINONG');
        $response->assertSee('Rekapitulasi Sebaran Per Kecamatan');
    }

    public function test_kecamatan_api_returns_json_details(): void
    {
        $cisarua = Kecamatan::where('nama', 'CISARUA')->firstOrFail();

        $response = $this->get(route('kecamatan.show', $cisarua));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'nama' => 'CISARUA',
                'kop_desa' => 9,
                'kop_kel' => 1,
                'jumlah' => 10,
            ],
        ]);
    }

    public function test_export_rekapitulasi_downloads_csv(): void
    {
        $response = $this->get(route('export.rekapitulasi'));

        $response->assertStatus(200);
        $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('Rekapitulasi_KMP_Kabupaten_Bogor_2025.csv', $response->headers->get('Content-Disposition'));
    }

    public function test_portal_login_validation_and_captcha(): void
    {
        $response = $this->post(route('portal.login'), [
            'username' => 'admin_bogor',
            'password' => 'secret123',
            'captcha' => '2842',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success');
        $this->assertAuthenticated();
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_admin_dashboard(): void
    {
        $admin = User::first();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('KOPERASI MERAH PUTIH');
        $response->assertSee('DESK KOP');
        $response->assertSee('KABUPATEN BOGOR');
        $response->assertSee('INFORMASI KOPERASI');
        $response->assertSee('435');
        $response->assertSee('Anggota Koperasi');
        $response->assertSee('OPERASIONAL');
        $response->assertSee('PELATIHAN');
        $response->assertSee('SERTIFIKAT');
        $response->assertSee('Anggota UMKM');
    }
}
