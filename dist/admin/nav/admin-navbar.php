<?php
$current_path = $_SERVER['PHP_SELF'];
$base_path = (strpos($current_path, '/dist/user/') !== false || strpos($current_path, '/dist/admin/') !== false) ? '../' : '';

$dashboard_url = "{$base_path}admin/admin-dashboard.php";
$data_laporan_url = "{$base_path}admin/admin-laporan.php";
$admin_verifikasi_url = "{$base_path}admin/admin-verifikasi.php";
$tentang_pothan_url = "{$base_path}about-pothan.php";
$tentang_dittekindhan_url = "{$base_path}about-dittekindhan.php";
$tentang_subditindhan_url = "{$base_path}about-subditindhan.php";
$logout_url = "{$base_path}logout.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Dropdown</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-red bg-red" style="background-color: rgb(118, 6, 6);;">
        <!-- Navbar Brand -->
         
        <a class="navbar-brand ps-3 text-white" href="<?= $dashboard_url ?>"><img src="../assets/img/logo-proyek-teks.png" style="width: 30px; height: 30px;"> Garuda Indhan</a>

        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!" style="color: white;"><i
                class="fas fa-bars"></i></button>


        <!-- Navbar Right -->
        <ul class="navbar-nav ms-auto me-5">
            <li><a class="btn btn-link" style="color: white;" href="<?= $logout_url ?>">Logout</a></li>
        </ul>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>