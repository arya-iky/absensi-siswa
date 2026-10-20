<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataCrudTest extends TestCase
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
    public function test_can_view_kelas_index_and_create(): void
    {
        $response = $this->get('/kelas');
        $response->assertStatus(200);
        $response->assertSee('Daftar Kelas');

        $response = $this->post('/kelas', [
            'nama_kelas' => 'X TKJ 1',
            'jurusan' => 'Teknik Komputer Jaringan',
            'wali_kelas' => 'Bpk. Ahmad',
        ]);
        $response->assertRedirect('/kelas');
        $this->assertDatabaseHas('classes', ['nama_kelas' => 'X TKJ 1']);
    }

    public function test_can_update_and_delete_kelas(): void
    {
        $kelas = Kelas::create([
            'nama_kelas' => 'XII RPL 3',
            'jurusan' => 'RPL',
        ]);

        $response = $this->put("/kelas/{$kelas->id}", [
            'nama_kelas' => 'XII RPL 3 Baru',
            'jurusan' => 'RPL Updated',
        ]);
        $response->assertRedirect('/kelas');
        $this->assertDatabaseHas('classes', ['nama_kelas' => 'XII RPL 3 Baru']);

        $deleteResponse = $this->delete("/kelas/{$kelas->id}");
        $deleteResponse->assertRedirect('/kelas');
        $this->assertDatabaseMissing('classes', ['id' => $kelas->id]);
    }

    // --- GURU TESTS ---
    public function test_can_view_guru_index_and_create(): void
    {
        $response = $this->get('/guru');
        $response->assertStatus(200);
        $response->assertSee('Daftar Guru Pengajar');

        $response = $this->post('/guru', [
            'nip' => '198501012010011001',
            'nama' => 'Drs. Supriyanto',
            'jenis_kelamin' => 'Laki-laki',
            'mata_pelajaran' => 'Matematika Terapan',
            'no_hp' => '081234567890',
        ]);
        $response->assertRedirect('/guru');
        $this->assertDatabaseHas('teachers', ['nip' => '198501012010011001']);
    }

    public function test_can_update_and_delete_guru(): void
    {
        $guru = Guru::create([
            'nip' => '199002022015012002',
            'nama' => 'Rina Marlina, S.Pd.',
            'jenis_kelamin' => 'Perempuan',
        ]);

        $response = $this->put("/guru/{$guru->id}", [
            'nip' => '199002022015012002',
            'nama' => 'Rina Marlina, M.Pd.',
            'jenis_kelamin' => 'Perempuan',
        ]);
        $response->assertRedirect('/guru');
        $this->assertDatabaseHas('teachers', ['nama' => 'Rina Marlina, M.Pd.']);

        $deleteResponse = $this->delete("/guru/{$guru->id}");
        $deleteResponse->assertRedirect('/guru');
        $this->assertDatabaseMissing('teachers', ['id' => $guru->id]);
    }

    // --- MAPEL TESTS ---
    public function test_can_view_mapel_index_and_create(): void
    {
        $response = $this->get('/mapel');
        $response->assertStatus(200);
        $response->assertSee('Daftar Mata Pelajaran');

        $response = $this->post('/mapel', [
            'kode_mapel' => 'RPL-99',
            'nama_mapel' => 'Cloud Computing',
            'jam_pelajaran' => 4,
        ]);
        $response->assertRedirect('/mapel');
        $this->assertDatabaseHas('subjects', ['kode_mapel' => 'RPL-99']);
    }

    public function test_can_update_and_delete_mapel(): void
    {
        $mapel = Mapel::create([
            'kode_mapel' => 'TKJ-99',
            'nama_mapel' => 'Cyber Security Basic',
            'jam_pelajaran' => 3,
        ]);

        $response = $this->put("/mapel/{$mapel->id}", [
            'kode_mapel' => 'TKJ-99',
            'nama_mapel' => 'Cyber Security Advanced',
            'jam_pelajaran' => 4,
        ]);
        $response->assertRedirect('/mapel');
        $this->assertDatabaseHas('subjects', ['nama_mapel' => 'Cyber Security Advanced']);

        $deleteResponse = $this->delete("/mapel/{$mapel->id}");
        $deleteResponse->assertRedirect('/mapel');
        $this->assertDatabaseMissing('subjects', ['id' => $mapel->id]);
    }
}

