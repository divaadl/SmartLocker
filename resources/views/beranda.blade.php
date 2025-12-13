<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Loker</title>

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

    /* Background galaksi */
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

    /* HEADER */
    .galaxy-header {
        text-align: center;
        padding: 80px 20px 40px;
        animation: fadeDown 1.2s ease;
    }

    @keyframes fadeDown {
        from { opacity: 0; transform: translateY(-25px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .galaxy-header h1 {
        font-weight: 700;
        font-size: 40px;
        background: linear-gradient(90deg, #fc67fa, #5cc2ff, #a06bff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .galaxy-header p {
        opacity: 0.9;
        max-width: 650px;
        margin: auto;
        font-size: 17px;
    }

    /* CARD LOKER */
    .loker-box {
        position: relative;
        border-radius: 18px;
        padding: 25px 20px;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(14px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.45), inset 0 0 15px rgba(255, 255, 255, 0.1);
        transition: 0.35s ease;
        height: 100%; /* agar tinggi rata */
    }

    .loker-box:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 12px 35px rgba(0,0,0,0.6), inset 0 0 20px rgba(255, 255, 255, 0.18);
        border-color: rgba(255, 255, 255, 0.25);
    }

    .loker-top-strip {
        width: 70%;
        height: 6px;
        background: linear-gradient(90deg, #ff4df0, #b46bff, #6a9dff);
        border-radius: 5px;
        margin: 0 auto 14px;
        box-shadow: 0 0 12px rgba(255, 143, 255, 0.7);
    }

    /* KEYHOLE */
    .locker-keyhole {
        width: 32px;
        height: 32px;
        background: linear-gradient(145deg, #c36bff, #6b2cff);
        margin: 12px auto;
        border-radius: 50%;
        position: relative;
        box-shadow: 0 0 12px rgba(162, 120, 255, 0.8), inset 0 0 6px rgba(255, 255, 255, 0.3);
    }

    .locker-keyhole::after {
        content: "";
        width: 8px;
        height: 14px;
        background: #fff;
        position: absolute;
        top: 9px;
        left: 50%;
        transform: translateX(-50%);
        border-radius: 3px;
        opacity: 0.9;
    }

    /* BUTTON */
    .btn-sewa {
        border-radius: 14px;
        padding: 12px 15px;
        width: 100%;
        background: linear-gradient(135deg, #ff6bd6, #ff8b5e, #ffbd4b);
        border: none;
        font-weight: 600;
        color: white;
        transition: 0.25s;
        box-shadow: 0 4px 15px rgba(255, 100, 200, 0.6);
    }

    .btn-sewa:hover {
        transform: scale(1.08) translateY(-2px);
        box-shadow: 0 7px 22px rgba(255, 100, 200, 0.75);
        filter: brightness(1.15);
    }

    /* MODAL */
    .modal-content {
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.07);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: white;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: white;
    }

    .form-control:focus {
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.4);
    }

    /* ---------------------------- */
    /*      RESPONSIVE FIXES        */
    /* ---------------------------- */

    /* Tablet */
    @media (max-width: 992px) {
        .galaxy-header h1 {
            font-size: 32px;
        }
        .loker-box {
            padding: 20px 16px;
        }
    }

    /* Mobile */
    @media (max-width: 576px) {
        .galaxy-header {
            padding: 60px 10px 30px;
        }

        .galaxy-header h1 {
            font-size: 27px;
        }

        .galaxy-header p {
            font-size: 15px;
            padding: 0 15px;
        }

        .loker-box {
            padding: 18px;
        }

        .loker-top-strip {
            width: 80%;
        }

        .locker-keyhole {
            width: 28px;
            height: 28px;
        }

        .btn-sewa {
            font-size: 14px;
            padding: 10px;
        }
    }
    </style>
</head>

<body>

<!-- HEADER GALAXY -->
<div class="galaxy-header">
    <h1>Selamat Datang di Website Sewa Loker</h1>
    <p>
        Sistem ini menyediakan layanan penyewaan loker secara mudah dan cepat.
        Pilih loker yang tersedia, isi data penyewa, dan lakukan pembayaran.
        Semua proses dilakukan secara online dan real-time.
    </p>
</div>

<div class="container py-5">

    <h2 class="text-center mb-4">Daftar Loker</h2>

    <div class="row g-4 justify-content-center">

        @foreach($lokers as $loker)
            <div class="col-lg-3 col-md-4 col-sm-6">

                <div class="loker-box text-center">

                    <div class="loker-top-strip"></div>

                    <h4 class="fw-bold">Loker {{ $loker->nomor_loker }}</h4>

                    @if($loker->status == 'kosong')
                        <span class="badge bg-success">Kosong</span>
                    @else
                        <span class="badge bg-danger">Disewa</span>
                    @endif

                    <div class="locker-keyhole"></div>

                    @if($loker->status == 'kosong')
                        <button class="btn btn-sewa mt-2"
                                data-bs-toggle="modal"
                                data-bs-target="#modalSewa"
                                onclick="pilihLoker({{ $loker->id }})">
                            Sewa Sekarang
                        </button>
                    @else
                        <!-- TOMBOL DETAIL (TAMBAHAN) -->
                        <button class="btn btn-sewa mt-2"
                                style="background: linear-gradient(135deg,#6b9bff,#9f6bff,#d66bff); box-shadow:0 4px 15px rgba(150,120,255,0.6);"
                                data-bs-toggle="modal"
                                data-bs-target="#modalAkses{{ $loker->id }}">
                            Info Sewa
                        </button>
                    @endif


                </div>

            </div>
        @endforeach

    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalSewa" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="{{ route('sewa.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Form Sewa Loker</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-4">

                    <input type="hidden" name="loker_id" id="selectedLokerId">

                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Mulai Sewa</label>
                        <input type="datetime-local" name="awal_sewa" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Akhir Sewa</label>
                        <input type="datetime-local" name="akhir_sewa" class="form-control">
                    </div>

                </div>

                <div class="modal-footer px-4">
                    <button type="submit" class="btn btn-sewa w-100">Lanjut Pembayaran</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function pilihLoker(id) {
        document.getElementById('selectedLokerId').value = id;
    }
</script>
<!-- ===================================================== -->
<!--          MODAL INPUT KODE AKSES (PER LOKER)          -->
<!-- ===================================================== -->
@foreach($lokers as $loker)
<div class="modal fade" id="modalAkses{{ $loker->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" action="{{ route('loker.validateKode') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Masukkan Kode Akses Loker {{ $loker->nomor_loker }}</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-4">

                    <label>Kode Akses</label>
                    @if ($errors->has('kode_akses') && session('error_loker_id') == $loker->id)
                        <div class="alert alert-danger text-center">
                            {{ $errors->first('kode_akses') }}
                        </div>
                    @endif

                    <input type="text"
                        name="kode_akses"
                        class="form-control mb-3 @if($errors->has('kode_akses') && session('error_loker_id') == $loker->id) is-invalid @endif"
                        value="{{ old('kode_akses') }}"
                        required>


                    <input type="hidden" name="loker_id" value="{{ $loker->id }}">

                </div>

                <div class="modal-footer px-4">
                    <button type="submit" class="btn btn-sewa w-100"
                        style="background: linear-gradient(135deg,#6b9bff,#9f6bff,#d66bff);">
                        Lihat Detail
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endforeach
@if ($errors->has('kode_akses') && session('error_loker_id'))
<script>
document.addEventListener("DOMContentLoaded", function () {

    const modalKey = "opened_modal_{{ session('error_loker_id') }}";

    // kalau belum pernah dibuka
    if (!sessionStorage.getItem(modalKey)) {

        let modalEl = document.getElementById("modalAkses{{ session('error_loker_id') }}");

        if (modalEl) {
            let modal = new bootstrap.Modal(modalEl);
            modal.show();

            // tandai sudah dibuka
            sessionStorage.setItem(modalKey, "true");

            // saat ditutup, jangan buka lagi
            modalEl.addEventListener('hidden.bs.modal', function () {
                // optional: clear error visual
            });
        }
    }

});
</script>
@endif

</body>
</html>
