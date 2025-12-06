<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Loker;
use App\Models\LokerAkses;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

class SewaController extends Controller
{

    public function beranda()
    {
    $lokers = \App\Models\Loker::orderBy('nomor_loker')->get();

    return view('beranda', compact('lokers'));
    }

    public function sewa(Request $request)
    {
        // 1. VALIDASI INPUT
        $request->validate([
            'nama'        => 'required|string|max:255',
            'no_hp'       => 'required|string|max:20',
            'loker_id'    => 'required|exists:lokers,id',
            'awal_sewa'   => 'required|date',
            'akhir_sewa'  => 'required|date|after_or_equal:awal_sewa',
        ]);

        DB::beginTransaction();

        try {

            // 2. CARI ATAU BUAT USER
            $user = User::firstOrCreate(
                ['no_hp' => $request->no_hp],
                ['nama' => $request->nama]
            );

            // 3. CEK LOKER APAKAH SUDAH DIPAKAI
            $loker = Loker::findOrFail($request->loker_id);

            if ($loker->status == 'disewa') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Loker sedang disewa!'
                ], 400);
            }

            // 4. GENERATE KODE AKSES RFID
            $kodeAkses = strtoupper(Str::random(8));

            // 5. SIMPAN DATA SEWA (LOKER_AKSES)
            $akses = LokerAkses::create([
                'loker_id'   => $loker->id,
                'card_id'    => null, // akan terisi nanti saat kartu ditempel
                'kode_akses' => $kodeAkses,
                'awal_sewa'  => $request->awal_sewa,
                'akhir_sewa' => $request->akhir_sewa,
                'status'     => 'nonaktif',
            ]);

            // 6. UPDATE STATUS LOKER → DISEWA
            $loker->update(['status' => 'terpakai']);

            // 7. HITUNG HARGA SEWA PER JAM
            $mulai = Carbon::parse($request->awal_sewa);
            $akhir = Carbon::parse($request->akhir_sewa);

            $durasiJam = $mulai->diffInMinutes($akhir) / 60;
            $durasiJam = ceil($durasiJam); // dibulatkan ke atas

            $hargaPerJam = 5000;
            $totalBayar = $durasiJam * $hargaPerJam;

            // 8. SIMPAN PEMBAYARAN
            $pembayaran = Pembayaran::create([
                'user_id'          => $user->id,
                'id_loker_akses'   => $akses->id,
                'pembayaran'       => $totalBayar,
            ]);

            DB::commit();

            return redirect()->route('pembayaran.detail', $pembayaran->id);
                } catch (\Exception $e) {

                DB::rollBack();
                return back()->with('error', $e->getMessage());
            }
    }

    public function detailPembayaran($id){
    $pembayaran = Pembayaran::with(['user', 'lokerAkses.loker'])->findOrFail($id);

    return view('pembayaran.detail', compact('pembayaran'));
    }

}
