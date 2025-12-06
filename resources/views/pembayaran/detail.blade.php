<!DOCTYPE html>
<html>
<head>
    <title>Detail Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
</script>

<div class="container py-5">
    <div class="card shadow p-4">

        <h3 class="mb-3">Detail Pembayaran</h3>

        <p><b>Nama:</b> {{ $pembayaran->user->nama }}</p>
        <p><b>No HP:</b> {{ $pembayaran->user->no_hp }}</p>
        <p><b>Loker:</b> Loker {{ $pembayaran->lokerAkses->loker->nomor_loker }}</p>
        <p><b>Mulai Sewa:</b> {{ $pembayaran->lokerAkses->awal_sewa }}</p>
        <p><b>Akhir Sewa:</b> {{ $pembayaran->lokerAkses->akhir_sewa }}</p>

        <h4 class="mt-4">Total Pembayaran:
            <span class="text-success">Rp {{ number_format($pembayaran->pembayaran) }}</span>
        </h4>

        <button id="pay-button" class="btn btn-primary mt-3 w-100">
            Bayar Sekarang
        </button>

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
            id: "{{ $pembayaran->id }}",
            nama: "{{ $pembayaran->user->nama }}",
            hp: "{{ $pembayaran->user->no_hp }}",
            total: {{ $pembayaran->pembayaran }}
        })
    })
    .then(response => response.json())
    .then(data => {
        snap.pay(data.token, {
            onSuccess: function(result){ console.log(result); },
            onPending: function(result){ console.log(result); },
            onError: function(result){ console.log(result); }
        });
    });

});
</script>

</body>
</html>
