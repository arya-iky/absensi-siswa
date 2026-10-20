<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = [
            [
                'nis' => '1001',
                'nama' => 'Aditya Pratama',
                'jenis_kelamin' => 'Laki-laki',
                'kelas' => 'XII RPL 1',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'no_hp' => '081234567801',
                'alamat' => 'Jl. Merdeka No. 12, Bandung',
            ],
            [
                'nis' => '1002',
                'nama' => 'Bunga Citra Lestari',
                'jenis_kelamin' => 'Perempuan',
                'kelas' => 'XII RPL 1',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'no_hp' => '081234567802',
                'alamat' => 'Jl. Mawar No. 5, Cimahi',
            ],
            [
                'nis' => '1003',
                'nama' => 'Dimas Arya Nugraha',
                'jenis_kelamin' => 'Laki-laki',
                'kelas' => 'XI TKJ 2',
                'jurusan' => 'Teknik Komputer & Jaringan',
                'no_hp' => '081234567803',
                'alamat' => 'Jl. Anggrek No. 8, Bandung',
            ],
            [
                'nis' => '1004',
                'nama' => 'Fitri Handayani',
                'jenis_kelamin' => 'Perempuan',
                'kelas' => 'XI TKJ 2',
                'jurusan' => 'Teknik Komputer & Jaringan',
                'no_hp' => '081234567804',
                'alamat' => 'Jl. Cempaka No. 20, Bandung',
            ],
            [
                'nis' => '1005',
                'nama' => 'Gilang Ramadhan',
                'jenis_kelamin' => 'Laki-laki',
                'kelas' => 'X DKV 1',
                'jurusan' => 'Desain Komunikasi Visual',
                'no_hp' => '081234567805',
                'alamat' => 'Jl. Kenanga No. 14, Soreang',
            ],
        ];

        foreach ($students as $data) {
            Student::firstOrCreate(['nis' => $data['nis']], $data);
        }
    }
}
