<?php
$current_page = basename($_SERVER['PHP_SELF']); // Mendapatkan nama file saat ini
?>

<style>
    .line-separate {
        border-bottom: 1px solid #ccc;
        margin: 10px 0;
    }

    .sb-sidenav {
        box-shadow: 10px 0 8px rgba(0, 0, 0, 0.2);
        background-color: rgb(118, 6, 6);
        color: white;
        height: 100vh;
        overflow-y: auto;
    }

    /* Kelas untuk latar belakang aktif */
    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.1);
        /* Warna latar belakang untuk link aktif */
    }
</style>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- Dashboard -->
                <a class="nav-link text-white <?php echo ($current_page == 'admin-dashboard.php') ? 'active' : ''; ?>" href="admin-dashboard.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                <!-- Laporan -->
                <a class="nav-link text-white <?php echo ($current_page == 'admin-laporan.php') ? 'active' : ''; ?>" href="admin-laporan.php">
                    <div class="sb-nav-link-icon"><i class="bi bi-graph-up"></i></div>
                    Laporan
                </a>
                <!-- Akun Indhan -->
                <a class="nav-link text-white <?php echo ($current_page == 'admin-verifikasi.php') ? 'active' : ''; ?>" href="admin-verifikasi.php">
                    <div class="sb-nav-link-icon"><i class="bi bi-command"></i></div>
                    Akun Indhan
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div style="font-size: smaller;">Jl. Tanah Abang Timur No.8 Jakarta Pusat <br>
                indhan.pothan@kemhan.go.id</div>
        </div>
    </nav>
</div>