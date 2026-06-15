<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Test cho AuthController (Đăng nhập / Đăng xuất)
 *
 * Chạy test: php artisan test tests/Feature/AuthControllerTest.php
 *
 * Lưu ý: Dùng DatabaseTransactions nên data thật KHÔNG bị xóa sau khi test.
 */
class AuthControllerTest extends TestCase
{
    use DatabaseTransactions;

    // ==========================================================
    // Test trang đăng nhập (GET /login)
    // ==========================================================

    #[Test]
    public function khach_co_the_xem_trang_dang_nhap(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    // ==========================================================
    // Test validation form đăng nhập
    // ==========================================================

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

    // ==========================================================
    // Test đăng nhập sai thông tin
    // ==========================================================

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
        // Tạo user mẫu trong DB (sẽ tự rollback sau test)
        User::factory()->create([
            'email'    => 'nhanvien@example.com',
            'password' => Hash::make('mat-khau-dung'),
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'nhanvien@example.com',
            'password' => 'mat-khau-sai',
        ]);

        $response->assertSessionHasErrors('email');
    }

    // ==========================================================
    // Test đăng nhập thành công → redirect đúng theo role
    // ==========================================================

    #[Test]
    public function admin_duoc_chuyen_den_trang_quan_tri(): void
    {
        $user = User::factory()->create([
            'email'    => 'admin@example.com',
            'password' => Hash::make('123456'),
            'role'     => 'admin',
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'admin@example.com',
            'password' => '123456',
        ]);

        // Kiểm tra redirect đúng trang
        $response->assertRedirect(route('admin.home'));

        // Kiểm tra session được lưu đúng
        $this->assertEquals($user->id, session('user_id'));
        $this->assertEquals('admin', session('user_role'));
    }

    #[Test]
    public function nhan_vien_duoc_chuyen_den_trang_ca_nhan(): void
    {
        User::factory()->create([
            'email'    => 'nv@example.com',
            'password' => Hash::make('123456'),
            'role'     => 'employee',
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'nv@example.com',
            'password' => '123456',
        ]);

        $response->assertRedirect(route('user.home'));
    }

    // ==========================================================
    // Test đăng xuất
    // ==========================================================

    #[Test]
    public function dang_xuat_xoa_session_va_quay_ve_trang_login(): void
    {
        // Giả lập đang đăng nhập
        $response = $this->withSession([
            'user_id'   => 1,
            'user_role' => 'admin',
        ])->post(route('logout'));

        // Phải redirect về trang login
        $response->assertRedirect(route('login'));

        // Session phải bị xóa
        $this->assertNull(session('user_id'));
        $this->assertNull(session('user_role'));
    }
}
