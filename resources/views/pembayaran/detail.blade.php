<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pembayaran</title>

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

        /* background galaksi */
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

        /* container card */
        .payment-card {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 18px;
            padding: 35px 28px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(14px);
            box-shadow:
                0 8px 25px rgba(0,0,0,0.45),
                inset 0 0 15px rgba(255, 255, 255, 0.1);
            animation: fadeUp 1.2s ease;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(25px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .payment-card h3 {
            font-weight: 700;
            font-size: 28px;
            background: linear-gradient(90deg, #fc67fa, #5cc2ff, #a06bff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .label-title {
            font-weight: 600;
            opacity: 0.9;
        }

        .value-text {
            font-size: 17px;
        }

        .divider-line {
            height: 2px;
            background: linear-gradient(90deg, #ff4df0, #b46bff, #6a9dff);
            border-radius: 2px;
            margin: 10px 0 20px;
            opacity: 0.8;
        }

        .total-price {
            font-size: 25px;
            font-weight: 600;
            color: #4ef7b9;
            text-shadow: 0 0 8px rgba(78, 247, 185, 0.8);
        }

        /* tombol bayar */
        .btn-pay {
            border-radius: 14px;
            padding: 14px;
            width: 100%;
            background: linear-gradient(135deg, #ff6bd6, #ff8b5e, #ffbd4b);
            border: none;
            font-weight: 600;
            color: white;
            transition: 0.25s;
            box-shadow: 0 4px 15px rgba(255, 100, 200, 0.6);
            font-size: 18px;
        }

        .btn-pay:hover {
            transform: scale(1.07) translateY(-2px);
            box-shadow: 0 7px 22px rgba(255, 100, 200, 0.75);
            filter: brightness(1.1);
        }

        @media (max-width: 576px) {
            .payment-card {
                padding: 25px 18px;
            }
        }
    </style>
</head>

<body>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
</script>

<div class="container py-5">

    <div class="col-lg-6 col-md-8 col-11 mx-auto">

        <div class="payment-card">

            <h3 class="text-center mb-3">Detail Pembayaran</h3>
            <div class="divider-line"></div>

            <p class="mb-1 label-title">Nama:</p>
            <p class="value-text mb-3">{{ $pembayaran->user->nama }}</p>

            <p class="mb-1 label-title">No HP:</p>
            <p class="value-text mb-3">{{ $pembayaran->user->no_hp }}</p>

            <p class="mb-1 label-title">Loker:</p>
            <p class="value-text mb-3">Loker {{ $pembayaran->lokerAkses->loker->nomor_loker }}</p>

            <p class="mb-1 label-title">Mulai Sewa:</p>
            <p class="value-text mb-3">{{ $pembayaran->lokerAkses->awal_sewa }}</p>

            <p class="mb-1 label-title">Akhir Sewa:</p>
            <p class="value-text mb-3">{{ $pembayaran->lokerAkses->akhir_sewa }}</p>

            <div class="divider-line"></div>

            <h4 class="text-center mt-4">
                Total Pembayaran:
                <span class="total-price">Rp {{ number_format($pembayaran->pembayaran) }}</span>
            </h4>

            <button id="pay-button" class="btn-pay mt-4">Bayar Sekarang</button>

        </div>
    </div>
</div>

<script>
document.getElementById('pay-button').addEventListener('click', function () {

    fetch("{{ route('payment.create') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            pembayaran_id: {{ $pembayaran->id }},
            nama: "{{ $pembayaran->user->nama }}",
            hp: "{{ $pembayaran->user->no_hp }}",
            total: {{ $pembayaran->pembayaran }}
        })
    })
    .then(response => response.json())
    .then(data => {

        snap.pay(data.token, {
            onSuccess: async function(result){

                // kirim kode akses via WA
                await fetch("{{ route('send.wa') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        id: {{ $pembayaran->id }}
                    })
                });

                // kembali ke beranda
                window.location.href = "{{ route('beranda') }}";
            },

            onPending: function(result){
                console.log("Pending:", result);
            },
            onError: function(result){
                alert("Pembayaran gagal!");
                console.log(result);
            },
        });

    });

});
</script>

</body>
</html>