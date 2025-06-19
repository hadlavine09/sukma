<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjual - SukMa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f5f5f5;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #2d5727;
            color: white;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #244a21;
            color: #fff;
        }

        .card-stat {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .card-stat:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .text-green {
            color: #2d5727;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar py-4 px-3">
                <div class="text-center mb-4">
                    <img src="{{ asset('logo/logo2.png') }}" alt="Logo Toko" class="rounded-circle mb-2" style="width: 80px;">
                    <h5 class="mb-0">Toko Anda</h5>
                    <small>Penjual Terdaftar</small>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2"><a href="#" class="nav-link"><i class="bi bi-house-door me-2"></i>Beranda</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link"><i class="bi bi-box-seam me-2"></i>Produk</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link"><i class="bi bi-cart-check me-2"></i>Pesanan</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link"><i class="bi bi-bar-chart-line me-2"></i>Statistik</a></li>
                    <li class="nav-item mb-2"><a href="#" class="nav-link"><i class="bi bi-gear me-2"></i>Pengaturan</a></li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-4">
                    <h2 class="h4">Dashboard Penjual</h2>
                    <div>
                        <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-box-arrow-right me-1"></i> Logout</button>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card card-stat p-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-box-seam fs-1 text-green me-3"></i>
                                <div>
                                    <h5 class="mb-0">120</h5>
                                    <small>Produk Aktif</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stat p-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-cart-check fs-1 text-green me-3"></i>
                                <div>
                                    <h5 class="mb-0">45</h5>
                                    <small>Pesanan Baru</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stat p-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-cash-stack fs-1 text-green me-3"></i>
                                <div>
                                    <h5 class="mb-0">Rp 12.300.000</h5>
                                    <small>Total Pendapatan</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-12">
                        <h5 class="mb-3">Aktivitas Terbaru</h5>
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Produk <strong>"Kaos Polos Pria"</strong> berhasil ditambahkan.
                                <span class="badge bg-success">2 menit lalu</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Pesanan baru dari <strong>Rahmat</strong>.
                                <span class="badge bg-warning text-dark">5 menit lalu</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Produk <strong>"Sneakers Wanita"</strong> stok habis.
                                <span class="badge bg-danger">10 menit lalu</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </main>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
