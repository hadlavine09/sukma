<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Toko extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tokos';
    protected $primaryKey = 'id';

    // Jika kamu ingin menggunakan mass assignment secara eksplisit
    protected $fillable = [
        // Step 1
        'nama_toko',
        'no_hp',
        'kategori_toko',
        'alamat_toko',
        'logo_toko',
        'deskripsi_toko',

        // Step 2
        'nama_ktp',
        'nomor_ktp',
        'nomor_kk',
        'foto_ktp',
        'foto_kk',

        // Step 3
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik',

        // Step 4
        'email_cs',
        'wa_cs',
        'instagram',
        'facebook',
        'tiktok',
        'google_maps',

        // Step 5
        'hari_operasional', // disimpan sebagai JSON
        'jam_buka',
        'jam_tutup',
    ];

    // Optional: Cast JSON
    protected $casts = [
        'hari_operasional' => 'array', // Laravel akan decode otomatis JSON ke array
    ];
}
