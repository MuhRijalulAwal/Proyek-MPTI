<?php
session_start(); // Memastikan session dimulai

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Example code to fetch the counts from the database
$host = 'localhost';
$db = 'db_subditindhan';
$user = 'root';
$pass = '';

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count the reports by status
$sqlStatus = "SELECT status, COUNT(*) AS jumlah FROM report WHERE status IN ('Pending', 'Diterima', 'Ditolak') GROUP BY status";
$resultStatus = $conn->query($sqlStatus);

// Initialize counts for each status
$menunggu_count = 0;
$diterima_count = 0;
$ditolak_count = 0;

// Fetch the counts for each status
if ($resultStatus->num_rows > 0) {
    while ($row = $resultStatus->fetch_assoc()) {
        if ($row['status'] == 'Pending') {
            $menunggu_count = $row['jumlah'];
        } elseif ($row['status'] == 'Diterima') {
            $diterima_count = $row['jumlah'];
        } elseif ($row['status'] == 'Ditolak') {
            $ditolak_count = $row['jumlah'];
        }
    }
}

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT 
            c.company_name,
            p.product_name,
            p.product_group,
            r.id_report,
            r.date,
            r.status
        FROM 
            report r
        JOIN 
            companies c ON r.company_id = c.company_id
        JOIN 
            products_branch p ON r.products_id = p.products_id
        GROUP BY p.products_id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Laporan - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/img/logo-proyek-tanpa-teks.png" rel="shortcut icon">
    <link href="../assets/img/logo-proyek-tanpa-teks.png" rel="shortcut icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="sb-nav-fixed">
    <!-- Navbar -->
    <?php include "nav/admin-navbar.php"; ?>

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav" class="bg-light">
            <?php include "nav/admin-sidebar.php"; ?>
        </div>
        <!-- Content -->
        <div id="layoutSidenav_content">
            <main>
                <div class="wrap px-2" style="margin-left: 47px; margin-right: 47px;">
                    <div class="container-fluid px-4">
                        <!-- Alert -->
                        <h3 style="color:#152C5B;" class="mt-4 mb-4">Daftar Laporan </h3>
                        <div class="row justify-content-center">
                            <!-- Menunggu Card -->
                            <div class="shadow p-2 col-sm-3 mb-3 me-2">
                                <div class="card border-warning text-bg-warning">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <p class="col-sm-10 card-title">Menunggu</p>
                                            <div class="col-sm-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hourglass" viewBox="0 0 16 16">
                                                    <path d="M2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1-.5-.5m2.5.5v1a3.5 3.5 0 0 0 1.989 3.158c.533.256 1.011.791 1.011 1.491v.702c0 .7-.478 1.235-1.011 1.491A3.5 3.5 0 0 0 4.5 13v1h7v-1a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351v-.702c0-.7.478-1.235 1.011-1.491A3.5 3.5 0 0 0 11.5 3V2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h2 class="card-text"><?php echo $menunggu_count; ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Diterima Card -->
                            <div class="shadow p-2 col-sm-3 mb-3 me-2">
                                <div class="card border-success text-bg-success">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <p class="col-sm-10 card-title">Diterima</p>
                                            <div class="col-sm-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                    <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h2 class="card-text"><?php echo $diterima_count; ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Ditolak Card -->
                            <div class="shadow p-2 col-sm-3 mb-3">
                                <div class="card border-danger text-bg-danger">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <p class="col-sm-10 card-title">Ditolak</p>
                                            <div class="col-sm-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h2 class="card-text"><?php echo $ditolak_count; ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                            </div>
                            <div class="col-6 text-end">
                                <a href='export.php' class='btn btn-success btn-sm me-2'>
                                    <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <table class="table table-striped table-responsive table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Indhan</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Produk Ekspor/Impor</th>
                                        <th scope="col">Waktu & Tanggal</th>
                                        <th scope="col">Status</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Tampilkan data dalam tabel
                                    if ($result->num_rows > 0) {
                                        $no = 1; // Inisialisasi nomor
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $no++ . "</td>"; // Kolom nomor
                                            echo "<td>" . htmlspecialchars($row['company_name']) . "</td>"; // Kolom nama perusahaan
                                            echo "<td>" . htmlspecialchars($row['product_name']) . "</td>"; // Kolom nama produk
                                            echo "<td>" . htmlspecialchars($row['product_group']) . "</td>"; // Kolom status ekspor/impor
                                            echo "<td>" . htmlspecialchars($row['date']) . "</td>"; // Kolom waktu & tanggal
                                            // echo "<td>" . htmlspecialchars($row['status']) . "</td>"; // Kolom status
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
                                            echo "<td>
                                                    <div class='d-flex justify-content-center'>
                                                        <a href='admin-detailLaporan.php?id_report=$row[id_report]' class='btn btn-primary btn-sm me-2'>
                                                            <i class='bi bi-eye'></i>
                                                        </a>
                                                        <button class='btn btn-success btn-sm me-2' data-bs-toggle='modal' data-bs-target='#modalTerima' data-id='" . $row['id_report'] . "'>
                                                        <i class='bi bi-check-lg'></i>
                                                        </button>
                                                        <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#modalTolak' data-id='" . $row['id_report'] . "'>
                                                        <i class='bi bi-x-lg'></i>
                                                        </button>
                                                    </div>
                                                </td>"; // Kolom aksi
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>Tidak ada data</td></tr>";
                                    }

                                    // Tutup koneksi
                                    $stmt->close();
                                    $conn->close();
                                    ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Terima -->
    <div class="modal fade" id="modalTerima" tabindex="-1" aria-labelledby="modalTerimaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="admin-updatestatus.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTerimaLabel">Konfirmasi Terima</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menerima laporan ini?</p>
                        <input type="hidden" name="id_report" id="idReportTerima" />
                        <input type="hidden" name="status" value="Diterima" />
                        <div class="mb-3">
                            <label for="adminMessageTerima" class="form-label">Pesan ke User</label>
                            <textarea name="admin_message" id="adminMessageTerima" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Terima</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Terima -->
    <div class="modal fade" id="modalTerima" tabindex="-1" aria-labelledby="modalTerimaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="admin-updatestatus.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTerimaLabel">Konfirmasi Terima</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menerima laporan ini?</p>
                        <input type="hidden" name="id_report" id="idReportTerima" />
                        <input type="hidden" name="status" value="Diterima" />
                        <div class="mb-3">
                            <label for="adminMessageTerima" class="form-label">Pesan ke User</label>
                            <textarea name="admin_message" id="adminMessageTerima" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Terima</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tolak -->
    <div class="modal fade" id="modalTolak" tabindex="-1" aria-labelledby="modalTolakLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="admin-updatestatus.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTolakLabel">Konfirmasi Tolak</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menolak laporan ini?</p>
                        <input type="hidden" name="id_report" id="idReportTolak" />
                        <input type="hidden" name="status" value="Ditolak" />
                        <div class="mb-3">
                            <label for="adminMessageTolak" class="form-label">Pesan ke User</label>
                            <textarea name="admin_message" id="adminMessageTolak" class="form-control" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../js/datatables-simple-demo.js"></script>
    <script>
        let action; // Untuk menyimpan aksi yang dipilih
        let reportId; // Untuk menyimpan ID laporan

        function setAction(selectedAction, id) {
            action = selectedAction; // Set aksi
            reportId = id; // Set ID laporan
        }

        document.getElementById('confirmButton').addEventListener('click', function() {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = 'admin-updatestatus.php';

            let hiddenInputId = document.createElement('input');
            hiddenInputId.type = 'hidden';
            hiddenInputId.name = 'id_report';
            hiddenInputId.value = reportId; // Set ID laporan

            let hiddenInputStatus = document.createElement('input');
            hiddenInputStatus.type = 'hidden';
            hiddenInputStatus.name = 'status';
            hiddenInputStatus.value = action; // Set status

            form.appendChild(hiddenInputId);
            form.appendChild(hiddenInputStatus);
            document.body.appendChild(form);
            form.submit(); // Kirim form
        });
    </script>
    <script>
        // Set ID Report ke Modal
        var modalTerima = document.getElementById('modalTerima');
        modalTerima.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var idReport = button.getAttribute('data-id');
            var inputId = modalTerima.querySelector('#idReportTerima');
            inputId.value = idReport;
        });

        var modalTolak = document.getElementById('modalTolak');
        modalTolak.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var idReport = button.getAttribute('data-id');
            var inputId = modalTolak.querySelector('#idReportTolak');
            inputId.value = idReport;
        });
    </script>
</body>

</html>