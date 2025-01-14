<?php
session_start(); // Memastikan session dimulai
include 'config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// echo "$_SESSION[user_id]";
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

    <div class="py-3 px-3 card mb-2" style="position: relative;">
        <!-- <div class="card-img-top shadow" style="height: 460px; overflow: hidden; ">
            <img src="assets/img/Gedung-Kementerian-Pertahanan-Kemenhan.jpg"
                style="width: 100%; height: 100%; object-fit: cover;"
                alt="Gedung Kementerian Pertahanan">
        </div> -->
        <div id="carouselExampleAutoPlaying" class="carousel slide shadow-lg" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item" style="height: 500px; overflow: hidden;" data-bs-interval="3000">
                    <img src="assets/img/Gedung-Kementerian-Pertahanan-Kemenhan.jpg" style="width: 100%; height:100%; object-fit: cover;" alt="...">
                </div>
                <div class="carousel-item active" style="height: 500px; overflow: hidden;" data-bs-interval="3000">
                    <img src="assets/img/foto-beranda-1.jpg" style="width: 100%; height:100%; object-fit: cover;" alt="...">
                </div>
                <div class="carousel-item" style="height: 500px; overflow: hidden;" data-bs-interval="3000">
                    <img src="assets/img/logo-ditjen2.jpg" style="width: 100%; height:100%; object-fit: cover;" alt="...">
                </div>
            </div>
            <!-- <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button> -->
        </div>

        <!-- Card Body -->
        <div class="card-body d-flex flex-column justify-content-center align-items-center text-center"
            style="margin: 0; padding-top: 0;">
            <h5 class="card-title m-3" style="color: #152C5B;"><b>DIREKTORAT JENDERAL POTENSI PERTAHANAN<br>
                    DIREKTORAT TEKNOLOGI INDUSTRI PERTAHANAN<br>
                    KEMENTERIAN PERTAHANAN</b></h5>
            <p class="card-text" style="color: #695441;">
                Direktorat Teknologi Industri Pertahanan (Ditjen Tekindhan) adalah <br>
                salah satu satuan di bawah Direktorat Jenderal Potensi Pertahanan <br>
                (Ditjen Pothan) di Kementerian Pertahanan Republik Indonesia. <br>
                Ditjen Tekindhan memiliki tugas untuk merumuskan serta melaksanakan <br>
                kebijakan dan standardisasi teknis di bidang teknologi dan industri <br>
                pertahanan.
            </p>
            <a class="btn btn-primary mb-3" href="about-dittekindhan.php" role="button" style="width: 12%;">Selengkapnya...</a>
        </div>
    </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="assets/demo/chart-area-demo.js"></script>
<script src="assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>

</html>