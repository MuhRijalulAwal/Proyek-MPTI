<?php
session_start();
include "../config/koneksi.php"; // Pastikan koneksi database sudah benar

// Variabel untuk pesan
$successMessage = '';
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $verification_id = $_POST['verification_id'] ?? null;
    $action = $_POST['action'] ?? null;
    $reason = $_POST['reason'] ?? null;

    if ($verification_id && $action) {
        if ($action == 'terima') {
            // Update status ke "Diterima" dan is_verified ke TRUE
            $updateVerificationQuery = "UPDATE verification_requests SET status = 'Diterima' WHERE verification_id = ?";
            $stmt = $koneksi->prepare($updateVerificationQuery);
            $stmt->bind_param('i', $verification_id);

            if ($stmt->execute()) {
                $updateUserQuery = "UPDATE users 
                                    SET is_verified = TRUE 
                                    WHERE user_id = (SELECT user_id FROM verification_requests WHERE verification_id = ?)";
                $userStmt = $koneksi->prepare($updateUserQuery);
                $userStmt->bind_param('i', $verification_id);

                if ($userStmt->execute()) {
                    $successMessage = "Akun berhasil diverifikasi dan status diperbarui ke 'Diterima'.";
                } else {
                    $errorMessage = "Gagal memperbarui status di tabel users.";
                }
            } else {
                $errorMessage = "Gagal memperbarui status di tabel verification_requests.";
            }
        } elseif ($action == 'tolak') {
            // Pastikan alasan penolakan diisi
            $reason = !empty($reason) ? $reason : 'Alasan tidak diisi'; // Default jika alasan kosong

            // Update status ke "rejected" dan simpan alasan di rejection_reason
            $updateVerificationQuery = "UPDATE verification_requests 
                                        SET status = 'rejected', rejection_reason = ? 
                                        WHERE verification_id = ?";
            $stmt = $koneksi->prepare($updateVerificationQuery);
            $stmt->bind_param('si', $reason, $verification_id);

            if ($stmt->execute()) {
                $updateUserQuery = "UPDATE users 
                                    SET is_verified = FALSE 
                                    WHERE user_id = (SELECT user_id FROM verification_requests WHERE verification_id = ?)";
                $userStmt = $koneksi->prepare($updateUserQuery);
                $userStmt->bind_param('i', $verification_id);

                if ($userStmt->execute()) {
                    $successMessage = "Penolakan berhasil dicatat dengan alasan: $reason.";
                } else {
                    $errorMessage = "Gagal memperbarui status di tabel users.";
                }
            } else {
                $errorMessage = "Gagal memperbarui status di tabel verification_requests.";
            }
        }
    } else {
        $errorMessage = "Data tidak lengkap. Pastikan ID dan aksi valid.";
    }
}

// Query untuk menampilkan data dari tabel users dan status
$query = "
    SELECT 
        vr.verification_id, 
        u.user_id, 
        u.username,
        u.email,
        u.phone_number, 
        u.company_name, 
        u.determination_letter_number, 
        u.determination_letter_number_path, 
        CASE 
            WHEN u.is_verified = 1 THEN 'Diterima' 
            WHEN u.is_verified = 0 AND vr.status = 'rejected' THEN 'rejected' 
            ELSE 'Pending' 
        END AS status_verifikasi
    FROM verification_requests vr
    JOIN users u ON vr.user_id = u.user_id
";

$result = $koneksi->query($query);
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
                <div class="container-fluid mt-5" style="margin-left: 20px; margin-right: 20px;">
                    <h3 class="mb-4" style="color:#152C5B;">Daftar Akun</h3>
                    <!-- Konten Tabel -->
                    <!-- Notifikasi Pesan -->
                    <?php if ($successMessage): ?>
                        <div class="alert alert-success"><?= $successMessage; ?></div>
                    <?php elseif ($errorMessage): ?>
                        <div class="alert alert-danger"><?= $errorMessage; ?></div>
                    <?php endif; ?>

                    <!-- Tabel Data -->
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Nama INDHAN</th>
                                <th scope="col">Nomor Penetapan INDHAN</th>
                                <th scope="col">Surat Nomor Penetapan</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $determinationLetterPath = !empty($row['determination_letter_number_path'])
                                        ? '<a href="../uploads/' . htmlspecialchars($row['determination_letter_number_path']) . '" target="_blank">Lihat Surat</a>'
                                        : 'Tidak ada surat';

                                    echo "<tr>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['company_name']}</td>
                            <td>{$row['determination_letter_number']}</td>
                            <td>{$determinationLetterPath}</td>
                            <td>{$row['status_verifikasi']}</td>
                            <td class='text-center'>
                                <form method='POST' action=''>
                                    <input type='hidden' name='verification_id' value='{$row['verification_id']}'>
                                    <a href='admin-detailUsers.php?user_id=$row[user_id]' class='btn btn-primary btn-sm'>
                                        <i class='bi bi-eye'></i>
                                    </a>
                                    <button type='submit' name='action' value='terima' class='btn btn-success btn-sm'>
                                    <i class='bi bi-check-lg'></i>
                                    </button>
                                    <button type='button' class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#rejectionModal' onclick='setVerificationId({$row['verification_id']})'>
                                    <i class='bi bi-x-lg'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>Tidak ada data tersedia</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modal Penolakan -->
                <div class="modal fade" id="rejectionModal" tabindex="-1" aria-labelledby="rejectionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="rejectionModalLabel">Masukkan Alasan Penolakan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST">
                                    <input type="hidden" name="verification_id" id="verification_id" value="">
                                    <textarea class="form-control" name="reason" id="reason" rows="3" placeholder="Masukkan alasan penolakan"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="action" value="tolak" class="btn btn-danger">Tolak</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        function setVerificationId(verificationId) {
            document.getElementById('verification_id').value = verificationId;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
</body>
</body>

</html>