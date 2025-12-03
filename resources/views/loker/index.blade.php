<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Locker</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #e8f0f7;
            text-align: center;
            padding: 30px;
        }
        h1 {
            margin-bottom: 20px;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 15px;
            max-width: 800px;
            margin: 0 auto;
        }
        .locker-box {
            padding: 20px;
            border-radius: 10px;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            text-decoration: none;
            display: block;
        }
        .kosong { background: #28a745; }      /* Hijau */
        .terbuka { background: #ffc107; }     /* Kuning */
        .terkunci { background: #dc3545; }    /* Merah */
    </style>
</head>
<body>

    <h1>Smart Locker</h1>

    <div class="grid">
        @foreach ($lockers as $locker)
            <a href="{{ route('sewa.create', $locker->id) }}"
                class="locker-box {{ $locker->status }}">
                Loker {{ $locker->kode_loker }}
                <br>
                ({{ ucfirst($locker->status) }})
            </a>
        @endforeach
    </div>

</body>
</html>
