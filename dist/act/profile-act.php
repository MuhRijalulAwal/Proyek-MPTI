<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Ambil data perusahaan berdasarkan user_id
$user_id = $_SESSION['user_id'];

// Tangkap data dari form
$email = $_POST['email'] ?? null;
$company_name = $_POST['company_name'] ?? null;
$url_website = $_POST['url_website'] ?? null;
$company_nib = $_POST['company_nib'] ?? null;
$company_information = $_POST['company_information'] ?? null;
$company_assignment = $_POST['company_assignment'] ?? null;
$company_main_address = $_POST['company_main_address'] ?? null;
$main_number = $_POST['main_number'] ?? null;
$company_category = $_POST['company_category'] ?? null;

// Upload logo perusahaan
$target_dir = "../uploads/logos/";
$upload_ok = 1;
$file_name = "";

// Check if a new file is uploaded
if (isset($_FILES['company_logo_path']) && $_FILES['company_logo_path']['error'] == 0) {
    $file_name = basename($_FILES['company_logo_path']['name']);
    $target_file = $target_dir . $file_name;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi tipe file
    $valid_image_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($image_file_type, $valid_image_types)) {
        $upload_ok = 0;
        $_SESSION['error'] = "Harap unggah file gambar dengan format yang valid (JPG, PNG, GIF, atau WebP).";
        header('Location: ../profile.php');
        exit();
    }

    // Validasi ukuran file (maks 5MB)
    if ($_FILES['company_logo_path']['size'] > 5 * 1024 * 1024) {
        $upload_ok = 0;
        $_SESSION['error'] = "Ukuran file terlalu besar. Maksimal 5MB.";
        header('Location: ../profile.php');
        exit();
    }

    // Pindahkan file ke direktori tujuan
    if ($upload_ok && !move_uploaded_file($_FILES['company_logo_path']['tmp_name'], $target_file)) {
        $_SESSION['error'] = "Terjadi kesalahan saat mengunggah file.";
        header('Location: ../profile.php');
        exit();
    }
} else {
    // If no new file is uploaded, retain the old file path
    $query = "SELECT company_logo_path FROM companies WHERE user_id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($existing_file_name);
    $stmt->fetch();
    $stmt->close();
    $file_name = $existing_file_name;
}

// Retrieve existing values from the database if the new values are null
$query = "SELECT email, company_name, url_website, company_nib, company_information, company_assignment, company_main_address, main_number, company_category FROM companies WHERE user_id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($existing_email, $existing_company_name, $existing_url_website, $existing_company_nib, $existing_company_information, $existing_company_assignment, $existing_company_main_address, $existing_main_number, $existing_company_category);
$stmt->fetch();
$stmt->close();

$email = $email ?? $existing_email;
$company_name = $company_name ?? $existing_company_name;
$url_website = $url_website ?? $existing_url_website;
$company_nib = $company_nib ?? $existing_company_nib;
$company_information = $company_information ?? $existing_company_information;
$company_assignment = $company_assignment ?? $existing_company_assignment;
$company_main_address = $company_main_address ?? $existing_company_main_address;
$main_number = $main_number ?? $existing_main_number;
$company_category = $company_category ?? $existing_company_category;

// Simpan data ke database
$query = "UPDATE companies 
          SET email = ?, company_name = ?, url_website = ?, company_nib = ?, company_information = ?, 
              company_assignment = ?, company_main_address = ?, main_number = ?, company_category = ?, 
              company_logo_path = ?
          WHERE user_id = ?";

$stmt = $koneksi->prepare($query);
$stmt->bind_param(
    "ssssssssssi",
    $email,
    $company_name,
    $url_website,
    $company_nib,
    $company_information,
    $company_assignment,
    $company_main_address,
    $main_number,
    $company_category,
    $file_name,
    $_SESSION['user_id']
);

if ($stmt->execute()) {
    $_SESSION['success'] = "Profil berhasil diperbarui.";
} else {
    $_SESSION['error'] = "Terjadi kesalahan saat memperbarui profil.";
}

if (isset($_POST['company_address_branch'])) {
    $companyAddressBranchArray = $_POST['company_address_branch']; // Ambil array dari input form

    foreach ($companyAddressBranchArray as $companyAddressBranch) { // Iterasi setiap elemen array
        // Hilangkan spasi yang tidak diperlukan
        $companyAddressBranch = trim($companyAddressBranch);

        // Jika elemen tidak kosong, masukkan ke database
        if (!empty($companyAddressBranch)) {
            $queryCompanyAddressBranch = "INSERT INTO company_branch (
                                                company_id,
                                                company_branch_address
                                                ) VALUES (?, ?)";

            $stmtCompanyAddressBranch = mysqli_prepare($koneksi, $queryCompanyAddressBranch);
            mysqli_stmt_bind_param(
                $stmtCompanyAddressBranch,
                'is',
                $_SESSION['user_id'],
                $companyAddressBranch
            );

            if (!mysqli_stmt_execute($stmtCompanyAddressBranch)) {
                echo "Gagal menyimpan data ke tabel company_branch: " . mysqli_error($koneksi);
            } else {
                echo "Berhasil menyimpan alamat: $companyAddressBranch <br>";
            }
            mysqli_stmt_close($stmtCompanyAddressBranch);
        }
    }
}

// Redirect kembali ke halaman profil
header('Location: ../profile.php');
exit();
?>