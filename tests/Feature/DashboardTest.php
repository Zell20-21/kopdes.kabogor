<?php

namespace Tests\Feature;

use App\Models\Kecamatan;
use App\Models\Koperasi;
use App\Models\Kopsdm;
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
        $cisarua = Kecamatan::where('name_kopkec', 'CISARUA')->firstOrFail();

        $response = $this->get(route('kecamatan.show', $cisarua));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'nama' => 'CISARUA',
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
        $this->get(route('captcha'));

        $response = $this->post(route('portal.login'), [
            'username' => 'admin',
            'password' => 'password',
            'captcha' => session('login_captcha'),
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success');
        $this->assertAuthenticated();
    }

    public function test_operator_desa_can_login_and_access_dashboard(): void
    {
        $operator = User::create([
            'id_user' => 55,
            'name_user' => 'KOP. PONDOK RAJEG [CIBINONG]',
            'login_user' => 'kop.pond2108',
            'pswd' => 'f75191ede83d4e347ee30684227509e8',
            'level_user' => 15,
            'id_company' => 1,
            'id_branch' => 1,
        ]);
        $this->get(route('captcha'));

        $response = $this->post(route('portal.login'), [
            'username' => 'kop.pond2108',
            'password' => 'password',
            'captcha' => session('login_captcha'),
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($operator);
    }

    public function test_captcha_endpoint_returns_a_fresh_uncached_image(): void
    {
        $response = $this->get(route('captcha'));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'image/svg+xml');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('no-cache', $response->headers->get('Cache-Control'));
        $this->assertMatchesRegularExpression('/^\d{4}$/', session('login_captcha'));
        $this->assertStringContainsString('<svg', $response->getContent());
        $this->assertStringNotContainsString('<text', $response->getContent());
    }

    public function test_login_rejects_the_fixed_captcha_code_and_consumes_the_session_code(): void
    {
        $this->get(route('captcha'));
        $this->session(['login_captcha' => '1234']);

        $response = $this->post(route('portal.login'), [
            'username' => 'admin',
            'password' => 'password',
            'captcha' => '2842',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Kode Captcha tidak sesuai. Silakan coba lagi.');
        $response->assertSessionHas('open_login', true);
        $this->assertFalse(session()->has('login_captcha'));
        $this->assertGuest();
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

    public function test_operator_desa_sees_only_its_own_cooperative_information(): void
    {
        $this->createCooperative(9001, 9001, 'KOPERASI DESA PONDOK RAJEG', 11);
        $this->createCooperative(9002, 9002, 'KOPERASI DESA LAIN', 99);
        $operator = $this->createOperatorDesa(9001);

        $response = $this->actingAs($operator)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewHas('totalKoperasi', 1);
        $response->assertViewHas('totalAnggota', 11);
        $response->assertSee('KOPERASI DESA PONDOK RAJEG');
        $response->assertDontSee('KOPERASI DESA LAIN');
    }

    public function test_operator_desa_sees_only_its_own_cooperative_managers_and_member_count(): void
    {
        $this->createCooperative(9001, 9001, 'KOPERASI DESA PONDOK RAJEG', 11);
        $this->createCooperative(9002, 9002, 'KOPERASI DESA LAIN', 99);
        $this->createCooperativeManager(9001, 9001, 'PENGURUS PONDOK RAJEG');
        $this->createCooperativeManager(9002, 9002, 'PENGURUS DESA LAIN');
        $operator = $this->createOperatorDesa(9001);
        $this->actingAs($operator);

        $cooperativeResponse = $this->get(route('admin.dashboard', ['tab' => 'koperasi']));
        $managerResponse = $this->get(route('admin.dashboard', ['tab' => 'pengurus']));
        $memberResponse = $this->get(route('admin.dashboard', ['tab' => 'anggota']));

        $cooperativeResponse->assertOk();
        $managerResponse->assertOk();
        $memberResponse->assertOk();
        $cooperativeResponse->assertSee('KOPERASI DESA PONDOK RAJEG');
        $cooperativeResponse->assertDontSee('KOPERASI DESA LAIN');
        $managerResponse->assertSee('PENGURUS PONDOK RAJEG');
        $managerResponse->assertDontSee('PENGURUS DESA LAIN');
        $memberResponse->assertSee('Total 11 anggota tercatat');
        $memberResponse->assertSee('KOPERASI DESA PONDOK RAJEG');
        $memberResponse->assertDontSee('KOPERASI DESA LAIN');
    }

    public function test_operator_desa_manager_search_cannot_escape_its_cooperative_scope(): void
    {
        $this->createCooperative(9001, 9001, 'KOPERASI DESA PONDOK RAJEG', 11);
        $this->createCooperative(9002, 9002, 'KOPERASI DESA LAIN', 99);
        $this->createCooperativeManager(9002, 9002, 'PENGURUS DESA LAIN');
        $operator = $this->createOperatorDesa(9001);

        $response = $this->actingAs($operator)->get(route('admin.dashboard', [
            'tab' => 'pengurus',
            'search_pengurus' => 'PENGURUS DESA LAIN',
        ]));

        $response->assertOk();
        $response->assertViewHas('penguruses', fn ($penguruses): bool => $penguruses->total() === 0);
        $response->assertSee('Data pengurus tidak ditemukan.');
    }

    public function test_operator_without_a_village_assignment_sees_no_cooperative_data(): void
    {
        $this->createCooperative(9001, 9001, 'KOPERASI DESA PONDOK RAJEG', 11);
        $operator = $this->createOperatorDesa(0);

        $response = $this->actingAs($operator)->get(route('admin.dashboard', ['tab' => 'anggota']));

        $response->assertOk();
        $response->assertViewHas('totalKoperasi', 0);
        $response->assertViewHas('totalAnggota', 0);
        $response->assertDontSee('KOPERASI DESA PONDOK RAJEG');
        $response->assertSee('Data anggota tidak ditemukan.');
    }

    private function createCooperative(int $id, int $villageId, string $name, int $memberCount): void
    {
        Koperasi::create([
            'id_koperasi' => $id,
            'name_koperasi' => $name,
            'id_kec' => 1,
            'id_kel' => $villageId,
            'jum_anggota' => $memberCount,
            'flag_del' => 0,
        ]);
    }

    private function createCooperativeManager(int $id, int $cooperativeId, string $name): void
    {
        Kopsdm::create([
            'id_kopsdm' => $id,
            'id_koperasi' => $cooperativeId,
            'name_kopsdm' => $name,
            'jab_kopsdm' => 'KETUA KOPERASI',
            'type_kopsdm' => 'PENGURUS',
            'order_kopsdm' => '1',
            'comt_kopsdm' => '-',
            'id_user' => 1,
            'flag_del' => 0,
        ]);
    }

    private function createOperatorDesa(int $villageId): User
    {
        return User::create([
            'id_user' => 9001,
            'name_user' => 'Operator Desa',
            'login_user' => 'operator_desa_9001',
            'pswd' => 'password',
            'level_user' => 15,
            'id_company' => 1,
            'id_branch' => $villageId,
            'flag_del' => 0,
        ]);
    }
}
