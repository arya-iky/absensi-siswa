<?php

namespace Tests\Feature;

use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $admin = \App\Models\User::create([
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);
        $this->actingAs($admin);
    }

    private function createDummyStudent(array $override = []): Student
    {
        return Student::create(array_merge([
            'nis' => '1001',
            'nama' => 'Aditya Pratama',
            'jenis_kelamin' => 'Laki-laki',
            'kelas' => 'XII RPL 1',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Merdeka No. 12',
        ], $override));
    }

    public function test_can_display_student_list(): void
    {
        $this->createDummyStudent();

        $response = $this->get('/siswa');

        $response->assertStatus(200);
        $response->assertViewIs('siswa.index');
        $response->assertSee('Daftar Siswa');
        $response->assertSee('Aditya Pratama');
    }

    public function test_can_display_create_student_page(): void
    {
        $response = $this->get('/siswa/create');

        $response->assertStatus(200);
        $response->assertViewIs('siswa.create');
        $response->assertSee('Form Tambah Siswa');
    }

    public function test_can_store_new_student(): void
    {
        $payload = [
            'nis' => '2001',
            'nama' => 'Budi Santoso',
            'jenis_kelamin' => 'Laki-laki',
            'kelas' => 'X RPL 1',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'no_hp' => '0899999999',
            'alamat' => 'Alamat Pengujian',
        ];

        $response = $this->post('/siswa', $payload);

        $response->assertRedirect('/siswa');
        $this->assertDatabaseHas('students', ['nis' => '2001']);
    }

    public function test_can_display_student_detail(): void
    {
        $student = $this->createDummyStudent();

        $response = $this->get("/siswa/{$student->id}");

        $response->assertStatus(200);
        $response->assertViewIs('siswa.show');
        $response->assertSee($student->nama);
        $response->assertSee($student->nis);
    }

    public function test_can_display_edit_student_page(): void
    {
        $student = $this->createDummyStudent();

        $response = $this->get("/siswa/{$student->id}/edit");

        $response->assertStatus(200);
        $response->assertViewIs('siswa.edit');
        $response->assertSee($student->nama);
    }

    public function test_can_update_student(): void
    {
        $student = $this->createDummyStudent();

        $response = $this->put("/siswa/{$student->id}", [
            'nis' => $student->nis,
            'nama' => 'Nama Siswa Terupdate',
            'jenis_kelamin' => 'Perempuan',
            'kelas' => 'XII RPL 2',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'no_hp' => '0811111111',
            'alamat' => 'Alamat Terupdate',
        ]);

        $response->assertRedirect('/siswa');
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'nama' => 'Nama Siswa Terupdate',
            'jenis_kelamin' => 'Perempuan',
        ]);
    }

    public function test_can_delete_student(): void
    {
        $student = $this->createDummyStudent();

        $response = $this->delete("/siswa/{$student->id}");

        $response->assertRedirect('/siswa');
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }
}
