<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;


class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    // --- GET /login ---

    #[Test]
    public function khach_co_the_xem_trang_dang_nhap(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    // --- Validation ---

    #[Test]
    public function bao_loi_khi_email_trong(): void
    {
        $response = $this->post(route('login'), [
            'email'    => '',
            'password' => '123456',
        ]);

        $response->assertSessionHasErrors('email');
    }

    #[Test]
    public function bao_loi_khi_email_sai_dinh_dang(): void
    {
        $response = $this->post(route('login'), [
            'email'    => 'khong-phai-email',
            'password' => '123456',
        ]);

        $response->assertSessionHasErrors('email');
    }

    #[Test]
    public function bao_loi_khi_mat_khau_trong(): void
    {
        $response = $this->post(route('login'), [
            'email'    => 'test@example.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    // --- Sai thông tin ---

    #[Test]
    public function bao_loi_khi_email_khong_ton_tai(): void
    {
        $response = $this->post(route('login'), [
            'email'    => 'khongtontai@example.com',
            'password' => '123456',
        ]);

        $response->assertSessionHasErrors('email');
    }

    #[Test]
    public function bao_loi_khi_mat_khau_sai(): void
    {
        $role = Role::firstOrCreate(['name' => 'employee']);

        User::factory()->create([
            'role_id'  => $role->id,
            'email'    => 'nhanvien@example.com',
            'password' => Hash::make('mat-khau-dung'),
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'nhanvien@example.com',
            'password' => 'mat-khau-sai',
        ]);

        $response->assertSessionHasErrors('email');
    }

    // --- Redirect theo role ---

    #[Test]
    public function admin_duoc_chuyen_den_trang_quan_tri(): void
    {
        $role = Role::firstOrCreate(['name' => 'admin']);

        $user = User::factory()->create([
            'role_id'  => $role->id,
            'email'    => 'admin@example.com',
            'password' => Hash::make('123456'),
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'admin@example.com',
            'password' => '123456',
        ]);

        $response->assertRedirect(route('admin.home'));

        $this->assertEquals($user->id, session('user_id'));
        $this->assertEquals('admin', session('user_role'));
    }

    #[Test]
    public function nhan_vien_duoc_chuyen_den_trang_ca_nhan(): void
    {
        $role = Role::firstOrCreate(['name' => 'employee']);

        User::factory()->create([
            'role_id'  => $role->id,
            'email'    => 'nv@example.com',
            'password' => Hash::make('123456'),
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'nv@example.com',
            'password' => '123456',
        ]);

        $response->assertRedirect(route('user.home'));
    }

    // --- Đăng xuất ---

    #[Test]
    public function dang_xuat_xoa_session_va_quay_ve_trang_login(): void
    {

        $response = $this->withSession([
            'user_id'   => 1,
            'user_role' => 'admin',
        ])->post(route('logout'));


        $response->assertRedirect(route('login'));


        $this->assertNull(session('user_id'));
        $this->assertNull(session('user_role'));
    }
}
