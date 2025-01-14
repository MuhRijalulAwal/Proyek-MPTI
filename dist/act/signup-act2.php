<?php
// Sertakan file koneksi
include '../config/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $namaIndhan = trim($_POST['nama_indhan']);
    $alamat = trim($_POST['alamat']);
    $nomorSurat = trim($_POST['nomor_surat']);
    $dokumen = $_FILES['dokumen'];

    // Validasi input
    if (empty($namaIndhan) || empty($alamat) || empty($nomorSurat) || empty($dokumen)) {
        echo "Semua field wajib diisi!";
        exit;
    }

    // Proses upload file
    $uploadDir = "uploads/"; // Folder untuk menyimpan dokumen
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true); // Buat folder jika belum ada
    }

    $fileName = basename($dokumen['name']);
    $uploadFile = $uploadDir . time() . "_" . $fileName;

    if (move_uploaded_file($dokumen['tmp_name'], $uploadFile)) {
        $dokumenPath = $uploadFile; // Simpan path file untuk database
    } else {
        echo "Gagal mengunggah dokumen.";
        exit;
    }

    // Simpan data ke database
    $query = "INSERT INTO indhan (nama_indhan, alamat, nomor_surat, dokumen) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $namaIndhan, $alamat, $nomorSurat, $dokumenPath);

    if (mysqli_stmt_execute($stmt)) {
        echo "Registrasi berhasil!";
        header("Location: sukses.php"); // Redirect ke halaman sukses
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($koneksi);
?>
