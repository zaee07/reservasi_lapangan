<?php

use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase
{
    private $CI;
    private $authController;
    private $mockPenggunaModel;
    private $mockSession;

    protected function setUp(): void
    {
        // Load CodeIgniter instance
        $this->CI = &get_instance();

        // Load controller Auth
        require_once APPPATH . 'controllers/Auth.php';
        $this->authController = new Auth();

        // Mock Pengguna_model
        $this->mockPenggunaModel = $this->getMockBuilder('Pengguna_model')
            ->disableOriginalConstructor()
            ->getMock();

        // Replace asli dengan mock
        $this->authController->pengguna = $this->mockPenggunaModel;
    }

    /** @test */
    public function test_login_username_tidak_ditemukan()
    {
        // Mock: username tidak ditemukan
        $this->mockPenggunaModel->method('get_by_username')
            ->willReturn(null);

        $_POST['username'] = 'salah';
        $_POST['password'] = 'password';

        // Tangkap output redirect
        $this->expectOutputRegex('/Username tidak ditemukan/');

        $this->authController->login();
    }

    /** @test */
    public function test_login_password_salah()
    {
        // Mock user ditemukan tapi password salah
        $this->mockPenggunaModel->method('get_by_username')
            ->willReturn([
                'id' => 1,
                'username' => 'admin',
                'password' => password_hash('benar123', PASSWORD_DEFAULT),
                'is_active' => 1,
                'role_id' => 1,
                'nama_role' => 'admin'
            ]);

        $_POST['username'] = 'admin';
        $_POST['password'] = 'salah';

        $this->expectOutputRegex('/Password salah/');

        $this->authController->login();
    }

    /** @test */
    public function test_login_akun_belum_aktif()
    {
        // Mock user belum aktif
        $this->mockPenggunaModel->method('get_by_username')
            ->willReturn([
                'id' => 1,
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'is_active' => 0,
                'role_id' => 1,
                'nama_role' => 'admin'
            ]);

        $_POST['username'] = 'admin';
        $_POST['password'] = 'admin123';

        $this->expectOutputRegex('/Akun belum aktif/');

        $this->authController->login();
    }

    /** @test */
    public function test_login_berhasil()
    {
        // Mock user aktif dan password benar
        $this->mockPenggunaModel->method('get_by_username')
            ->willReturn([
                'id' => 1,
                'username' => 'admin',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'is_active' => 1,
                'role_id' => 1,
                'nama_role' => 'admin'
            ]);

        $_POST['username'] = 'admin';
        $_POST['password'] = 'admin123';

        // Assert redirect ke dashboard
        $this->expectOutputRegex('/dashboard/');

        $this->authController->login();
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
