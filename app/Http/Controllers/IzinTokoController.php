<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Toko;
use App\Models\IzinToko;
use App\Models\DetailToko;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\kategori_toko;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class IzinTokoController extends Controller
{

public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data toko
            $toko = DB::table('tokos')
                ->join('users', 'tokos.pemilik_toko_id', '=', 'users.id')
                ->join('kategori_tokos', 'tokos.kategori_toko_id', '=', 'kategori_tokos.id')
                ->where('tokos.status_toko','proses')
                ->whereNull('tokos.deleted_at')
                ->whereNull('kategori_tokos.deleted_at')
                ->select('tokos.*', 'users.username as nama_pemilik', 'kategori_tokos.nama_kategori_toko')
                ->get();
            return DataTables::of($toko)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return '
                        <a href="' . route('izin_toko.show', $data->kode_toko) . '" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i> Show
                        </a>
                        <button onclick="izinToko(\'' . $data->id . '\')" class="btn btn-sm btn-success">
                            <i class="bi bi-check-circle"></i> Izinkan
                        </button>
                        <button onclick="tolakToko(\'' . $data->id . '\')" class="btn btn-sm btn-danger">
                            <i class="bi bi-x-circle"></i> Tolak
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        // Mengirim data toko untuk tampilan normal jika tidak menggunakan AJAX
        return view('backend.manajementtoko.pendaftarantoko.index');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $kategoriTokos = kategori_toko::all();
        return view('backend.manajementtoko.pendaftarantoko.create',compact('kategoriTokos'));

    }
   public function izinkan(Request $request)
{
    $kode_toko = $request->input('kode_toko');

    DB::beginTransaction();
    try {
        // Ambil data toko dengan status 'proses'
        $toko = DB::table('tokos')
            ->where('status_toko', 'proses')
            ->where('kode_toko', $kode_toko)
            ->first();

        if (!$toko) {
            return redirect()->back()->with('error', 'Toko tidak ditemukan atau status tidak sesuai.');
        }

        // Update status toko menjadi 'izinkan'
        DB::table('tokos')
            ->where('id', $toko->id)
            ->update(['status_toko' => 'izinkan']);

        // Generate nomor izin otomatis
        $last = IzinToko::orderBy('nomor_izin', 'desc')->first();
        $lastNumber = 0;

        if ($last && preg_match('/IZT(\d+)/', $last->nomor_izin, $matches)) {
            $lastNumber = (int)$matches[1];
        }

        $nomor_izin = 'IZT' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        // Simpan data ke tabel izin_tokos
        IzinToko::create([
            'toko_id' => $toko->id,
            'nomor_izin' => $nomor_izin,
            'nama_dokumen' => 'Dokumen Izin Toko #' . $toko->id,
            'file_dokumen' => 'default.pdf', // Ubah jika menggunakan upload file
            'tanggal_terbit' => Carbon::now()->toDateString(),
            'created_at' => Carbon::now(),
        ]);

        DB::commit();
        return redirect()->back()->with('success', 'Toko berhasil diizinkan dan data izin disimpan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Gagal memproses izin: ' . $e->getMessage());
    }
}
   public function tidak_izinkan(Request $request)
{
    $kode_toko = $request->input('kode_toko');

    DB::beginTransaction();
    try {
        // Ambil data toko dengan status 'proses'
        $toko = DB::table('tokos')
            ->where('status_toko', 'proses')
            ->where('kode_toko', $kode_toko)
            ->first();

        if (!$toko) {
            return redirect()->back()->with('error', 'Toko tidak ditemukan atau status tidak sesuai.');
        }

        // Update status toko menjadi 'tidak_diizinkan'
        DB::table('tokos')
            ->where('id', $toko->id)
            ->update(['status_toko' => 'tidak_diizinkan']);


        DB::commit();
        return redirect()->back()->with('success', 'Toko berhasil tidak diizinkan dan data izin disimpan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Gagal memproses izin: ' . $e->getMessage());
    }
}
    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
{
    // dd($request->all());
    DB::beginTransaction();

    try {
        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'kategori_toko_id' => 'required|exists:kategori_tokos,id',
            'no_hp_toko' => 'required|string|max:20',
            'alamat_toko' => 'required|string',
            'deskripsi_toko' => 'nullable|string',
            'logo_toko' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'nama_ktp' => 'required|string|max:255',
            'nomor_ktp' => 'required|string|max:50',
            'nomor_kk' => 'required|string|max:50',
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'foto_kk' => 'required|image|mimes:jpg,jpeg,png|max:2048',

            'nama_bank' => 'nullable|string|max:255',
            'nomor_rekening' => 'nullable|string|max:100',
            'nama_pemilik_rekening' => 'nullable|string|max:255',

            'email_cs' => 'nullable|email|max:255',
            'whatsapp_cs' => 'nullable|string|max:20',
            'link_instagram' => 'nullable|string|max:255',
            'link_facebook' => 'nullable|string|max:255',
            'link_tiktok' => 'nullable|string|max:255',
            'link_google_maps' => 'nullable|string|max:255',

            'jadwal' => 'required|array',
        ]);

        // Upload logo toko
        $logoPath = $request->hasFile('logo_toko')
            ? $request->file('logo_toko')->store('logo_toko', 'public')
            : null;

        // Upload KTP dan KK
        $ktpPath = $request->file('foto_ktp')->store('dokumen_ktp', 'public');
        $kkPath = $request->file('foto_kk')->store('dokumen_kk', 'public');

         $last = Toko::withoutTrashed()->orderBy('kode_toko', 'desc')->first();
        $lastNumber = $last ? (int)substr($last->kode_toko, 4) : 0;
        $newKode = 'TK' . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        $toko = Toko::create([
            'kode_toko' => $newKode,
            'pemilik_toko_id' => auth()->id(),
            'kategori_toko_id' => $request->kategori_toko_id,
            'nama_toko' => $request->nama_toko,
            'logo_toko' => $logoPath,
            'no_hp_toko' => $request->no_hp_toko,
            'alamat_toko' => $request->alamat_toko,
            'deskripsi_toko' => $request->deskripsi_toko,
            'status_aktif_toko' => 1,
        ]);

        DetailToko::create([
            'toko_id' => $toko->id,
            'nama_bank' => $request->nama_bank,
            'nomor_rekening' => $request->nomor_rekening,
            'nama_pemilik_rekening' => $request->nama_pemilik_rekening,
            'email_cs' => $request->email_cs,
            'whatsapp_cs' => $request->whatsapp_cs,
            'link_instagram' => $request->link_instagram,
            'link_facebook' => $request->link_facebook,
            'link_tiktok' => $request->link_tiktok,
            'link_google_maps' => $request->link_google_maps,
            'catatan_tambahan' => null,
            'nomor_ktp' => $request->nomor_ktp,
            'nomor_kk' => $request->nomor_kk,
            'nama_ktp' => $request->nama_ktp,
            'foto_ktp' => $ktpPath,
            'foto_kk' => $kkPath,
        ]);

        foreach ($request->jadwal as $hari => $data) {
            DB::table('jam_operasionals')->insert([
                'toko_id' => $toko->id,
                'hari' => $hari,
                'buka' => isset($data['buka']) && $data['buka'] == '1',
                'jam_buka' => $data['jam_buka'] ?? null,
                'jam_tutup' => $data['jam_tutup'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::commit();
        return redirect()->route('izin_toko.index')->with('success', 'Toko berhasil didaftarkan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
}



    /**
     * Display the specified resource.
     */

    public function show($kode_toko)
{
    // Ambil detail utama toko (1 baris)
    $tokoshow = DB::table('tokos')
        ->join('users', 'tokos.pemilik_toko_id', '=', 'users.id')
        ->join('kategori_tokos', 'tokos.kategori_toko_id', '=', 'kategori_tokos.id')
        ->join('detail_tokos', 'tokos.id', '=', 'detail_tokos.toko_id')
        ->where('tokos.kode_toko', $kode_toko)
        ->whereNull('tokos.deleted_at')
        ->whereNull('kategori_tokos.deleted_at')
        ->select(
            'tokos.*',
            'users.username as nama_pemilik',
            'kategori_tokos.nama_kategori_toko',
            'detail_tokos.nama_ktp',
            'detail_tokos.nomor_ktp',
            'detail_tokos.nomor_kk',
            'detail_tokos.foto_ktp',
            'detail_tokos.foto_kk',
            'detail_tokos.nama_bank',
            'detail_tokos.nomor_rekening',
            'detail_tokos.nama_pemilik_rekening',
            'detail_tokos.email_cs',
            'detail_tokos.whatsapp_cs',
            'detail_tokos.link_instagram',
            'detail_tokos.link_facebook',
            'detail_tokos.link_tiktok',
            'detail_tokos.link_google_maps',
            'tokos.logo_toko'

        )
        ->first();

    if (!$tokoshow) {
        return redirect()->back()->with('error', 'Toko tidak ditemukan.');
    }

    // Ambil jam operasional per hari (banyak baris)
    $jadwalOperasional = DB::table('jam_operasionals')
    ->where('toko_id', $tokoshow->id)
    ->orderByRaw("CASE
        WHEN hari = 'Senin' THEN 1
        WHEN hari = 'Selasa' THEN 2
        WHEN hari = 'Rabu' THEN 3
        WHEN hari = 'Kamis' THEN 4
        WHEN hari = 'Jumat' THEN 5
        WHEN hari = 'Sabtu' THEN 6
        WHEN hari = 'Minggu' THEN 7
        ELSE 8 END")
    ->get();


    return view('backend.manajementtoko.pendaftarantoko.show', compact('tokoshow', 'jadwalOperasional'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IzinToko $izinToko)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IzinToko $izinToko)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IzinToko $izinToko)
    {
        //
    }

    public function verifikasi_toko(){
        return view('toko.verifikasi');
    }
}
