<?php
session_start();
include '../config/koneksi.php'; // Sertakan koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $error = "";

    if (empty($username) || empty($password)) {
        $error = "Username dan Password tidak boleh kosong.";
    } else {
        // Tambahkan kondisi khusus untuk admin
        if ($username === 'admin' && $password === 'admin') {
            session_regenerate_id(true);
            $_SESSION['user_id'] = 'admin'; // Anda bisa mengganti 'admin' dengan nilai lain jika diperlukan
            $_SESSION['username'] = 'admin';

            header('Location: ../admin/admin-dashboard.php');
            exit();
        }

        // Query untuk mendapatkan data pengguna biasa
        $query = "SELECT user_id, password_hash, is_verified FROM users WHERE username = ?";
        $stmt = mysqli_prepare($koneksi, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $user_id, $hashedPassword, $isVerified);
                mysqli_stmt_fetch($stmt);

                if ($isVerified == 0) {
                    $error = "Akun Anda belum diverifikasi oleh admin.";
                } elseif (!password_verify($password, $hashedPassword)) {
                    $error = "Username atau Password salah.";
                } else {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $username;

                    header('Location: ../index.php');
                    exit();
                }
            } else {
                $error = "Username atau Password salah.";
            }
        } else {
            $error = "Gagal menyiapkan statement: " . mysqli_error($koneksi);
        }
        mysqli_stmt_close($stmt);
    }

    if (!empty($error)) {
        header('Location: ../login.php?error=' . urlencode($error));
        exit();
    }
}

mysqli_close($koneksi);
