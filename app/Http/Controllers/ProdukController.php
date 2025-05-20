<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    public function index(Request $request)
{
    if ($request->ajax()) {
        // Ambil data produk
        $produk = Produk::all(); // Bisa diganti dengan query yang lebih kompleks, misalnya dengan filter atau pagination

        return DataTables::of($produk)
            ->addIndexColumn()
            ->editColumn('harga_produk', function ($data) {
                return 'Rp ' . number_format($data->harga_produk, 2, ',', '.'); // Format harga
            })
            ->editColumn('created_at', function ($data) {
                return \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i'); // Format waktu
            })
            ->addColumn('action', function ($data) {
                // Tombol untuk Show, Edit dan Hapus
                return '
                    <a href="' . route('produk.show', $data->kode_produk) . '" class="btn btn-info btn-sm">
                        <i class="bi bi-eye"></i> Show
                    </a>
                    <a href="' . route('produk.edit', $data->kode_produk) . '" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-btn" data-id="' . $data->kode_produk . '" data-nm="' . $data->nama_produk . '">
                        <i class="bi bi-trash"></i> Hapus
                    </a>
                ';
            })
            ->rawColumns(['action']) // Menandai kolom 'action' sebagai raw HTML untuk menghindari escaping
            ->make(true);  // DataTables JSON response
    }
    // $produk = Produk::all(); // Bisa diganti dengan query yang lebih kompleks, misalnya dengan filter atau pagination
    // dd($produk);

    // Mengirim data produk untuk tampilan normal jika tidak menggunakan AJAX
    return view('backend.manajementproduk.produk.index');
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategori = Kategori::getSemuaKategori();
        $tags = Tag::getSemuaTag();
        return view('backend.manajementproduk.produk.create',compact('kategori','tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Start a database transaction
        DB::beginTransaction();

        try {
            // Cek duplikasi nama produk
            $existingNama = DB::connection('pgsql')->table('produks')
                ->where('nama_produk', $request->nama_produk)
                ->exists();

            if ($existingNama) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Nama Produk "' . $request->nama_produk . '" sudah ada di database.')
                    ->withInput();
            }

            // Validasi deskripsi
            if (empty($request->deskripsi_produk) || strlen($request->deskripsi_produk) < 10) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Deskripsi harus diisi dan minimal 10 karakter.')
                    ->withInput();
            }

            // Validasi stok (minimal 1)
            if (!is_numeric($request->stok_produk) || $request->stok_produk < 1) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Stok produk tidak boleh kosong atau kurang dari 1.')
                    ->withInput();
            }

            // Validasi harga (minimal 1)
            if (!is_numeric($request->harga_produk) || $request->harga_produk < 1) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Harga produk tidak boleh kosong atau kurang dari 1.')
                    ->withInput();
            }

            // Validasi gambar
            if (!$request->hasFile('gambar_produk')) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Gambar produk wajib diunggah.')
                    ->withInput();
            } else {
                $ext = $request->file('gambar_produk')->extension();
                $allowed = ['jpg', 'jpeg', 'png'];
                if (!in_array($ext, $allowed)) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', 'File gambar harus berupa JPG, JPEG, atau PNG.')
                        ->withInput();
                }
            }

            // Validasi kode_kategori
            $kategoriAda = DB::connection('pgsql')->table('kategoris')
                ->where('kode_kategori', $request->kode_kategori)
                ->exists();

            if (!$kategoriAda) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Kategori tidak ditemukan.')
                    ->withInput();
            }

            // Validasi kode_tag
            foreach ($request->tags as $tag) {
                $cekTag = DB::connection('pgsql')->table('tags')
                    ->where('kode_tag', $tag)
                    ->exists();

                if (!$cekTag) {
                    DB::rollBack();
                    return redirect()->back()
                        ->with('error', 'Tag "' . $tag . '" tidak ditemukan.')
                        ->withInput();
                }
            }

            // Validasi status_produk
            $status = $request->status_produk;
            if (empty($status) || !in_array($status, ['Aktif', 'Tidak Aktif'])) {
                DB::rollBack();
                return redirect()->back()
                    ->with('error', 'Status produk wajib dipilih dan hanya boleh "Aktif" atau "Tidak Aktif".')
                    ->withInput();
            }

            // Simpan data produk
            $kode_produk = 'PRD-' . strtoupper(uniqid());
            $gambar = null;

            // Cek & buat folder jika belum ada
            if (!Storage::disk('public')->exists('produk')) {
                Storage::disk('public')->makeDirectory('produk');
            }

            // Upload gambar
            $gambar = $request->file('gambar_produk')->store('produk', 'public');

            $save_produk = Produk::create([
                'kode_produk'      => $kode_produk,
                'nama_produk'      => $request->nama_produk,
                'deskripsi_produk' => $request->deskripsi_produk,
                'stok_produk'      => $request->stok_produk,
                'harga_produk'     => $request->harga_produk,
                'gambar_produk'    => $gambar,
                'kode_kategori'    => $request->kode_kategori,
                'status_produk'    => $status,
            ]);

            // Insert related tags to tag_produks
            foreach ($request->tags as $tag) {
                DB::table('tag_produks')->insert([
                    'kode_tag'   => $tag,
                    'kode_produk' => $save_produk->kode_produk,
                ]);
            }

            // Commit the transaction
            DB::commit();

            return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Rollback in case of error
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage())
                ->withInput();
        }
    }



    /**
     * Display the specified resource.
     */
    public function show($kode_produk)
    {
        // Get the product and related category
        $produk = DB::table('produks')
            ->join('kategoris', 'produks.kode_kategori', '=', 'kategoris.kode_kategori')
            ->leftJoin('tag_produks', 'produks.kode_produk', '=', 'tag_produks.kode_produk')
            ->leftJoin('tags', 'tag_produks.kode_tag', '=', 'tags.kode_tag')
            ->where('produks.kode_produk', $kode_produk)
            ->select('produks.*', 'kategoris.nama_kategori', 'tags.nama_tag') // Select product, category, and tag name
            ->get();

        // Check if the product exists
        if ($produk->isEmpty()) {
            return redirect()->back()->with('error', 'Data produk tidak ditemukan.');
        }

        // Get the first product's details (there will only be one product since we are filtering by 'kode_produk')
        $produkDetail = $produk->first(); // Get the first product

        // Group the tags associated with the product
        $tags = $produk->pluck('nama_tag')->toArray(); // Pluck all the tags' names

        // Pass the product and tags to the view
        return view('backend.manajementproduk.produk.show', compact('produkDetail', 'tags'));
    }






    /**
     * Show the form for editing the specified resource.
     */
    public function edit($kode_produk)
    {
        // Ambil data produk berdasarkan kode_produk
        $produk = DB::table('produks')->where('kode_produk', $kode_produk)->first();

        // Validasi: jika data produk tidak ditemukan
        if (!$produk) {
            return redirect()->back()->with('error', 'Produk dengan kode ini tidak ditemukan.');
        }

        // Ambil semua kategori
        $kategori = Kategori::all();

        // Ambil tags yang terkait dengan produk ini
        $tags = DB::table('tag_produks')
                    ->join('tags', 'tag_produks.kode_tag', '=', 'tags.kode_tag')
                    ->where('tag_produks.kode_produk', $kode_produk)
                    ->pluck('tags.kode_tag')->toArray(); // Fetch associated tags

        // Ambil semua tags yang tersedia
        $allTags = Tag::all();

        // Tampilkan view edit dengan membawa data produk, kategori, tags yang ada, dan semua tags
        return view('backend.manajementproduk.produk.edit', compact('produk', 'kategori', 'tags', 'allTags'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kode_produk)
    {
        DB::beginTransaction();  // Start the transaction

        try {
            // Cek apakah produk dengan kode_produk ada
            $produk = Produk::where('kode_produk', $kode_produk)->first();

            if (!$produk) {
                throw new \Exception('Produk tidak ditemukan.');
            }

            // Cek duplikasi nama produk (kecuali produk itu sendiri)
            $existingNama = DB::connection('pgsql')->table('produks')
                ->where('nama_produk', $request->nama_produk)
                ->where('kode_produk', '!=', $kode_produk)  // pastikan tidak memeriksa produk itu sendiri
                ->exists();

            if ($existingNama) {
                throw new \Exception('Nama Produk "' . $request->nama_produk . '" sudah ada di database.');
            }

            // Validasi deskripsi
            if (empty($request->deskripsi_produk) || strlen($request->deskripsi_produk) < 10) {
                throw new \Exception('Deskripsi harus diisi dan minimal 10 karakter.');
            }

            // Validasi stok (minimal 1)
            if (!is_numeric($request->stok_produk) || $request->stok_produk < 1) {
                throw new \Exception('Stok produk tidak boleh kosong atau kurang dari 1.');
            }

            // Validasi harga (minimal 1)
            if (!is_numeric($request->harga_produk) || $request->harga_produk < 1) {
                throw new \Exception('Harga produk tidak boleh kosong atau kurang dari 1.');
            }

            // Validasi kategori
            $kategoriAda = DB::connection('pgsql')->table('kategoris')
                ->where('kode_kategori', $request->kode_kategori)
                ->exists();

            if (!$kategoriAda) {
                throw new \Exception('Kategori tidak ditemukan.');
            }

            // Validasi status produk
            $status = $request->status_produk;
            if (empty($status) || !in_array($status, ['Aktif', 'Tidak Aktif'])) {
                throw new \Exception('Status produk wajib dipilih dan hanya boleh "Aktif" atau "Tidak Aktif".');
            }

            // Cek dan buat folder jika belum ada
            if ($request->hasFile('gambar_produk')) {
                // Validasi gambar
                $ext = $request->file('gambar_produk')->extension();
                $allowed = ['jpg', 'jpeg', 'png'];
                if (!in_array($ext, $allowed)) {
                    throw new \Exception('File gambar harus berupa JPG, JPEG, atau PNG.');
                }

                // Jika gambar diunggah, simpan gambar ke folder produk
                if (!Storage::disk('public')->exists('produk')) {
                    Storage::disk('public')->makeDirectory('produk');
                }

                $gambar = $request->file('gambar_produk')->store('produk', 'public');
                $produk->gambar_produk = $gambar; // Update gambar produk
            }

            // Validasi dan update tags
            if ($request->has('tags') && is_array($request->tags)) {
                foreach ($request->tags as $tag) {
                    // Validasi apakah tag ada di database
                    $cekTag = DB::connection('pgsql')->table('tags')
                        ->where('kode_tag', $tag)
                        ->exists();

                    if (!$cekTag) {
                        throw new \Exception('Tag "' . $tag . '" tidak ditemukan.');
                    }
                }

                // Menghapus hubungan lama dan menambahkan tag baru
                DB::connection('pgsql')->table('tag_produks')
                    ->where('kode_produk', $kode_produk)  // Hapus hubungan lama
                    ->delete();

                // Menambahkan tag baru ke tag_produks
                foreach ($request->tags as $tag) {
                    DB::connection('pgsql')->table('tag_produks')->insert([
                        'kode_produk' => $kode_produk,
                        'kode_tag'    => $tag,
                    ]);
                }
            }

            // Update produk
            $produk->update([
                'nama_produk'       => $request->nama_produk,
                'deskripsi_produk'  => $request->deskripsi_produk,
                'stok_produk'       => $request->stok_produk,
                'harga_produk'      => $request->harga_produk,
                'kode_kategori'     => $request->kode_kategori,
                'status_produk'     => $status,
            ]);

            DB::commit();  // Commit the transaction if everything was successful
            return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();  // Rollback the transaction if any exception occurs
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage())
                ->withInput();
        }
    }


    public function destroy(Request $request)
    {
        $kode_produk = $request->kode_produk; // Mendapatkan kode_produk dari request

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Cari produk berdasarkan kode_produk
            $cek_produk = DB::connection('pgsql')->table('produks')->where('kode_produk', $kode_produk)->first();

            // Validasi: jika produk tidak ditemukan, return error
            if (!$cek_produk) {
                return redirect()->route('produk.index')->with('error', 'Produk tidak ditemukan.');
            }

            // Hapus gambar produk dari penyimpanan jika ada
            if ($cek_produk->gambar_produk) {
                $gambarPath = storage_path('app/public/' . $cek_produk->gambar_produk);
                if (file_exists($gambarPath)) {
                    unlink($gambarPath); // Hapus gambar dari penyimpanan
                }
            }

            // Hapus produk dari database
            DB::connection('pgsql')->table('produks')->where('kode_produk', $kode_produk)->delete();

            // Commit transaksi jika tidak ada error
            DB::commit();

            // Return success response
            return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');

        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            // Return error response
            return redirect()->route('produk.index')->with('error', 'Terjadi kesalahan dalam menghapus produk.');
        }
    }

}
