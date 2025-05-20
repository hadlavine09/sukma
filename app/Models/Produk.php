<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    // Tentukan nama tabel (jika berbeda dari konvensi)
    protected $table = 'produks';
    protected $primaryKey = 'id';

    // Kolom yang dapat diisi mass-assignment
    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'deskripsi_produk',
        'stok_produk',
        'harga_produk',
        'gambar_produk',
        'kode_kategori',
        'status_produk',
    ];

    protected $connection = 'pgsql'; // kalau pakai pgsql, wajib ini

    public static function getSemuaProduk()
    {
        return self::all(); // Ambil semua data dari tabel kategoris
    }
}
