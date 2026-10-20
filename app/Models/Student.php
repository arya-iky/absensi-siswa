<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'nama',
        'jenis_kelamin',
        'kelas',
        'jurusan',
        'no_hp',
        'alamat',
    ];

    /**
     * Relasi ke riwayat absensi siswa
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
