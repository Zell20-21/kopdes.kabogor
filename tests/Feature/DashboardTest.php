<?php

namespace Tests\Feature;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
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
        $response->assertSee('Capaian Agregat Kabupaten Bogor');
        $response->assertSee('CISARUA');
        $response->assertSee('CIBINONG');
        $response->assertSee('Rekapitulasi Sebaran Per Kecamatan');
    }

    public function test_kecamatan_api_returns_json_details(): void
    {
        $cisarua = Kecamatan::where('name_kopkec', 'CISARUA')->firstOrFail();

        $response = $this->getJson(route('kecamatan.show', $cisarua));

        $response->assertStatus(200);
        $response->assertJson([
            'status' => 'success',
            'data' => [
                'nama' => 'CISARUA',
                'jumlah' => 11,
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

    public function test_public_csv_export_escapes_spreadsheet_formulas(): void
    {
        Kecamatan::create([
            'id_kopkec' => 9900,
            'name_kopkec' => '=1+1',
            'flag_del' => 0,
        ]);

        $response = $this->get(route('export.rekapitulasi'));

        $response->assertOk()->assertStreamed();
        $content = $response->streamedContent();
        $this->assertStringContainsString("'=1+1", $content);
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
            'pswd' => md5('password'),
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

    public function test_login_rejects_plaintext_passwords_and_inactive_users(): void
    {
        User::create([
            'id_user' => 56,
            'name_user' => 'Akun Password Teks',
            'login_user' => 'akun_password_teks',
            'pswd' => 'password',
            'level_user' => 15,
            'id_company' => 1,
            'id_branch' => 1,
            'flag_del' => 0,
        ]);
        User::create([
            'id_user' => 57,
            'name_user' => 'Akun Nonaktif',
            'login_user' => 'akun_nonaktif',
            'pswd' => md5('password'),
            'level_user' => 15,
            'id_company' => 1,
            'id_branch' => 1,
            'flag_del' => 1,
        ]);

        foreach (['akun_password_teks', 'akun_nonaktif'] as $username) {
            $this->get(route('captcha'));
            $captcha = session('login_captcha');

            $response = $this->post(route('portal.login'), [
                'username' => $username,
                'password' => 'password',
                'captcha' => $captcha,
            ]);

            $response->assertRedirect()
                ->assertSessionHas('error', 'Username atau kata sandi tidak sesuai.');
            $this->assertGuest();
        }
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

    public function test_authenticated_user_without_an_admin_role_cannot_access_admin_dashboard(): void
    {
        $user = User::create([
            'id_user' => 58,
            'name_user' => 'Pengguna Tanpa Role Admin',
            'login_user' => 'pengguna_tanpa_role_admin',
            'pswd' => md5('password'),
            'level_user' => 16,
            'id_company' => 0,
            'id_branch' => 0,
            'flag_del' => 0,
        ]);

        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
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
        $response->assertSee('<select onchange="window.location.href=this.value"', false);
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
        $response->assertSee('Portal Koperasi Desa');
        $response->assertDontSee('id="map-members"', false);
        $response->assertDontSee('id="sidebar"', false);
    }

    public function test_each_operator_desa_sees_only_its_assigned_cooperative_and_village_filter(): void
    {
        $this->createKecamatan(9001, 'KECAMATAN PERTAMA');
        $this->createKecamatan(9002, 'KECAMATAN KEDUA');
        $this->createKelurahan(9101, 9001, 'DESA OPERATOR PERTAMA');
        $this->createKelurahan(9201, 9002, 'DESA OPERATOR KEDUA');
        $this->createCooperative(9301, 9101, 'KOPERASI DESA PERTAMA', 10, 9001);
        $this->createCooperative(9302, 9201, 'KOPERASI DESA KEDUA', 20, 9002);
        $firstOperator = $this->createOperatorDesa(9101, 9001);
        $secondOperator = $this->createOperatorDesa(9201, 9002, 9002);

        $firstResponse = $this->actingAs($firstOperator)->get(route('admin.dashboard', ['tab' => 'koperasi']));
        $secondResponse = $this->actingAs($secondOperator)->get(route('admin.dashboard', ['tab' => 'koperasi']));

        $firstResponse->assertOk();
        $firstResponse->assertViewHas('gisKoperasis', fn ($koperasis): bool => $koperasis->pluck('id_koperasi')->all() === [9301]);
        $firstResponse->assertViewHas('koperasis', fn ($koperasis): bool => $koperasis->pluck('id_koperasi')->all() === [9301]);
        $firstResponse->assertDontSee('id="map-members"', false);
        $firstResponse->assertSee('KOPERASI DESA PERTAMA');
        $firstResponse->assertDontSee('KECAMATAN KEDUA');
        $firstResponse->assertDontSee('DESA OPERATOR KEDUA');
        $firstResponse->assertDontSee('KOPERASI DESA KEDUA');

        $secondResponse->assertOk();
        $secondResponse->assertViewHas('gisKoperasis', fn ($koperasis): bool => $koperasis->pluck('id_koperasi')->all() === [9302]);
        $secondResponse->assertDontSee('id="map-members"', false);
        $secondResponse->assertSee('KOPERASI DESA KEDUA');
        $secondResponse->assertDontSee('KECAMATAN PERTAMA');
        $secondResponse->assertDontSee('DESA OPERATOR PERTAMA');
        $secondResponse->assertDontSee('KOPERASI DESA PERTAMA');
    }

    public function test_operator_kecamatan_sees_only_cooperatives_and_filters_in_its_assigned_kecamatan(): void
    {
        $this->createKecamatan(9001, 'KLAPANUNGGAL');
        $this->createKecamatan(9002, 'KECAMATAN LAIN');
        $this->createKelurahan(9101, 9001, 'NAMBO');
        $this->createKelurahan(9102, 9001, 'DESA KLAPANUNGGAL LAIN');
        $this->createKelurahan(9201, 9002, 'DESA LUAR WILAYAH');
        $this->createCooperative(9301, 9101, 'KOPERASI NAMBO', 10, 9001);
        $this->createCooperative(9302, 9201, 'KOPERASI LUAR WILAYAH', 20, 9002);
        $operator = $this->createOperatorKecamatan(9001);

        $response = $this->actingAs($operator)->get(route('admin.dashboard', ['tab' => 'koperasi']));

        $response->assertOk();
        $response->assertViewHas('totalKoperasi', 1);
        $response->assertViewHas('gisKoperasis', fn ($koperasis): bool => $koperasis->pluck('id_koperasi')->all() === [9301]);
        $response->assertViewHas('kecamatans', function ($kecamatans): bool {
            return $kecamatans->pluck('id_kopkec')->all() === [9001]
                && $kecamatans->first()->kelurahans->pluck('id_kopkel')->all() === [9102, 9101];
        });
        $response->assertViewHas('kecamatansData', fn (array $data): bool => count($data) === 1
            && $data[0]['id_kopkec'] === 9001
            && array_column($data[0]['kelurahans'], 'id_kopkel') === [9102, 9101]);
        $response->assertSee('KOPERASI NAMBO');
        $response->assertSee('KLAPANUNGGAL');
        $response->assertSee('KMP Kab. Bogor');
        $response->assertSee('data-dashboard-shell="operator-kecamatan"', false);
        $response->assertSee('max-w-7xl', false);
        $response->assertSee('Keluar');
        $response->assertDontSee('fixed top-0 inset-x-0', false);
        $response->assertDontSee('id="map-members"', false);
        $response->assertDontSee('KOPERASI LUAR WILAYAH');
        $response->assertDontSee('KECAMATAN LAIN');
        $response->assertDontSee('DESA LUAR WILAYAH');
        $response->assertDontSee('-- SEMUA KECAMATAN (40) --');
        $response->assertDontSee('Ciawi & Megamendung (19, 45)');
    }

    public function test_operator_kecamatan_does_not_see_lampiran_informasi_section(): void
    {
        $this->createKecamatan(9001, 'KLAPANUNGGAL');
        $operator = $this->createOperatorKecamatan(9001);

        $this->actingAs($operator)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertDontSee('Lampiran Informasi');

        $this->get(route('admin.dashboard', ['tab' => 'lampiran']))
            ->assertOk()
            ->assertSee('INFORMASI KOPERASI')
            ->assertDontSee('LAMPIRAN INFORMASI')
            ->assertDontSee('Upload File Lampiran Baru');
    }

    public function test_operator_kecamatan_cannot_expand_dashboard_data_with_other_region_filters(): void
    {
        $this->createKecamatan(9001, 'KLAPANUNGGAL');
        $this->createKecamatan(9002, 'KECAMATAN LAIN');
        $this->createKelurahan(9101, 9001, 'NAMBO');
        $this->createKelurahan(9201, 9002, 'DESA LUAR WILAYAH');
        $this->createCooperative(9301, 9101, 'KOPERASI NAMBO', 10, 9001);
        $this->createCooperative(9302, 9201, 'KOPERASI LUAR WILAYAH', 20, 9002);
        $operator = $this->createOperatorKecamatan(9001);

        $response = $this->actingAs($operator)->get(route('admin.dashboard', [
            'tab' => 'koperasi',
            'id_kec' => 9002,
            'id_kel' => 9201,
        ]));

        $response->assertOk();
        $response->assertSee('KOPERASI MERAH PUTIH');
        $response->assertDontSee('id="map-members"', false);
        $response->assertViewHas('koperasis', fn ($koperasis): bool => $koperasis->total() === 0);
        $response->assertViewHas('gisKoperasis', fn ($koperasis): bool => $koperasis->pluck('id_koperasi')->all() === [9301]);
        $response->assertViewHas('kecamatans', fn ($kecamatans): bool => $kecamatans->pluck('id_kopkec')->all() === [9001]);
        $response->assertDontSee('KOPERASI LUAR WILAYAH');
        $response->assertDontSee('KECAMATAN LAIN');
        $response->assertDontSee('DESA LUAR WILAYAH');
    }

    public function test_operator_kecamatan_cannot_create_or_move_a_cooperative_outside_its_district(): void
    {
        $this->createKecamatan(9001, 'KECAMATAN TUGAS');
        $this->createKecamatan(9002, 'KECAMATAN LAIN');
        $this->createKelurahan(9101, 9001, 'DESA TUGAS');
        $this->createKelurahan(9201, 9002, 'DESA LAIN');
        $this->createCooperative(9301, 9101, 'KOPERASI TUGAS', 10, 9001);
        $operator = $this->createOperatorKecamatan(9001);

        $this->actingAs($operator)->post(route('admin.koperasi.store'), [
            'name_koperasi' => 'KOPERASI DI LUAR WILAYAH',
            'id_kec' => 9002,
            'id_kel' => 9201,
            'st_ops' => 'SUDAH',
            'st_latih' => 'BELUM',
            'st_sertifikat' => 'BELUM',
        ])->assertNotFound();

        $this->put(route('admin.koperasi.update', 9301), [
            'name_koperasi' => 'KOPERASI TUGAS',
            'id_kec' => 9002,
            'id_kel' => 9201,
            'st_ops' => 'SUDAH',
            'st_latih' => 'BELUM',
            'st_sertifikat' => 'BELUM',
        ])->assertNotFound();

        $this->assertDatabaseHas('app_md_koperasi', [
            'id_koperasi' => 9301,
            'id_kec' => 9001,
            'id_kel' => 9101,
        ]);
        $this->assertDatabaseMissing('app_md_koperasi', [
            'name_koperasi' => 'KOPERASI DI LUAR WILAYAH',
        ]);
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
        $managerResponse->assertDontSee('id="map-members"', false);
        $memberResponse->assertDontSee('id="map-members"', false);
        $cooperativeResponse->assertSee('KOPERASI DESA PONDOK RAJEG');
        $cooperativeResponse->assertDontSee('KOPERASI DESA LAIN');
        $managerResponse->assertSee('PENGURUS PONDOK RAJEG');
        $managerResponse->assertDontSee('PENGURUS DESA LAIN');
        $memberResponse->assertSee('11 anggota');
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
        $response->assertDontSee('id="map-members"', false);
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
        $response->assertDontSee('id="map-members"', false);
    }

    private function createCooperative(int $id, int $villageId, string $name, int $memberCount, int $districtId = 1): void
    {
        Koperasi::create([
            'id_koperasi' => $id,
            'name_koperasi' => $name,
            'id_kec' => $districtId,
            'id_kel' => $villageId,
            'jum_anggota' => $memberCount,
            'flag_del' => 0,
        ]);
    }

    private function createKecamatan(int $id, string $name): void
    {
        Kecamatan::create([
            'id_kopkec' => $id,
            'name_kopkec' => $name,
        ]);
    }

    private function createKelurahan(int $id, int $districtId, string $name): void
    {
        Kelurahan::create([
            'id_kopkel' => $id,
            'id_kopkec' => $districtId,
            'name_kopkel' => $name,
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

    private function createOperatorDesa(int $villageId, int $districtId = 1, int $userId = 9001): User
    {
        return User::create([
            'id_user' => $userId,
            'name_user' => 'Operator Desa',
            'login_user' => 'operator_desa_'.$userId,
            'pswd' => 'password',
            'level_user' => 15,
            'id_company' => $districtId,
            'id_branch' => $villageId,
            'flag_del' => 0,
        ]);
    }

    private function createOperatorKecamatan(int $districtId): User
    {
        return User::create([
            'id_user' => 9002,
            'name_user' => 'Operator Kecamatan',
            'login_user' => 'operator_kecamatan_9002',
            'pswd' => 'password',
            'level_user' => 14,
            'id_company' => $districtId,
            'id_branch' => 0,
            'flag_del' => 0,
        ]);
    }

    public function test_dashboard_displays_informasi_files_and_scrollspy_navigation(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertStatus(200);
        $response->assertSee('id="publicNav"', false);
        $response->assertSee('id="nav-beranda"', false);
        $response->assertSee('id="nav-informasi"', false);
        $response->assertSee('id="nav-sebaran"', false);
        $response->assertSee('DATA PROGRES PEMBANGUNAN KDKMP');
        $response->assertSee('id="progresDocCard"', false);
        $response->assertSee('btn-trigger-doc');
    }

    public function test_informasi_file_route_can_stream_pdf(): void
    {
        $response = $this->get(route('informasi.file', 'kdkp_maret_2026.pdf'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_admin_can_update_koperasi_data(): void
    {
        $admin = User::first();
        $koperasi = Koperasi::first();

        $response = $this->actingAs($admin)->put(route('admin.koperasi.update', $koperasi), [
            'name_koperasi' => 'KOPERASI TEST UPDATE BARU',
            'id_kec' => $koperasi->id_kec,
            'id_kel' => $koperasi->id_kel,
            'no_inkop' => '3201999999999',
            'no_ahu' => 'AHU-TEST-2026',
            'tgl_ahu' => '2026-01-15',
            'st_ops' => 'SUDAH',
            'st_latih' => 'SUDAH',
            'st_sertifikat' => 'SUDAH',
            'cat_koperasi' => 'KOPERASI KONSUMEN',
            'jum_anggota' => 150,
        ]);

        $response->assertRedirect(route('admin.dashboard', ['tab' => 'koperasi']));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('app_md_koperasi', [
            'id_koperasi' => $koperasi->id_koperasi,
            'name_koperasi' => 'KOPERASI TEST UPDATE BARU',
            'no_inkop' => '3201999999999',
            'jum_anggota' => 150,
        ]);
    }

    public function test_admin_can_soft_delete_koperasi(): void
    {
        $admin = User::first();
        $koperasi = Koperasi::first();

        $response = $this->actingAs($admin)->delete(route('admin.koperasi.destroy', $koperasi));

        $response->assertRedirect(route('admin.dashboard', ['tab' => 'koperasi']));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('app_md_koperasi', [
            'id_koperasi' => $koperasi->id_koperasi,
            'flag_del' => 1,
        ]);
    }
}
