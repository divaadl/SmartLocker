<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Detail Sewa Loker</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Poppins", sans-serif;
            background: radial-gradient(circle at top, #4b1fa3 0%, #20055a 40%, #0b012b 100%);
            min-height: 100vh;
            color: white;
            overflow-x: hidden;
        }

        /* Background Galaxy */
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("https://raw.githubusercontent.com/istareh/vecteezy-backgrounds/main/galaxy/galaxy-purple.png");
            background-size: cover;
            opacity: 0.35;
            z-index: -1;
        }

        /* CARD GLASS */
        .card-glass {
            background: rgba(255, 255, 255, 0.07);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(14px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.45), inset 0 0 18px rgba(255,255,255,0.12);
            animation: fadeDown 0.9s ease;
        }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h3 {
            font-weight: 600;
            font-size: 30px;
            background: linear-gradient(90deg, #fc67fa, #5cc2ff, #a06bff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            margin-bottom: 20px;
        }

        p strong {
            color: #ff9bff;
            text-shadow: 0 0 6px rgba(255, 159, 255, 0.8);
        }

        /* BADGE */
        .badge-custom {
            padding: 7px 12px;
            border-radius: 10px;
            font-size: 14px;
            background: linear-gradient(135deg, #ff6bd6, #ff8b5e, #ffbd4b);
            box-shadow: 0 0 10px rgba(255,120,200,0.7);
        }

        .badge-paid {
            background: linear-gradient(135deg, #29ff83, #4bffb0);
            box-shadow: 0 0 12px rgba(80,255,160,0.8);
        }

        .badge-unpaid {
            background: linear-gradient(135deg, #ffe36b, #ffc94b);
            box-shadow: 0 0 12px rgba(255,210,120,0.8);
            color: black;
        }

        /* BUTTON */
        .btn-galaxy {
            width: 100%;
            padding: 12px;
            border-radius: 14px;
            background: linear-gradient(135deg, #ff6bd6, #ff8b5e, #ffbd4b);
            border: none;
            font-weight: 600;
            color: white;
            box-shadow: 0 4px 15px rgba(255, 100, 200, 0.6);
            transition: 0.25s;
            margin-top: 20px;
        }

        .btn-galaxy:hover {
            transform: scale(1.08) translateY(-2px);
            box-shadow: 0 7px 22px rgba(255, 100, 200, 0.8);
            filter: brightness(1.15);
        }
    </style>
</head>

<body>

<div class="container mt-5" style="max-width: 700px;">

    <div class="card-glass">

        <h3>Detail Sewa Loker</h3>

        <hr style="border-color: rgba(255,255,255,0.2);">

        <p><strong>Nama Penyewa:</strong> {{ $akses->nama }}</p>
        <p><strong>Nomor HP:</strong> {{ $akses->no_hp }}</p>
        <p><strong>Loker:</strong> Loker {{ $akses->loker->nomor_loker }}</p>
        <p><strong>Mulai Sewa:</strong> {{ $akses->awal_sewa }}</p>
        <p><strong>Akhir Sewa:</strong> {{ $akses->akhir_sewa }}</p>
        <p><strong>Kode Akses:</strong> {{ $akses->kode_akses }}</p>

        <p><strong>Status Pembayaran:</strong><br>
            @if($akses->pembayaran->status == 'lunas')
                <span class="badge badge-paid">Sudah Dibayar</span>
            @else
                <span class="badge badge-unpaid">Belum Dibayar</span>
            @endif
        </p>

    </div>

    <!-- TOMBOL AKSI -->
    <div class="row mt-5 g-3">

        <!-- KEMBALI -->
        <div class="col-md-6">
            <a href="{{ route('beranda') }}"
            class="btn-galaxy text-center d-block">
                Kembali ke Beranda
            </a>
        </div>

        <!-- SELESAIKAN SEWA -->
        @if($akses->status !== 'selesai')
        <div class="col-md-6">
            <form action="{{ route('sewa.selesai', $akses->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menyelesaikan sesi sewa ini?')">

                @csrf
                <button type="submit"
                        class="btn-galaxy w-100">
                    Selesaikan / Batalkan Sesi
                </button>
            </form>
        </div>
        @endif

    </div>




</div>

</body>
</html>
