<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiKaryawan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'jam_absensi_masuk', 'jam_absensi_pulang', 'status_absensi_masuk'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
