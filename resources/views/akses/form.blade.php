<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Kode Akses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            font-family: "Outfit", sans-serif, sans-serif !important;
        }

    </style>
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">

    <div class="card shadow-lg" style="width: 400px;">
        <div class="card-header text-center bg-primary text-white">
            <h5 class="mb-0">Verifikasi Kode Akses</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('akses.verify') }}">
                @csrf
                <div class="mb-3">
                    <label for="kode" class="form-label">Masukkan Kode Akses</label>
                    <input type="password" name="kode" id="kode" class="form-control text-center"
                           placeholder="••••••" autofocus required>
                    @error('kode')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">Verifikasi</button>
            </form>
        </div>
        <div class="card-footer text-center text-muted small">
            © {{ date('Y') }} Sistem Contrabon - Roputex
        </div>
    </div>

    {{-- Notifikasi dengan SweetAlert --}}
    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Kode Salah',
                text: '{{ session('error') }}'
            });
        </script>
    @endif

</body>
</html>
