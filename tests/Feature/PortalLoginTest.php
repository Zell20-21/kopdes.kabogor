<?php

namespace Tests\Feature;

use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Koperasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class PortalLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_wrong_password_is_rejected_with_the_generic_login_message(): void
    {
        $user = $this->createUser('wrong_password_user', md5('correct-password'));

        $response = $this->submitLogin($user->login_user, 'wrong-password');

        $response->assertRedirect()
            ->assertSessionHas('error', 'Username atau kata sandi tidak sesuai.');
        $this->assertGuest();
    }

    public function test_unknown_username_is_rejected_with_the_generic_login_message(): void
    {
        $response = $this->submitLogin('unknown_synthetic_user', 'any-password');

        $response->assertRedirect()
            ->assertSessionHas('error', 'Username atau kata sandi tidak sesuai.');
        $this->assertGuest();
    }

    public function test_valid_bcrypt_password_authenticates_the_synthetic_user(): void
    {
        $user = $this->createUser('bcrypt_valid_user', Hash::make('bcrypt-password'));

        $response = $this->submitLogin($user->login_user, 'bcrypt-password');

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_bcrypt_password_is_rejected(): void
    {
        $user = $this->createUser('bcrypt_wrong_user', Hash::make('bcrypt-password'));

        $response = $this->submitLogin($user->login_user, 'wrong-password');

        $response->assertRedirect()
            ->assertSessionHas('error', 'Username atau kata sandi tidak sesuai.');
        $this->assertGuest();
    }

    public function test_unsupported_password_hash_is_rejected(): void
    {
        $user = $this->createUser('unsupported_hash_user', '$argon2id$synthetic-unsupported-hash');

        $response = $this->submitLogin($user->login_user, 'synthetic-password');

        $response->assertRedirect()
            ->assertSessionHas('error', 'Username atau kata sandi tidak sesuai.');
        $this->assertGuest();
    }

    public function test_empty_login_fields_are_rejected_by_validation(): void
    {
        $response = $this->submitLogin('', '');

        $response->assertRedirect()
            ->assertSessionHasErrors(['username', 'password']);
        $this->assertGuest();
    }

    public function test_array_username_does_not_cause_a_server_error(): void
    {
        $response = $this->submitLogin(['synthetic_user'], 'synthetic-password');

        $response->assertRedirect()
            ->assertSessionHasErrors(['username']);
        $this->assertGuest();
    }

    public function test_array_password_does_not_cause_a_server_error(): void
    {
        $user = $this->createUser('array_password_user', md5('synthetic-password'));

        $response = $this->submitLogin($user->login_user, ['synthetic-password']);

        $response->assertRedirect()
            ->assertSessionHasErrors(['password']);
        $this->assertGuest();
    }

    public function test_empty_captcha_is_rejected_before_password_authentication(): void
    {
        $user = $this->createUser('empty_captcha_user', md5('synthetic-password'));
        $this->get(route('captcha'));

        $response = $this->post(route('portal.login'), [
            'username' => $user->login_user,
            'password' => 'synthetic-password',
            'captcha' => '',
        ]);

        $response->assertRedirect()
            ->assertSessionHas('error', 'Kode Captcha tidak sesuai. Silakan coba lagi.');
        $this->assertGuest();
    }

    public function test_captcha_cannot_be_reused_after_a_failed_login_attempt(): void
    {
        $user = $this->createUser('captcha_reuse_user', md5('correct-password'));
        $this->session(['login_captcha' => '1234']);

        $firstResponse = $this->post(route('portal.login'), [
            'username' => $user->login_user,
            'password' => 'wrong-password',
            'captcha' => '1234',
        ]);
        $firstResponse->assertSessionHas('error', 'Username atau kata sandi tidak sesuai.');
        $this->assertGuest();

        $secondResponse = $this->post(route('portal.login'), [
            'username' => $user->login_user,
            'password' => 'correct-password',
            'captcha' => '1234',
        ]);

        $secondResponse->assertRedirect()
            ->assertSessionHas('error', 'Kode Captcha tidak sesuai. Silakan coba lagi.');
        $this->assertGuest();
    }

    public function test_login_regenerates_the_session_identifier(): void
    {
        $user = $this->createUser('session_regeneration_user', md5('synthetic-password'));
        $captcha = $this->getCaptcha();
        $previousSessionId = $this->app['session']->getId();

        $response = $this->post(route('portal.login'), [
            'username' => $user->login_user,
            'password' => 'synthetic-password',
            'captcha' => $captcha,
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
        $this->assertNotSame($previousSessionId, $this->app['session']->getId());
    }

    public function test_valid_md5_password_authenticates_the_user_by_unique_username(): void
    {
        $user = $this->createUser('md5_valid_username', md5('md5-password'));

        $response = $this->submitLogin($user->login_user, 'md5-password');

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_logout_invalidates_the_authenticated_session(): void
    {
        $user = $this->createUser('logout_synthetic_user', md5('synthetic-password'));
        $this->actingAs($user)->withSession(['logout_marker' => 'must-be-removed']);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('dashboard'))
            ->assertSessionMissing('logout_marker');
        $this->assertGuest();
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_duplicate_email_does_not_authenticate_an_ambiguous_user(): void
    {
        $this->createUser('duplicate_email_first', md5('first-password'), [
            'email_user' => 'shared.synthetic@example.test',
        ]);
        $this->createUser('duplicate_email_second', md5('second-password'), [
            'email_user' => 'shared.synthetic@example.test',
        ]);

        $response = $this->submitLogin('shared.synthetic@example.test', 'first-password');

        $response->assertRedirect()
            ->assertSessionHas('error', 'Username atau kata sandi tidak sesuai.');
        $this->assertGuest();
    }

    public function test_unique_username_authenticates_even_if_its_email_is_duplicated(): void
    {
        $this->createUser('duplicate_email_first', md5('first-password'), [
            'email_user' => 'shared.synthetic@example.test',
        ]);
        $this->createUser('duplicate_email_second', md5('second-password'), [
            'email_user' => 'shared.synthetic@example.test',
        ]);
        $user = $this->createUser('username_with_duplicate_email', md5('unique-password'), [
            'email_user' => 'shared.synthetic@example.test',
        ]);

        $response = $this->submitLogin($user->login_user, 'unique-password');

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_alias_fallback_still_requires_the_admin_password(): void
    {
        $this->createUser('synthetic_admin_account', md5('correct-admin-password'), [
            'id_user' => 1,
            'level_user' => 1,
        ]);

        $response = $this->submitLogin('admin', 'wrong-admin-password');

        $response->assertRedirect()
            ->assertSessionHas('error', 'Username atau kata sandi tidak sesuai.');
        $this->assertGuest();
    }

    public function test_operator_desa_cannot_read_or_update_a_cooperative_outside_its_village(): void
    {
        $this->createDistrictAndVillage(980001, 980002, 'VILLAGE OUTSIDE OPERATOR SCOPE');
        $cooperative = Koperasi::create([
            'id_koperasi' => 980003,
            'name_koperasi' => 'SYNTHETIC OUTSIDE COOPERATIVE',
            'id_kec' => 980001,
            'id_kel' => 980002,
            'jum_anggota' => 3,
            'flag_del' => 0,
        ]);
        $operator = $this->createUser('village_scope_operator', md5('synthetic-password'), [
            'level_user' => 15,
            'id_company' => 980004,
            'id_branch' => 980005,
        ]);

        $dashboardResponse = $this->actingAs($operator)
            ->get(route('admin.dashboard', ['tab' => 'koperasi']))
            ->assertOk();
        $dashboardResponse->assertDontSee('SYNTHETIC OUTSIDE COOPERATIVE');

        $this->put(route('admin.koperasi.update', $cooperative), [
            'name_koperasi' => 'UNAUTHORIZED SYNTHETIC UPDATE',
            'id_kec' => 980001,
            'id_kel' => 980002,
            'st_ops' => 'SUDAH',
            'st_latih' => 'BELUM',
            'st_sertifikat' => 'BELUM',
        ])->assertNotFound();

        $this->assertDatabaseHas('app_md_koperasi', [
            'id_koperasi' => 980003,
            'name_koperasi' => 'SYNTHETIC OUTSIDE COOPERATIVE',
            'id_kel' => 980002,
        ]);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createUser(string $username, string $passwordHash, array $attributes = []): User
    {
        return User::create(array_merge([
            'id_user' => 980100 + User::count(),
            'name_user' => 'Synthetic '.$username,
            'login_user' => $username,
            'pswd' => $passwordHash,
            'level_user' => 15,
            'id_company' => 0,
            'id_branch' => 0,
            'flag_del' => 0,
        ], $attributes));
    }

    private function submitLogin(string|array $username, string|array $password): TestResponse
    {
        return $this->post(route('portal.login'), [
            'username' => $username,
            'password' => $password,
            'captcha' => $this->getCaptcha(),
        ]);
    }

    private function getCaptcha(): string
    {
        $this->get(route('captcha'));

        return (string) session('login_captcha');
    }

    private function createDistrictAndVillage(int $districtId, int $villageId, string $villageName): void
    {
        Kecamatan::create([
            'id_kopkec' => $districtId,
            'name_kopkec' => 'SYNTHETIC DISTRICT '.$districtId,
            'flag_del' => 0,
        ]);
        Kelurahan::create([
            'id_kopkel' => $villageId,
            'id_kopkec' => $districtId,
            'name_kopkel' => $villageName,
            'flag_del' => 0,
        ]);
    }
}
