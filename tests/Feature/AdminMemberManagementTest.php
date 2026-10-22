<?php

namespace Tests\Feature;

use App\Models\Kopang;
use App\Models\KopangType;
use App\Models\Koperasi;
use App\Models\Kopsdm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminMemberManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_dashboard_keeps_its_existing_tabbed_layout(): void
    {
        $cooperative = $this->createCooperative(9901, 5);
        $this->createManager(9901, $cooperative->id_koperasi);

        $response = $this->actingAs(User::firstOrFail())->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('INFORMASI KOPERASI');
        $response->assertSee('Database Anggota');
        $response->assertSee('<aside', false);
        $response->assertDontSee('Foto lokasi koperasi');
        $response->assertDontSee('Tambah pengurus');
        $response->assertDontSee('Unggah foto pengurus');
        $response->assertDontSee('id="map-members"', false);
    }

    public function test_operator_desa_gets_the_single_page_member_and_manager_dashboard_without_a_map(): void
    {
        $this->createCooperative(9910, 5);
        $this->createManager(9910, 9910);
        $operator = User::create([
            'id_user' => 9910,
            'name_user' => 'Operator Desa',
            'login_user' => 'operator_single_page_test',
            'pswd' => 'password',
            'level_user' => 15,
            'id_company' => 1,
            'id_branch' => 1,
            'flag_del' => 0,
        ]);

        $response = $this->actingAs($operator)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Total anggota');
        $response->assertSee('Tambah anggota');
        $response->assertSee('Pengurus koperasi');
        $response->assertSee('Tambah pengurus');
        $response->assertSee('Foto lokasi koperasi');
        $response->assertSee('Unggah foto pengurus');
        $response->assertDontSee('id="map-members"', false);
        $response->assertDontSee('<aside', false);
    }

    public function test_operator_desa_can_add_a_manager_to_its_cooperative(): void
    {
        $this->createCooperative(9912, 0);
        $operator = $this->createOperatorDesa(9912, 1);

        $response = $this->actingAs($operator)->post(route('admin.pengurus.store'), [
            'id_koperasi' => 9912,
            'name_kopsdm' => 'Pengurus Baru Desa',
            'jab_kopsdm' => 'KETUA KOPERASI',
            'type_kopsdm' => 'PENGURUS',
            'order_kopsdm' => '1',
            'comt_kopsdm' => 'Bidang usaha',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('app_md_kopsdm', [
            'id_koperasi' => 9912,
            'name_kopsdm' => 'Pengurus Baru Desa',
            'jab_kopsdm' => 'KETUA KOPERASI',
            'type_kopsdm' => 'PENGURUS',
            'flag_del' => 0,
        ]);
    }

    public function test_operator_desa_cannot_add_a_manager_to_another_villages_cooperative(): void
    {
        $this->createCooperative(9913, 0, 1, 2);
        $operator = $this->createOperatorDesa(9913, 1);

        $response = $this->actingAs($operator)->post(route('admin.pengurus.store'), [
            'id_koperasi' => 9913,
            'name_kopsdm' => 'Pengurus Tidak Diizinkan',
            'jab_kopsdm' => 'KETUA KOPERASI',
            'type_kopsdm' => 'PENGURUS',
        ]);

        $response->assertNotFound();
        $this->assertDatabaseMissing('app_md_kopsdm', [
            'name_kopsdm' => 'Pengurus Tidak Diizinkan',
        ]);
    }

    public function test_admin_can_update_manager(): void
    {
        $cooperative = $this->createCooperative(9950, 2);
        $manager = $this->createManager(9950, $cooperative->id_koperasi);
        $admin = User::firstOrFail();

        $response = $this->actingAs($admin)->put(route('admin.pengurus.update', $manager), [
            'id_koperasi' => $cooperative->id_koperasi,
            'name_kopsdm' => 'SUSHI HARIANTO WIDIASTUTI',
            'jab_kopsdm' => 'BENDAHARA KOPERASI',
            'type_kopsdm' => 'PENGURUS',
            'order_kopsdm' => '4',
            'comt_kopsdm' => '-',
        ]);

        $response->assertRedirect(route('admin.dashboard', ['tab' => 'pengurus']));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('app_md_kopsdm', [
            'id_kopsdm' => $manager->id_kopsdm,
            'name_kopsdm' => 'SUSHI HARIANTO WIDIASTUTI',
            'jab_kopsdm' => 'BENDAHARA KOPERASI',
            'order_kopsdm' => '4',
        ]);
    }

    public function test_admin_can_delete_manager(): void
    {
        $cooperative = $this->createCooperative(9951, 2);
        $manager = $this->createManager(9951, $cooperative->id_koperasi);
        $admin = User::firstOrFail();

        $response = $this->actingAs($admin)->delete(route('admin.pengurus.destroy', $manager));

        $response->assertRedirect(route('admin.dashboard', ['tab' => 'pengurus']));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('app_md_kopsdm', [
            'id_kopsdm' => $manager->id_kopsdm,
            'flag_del' => 1,
        ]);
    }

    public function test_admin_can_add_an_individual_member_and_member_nik_is_encrypted(): void
    {
        $cooperative = $this->createCooperative(9902, 4);
        $memberType = KopangType::firstOrFail();
        $nik = '3201011234567890';

        $response = $this->actingAs(User::firstOrFail())->post(route('admin.anggota.store'), [
            'id_koperasi' => $cooperative->id_koperasi,
            'id_kopangtype' => $memberType->id_kopangtype,
            'name_kopang' => 'Anggota Tes',
            'nik_kopang' => $nik,
            'kopang_telp' => '081234567890',
            'kopang_usaha' => 'Usaha Tes',
            'kopang_addr' => 'Kabupaten Bogor',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('app_md_kopang', [
            'name_kopang' => 'Anggota Tes',
            'id_koperasi' => $cooperative->id_koperasi,
            'id_kopangtype' => $memberType->id_kopangtype,
            'kopang_telp' => '081234567890',
        ]);
        $this->assertSame(5, (int) $cooperative->fresh()->jum_anggota);

        $member = Kopang::where('name_kopang', 'Anggota Tes')->firstOrFail();
        $this->assertSame($nik, $member->nik_kopang);
        $this->assertNotSame($nik, DB::table('app_md_kopang')->where('id_kopang', $member->id_kopang)->value('nik_kopang'));

        $operator = User::create([
            'id_user' => 9911,
            'name_user' => 'Operator Desa',
            'login_user' => 'operator_added_member_test',
            'pswd' => 'password',
            'level_user' => 15,
            'id_company' => 1,
            'id_branch' => 1,
            'flag_del' => 0,
        ]);
        $page = $this->actingAs($operator)->get(route('admin.dashboard'));
        $page->assertSee('Anggota Tes');
        $page->assertDontSee($nik);
    }

    public function test_operator_cannot_add_a_member_to_another_villages_cooperative(): void
    {
        $cooperative = $this->createCooperative(9903, 2, 12, 22);
        $operator = User::create([
            'id_user' => 9903,
            'name_user' => 'Operator Desa',
            'login_user' => 'operator_member_test',
            'pswd' => 'password',
            'level_user' => 15,
            'id_company' => 12,
            'id_branch' => 11,
            'flag_del' => 0,
        ]);

        $response = $this->actingAs($operator)->post(route('admin.anggota.store'), [
            'id_koperasi' => $cooperative->id_koperasi,
            'id_kopangtype' => KopangType::firstOrFail()->id_kopangtype,
            'name_kopang' => 'Anggota Tidak Diizinkan',
            'nik_kopang' => '3201011234567890',
        ]);

        $response->assertNotFound();
        $this->assertDatabaseMissing('app_md_kopang', [
            'name_kopang' => 'Anggota Tidak Diizinkan',
        ]);
        $this->assertSame(2, (int) $cooperative->fresh()->jum_anggota);
    }

    public function test_member_requires_a_sixteen_digit_nik(): void
    {
        $cooperative = $this->createCooperative(9906, 1);

        $response = $this->actingAs(User::firstOrFail())->post(route('admin.anggota.store'), [
            'id_koperasi' => $cooperative->id_koperasi,
            'id_kopangtype' => KopangType::firstOrFail()->id_kopangtype,
            'name_kopang' => 'Anggota NIK Tidak Valid',
            'nik_kopang' => '12345',
        ]);

        $response->assertSessionHasErrors('nik_kopang');
        $this->assertDatabaseMissing('app_md_kopang', [
            'name_kopang' => 'Anggota NIK Tidak Valid',
        ]);
        $this->assertSame(1, (int) $cooperative->fresh()->jum_anggota);
    }

    public function test_admin_can_upload_a_photo_for_a_manager_without_one(): void
    {
        Storage::fake('public');
        $cooperative = $this->createCooperative(9904, 0);
        $manager = $this->createManager(9904, $cooperative->id_koperasi);

        $response = $this->actingAs(User::firstOrFail())->post(
            route('admin.pengurus.foto', $manager),
            ['foto' => $this->fakePng('pengurus.png')]
        );

        $response->assertRedirect(route('admin.dashboard'));
        $manager->refresh();
        $this->assertNotEmpty($manager->foto_kopsdm);
        Storage::disk('public')->assertExists($manager->foto_kopsdm);

        $managerWithoutPhoto = $this->createManager(9907, $cooperative->id_koperasi);
        $operator = $this->createOperatorDesa(9904, 1);
        $page = $this->actingAs($operator)->get(route('admin.dashboard'));
        $page->assertSee('Unggah foto pengurus');
        $page->assertDontSee('id="map-members"', false);
        $page->assertSee(route('admin.pengurus.foto.operator'));
        $page->assertSee('value="'.$manager->id_kopsdm.'"', false);
        $page->assertSee('value="'.$managerWithoutPhoto->id_kopsdm.'"', false);
        $this->assertSame(1, substr_count($page->getContent(), 'action="'.route('admin.pengurus.foto.operator').'"'));
    }

    public function test_manager_photo_cannot_be_replaced_through_the_missing_photo_upload(): void
    {
        $cooperative = $this->createCooperative(9905, 0);
        $manager = $this->createManager(9905, $cooperative->id_koperasi, 'pengurus/tersimpan.png');

        $response = $this->actingAs(User::firstOrFail())->post(
            route('admin.pengurus.foto', $manager),
            []
        );

        $response->assertStatus(409);
        $this->assertSame('pengurus/tersimpan.png', $manager->fresh()->foto_kopsdm);
    }

    public function test_operator_desa_can_replace_a_manager_photo_from_the_single_upload_form(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('pengurus/foto-lama.png', 'old photo');
        $cooperative = $this->createCooperative(9908, 0);
        $manager = $this->createManager(9908, $cooperative->id_koperasi, 'pengurus/foto-lama.png');
        $operator = $this->createOperatorDesa(9908, 1);

        $response = $this->actingAs($operator)->post(route('admin.pengurus.foto.operator'), [
            'id_kopsdm' => $manager->id_kopsdm,
            'foto' => $this->fakePng('foto-baru.png'),
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success');
        $manager->refresh();
        $this->assertNotSame('pengurus/foto-lama.png', $manager->foto_kopsdm);
        Storage::disk('public')->assertMissing('pengurus/foto-lama.png');
        Storage::disk('public')->assertExists($manager->foto_kopsdm);
    }

    public function test_operator_desa_cannot_upload_a_photo_for_another_villages_manager(): void
    {
        Storage::fake('public');
        $cooperative = $this->createCooperative(9909, 0, 1, 2);
        $manager = $this->createManager(9909, $cooperative->id_koperasi);
        $operator = $this->createOperatorDesa(9909, 1);

        $response = $this->actingAs($operator)->post(route('admin.pengurus.foto.operator'), [
            'id_kopsdm' => $manager->id_kopsdm,
            'foto' => $this->fakePng('foto-terlarang.png'),
        ]);

        $response->assertNotFound();
        $this->assertEmpty($manager->fresh()->foto_kopsdm);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_admin_cannot_use_the_operator_photo_upload_endpoint(): void
    {
        $cooperative = $this->createCooperative(9914, 0);
        $manager = $this->createManager(9914, $cooperative->id_koperasi);
        $admin = User::firstOrFail();

        $response = $this->actingAs($admin)->post(route('admin.pengurus.foto.operator'), [
            'id_kopsdm' => $manager->id_kopsdm,
            'foto' => $this->fakePng('foto-admin.png'),
        ]);

        $response->assertNotFound();
        $this->assertEmpty($manager->fresh()->foto_kopsdm);
    }

    public function test_operator_desa_can_upload_a_location_photo_for_its_cooperative(): void
    {
        Storage::fake('public');
        $cooperative = $this->createCooperative(9915, 0);
        $operator = $this->createOperatorDesa(9915, 1);

        $response = $this->actingAs($operator)->post(
            route('admin.koperasi.foto-lokasi', $cooperative),
            ['foto_lokasi' => $this->fakePng('lokasi.png')]
        );

        $response->assertRedirect(route('admin.dashboard').'#lokasi-koperasi');
        $response->assertSessionHas('success');
        $cooperative->refresh();
        $this->assertNotEmpty($cooperative->foto_lokasi);
        Storage::disk('public')->assertExists($cooperative->foto_lokasi);

        $page = $this->actingAs($operator)->get(route('admin.dashboard'));
        $page->assertOk();
        $page->assertSee('Foto lokasi siap ditampilkan.');
        $page->assertSee('Perbesar foto lokasi', false);
        $page->assertSee('Batalkan pilihan', false);
        $page->assertSee(Storage::disk('public')->url($cooperative->foto_lokasi), false);
    }

    public function test_operator_desa_replacing_a_location_photo_deletes_the_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('koperasi/lokasi/9916/foto-lama.png', 'foto lama');
        $cooperative = $this->createCooperative(9916, 0);
        $cooperative->foto_lokasi = 'koperasi/lokasi/9916/foto-lama.png';
        $cooperative->save();
        $operator = $this->createOperatorDesa(9916, 1);

        $response = $this->actingAs($operator)->post(
            route('admin.koperasi.foto-lokasi', $cooperative),
            ['foto_lokasi' => $this->fakePng('foto-baru.png')]
        );

        $response->assertRedirect(route('admin.dashboard').'#lokasi-koperasi');
        $cooperative->refresh();
        $this->assertNotSame('koperasi/lokasi/9916/foto-lama.png', $cooperative->foto_lokasi);
        Storage::disk('public')->assertMissing('koperasi/lokasi/9916/foto-lama.png');
        Storage::disk('public')->assertExists($cooperative->foto_lokasi);
    }

    public function test_operator_desa_cannot_upload_a_location_photo_for_another_village(): void
    {
        Storage::fake('public');
        $cooperative = $this->createCooperative(9917, 0, 1, 2);
        $operator = $this->createOperatorDesa(9917, 1);

        $response = $this->actingAs($operator)->post(
            route('admin.koperasi.foto-lokasi', $cooperative),
            ['foto_lokasi' => $this->fakePng('lokasi-terlarang.png')]
        );

        $response->assertNotFound();
        $this->assertEmpty($cooperative->fresh()->foto_lokasi);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_admin_cannot_upload_a_location_photo_through_the_operator_endpoint(): void
    {
        Storage::fake('public');
        $cooperative = $this->createCooperative(9918, 0);
        $admin = User::firstOrFail();

        $response = $this->actingAs($admin)->post(
            route('admin.koperasi.foto-lokasi', $cooperative),
            ['foto_lokasi' => $this->fakePng('lokasi-admin.png')]
        );

        $response->assertNotFound();
        $this->assertEmpty($cooperative->fresh()->foto_lokasi);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_operator_desa_must_upload_a_valid_location_image(): void
    {
        Storage::fake('public');
        $cooperative = $this->createCooperative(9919, 0);
        $operator = $this->createOperatorDesa(9919, 1);

        $response = $this->actingAs($operator)->post(
            route('admin.koperasi.foto-lokasi', $cooperative),
            ['foto_lokasi' => UploadedFile::fake()->create('bukan-gambar.txt', 10, 'text/plain')]
        );

        $response->assertSessionHasErrors('foto_lokasi');
        $this->assertEmpty($cooperative->fresh()->foto_lokasi);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    private function createCooperative(int $id, int $memberCount, int $districtId = 1, int $villageId = 1): Koperasi
    {
        return Koperasi::create([
            'id_koperasi' => $id,
            'name_koperasi' => 'Koperasi Tes '.$id,
            'id_kec' => $districtId,
            'id_kel' => $villageId,
            'jum_anggota' => $memberCount,
            'gps_lat' => '-6.5950',
            'gps_long' => '106.7900',
            'flag_del' => 0,
        ]);
    }

    private function createManager(int $id, int $cooperativeId, ?string $photo = null): Kopsdm
    {
        return Kopsdm::create([
            'id_kopsdm' => $id,
            'id_koperasi' => $cooperativeId,
            'name_kopsdm' => 'Pengurus Tes '.$id,
            'jab_kopsdm' => 'KETUA KOPERASI',
            'type_kopsdm' => 'PENGURUS',
            'order_kopsdm' => '1',
            'comt_kopsdm' => '-',
            'foto_kopsdm' => $photo,
            'id_user' => 1,
            'flag_del' => 0,
        ]);
    }

    private function createOperatorDesa(int $id, int $villageId): User
    {
        return User::create([
            'id_user' => $id,
            'name_user' => 'Operator Desa',
            'login_user' => 'operator_member_'.$id,
            'pswd' => 'password',
            'level_user' => 15,
            'id_company' => 1,
            'id_branch' => $villageId,
            'flag_del' => 0,
        ]);
    }

    private function fakePng(string $name): UploadedFile
    {
        $contents = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAADUlEQVR4nGP4z8AAAAMBAQDJ/pLvAAAAAElFTkSuQmCC',
            true
        );

        return UploadedFile::fake()->createWithContent($name, $contents);
    }
}
