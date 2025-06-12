<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = DB::table('carts')->get();
        return view('backend.manajementtransaksi.cart.index',compact('carts'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $users = User::all();

        $produks = Produk::all();
        return view('backend.manajementtransaksi.cart.create',compact('produks','users'));
    }
  public function checkout()
{
    // Ambil semua user
    $users = User::all();

    // Ambil data carts yang belum checkout dengan relasi produk dan user
    $carts = DB::table('carts')
        ->join('produks', 'carts.kode_produk', '=', 'produks.kode_produk')
        ->join('users', 'carts.user_id', '=', 'users.id')
        ->select(
            'carts.id as cart_id',
            'carts.user_id',
            'carts.quantity',
            'carts.kode_produk',
            'carts.harga_produk',
            'produks.nama_produk',
            'produks.harga_produk',
            'users.name as user_name',
            'users.email as user_email'
        )
        ->get();

    // Ambil semua voucher

    // Kirim data ke view
    return view('backend.manajementtransaksi.cart.checkout', compact('users', 'carts'));
}


public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'kode_produk' => 'required|exists:produks,kode_produk',
        'quantity' => 'required|integer|min:1',
    ]);

    // Ambil data produk
    $produk = DB::table('produks')->where('kode_produk', $request->kode_produk)->first();

    if (!$produk) {
        return back()->with('error', 'Produk tidak ditemukan.');
    }

    // Hitung total quantity saat ini jika sudah ada di cart
    $existing = DB::table('carts')
        ->where('user_id', $request->user_id)
        ->where('kode_produk', $request->kode_produk)
        ->whereNull('deleted_at')
        ->first();

    $totalQuantity = $request->quantity;
    if ($existing) {
        $totalQuantity += $existing->quantity;
    }

    if ($totalQuantity > $produk->stok_produk) {
        return back()->with('error', 'Jumlah melebihi stok produk. Stok tersedia: ' . $produk->stok_produk);
    }

    if ($existing) {
        // Update quantity
        DB::table('carts')->where('id', $existing->id)->update([
            'quantity' => $existing->quantity + $request->quantity,
            'updated_at' => now()
        ]);
    } else {
        // Insert cart baru
        DB::table('carts')->insert([
            'user_id' => $request->user_id,
            'kode_produk' => $request->kode_produk,
            'quantity' => $request->quantity,
            'harga_produk' => $produk->harga_produk, // simpan harga saat ini
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke cart.');
}

public function checkoutStore(Request $request)
{
    $request->validate([
        'cart_ids' => 'required|array',
        'cart_ids.*' => 'exists:carts,id',
    ]);

    DB::beginTransaction();

    try {
        $cartIds = $request->input('cart_ids');
        $voucherId = $request->input('voucher_id');
        $kodeTransaksi = 'TRX-' . strtoupper(Str::random(10));

        // Ambil semua cart yang dipilih
        $carts = Cart::with(['produk', 'user'])->whereIn('id', $cartIds)->get();

        foreach ($carts as $cart) {
            Transaksi::create([
                'kode_transaksi'     => $kodeTransaksi,
                'user_id'            => $cart->user_id,
                'kode_produk'        => $cart->produk->kode_produk,
                'quantity'           => $cart->quantity,
                'harga_produk'       => $cart->produk->harga_produk,
                'total_harga_produk' => $cart->produk->harga_produk * $cart->quantity,
                'status'             => 'proses',

                // Ambil data dari relasi user
                'nama'               => $cart->user->name,
                'alamat'             => $cart->user->alamat ?? '',
                'no_hp'              => $cart->user->no_hp ?? '',
                'catatan'            => '', // Diisi jika ada form tambahan
            ]);
        }

        // Hapus cart yang sudah di-checkout
        Cart::whereIn('id', $cartIds)->delete();

        DB::commit();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diproses.');
    } catch (\Exception $e) {
        DB::rollback();
        return back()->with('error', 'Gagal memproses transaksi: ' . $e->getMessage());
    }
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
public function destroy($id)
{
    // Cari data cart berdasarkan ID
    $cart = DB::table('carts')->where('id', $id)->first();

    // Jika data tidak ditemukan
    if (!$cart) {
        return redirect()->back()->with('error', 'Data cart tidak ditemukan.');
    }

    // Hapus permanen dari database
    DB::table('carts')->where('id', $id)->delete();

    return redirect()->back()->with('success', 'Data cart berhasil dihapus.');
}

}
