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
                'nama'       => $request->nama,
                'no_hp'      => $request->no_hp,
                'card_id'    => null,
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
            $orderId = 'ORDER-' . strtoupper(Str::random(8));

            $pembayaran = Pembayaran::create([
                'user_id'          => $user->id,
                'id_loker_akses'   => $akses->id,
                'pembayaran'       => $totalBayar,
                'order_id'         => $orderId,  // ← SIMPAN ORDER ID DI SINI
                'status'           => 'pending', // optional
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

    public function sendWa(Request $request)
    {
        $pembayaran = \App\Models\Pembayaran::with(['user', 'lokerAkses.loker'])
                        ->findOrFail($request->id);

        $nama        = $pembayaran->user->nama;
        $nohp        = $pembayaran->user->no_hp;
        $kodeAkses   = $pembayaran->lokerAkses->kode_akses;
        $nomorLoker  = $pembayaran->lokerAkses->loker->nomor_loker;

        $pesan = "
    Halo *$nama* 👋

    Pembayaran sewa *Loker $nomorLoker* telah *BERHASIL*.

    Berikut kode akses loker Anda:
    🔐 *Kode Akses:* $kodeAkses

    Gunakan kode ini untuk membuka loker Anda.
    Terima kasih 🙏
    ";

        $token = env('FONNTE_TOKEN');

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'target'  => $nohp,
                'message' => $pesan,
            ],
            CURLOPT_HTTPHEADER => [
                "Authorization: $token"
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return response()->json(['status' => 'ok']);
    }

    public function validateKode(Request $request)
    {
        $request->validate([
            'kode_akses' => 'required',
            'loker_id'   => 'required'
        ]);

        $akses = \App\Models\LokerAkses::where('loker_id', $request->loker_id)
            ->where('kode_akses', $request->kode_akses)
            ->first();

        if (!$akses) {
            return redirect()->back()
                ->withErrors(['kode_akses' => 'Kode akses salah'])
                ->withInput()
                ->with('error_loker_id', $request->loker_id);
        }

        return redirect()->route('loker.detailPage', $akses->id);
    }

    public function detailSewaPage($id)
    {
        $akses = \App\Models\LokerAkses::with(['loker', 'pembayaran', 'pembayaran.user'])->findOrFail($id);

        return view('detail-akses', compact('akses'));
    }

    public function selesaikanSewa($id)
    {
        DB::transaction(function () use ($id) {

            $akses = LokerAkses::with('loker')->findOrFail($id);

            // Update status sewa
            $akses->update([
                'status' => 'selesai',
                'akhir_sewa' => now(),
            ]);

            // Kosongkan loker
            $akses->loker->update([
                'status' => 'kosong'
            ]);
        });

        return redirect()->route('beranda')
            ->with('success', 'Sesi sewa berhasil diselesaikan');
    }


}
