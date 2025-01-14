<?php
session_start();
include '../config/koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Akses ditolak.']);
    exit();
}

// Ambil company_id dari session
$company_id = $_SESSION['user_id'];

// Ambil data JSON dari permintaan
$data = json_decode(file_get_contents('php://input'), true);

// Validasi data input
$email = mysqli_real_escape_string($koneksi, $data['email']);
$url_website = mysqli_real_escape_string($koneksi, $data['url_website']);
$company_nib = mysqli_real_escape_string($koneksi, $data['company_nib']);
$company_information = mysqli_real_escape_string($koneksi, $data['company_information']);
$company_assignment = mysqli_real_escape_string($koneksi, $data['company_assignment']);
$company_main_address = mysqli_real_escape_string($koneksi, $data['company_main_address']);
$main_number = mysqli_real_escape_string($koneksi, $data['main_number']);
$company_category = mysqli_real_escape_string($koneksi, $data['company_category']);

// Fungsi untuk mengupload file dengan validasi
function uploadFile($file, $uploadDir)
{
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $file['tmp_name'];
        $fileName = uniqid() . '_' . basename($file['name']);
        $filePath = $uploadDir . $fileName;

        // Validasi ekstensi file
        $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'xlsx']; // Tipe file yang diizinkan

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($fileTmpPath, $filePath)) {
                return $filePath;
            } else {
                return ["error" => "Gagal memindahkan file yang diunggah."];
            }
        } else {
            return ["error" => "Format file tidak valid. Hanya JPG, PNG, dan PDF yang diperbolehkan."];
        }
    } else {
        return ["error" => "Terjadi kesalahan saat mengunggah file."];
    }
}

$uploadDir = '../uploads/logos/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Variable untuk Company Logo
$companyLogoPath = uploadFile($_FILES['company_logo_path'], $uploadDir);
if (isset($companyLogoPath['error'])) {
    die($companyLogoPath['error']);
}

// Query UPDATE
$query = "UPDATE companies 
          SET email = ?,
              company_logo_path = ?, 
              url_website = ?, 
              company_nib = ?, 
              company_information = ?, 
              company_assignment = ?, 
              company_main_address = ?, 
              main_number = ?, 
              company_category = ? 
          WHERE company_id = ?";

$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, 'ssssssssi', $email, $companyLogoPath, $url_website, $company_nib, $company_information, $company_assignment, $company_main_address, $main_number, $company_category, $company_id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Gagal memperbarui data.']);
}

mysqli_stmt_close($stmt);
mysqli_close($koneksi);
