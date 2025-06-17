<?php

namespace App\Http\Controllers;

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
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
    {
        if ($request->ajax()) {
            // Ambil data toko
            $toko = IzinToko::all();
            return DataTables::of($toko)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    // Tombol untuk Show, Edit dan Hapus
                    return '
                        <a href="' . route('toko.show', $data->kode_toko) . '" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Show
                        </a>
                        <a href="' . route('toko.edit', $data->kode_toko) . '" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm delete-btn" data-id="' . $data->kode_toko . '" data-nm="' . $data->nama_toko . '">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    ';
                })
                ->rawColumns(['action']) // Menandai kolom 'action' sebagai raw HTML untuk menghindari escaping
                ->make(true);            // DataTables JSON response
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
        return redirect()->route('toko.index')->with('success', 'Toko berhasil didaftarkan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
    }
}



    /**
     * Display the specified resource.
     */
    public function show(IzinToko $izinToko)
    {
        //
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
}
