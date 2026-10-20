<?php

namespace Tests\Feature;

use App\Models\Attendance;
use App\Models\Kelas;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AttendanceTest extends TestCase
{
    use RefreshDatabase;

    private User $guru;
    private User $siswaUser;
    private Student $student;

    protected function setUp(): void
    {
        parent::setUp();

        $this->guru = User::create([
            'name' => 'Guru Pengajar',
            'email' => 'guru@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru',
        ]);

        $this->siswaUser = User::create([
            'name' => 'Aditya Pratama',
            'email' => 'siswa@sekolah.sch.id',
            'password' => Hash::make('password'),
            'role' => 'siswa',
        ]);

        Kelas::create([
            'nama_kelas' => 'XII RPL 1',
            'jurusan' => 'Rekayasa Perangkat Lunak',
        ]);

        $this->student = Student::create([
            'nis' => '1001',
            'nama' => 'Aditya Pratama',
            'jenis_kelamin' => 'Laki-laki',
            'kelas' => 'XII RPL 1',
            'jurusan' => 'Rekayasa Perangkat Lunak',
        ]);
    }

    public function test_guru_can_view_absensi_checklist_page(): void
    {
        $response = $this->actingAs($this->guru)->get('/absensi?tanggal=2026-10-16&kelas=XII+RPL+1');

        $response->assertStatus(200);
        $response->assertViewIs('absensi.index');
        $response->assertSee('Daftar Siswa Kelas XII RPL 1');
        $response->assertSee('Aditya Pratama');
    }

    public function test_guru_can_store_bulk_absensi(): void
    {
        $payload = [
            'tanggal' => '2026-10-16',
            'kelas' => 'XII RPL 1',
            'attendances' => [
                $this->student->id => [
                    'status' => 'Hadir',
                    'keterangan' => 'Tepat waktu',
                ],
            ],
        ];

        $response = $this->actingAs($this->guru)->post('/absensi', $payload);

        $response->assertRedirect(route('absensi.index', ['tanggal' => '2026-10-16', 'kelas' => 'XII RPL 1']));
        $this->assertDatabaseHas('attendances', [
            'student_id' => $this->student->id,
            'tanggal' => '2026-10-16',
            'status' => 'Hadir',
            'keterangan' => 'Tepat waktu',
        ]);
    }

    public function test_guru_can_view_rekap_page(): void
    {
        Attendance::create([
            'student_id' => $this->student->id,
            'tanggal' => '2026-10-16',
            'status' => 'Hadir',
        ]);

        $response = $this->actingAs($this->guru)->get('/rekap?bulan=2026-10&kelas=XII+RPL+1');

        $response->assertStatus(200);
        $response->assertViewIs('absensi.rekap');
        $response->assertSee('Rekap Kehadiran: Kelas XII RPL 1');
        $response->assertSee('Aditya Pratama');
    }

    public function test_siswa_can_view_own_riwayat(): void
    {
        Attendance::create([
            'student_id' => $this->student->id,
            'tanggal' => '2026-10-16',
            'status' => 'Hadir',
            'keterangan' => 'Hadir di lab RPL',
        ]);

        $response = $this->actingAs($this->siswaUser)->get('/riwayat-absensi');

        $response->assertStatus(200);
        $response->assertViewIs('absensi.riwayat');
        $response->assertSee('Riwayat Kehadiran Saya');
        $response->assertSee('Aditya Pratama');
    }

    public function test_siswa_cannot_access_guru_absensi_input(): void
    {
        $response = $this->actingAs($this->siswaUser)->get('/absensi');

        $response->assertStatus(403);
    }
}
