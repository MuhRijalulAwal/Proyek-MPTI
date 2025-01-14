<?php
session_start(); // Memastikan session dimulai
include '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];

// Query untuk mengambil data produk dan status laporan
$query = "SELECT 
            pb.product_name, 
            pb.product_group, 
            pb.product_classification, 
            r.status, 
            r.date,
            r.id_report
            FROM products p 
            JOIN report r ON p.company_id = r.company_id 
            JOIN products_branch pb ON pb.products_id = p.products_id 
            WHERE r.company_id = ? 
            AND pb.company_id = ? 
            AND p.products_id = r.products_id
            GROUP BY pb.products_id";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Laporan - User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../assets/img/logo-proyek-tanpa-teks.png" rel="shortcut icon">
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .footer {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <?php include "../nav/navbar.php" ?>
    <div class="footer">
        <main>
            <div class="wrap px-5" style="margin-left: 47px; margin-right: 47px;">
                <div class="container-fluid">
                    <h1 style="color:#152C5B;" class="mt-4 mb-4">Laporan</h1>
                    <div class="row">
                        <div class="col-4 mt-4 mb-2">
                            <div class="container-fluid ">
                                <form class="d-flex" role="search">
                                    <input class="form-control me-2" type="search" placeholder="Cari Kata Kunci" aria-label="Cari Kata Kunci">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-8 ms-auto mt-4 mb-2 text-end">
                            <div class="container-fluid ">
                                <a href="userTambahLaporan.php">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                        </svg>
                                        Tambah Laporan
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <table class="table table-striped table-responsive table-hover shadow">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Produk</th>
                                    <th scope="col">Kelompok Produk</th>
                                    <th scope="col">Klasifikasi Produk</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Tanggal / Waktu</th>
                                    <th scope="col">Aksi</th>
                                    <th scope="col">Pesan</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                // Menampilkan data produk yang diambil dari database
                                if ($result->num_rows > 0) {
                                    $no = 1; // untuk nomor urut
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<th scope='row'>{$no}</th>";
                                        echo "<td>{$row['product_name']}</td>";
                                        echo "<td>{$row['product_group']}</td>";
                                        echo "<td>{$row['product_classification']}</td>";

                                        // Tentukan warna tombol berdasarkan nilai status
                                        if ($row['status'] === 'Pending') {
                                            $statusButton = "<button class='btn btn-warning btn-sm'>Pending</button>";
                                        } elseif ($row['status'] === 'Ditolak') {
                                            $statusButton = "<button class='btn btn-danger btn-sm'>Ditolak</button>";
                                        } elseif ($row['status'] === 'Diterima') {
                                            $statusButton = "<button class='btn btn-success btn-sm'>Diterima</button>";
                                        } else {
                                            $statusButton = "<button class='btn btn-secondary btn-sm'>Status Tidak Diketahui</button>";
                                        }

                                        echo "<td>{$statusButton}</td>";
                                        echo "<td>{$row['date']}</td>";
                                        echo "<td><a href='userDetailLaporan.php?id_report={$row['id_report']}' class='btn btn-primary btn-sm'>
                                                    <i class='bi bi-eye'></i>        
                                                  </a></td>";
                                        echo "<td><a href='userNote.php?id_report={$row['id_report']}' class='btn btn-primary btn-sm'>
                                                    <i class='bi bi-eye'></i>   
                                                    </a></td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer>
        <?php include "../footer/footer.php"; ?>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>

</html>