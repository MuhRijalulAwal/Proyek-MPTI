<?php
session_start(); // Memastikan session dimulai
include 'config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>INDHAN POTHAN</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <link href="assets/img/logo-proyek-tanpa-teks.png" rel="shortcut icon">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <?php
    include "nav/navbar.php"
    ?>

    <div class="container mx-6 mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tentang Subditindhan</li>
            </ol>
        </nav>
        <main>
            <div class="mx-5">
                <div class="row d-flex justify-content-center">
                    <div class="col-4 text-center mb-3">
                        <h4 style="color: #152C5B; margin-bottom: 2;">SUBDIREKTORAT INDUSTRI POTENSI PERTAHANAN</h4>
                    </div>
                </div>
                <div class="row g-4 align-items-stretch">
                    <!-- Kolom kiri untuk satu gambar -->
                    <div class="col-md-6">
                        <div style="height: 486px;">
                            <img src="assets/img/pothan1.png" class="card-img-top" style="height: 100%; object-fit: cover;" alt="Gambar Kiri">
                        </div>
                    </div>
                    <!-- Kolom kanan untuk dua gambar -->
                    <div class="col-md-6 d-flex flex-column">
                        <div class="flex-fill mb-2" style="height: 243px;">
                            <img src="assets/img/pothan2.png" class="card-img-top" style="height: 100%; object-fit: cover;" alt="Gambar Kanan Atas">
                        </div>
                        <div class="flex-fill" style="height: 235px;">
                            <img src="assets/img/pothan3.png" class="card-img-top" style="height: 100%; object-fit: cover;" alt="Gambar Kanan Bawah">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-center mt-4">
                <div class="col-6 text-center">
                    <h4 style="color: #152C5B;">Tentang Subdirektorat Industri Pertahanan</h4>
                </div>
                <p class="mt-4" style="text-align: center; font-size: 16px; color:#695441;">
                    Subdirektorat Industri Pertahanan mempunyai tugas
                    melaksanakan penyiapan perumusan,<br> pemantauan,
                    evaluasi dan pelaporan kebijakan di bidang asesmen,<br>
                    pengembangan, dan pendayagunaan industri pertahanan.
                </p>
            </div>

            <div class="row d-flex justify-content-center mt-4">
                <div class="col-6 text-center">
                    <h4 style="color: #152C5B;">Tugas Utama</h4>
                </div>

                <div class="row">
                    <div class="col-6">
                        <p class="mt-4 text-center" style="color:#695441; font-size: 18px;"><b>Penyiapan Bahan Rumusan Kebijakan dan Bahan Penyusunan Peraturan</b> <br>
                            Bidang Asesmen, Pengembangan, dan Pendayagunaan Industri
                            Pertahanan. </p>
                    </div>

                    <div class="col-6">
                        <p class="mt-4 text-center" style="color:#695441; font-size: 18px;"><b>Penyiapan Bahan Rumusan Kebijakan dan Bahan Penyusunan Peraturan</b> <br>
                            Bidang Asesmen, Pengembangan, dan Pendayagunaan Industri
                            Pertahanan. </p>
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php
    include "footer/footer.php";
    ?>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>

</html>