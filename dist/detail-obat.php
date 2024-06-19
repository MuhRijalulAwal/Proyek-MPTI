<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sorobayan Farma</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">Sorobayan Farma</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <?php
        include "nav/sidenavbar.php";
        ?>
        <?php
        include 'config/koneksi.php';

        if (@$_GET['id']) {
            $id = $_GET['id'];

            // Query untuk mengambil detail obat berdasarkan ID
            $queryObat = "SELECT * FROM obat WHERE id_obat = '$id'";
            $resultObat = mysqli_query($koneksi, $queryObat);
            $obat = mysqli_fetch_array($resultObat);

            // Query untuk menghitung jumlah quantity dari tabel order berdasarkan nama_obat
            $queryOrder = "
            SELECT SUM(IF(nama_obat = '" . mysqli_real_escape_string($koneksi, $obat['nama_obat'])
            . "', qty, 0)) AS total_quantity FROM `order`";
            $resultOrder = mysqli_query($koneksi, $queryOrder);
            $orderData = mysqli_fetch_array($resultOrder);
            $totalQuantity = $orderData['total_quantity'];

            // Query untuk menghitung jumlah quantity dari tabel pemasukan_obat berdasarkan nama_obat
            $queryPemasukan = "
            SELECT SUM(IF(nama_obat = '" . mysqli_real_escape_string($koneksi, $obat['nama_obat'])
            . "', qty, 0)) AS total_pemasukan FROM `pemasukan_obat`";
            $resultPemasukan = mysqli_query($koneksi, $queryPemasukan);
            $pemasukanData = mysqli_fetch_array($resultPemasukan);
            $totalPemasukan = $pemasukanData['total_pemasukan'];

            // Menghitung sisa stok
            $sisaStok = $obat['stok'] - $totalQuantity;
        }
        ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Penyimpanan > Obat Tersedia > <?= $obat['nama_obat'] ?></h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Detail Tentang Obat</li>
                    </ol>

                    <div class="row">
                        <div class="col-md-6 mb-4">

                        </div>

                        <div class="col-md-6 mb-4 d-flex justify-content-end">
                            <div>
                                <a href="tambah-item.php?id=<?= $obat['id_obat'] ?>" class="btn btn-primary btn-lg">Edit </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid px-4 mt-4">
                    <div class="row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-header bg-transparent border">Tentang</div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="card-title"><?= $obat['id_obat'] ?></h5>
                                                <p class="card-text">ID Obat</p>
                                            </div>
                                            <div class="col-6">
                                                <h5 class="card-title"><?= $obat['kategori'] ?></h5>
                                                <p class="card-text">Kategori</p>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-header bg-transparent border">
                                    <div class="row">
                                        <div class="col-6">Penyimpanan (QTY)</div>
                                        <div class="col-6">Kirim Permintaan</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <div class="row">
                                            <div class="col-3">
                                                <h5 class="card-title"><?= $totalPemasukan ?></h5>
                                                <p class="card-text">Obat Masuk</p>
                                            </div>
                                            <div class="col-3">
                                                <h5 class="card-title"><?= $totalQuantity ?></h5>
                                                <p class="card-text">Obat Terjual</p>
                                            </div>
                                            <div class="col-3">
                                                <h5 class="card-title"><?= $sisaStok ?></h5>
                                                <p class="card-text">Sisa stok</p>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid px-4 mt-4">
                    <div class="row">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <div class="card">
                                <div class="card-header bg-transparent border">Pedoman Pemakaian</div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="card-text"><?= $obat['pedoman_pemakaian'] ?>
                                                </p>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-4">
                            <div class="card">
                                <div class="card-header bg-transparent border">Efek Samping</div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <div class="row">
                                            <div class="col-12">
                                                <p class="card-text"><?= $obat['efek_samping'] ?>
                                                </p>
                                            </div>
                                        </div>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-3 mt-4">
                            <a class="btn btn-outline-danger" href="act/obat-act.php?id_obat=<?= $obat['id_obat'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                </svg>Hapus Obat</a>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>