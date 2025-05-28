<?php

namespace App\Http\Controllers;

use App\Models\DetailProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DetailProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //  $product = Product::with(['reviews.user'])->findOrFail($id);

    // Tambahkan spesifikasi manual atau dari kolom json
    $product = (object)[
        'store' => 'Toko',
        'name' => 'Kaos Distro Pria Keren',
        'price' => 85000,
        'stock' => 50,
        'image' => 'products/kaos-distro.jpg',
        'description' => 'Kaos distro pria dengan bahan katun premium, cocok untuk gaya santai dan casual sehari-hari.',
        'specs' => collect([
            ['key' => 'Bahan', 'value' => 'Katun Combed 30s'],
            ['key' => 'Ukuran', 'value' => 'M, L, XL'],
            ['key' => 'Warna', 'value' => 'Hitam, Putih, Merah'],
            ['key' => 'Tipe', 'value' => 'Unisex'],
        ]),
        'reviews' => collect([
            (object)[
                'user' => (object)['name' => 'Andi'],
                'rating' => 5,
                'comment' => 'Kualitas bagus banget! Bahan adem dan nyaman dipakai.'
            ],
            (object)[
                'user' => (object)['name' => 'Sari'],
                'rating' => 4,
                'comment' => 'Barang sesuai deskripsi, pengiriman cepat.'
            ]
        ]),
    ];

    return view('frontend.detail', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailProduk $detailProduk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailProduk $detailProduk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailProduk $detailProduk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailProduk $detailProduk)
    {
        //
    }
}
