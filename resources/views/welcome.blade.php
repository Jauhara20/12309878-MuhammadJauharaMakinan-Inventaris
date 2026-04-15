<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory Management of SMK Wikrama</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(180deg, #f8fafc 0%, #e2e8f0 100%);
            color: #0f172a;
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .hero-card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(148, 163, 184, 0.24);
            box-shadow: 0 24px 60px rgba(15, 23, 42, 0.08);
            border-radius: 32px;
            padding: 3rem;
        }
        .feature-card {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(148, 163, 184, 0.18);
            border-radius: 20px;
            padding: 1.5rem;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 42px rgba(15, 23, 42, 0.12);
        }
        .brand-badge {
            width: 56px;
            height: 56px;
            font-size: 1.15rem;
        }
        .footer-note {
            font-size: 0.95rem;
            color: #475569;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <header class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5">
            <div class="d-flex align-items-center gap-3 mb-4 mb-md-0">
                <div class="d-flex align-items-center justify-content-center rounded-circle bg-primary text-white shadow brand-badge">W</div>
                <div>
                    <p class="mb-1 text-uppercase text-secondary small">SMK Wikrama</p>
                    <h1 class="h4 fw-bold mb-0">Inventory Management</h1>
                </div>
            </div>
            <a href="/login" class="btn btn-dark btn-lg px-4">Login</a>
        </header>

        <div class="row g-4 align-items-center">
            <div class="col-lg-7">
                <div class="hero-card">
                    <h2 class="display-5 fw-bold mb-3">Sistem inventaris lengkap untuk SMK Wikrama.</h2>
                    <p class="lead text-secondary mb-4">Catat barang masuk, barang keluar, kelola operator dan admin, serta pantau status peminjaman secara cepat dan aman.</p>
                    <div class="d-flex flex-column flex-sm-row gap-3">
                        <a href="/login" class="btn btn-primary btn-lg px-5">Explore</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="feature-card">
                            <h5 class="fw-bold mb-2">Kelola Akun & Hak Akses</h5>
                            <p class="mb-0 text-secondary">Buat admin dan operator, atur hak akses, dan reset password dengan cepat.</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="feature-card">
                            <h5 class="fw-bold mb-2">Inventaris Barang</h5>
                            <p class="mb-0 text-secondary">Pantau stok, barang rusak, dan riwayat peminjaman dalam satu tampilan intuitif.</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="feature-card">
                            <h5 class="fw-bold mb-2">Ekspor Data</h5>
                            <p class="mb-0 text-secondary">Download laporan Excel untuk barang dan pengguna yang mudah dilaporkan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <footer class="mt-5 text-center footer-note">
            &copy; {{ date('Y') }} SMK Wikrama. Sistem inventaris untuk pembelajaran dan operasional sekolah.
        </footer>
    </div>
</body>
</html>
