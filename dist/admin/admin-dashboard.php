<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>INDHAN POTHAN</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../assets/img/logo-proyek-tanpa-teks.png" rel="shortcut icon">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="sb-nav-fixed">
    <!-- Navbar -->
    <?php include "nav/admin-navbar.php"; ?>

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav">
            <?php include "nav/admin-sidebar.php"; ?>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="card mb-2">
                    <div class="card-img-top" style="height: 460px; overflow: hidden;">
                        <img src="../assets/img/Gedung-Kementerian-Pertahanan-Kemenhan.jpg"
                            class="img-fluid"
                            style="object-fit: cover; height: 100%; width: 100%;"
                            alt="Gedung Kementerian Pertahanan">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title text-primary fw-bold">
                            DIREKTORAT TEKNOLOGI INDUSTRI PERTAHANAN<br>
                            DIREKTORAT JENDERAL POTENSI PERTAHANAN<br>
                            KEMENTERIAN PERTAHANAN
                        </h5>
                        <p class="card-text text-secondary">
                            Direktorat Teknologi Industri Pertahanan (Ditjen Tekindhan) adalah salah satu satuan di bawah<br>
                            Direktorat Jenderal Potensi Pertahanan (Ditjen Pothan) di Kementerian Pertahanan Republik Indonesia.<br>
                            Ditjen Tekindhan memiliki tugas untuk merumuskan serta melaksanakan kebijakan dan standardisasi teknis<br>
                            di bidang teknologi dan industri pertahanan.
                        </p>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <!-- Kategori Industri Pertahanan -->
                        <div class="col-sm-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i> Kategori Industri Pertahanan
                                </div>
                                <div class="card-body">
                                    <canvas id="myPieChartCategory" width="100%" height="50"></canvas>
                                </div>
                                <div class="card-footer small text-muted">Updated recently</div>
                            </div>
                        </div>
                        <!-- Penetapan Industri Pertahanan -->
                        <div class="col-sm-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i> Penetapan Industri Pertahanan
                                </div>
                                <div class="card-body">
                                    <canvas id="myPieChartAssignment" width="100%" height="50"></canvas>
                                </div>
                                <div class="card-footer small text-muted">Updated recently</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Kelompok Produk -->
                        <div class="col-sm-6 mx-auto">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i> Kelompok Produk
                                </div>
                                <div class="card-body">
                                    <canvas id="myPieChartProductGroup" width="100%" height="50"></canvas>
                                </div>
                                <div class="card-footer small text-muted">Updated recently</div>
                            </div>
                        </div>
                    </div>

            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ambil elemen canvas
            const ctxCategory = document.getElementById("myPieChartCategory");
            const ctxAssignment = document.getElementById("myPieChartAssignment");
            const ctxProductGroup = document.getElementById("myPieChartProductGroup");
            const ctxClassificationNameAlatUtama = document.getElementById("myPieChartClassificationNameAlatUtama");
            const ctxClassificationNameKomponenUtama = document.getElementById("myPieChartClassificationNameKomponenUtama");
            const ctxClassificationNameKomponenPendukung = document.getElementById("myPieChartClassificationNameKomponenPendukung");
            const ctxClassificationNameBahanBaku = document.getElementById("myPieChartClassificationNameBahanBaku");

            // Fungsi untuk membuat pie chart
            function createPieChart(ctx, url, labelText, colors) {
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(item => item.label);
                        const values = data.map(item => item.value);

                        // Menambahkan warna yang berbeda untuk tiap bagian pie
                        const pieColors = colors || Array(values.length).fill("rgba(2,117,216,1)");

                        new Chart(ctx, {
                            type: 'pie', // Mengubah tipe chart menjadi 'pie'
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: labelText,
                                    backgroundColor: pieColors, // Menggunakan warna yang berbeda untuk setiap bagian
                                    data: values,
                                }],
                            },
                            options: {
                                responsive: true,
                                legend: {
                                    position: 'top',
                                },
                                animation: {
                                    animateScale: true,
                                    animateRotate: true
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error fetching chart data:', error));
            }

            // Fungsi untuk membuat bar chart
            function createBarChart(ctx, url, labelText, barColors) {
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const labels = data.map(item => item.label); // Label data
                        const values = data.map(item => item.value); // Nilai data

                        const backgroundColors = barColors || Array(values.length).fill("rgba(2,117,216,1)");
                        const borderColors = barColors ? barColors.map(color => color.replace(/0.5\)/, "1)")) : Array(values.length).fill("rgba(2,117,216,1)");

                        new Chart(ctx, {
                            type: 'bar', // Ubah tipe chart menjadi bar
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: labelText,
                                    backgroundColor: backgroundColors, // Warna batang
                                    borderColor: borderColors, // Warna tepi
                                    borderWidth: 1,
                                    data: values,
                                }],
                            },
                            options: {
                                responsive: true,
                                legend: {
                                    display: false, // Sembunyikan legend untuk bar chart
                                },
                                scales: {
                                    xAxes: [{
                                        gridLines: {
                                            display: true
                                        },
                                        ticks: {
                                            fontSize: 12
                                        }
                                    }],
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true, // Mulai dari nol
                                            stepSize: 10 // Atur step untuk y-axis
                                        }
                                    }]
                                }
                            }
                        });
                    })
                    .catch(error => console.error('Error fetching chart data:', error));
            }

            // Warna untuk bar chart
            const productGroupColors = [
                "rgba(255, 99, 132, 1)", "rgba(54, 162, 235, 1)", "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 0, 1)", "rgba(20, 255, 20, 1)", "rgba(255, 159, 64, 0.5)"
            ];

            // Warna untuk kategori dan assignment industri
            const categoryColors = ["rgba(255, 255, 0, 1)", "rgba(0, 162, 235, 1)", "rgba(75, 192, 192, 0.6)", "rgba(153, 102, 255, 0.6)"];
            const assignmentColors = ["rgba(255, 0, 0, 1)", "rgba(0, 0, 235, 1)", "rgba(54, 162, 235, 0.6)", "rgba(75, 192, 192, 0.6)"];
            const product_groupColours = ["rgba(255, 0, 0, 1)", "rgba(255, 0, 235, 1)", "rgba(0, 255, 0, 1)", "rgba(0, 192, 0, 1)"];
            const classificationNameColours = [
                "rgba(255, 0, 0, 1)", // Red
                "rgba(0, 255, 0, 1)", // Green
                "rgba(0, 0, 255, 1)", // Blue
                "rgba(255, 165, 0, 1)", // Orange
                "rgba(255, 255, 0, 1)", // Yellow
                "rgba(128, 0, 128, 1)", // Purple
                "rgba(0, 255, 255, 1)", // Cyan
                "rgba(128, 128, 128, 1)", // Gray
                "rgba(255, 192, 203, 1)", // Pink
                "rgba(128, 0, 0, 1)", // Maroon
                "rgba(0, 128, 128, 1)", // Teal
                "rgba(210, 105, 30, 1)", // Chocolate
                "rgba(0, 128, 0, 1)", // Dark Green
                "rgba(75, 0, 130, 1)", // Indigo
                "rgba(255, 69, 0, 1)", // Red-Orange
                "rgba(255, 215, 0, 1)", // Gold
                "rgba(0, 100, 0, 1)", // Dark Green
                "rgba(70, 130, 180, 1)", // Steel Blue
                "rgba(139, 69, 19, 1)", // Saddle Brown
                "rgba(220, 20, 60, 1)", // Crimson
                "rgba(244, 164, 96, 1)", // Sandy Brown
                "rgba(199, 21, 133, 1)", // Medium Violet Red
                "rgba(173, 216, 230, 1)", // Light Blue
                "rgba(46, 139, 87, 1)", // Sea Green
                "rgba(255, 228, 196, 1)" // Bisque
            ];


            // Buat pie chart untuk kategori
            createPieChart(ctxCategory, 'get-chart-data.php?type=category', 'Data Kategori Perusahaan', categoryColors);

            // Buat pie chart untuk assignment
            createPieChart(ctxAssignment, 'get-chart-data.php?type=assignment', 'Data Assignment Perusahaan', assignmentColors);

            // Buat bar chart untuk kelompok produk
            createBarChart(ctxProductGroup, 'get-chart-data.php?type=product_group', 'Data Grup Produk Perusahaan', productGroupColors);

            // Buat pie chart untuk classification name alat utama
            createPieChart(ctxClassificationNameAlatUtama, 'get-chart-data.php?type=classification_name_alat_utama', 'Data Nama Klasifikasi Produk Alat Utama', classificationNameColours);

            // Buat pie chart untuk classification name komponen utama
            createPieChart(ctxClassificationNameKomponenUtama, 'get-chart-data.php?type=classification_name_komponen_utama', 'Data Nama Klasifikasi Produk Komponen Utama', classificationNameColours);

            // Buat pie chart untuk classification name komponen pendukung
            createPieChart(ctxClassificationNameKomponenPendukung, 'get-chart-data.php?type=classification_name_komponen_pendukung', 'Data Nama Klasifikasi Produk Komponen Pendukung', classificationNameColours);

            // Buat pie chart untuk classification name bahan baku
            createPieChart(ctxClassificationNameBahanBaku, 'get-chart-data.php?type=classification_name_bahan_baku', 'Data Nama Klasifikasi Produk Bahan Baku', classificationNameColours);
        });
    </script>

</body>

</html>