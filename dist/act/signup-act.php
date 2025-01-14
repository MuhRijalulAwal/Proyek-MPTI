<?php
include '../config/koneksi.php'; // Sertakan koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil input dari form
    $company_name = trim($_POST['company_name']);
    $company_address = trim($_POST['company_address']);
    $determination_letter_number = trim($_POST['determination_letter_number']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $password_hash = trim($_POST['password_hash']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Validasi password
    if ($password_hash !== $confirmPassword) {
        header("Location: ../signup.php?error=Password%20tidak%20cocok");
        exit();
    }

    // Validasi username unik
    $query_check_username = "SELECT user_id FROM users WHERE username = ?";
    $stmt_check_username = mysqli_prepare($koneksi, $query_check_username);
    mysqli_stmt_bind_param($stmt_check_username, "s", $username);
    mysqli_stmt_execute($stmt_check_username);
    mysqli_stmt_store_result($stmt_check_username);

    if (mysqli_stmt_num_rows($stmt_check_username) > 0) {
        // Username sudah ada
        header("Location: ../signup.php?error=Username%20sudah%20digunakan");
        exit();
    }

    mysqli_stmt_close($stmt_check_username);

    // Hash password
    $hashedPassword = password_hash($password_hash, PASSWORD_DEFAULT);

    // Menangani upload file
    $determination_letter_number_path = null;
    if (isset($_FILES['determination_letter_number_path']) && $_FILES['determination_letter_number_path']['error'] == 0) {
        $targetDir = "../uploads/";
        $fileName = basename($_FILES['determination_letter_number_path']['name']);
        $targetFile = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validasi tipe file
        $allowedTypes = array('pdf', 'jpg', 'jpeg', 'png');
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['determination_letter_number_path']['tmp_name'], $targetFile)) {
                $determination_letter_number_path = $fileName;
            } else {
                die("Gagal mengunggah dokumen surat.");
            }
        } else {
            die("Tipe file tidak diperbolehkan.");
        }
    }

    // Simpan data ke tabel users
    $query = "INSERT INTO users (company_name, company_address, determination_letter_number, determination_letter_number_path, username, email, phone_number, password_hash) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $company_name, $company_address, $determination_letter_number, $determination_letter_number_path, $username, $email, $phone_number, $hashedPassword);

        if (mysqli_stmt_execute($stmt)) {
            $user_id = mysqli_insert_id($koneksi);

            // Simpan data ke tabel verification_request
            $verification_status = 0; // Status "Menunggu Verifikasi"
            $verification_query = "INSERT INTO verification_requests (user_id, company_name, determination_letter_number, determination_letter_number_path, status) 
                                    VALUES (?, ?, ?, ?, ?)";
            $verification_stmt = mysqli_prepare($koneksi, $verification_query);

            if ($verification_stmt) {
                mysqli_stmt_bind_param($verification_stmt, "isssi", $user_id, $company_name, $determination_letter_number, $determination_letter_number_path, $verification_status);

                if (mysqli_stmt_execute($verification_stmt)) {
                    // Simpan data ke tabel companies
                    $company_query = "INSERT INTO companies (user_id, company_name, email, company_main_address, main_number) 
                                      VALUES (?, ?, ?, ?, ?)";
                    $company_stmt = mysqli_prepare($koneksi, $company_query);

                    if ($company_stmt) {
                        mysqli_stmt_bind_param($company_stmt, "issss", $user_id, $company_name, $email, $company_address, $phone_number);

                        if (mysqli_stmt_execute($company_stmt)) {
                            header("Location: ../signup.php?status=success");
                            exit();
                        } else {
                            echo "Gagal menyimpan data ke tabel companies: " . mysqli_error($koneksi);
                        }   
                        mysqli_stmt_close($company_stmt);
                    } else {
                        echo "Gagal menyiapkan statement untuk tabel companies: " . mysqli_error($koneksi);
                    }
                } else {
                    echo "Gagal menyimpan data verifikasi: " . mysqli_error($koneksi);
                }
            } else {
                echo "Gagal menyiapkan statement untuk verifikasi: " . mysqli_error($koneksi);
            }
        } else {
            echo "Gagal menyimpan data pengguna: " . mysqli_error($koneksi);
        }
    } else {
        echo "Gagal menyiapkan statement: " . mysqli_error($koneksi);
    }
}

mysqli_close($koneksi);
