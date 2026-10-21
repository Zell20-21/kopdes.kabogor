<?php

namespace Tests\Feature;

use App\Models\LampiranInformasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminLampiranTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    private function createAdminUser(): User
    {
        return User::firstOrCreate(
            ['login_user' => 'admin_test_lampiran'],
            [
                'id_user' => 8888,
                'name_user' => 'Administrator Tes',
                'pswd' => 'password',
                'level_user' => 1,
                'id_company' => 0,
                'id_branch' => 0,
                'flag_del' => 0,
            ]
        );
    }

    public function test_admin_can_view_the_existing_dashboard_and_lampiran_page(): void
    {
        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)
            ->get(route('admin.dashboard', ['tab' => 'lampiran']));

        $response->assertStatus(200);
        $response->assertSee('LAMPIRAN INFORMASI');
        $response->assertSee('Upload File Lampiran Baru');
        $response->assertSee('modalPreviewUpload');
        $response->assertSee('<aside', false);
    }

    public function test_admin_can_upload_and_manage_lampiran(): void
    {
        $admin = $this->createAdminUser();

        $file = UploadedFile::fake()->create('laporan_kdkmp_terbaru.pdf', 1024, 'application/pdf');

        $response = $this->actingAs($admin)->post(route('admin.lampiran.store'), [
            'file' => $file,
            'judul' => 'DOKUMEN PROGRES KDKMP TAHAP 2',
            'keterangan' => 'LAPORAN REKAPITULASI BOGOR OKTOBER 2026',
            'urutan' => 2,
        ]);

        $response->assertRedirect(route('admin.dashboard', ['tab' => 'lampiran']));
        $response->assertSessionHas('success');

        $lampiran = LampiranInformasi::where('judul', 'DOKUMEN PROGRES KDKMP TAHAP 2')->first();
        $this->assertNotNull($lampiran);
        $this->assertEquals('LAPORAN REKAPITULASI BOGOR OKTOBER 2026', $lampiran->keterangan);

        // Verify public dashboard displays the newly created lampiran in dropdown
        $publicResponse = $this->get(route('dashboard'));
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('DOKUMEN PROGRES KDKMP TAHAP 2');
        $publicResponse->assertSee('Lihat Detail Informasi');

        // Test update
        $updateResponse = $this->actingAs($admin)->put(route('admin.lampiran.update', $lampiran->id), [
            'judul' => 'DOKUMEN PROGRES KDKMP TAHAP 2 REVISI',
            'keterangan' => 'KETERANGAN DIPERBARUI',
            'urutan' => 1,
        ]);

        $updateResponse->assertRedirect(route('admin.dashboard', ['tab' => 'lampiran']));
        $lampiran->refresh();
        $this->assertEquals('DOKUMEN PROGRES KDKMP TAHAP 2 REVISI', $lampiran->judul);

        // Test delete
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.lampiran.destroy', $lampiran->id));
        $deleteResponse->assertRedirect(route('admin.dashboard', ['tab' => 'lampiran']));
        $this->assertNull(LampiranInformasi::find($lampiran->id));
    }
}
