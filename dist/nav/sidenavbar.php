<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SideNavBar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .line-separate {
            border-bottom: 1px solid #ccc;
            margin: 10px 0;
        }

        .sb-sidenav {
            box-shadow: 10px 0 8px rgba(0, 0, 0, 0.2);
            /* Shadow di sisi kanan */
            /* background-color: #343a40; Latar belakang sidebar */
            /* color: white; Warna teks */
            height: 100vh;
            /* Pastikan sidebar memenuhi tinggi layar */
            overflow-y: auto;
            /* Scroll jika konten lebih panjang */
        }
    </style>
</head>

<body>

    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <!-- Dashboard -->
                    <a class="nav-link text-dark" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Beranda
                    </a>
                    <!-- Laporan -->
                    <a class="nav-link text-dark" href="../user/userLaporan.php">
                        <div class="sb-nav-link-icon"><i class="bi bi-graph-up"></i></div>
                        Laporan
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="large">Ditjen Pothan Indhan</div>
                <div style="font-size: smaller;">Jakarta Pusat, DKI Jakarta</div>
            </div>
        </nav>
    </div>

</body>

</html>