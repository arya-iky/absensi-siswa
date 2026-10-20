<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'mata_pelajaran',
        'no_hp',
        'alamat',
    ];
}

