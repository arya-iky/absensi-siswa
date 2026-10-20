<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Data Kelas
        $classes = [
            ['nama_kelas' => 'X RPL 1', 'jurusan' => 'Rekayasa Perangkat Lunak', 'wali_kelas' => 'Drs. Hendra Gunawan'],
            ['nama_kelas' => 'XI RPL 1', 'jurusan' => 'Rekayasa Perangkat Lunak', 'wali_kelas' => 'Siti Nurhaliza, S.Pd.'],
            ['nama_kelas' => 'XII RPL 1', 'jurusan' => 'Rekayasa Perangkat Lunak', 'wali_kelas' => 'Budi Santoso, S.Kom.'],
            ['nama_kelas' => 'X TKJ 1', 'jurusan' => 'Teknik Komputer & Jaringan', 'wali_kelas' => 'Ahmad Fauzi, M.T.'],
            ['nama_kelas' => 'XI TKJ 2', 'jurusan' => 'Teknik Komputer & Jaringan', 'wali_kelas' => 'Dewi Anggraini, S.Kom.'],
            ['nama_kelas' => 'X DKV 1', 'jurusan' => 'Desain Komunikasi Visual', 'wali_kelas' => 'Eko Prasetyo, S.Sn.'],
        ];

        foreach ($classes as $c) {
            Kelas::firstOrCreate(['nama_kelas' => $c['nama_kelas']], $c);
        }

        // 2. Data Guru
        $teachers = [
            [
                'nip' => '198001012005011001',
                'nama' => 'Budi Santoso, S.Kom., M.T.',
                'jenis_kelamin' => 'Laki-laki',
                'mata_pelajaran' => 'Pemrograman Web & Bergerak',
                'no_hp' => '081211112222',
                'alamat' => 'Jl. Pendidikan No. 10, Bandung',
            ],
            [
                'nip' => '198505122010012003',
                'nama' => 'Siti Nurhaliza, S.Pd.',
                'jenis_kelamin' => 'Perempuan',
                'mata_pelajaran' => 'Basis Data & SQL',
                'no_hp' => '081233334444',
                'alamat' => 'Jl. Terusan Buah Batu No. 45, Bandung',
            ],
            [
                'nip' => '197903152006041002',
                'nama' => 'Ahmad Fauzi, M.T.',
                'jenis_kelamin' => 'Laki-laki',
                'mata_pelajaran' => 'Administrasi Infrastruktur Jaringan',
                'no_hp' => '081255556666',
                'alamat' => 'Jl. Kopo Permai No. 12, Bandung',
            ],
            [
                'nip' => '199011202018012005',
                'nama' => 'Dewi Anggraini, S.Kom.',
                'jenis_kelamin' => 'Perempuan',
                'mata_pelajaran' => 'Keamanan Jaringan Komputer',
                'no_hp' => '081277778888',
                'alamat' => 'Jl. Sukajadi No. 88, Bandung',
            ],
        ];

        foreach ($teachers as $t) {
            Guru::firstOrCreate(['nip' => $t['nip']], $t);
        }

        // 3. Data Mata Pelajaran
        $subjects = [
            ['kode_mapel' => 'RPL-01', 'nama_mapel' => 'Pemrograman Web & Bergerak', 'jam_pelajaran' => 4],
            ['kode_mapel' => 'RPL-02', 'nama_mapel' => 'Basis Data & Relasional Database', 'jam_pelajaran' => 3],
            ['kode_mapel' => 'RPL-03', 'nama_mapel' => 'Pemrograman Berorientasi Objek (PBO)', 'jam_pelajaran' => 4],
            ['kode_mapel' => 'TKJ-01', 'nama_mapel' => 'Administrasi Server & Jaringan', 'jam_pelajaran' => 4],
            ['kode_mapel' => 'UMUM-01', 'nama_mapel' => 'Pendidikan Pancasila & Kewarganegaraan', 'jam_pelajaran' => 2],
            ['kode_mapel' => 'UMUM-02', 'nama_mapel' => 'Bahasa Indonesia', 'jam_pelajaran' => 2],
            ['kode_mapel' => 'UMUM-03', 'nama_mapel' => 'Bahasa Inggris Kejuruan', 'jam_pelajaran' => 2],
        ];

        foreach ($subjects as $s) {
            Mapel::firstOrCreate(['kode_mapel' => $s['kode_mapel']], $s);
        }
    }
}

