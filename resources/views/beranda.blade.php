<!DOCTYPE html>
<html>
<head>
    <title>Daftar Loker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <h1 class="mb-4 text-center">Daftar Loker</h1>

    <div class="row">

        @foreach($lokers as $loker)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">

                    <div class="card-body text-center">
                        <h4>Loker {{ $loker->nomor_loker }}</h4>

                        @if($loker->status == 'kosong')
                            <span class="badge bg-success">Kosong</span>
                        @else
                            <span class="badge bg-danger">Disewa</span>
                        @endif

                        @if($loker->status == 'kosong')
                            <button class="btn btn-primary mt-3" data-bs-toggle="modal"
                                    data-bs-target="#modalSewa"
                                    onclick="pilihLoker({{ $loker->id }}, '{{ $loker->nomor_loker }}')">
                                Sewa
                            </button>
                        @endif
                    </div>

                </div>
            </div>
        @endforeach

    </div>
</div>

<!-- Modal Form Sewa -->
<div class="modal fade" id="modalSewa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="{{ route('sewa.store') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">Form Sewa Loker</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="loker_id" id="selectedLokerId">

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Mulai Sewa</label>
                        <input type="datetime-local" name="awal_sewa" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Akhir Sewa</label>
                        <input type="datetime-local" name="akhir_sewa" class="form-control" required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Lanjut Pembayaran</button>
                </div>

            </form>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function pilihLoker(id, nomor) {
        document.getElementById('selectedLokerId').value = id;
    }
</script>

</body>
</html>
