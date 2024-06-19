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
    </style>
</head>

<body>
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link" href="index.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link collapsed" href="penyimpanan.php">
                        <div class="sb-nav-link-icon"><i class="bi bi-archive"></i></div>
                        Penyimpanan
                    </a>

                    <a class="nav-link collapsed" href="laporan.php">
                        <div class="sb-nav-link-icon"><i class="bi bi-graph-up"></i></div>
                        Laporan
                    </a>

                    <a class="nav-link" href="charts.html">
                        <div class="sb-nav-link-icon"><i class="bi bi-sliders2"></i></div>
                        Konfigurasi
                    </a>
                    <div class="line-separate"></div>
                    <a class="nav-link" href="charts.html">
                        <div class="sb-nav-link-icon"><i class="bi bi-people-fill"></i></div>
                        Kontak
                    </a>
                    <a class="nav-link" href="tables.html">
                        <div class="sb-nav-link-icon"><i class="bi bi-bell"></i></div>
                        Notifikasi
                    </a>
                    <a class="nav-link" href="tables.html">
                        <div class="sb-nav-link-icon"><i class="bi bi-chat-left-dots"></i></div>
                        Chat
                    </a>
                    <div class="line-separate"></div>
                    <a class="nav-link" href="charts.html">
                        <div class="sb-nav-link-icon"><i class="bi bi-gear"></i></div>
                        Setelan
                    </a>
                    <a class="nav-link" href="tables.html">
                        <div class="sb-nav-link-icon"><i class="bi bi-command"></i></div>
                        Prediksi
                    </a>
                    <a class="nav-link" href="tables.html">
                        <div class="sb-nav-link-icon"><i class="bi bi-question-square"></i></div>
                        Bantuan
                    </a>

                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="large">Sorobayan Farma</div>
                <div style="font-size: smaller;">Sorobayan Farma, Sanden, Bantul</div>
            </div>
        </nav>
    </div>
</body>

</html>
