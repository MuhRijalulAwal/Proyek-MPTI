<?php
session_start(); // Pastikan session dimulai untuk menggunakan $_SESSION

$conn = new mysqli("localhost", "root", "", "db_subditindhan");
if ($conn->connect_error) die("Koneksi gagal: " . $conn->connect_error);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_report = $_POST['id_report'];
    $status = $_POST['status'];
    $admin_message = $_POST['admin_message'];

    // Pastikan user_id ada di session
    if (!isset($_SESSION['user_id'])) {
        echo "<script>
                alert('User tidak terautentikasi.');
                window.history.back();
              </script>";
        exit;
    }
    $company_id = $_SESSION['user_id']; // Ambil user ID dari session
    echo $id_report;
    // // Dapatkan company_id dari tabel report
    // $sqlGetCompanyId = "SELECT company_id FROM report WHERE id_report = ?";
    // $stmtGetCompanyId = $conn->prepare($sqlGetCompanyId);
    // $stmtGetCompanyId->bind_param("i", $id_report);
    // $stmtGetCompanyId->execute();
    // $result = $stmtGetCompanyId->get_result();
    // if ($result->num_rows === 0) {
    //     echo "<script>
    //             alert('Laporan tidak ditemukan.');
    //             window.history.back();
    //           </script>";
    //     exit;
    // }
    // $company = $result->fetch_assoc();
    // $company_id = $company['company_id'];

    // Perbarui status laporan
    $sqlUpdateReport = "UPDATE report SET status = ? WHERE id_report = ?";
    $stmtReport = $conn->prepare($sqlUpdateReport);
    $stmtReport->bind_param("si", $status, $id_report);

    // Simpan pesan ke tabel note
    $sqlInsertNote = "INSERT INTO note (id_report, company_id, note) VALUES (?, ?, ?)";
    $stmtNote = $conn->prepare($sqlInsertNote);
    $stmtNote->bind_param("iis", $id_report, $company_id, $admin_message);

    // Eksekusi query
    if ($stmtReport->execute() && $stmtNote->execute()) {
        echo "<script>
                alert('Laporan berhasil diperbarui dan pesan tersimpan.');
                window.location.href = 'admin-laporan.php';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan saat memproses laporan.');
                window.history.back();
              </script>";
    }

    $stmtReport->close();
    $stmtNote->close();
}
$conn->close();
