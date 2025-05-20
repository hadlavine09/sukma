<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'kategoris'; // pastikan nama tabel benar
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'deskripsi_kategori',
        'gambar_kategori'
    ];



    public static function getSemuaKategori()
    {
        return self::all(); // Ambil semua data dari tabel kategoris
    }

}
