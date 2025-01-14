<?php
session_start(); // Memastikan session dimulai
include '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Laporan - User</title>
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../assets/img/logo-proyek-tanpa-teks.png" rel="shortcut icon">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="sb-nav-fixed">
    <?php include "../nav/navbar.php" ?>
    <main>
        <div class="wrap" style="margin-left: 47px; margin-right: 47px;">
            <div class="container-fluid px-4">
                <h3 style="color:#152C5B;" class="mt-4">Laporan > Tambah Laporan </h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">*Semua kolom wajib diisi, kecuali disebutkan sebagai
                        (opsional).</li>
                </ol>
                <?php
                if (!empty($message)) {
                    echo '<div class="alert alert-danger">' . $message . '</div>';
                }
                ?>
                <div class="container mt-4">
                    <!-- Form Utama -->
                    <form action="../act/cobaLaporanAct.php" enctype="multipart/form-data" method="POST">
                        <div class="workshop-item mb-3">
                            <!-- Nama WorkShop -->
                            <div class="row mb-3">
                                <p class="mb-3"><strong>Workshop 1</strong></p>
                                <label for="inputText" class="text-secondary col-sm-4 col-form-label text-start">Nama WorkShop</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama_workshop" name="nama_workshop[]" placeholder="Masukkan Nama WorkShop">
                                </div>
                            </div>
                            <!-- Nomor Telepon WorkShop -->
                            <div class="row mb-3">
                                <label for="phoneInput" class="text-secondary col-sm-4 col-form-label text-start">Nomor Telepon WorkShop</label>
                                <div class="col-sm-8">
                                    <input type="tel" class="form-control" id="nomor_telp_workshop" name="nomor_telp_workshop[]" placeholder="Masukkan nomor telepon workshop (10 - 13 digit angka)" pattern="[0-9]{10,13}">
                                </div>
                            </div>
                            <hr>
                        </div>

                        <div id="workshopContainer"></div>

                        <!-- Tombol Tambah dan Hapus -->
                        <div class="row mb-3">
                            <div class="col-sm-8 offset-sm-4">
                                <button type="button" class="btn btn-link btn-sm" id="addWorkshop">+ Tambah Workshop</button>
                                <button type="button" class="btn btn-link btn-sm" id="removeWorkshop">- Hapus Workshop</button>
                            </div>
                        </div>

                        <!-- Manajemen dan Organisasi -->
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <h5 class="mb-3">Manajemen dan Organisasi</h5>
                            </div>
                            <label for="formFile" class="text-secondary col-sm-4 col-form-label text-start">Struktur Organisasi</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="file" id="struktur_organisasi" name="struktur_organisasi">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- Nama Direktur Utama -->
                        <div class="row mb-3">
                            <label for="inputText" class="text-secondary col-sm-4 col-form-label text-start">Nama Direktur Utama</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama_direktur_utama" name="nama_direktur_utama" placeholder="Masukkan Nama Direktur Utama">
                            </div>
                        </div>

                        <!-- Nomor Telepon Utama -->
                        <div class="row mb-3 form-group">
                            <label for="phoneInput" class="text-secondary col-sm-4 col-form-label text-start">Nomor Telepon Direktur Utama</label>
                            <div class="class col-sm-8">
                                <input type="tel" class="form-control" id="telepon_direktur_utama" name="telepon_direktur_utama" placeholder="Masukkan nomor telepon" pattern="[0-9]{10,13}">
                                <small class="form-text text-muted ms-3"><i>Masukkan nomor telepon yang terdiri dari 10 hingga 13 digit angka.</i></small>
                            </div>
                        </div>

                        <!-- Nama PIC -->
                        <div class="row mb-3">
                            <label for="inputText" class="text-secondary col-sm-4 col-form-label text-start">Nama PIC</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama_pic" name="nama_pic" placeholder="Masukkan Nama PIC">
                            </div>
                        </div>

                        <!-- Nomor Telepon Utama -->
                        <div class="row mb-3 form-group">
                            <label for="phoneInput" class="text-secondary col-sm-4 col-form-label text-start">Nomor Telepon PIC Utama</label>
                            <div class="class col-sm-8">
                                <input type="tel" class="form-control" id="telepon_pic" name="telepon_pic" placeholder="Masukkan nomor telepon" pattern="[0-9]{10,13}">
                                <small class="form-text text-muted ms-3"><i>Masukkan nomor telepon yang terdiri dari 10 hingga 13 digit angka.</i></small>
                            </div>
                        </div>

                        <!-- Daftar Tenaga Ahli -->
                        <div class="row mb-3 align-items-center">
                            <label for="time" class="text-secondary col-sm-4 col-form-label text-start">Daftar Tenaga Ahli
                                (<a href="https://docs.google.com/spreadsheets/d/14HeQKuxOJUJefaethYCeWIOOSjuOTSg_Po67-oHWDyg/edit?gid=0#gid=0" class="text-decoration-underline text-primary">Informasi Tenaga Ahli</a>)
                            </label>
                            <div class="col-sm-8">
                                <input class="form-control" type="file" id="daftar_tenaga_ahli" name="daftar_tenaga_ahli">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- Manajemen Keuangan -->
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <h5 class="mb-3">Manajemen Keuangan</h5>
                            </div>
                            <label for="nama_kantor" class="text-secondary col-sm-4 col-form-label text-start">Nama Kantor Akuntan Public</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama_kantor" name="nama_kantor" placeholder="Masukkan Nama Kantor Akuntan Public">
                            </div>
                        </div>

                        <!-- Laporan Keuangan Internal -->
                        <div class="row mb-3">
                            <label for="laporan_keuangan_internal" class="text-secondary col-sm-4 col-form-label text-start">Laporan Keuangan (Hasil Audit Auditor Internal)</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="laporan_keuangan_internal" name="laporan_keuangan_internal">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- Laporan Keuangan Eksternal -->
                        <div class="row mb-3">
                            <label for="laporan_keuangan_external" class="text-secondary col-sm-4 col-form-label text-start">Laporan Keuangan (Hasil Audit Auditor External)</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="laporan_keuangan_external" name="laporan_keuangan_external">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- Grafik Perkembangan Finansial (5 thn terakhir) -->
                        <div class="row mb-3">
                            <label for="grafik_perkembangan" class="text-secondary col-sm-4 col-form-label text-start">Grafik Perkembangan Finansial (5 thn terakhir)</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="grafik_perkembangan" name="grafik_perkembangan">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- Opini Akuntan Publik -->
                        <div class="row mb-3">
                            <label for="opini_akuntan" class="text-secondary col-sm-4 col-form-label text-start">Opini Akuntan Publik</label>
                            <div class="col-sm-8">
                                <select class="form-select" id="opini_akuntan" name="opini_akuntan">
                                    <option value="" disabled selected>Pilih Opini</option>
                                    <option value="Unqualified Opinion">Unqualified Opinion</option>
                                    <option value="Unqualified Opinion With Explanatory Language">Unqualified Opinion With Explanatory Language</option>
                                    <option value="Adverse Opinion">Adverse Opinion</option>
                                    <option value="Disclaimer Opinion">Disclaimer Opinion</option>
                                </select>
                            </div>
                        </div>

                        <!-- SOP Aktivitas Bisnis Pemasaran -->
                        <div class="row mb-3">
                            <label for="sop_pemasaran" class="text-secondary col-sm-4 col-form-label text-start">SOP Aktivitas Bisnis Pemasaran</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="sop_pemasaran" name="sop_pemasaran">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- MANAJEMEN TEKNOLOGI DAN REKAYASA-->
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <h5 class="mb-3">Manajemen Teknologi dan Rekayasa</h5>
                            </div>
                            <label for="teknologi_project_portofolio" class="text-secondary col-sm-4 col-form-label text-start">Technology Project Portofolio</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="teknologi_project_portofolio" name="teknologi_project_portofolio">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- RoadMap Pengembangan Teknologi -->
                        <div class="row mb-3">
                            <label for="roadmap_pengembangan" class="text-secondary col-sm-4 col-form-label text-start">Roadmap Pengembangan Teknologi</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="roadmap_pengembangan" name="roadmap_pengembangan">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- LITBANG R & D (Produk ALPALHANKAM) -->
                        <div class="row mb-3">
                            <label for="litbang_rd" class="text-secondary col-sm-4 col-form-label text-start">LITBANG R & D (Produk ALPALHANKAM)</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="litbang_rd" name="litbang_rd">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- Offset -->
                        <div class="row mb-3">
                            <label for="offset" class="text-secondary col-sm-4 col-form-label text-start">Offset</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="offset" name="offset">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- FASILITAS PERALATAN DAN PRODUKSI -->
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <h5 class="mb-3">Fasilitas Peralatan dan Produksi</h5>
                            </div>
                            <label for="daftar_peralatan" class="text-secondary col-sm-4 col-form-label text-start">Daftar Peralatan</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="daftar_peralatan" name="daftar_peralatan">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- KEPEMILIKAN SARANA/PRASARANA PRODUKSI -->
                        <div class="row mb-3">
                            <label for="kepemilikan_sarana" class="text-secondary col-sm-4 col-form-label text-start">Kepemilikan Sarana/Prasarana Produksi</label>
                            <div class="col-sm-8">
                                <select class="form-select" id="kepemilikan_sarana" name="kepemilikan_sarana">
                                    <option value="" disabled selected>Pilih Kepemilikan</option>
                                    <option value="Sewa">Sewa</option>
                                    <option value="Milik Sendiri">Milik Sendiri</option>
                                </select>
                            </div>
                        </div>

                        <!-- LAYOUT PRODUKSI & JASA PEMELIHARAAN -->
                        <div class="row mb-3">
                            <label for="layout_produksi" class="text-secondary col-sm-4 col-form-label text-start">Layout Produksi & Jasa Pemeliharaan</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="layout_produksi" name="layout_produksi">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- PRODUK PERUSAHAAN -->
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <h5 class="mb-3">Produk Perusahaan</h5>
                                <p><strong>Produk 1</strong></p>
                            </div>
                            <label for="nama_produk" class="text-secondary col-sm-4 col-form-label text-start">Nama Produk</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama_produk" name="nama_produk[]" placeholder="Masukkan Nama Produk">
                            </div>
                        </div>

                        <!-- Nomor KBLI -->
                        <div class="row mb-3">
                            <label for="nomor_kbli" class="text-secondary col-sm-4 col-form-label text-start">Nomor KBLI
                                (<a href="https://docs.google.com/document/d/1PWSdth5JC4JnI-hwnM4snxbLwSUPnvTb9ZM40Uwfe8I/edit?usp=sharing" class="text-decoration-underline text-primary">Informasi KBLI</a>)
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nomor_kbli" name="nomor_kbli[]" placeholder="Masukkan KBLI">
                            </div>
                        </div>

                        <!-- Deskripsi KBLI -->
                        <div class="row mb-3">
                            <label for="deskripsi_kbli" class="text-secondary col-sm-4 col-form-label text-start">Deskripsi KBLI</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="deskripsi_kbli" name="deskripsi_kbli[]" placeholder="Masukkan Deskripsi KBLI">
                            </div>
                        </div>

                        <!-- Informasi Produk Ekspor/Impor -->
                        <div class="row mb-3">
                            <label for="kelompok_produk" class="text-secondary col-sm-4 col-form-label text-start">
                                Kelompok Produk
                                (<a href="#" id="infoLink" class="text-decoration-underline text-primary">Informasi Produk INDHAN</a>)
                            </label>
                            <div class="col-sm-8">
                                <select class="form-select" id="kelompok_produk" name="kelompok_produk[]">
                                    <option value="" disabled selected>Pilih Kelompok Produk</option>
                                    <option value="Alat Utama">Alat Utama</option>
                                    <option value="Komponen Utama">Komponen Utama</option>
                                    <option value="Komponen Pendukung">Komponen Pendukung</option>
                                    <option value="Komponen Bahan Baku">Komponen Bahan Baku</option>
                                </select>
                            </div>
                        </div>

                        <!-- Klasifikasi Produk INDHAN -->
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="klasifikasi_produk" class="text-secondary col-sm-12 col-form-label text-start">
                                    Klasifikasi Produk INDHAN
                                    (<a href="#" id="infoLink1" class="text-decoration-underline text-primary">Informasi Klasifikasi Produk INDHAN</a>)
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="klasifikasi_produk" name="klasifikasi_produk[]" placeholder="Masukkan Klasifikasi Produk">
                            </div>
                        </div>

                        <!-- LEVEL -->
                        <div class="row mb-3">
                            <label for="trl" class="text-secondary col-sm-4 col-form-label text-start">TRL (<i>Technology Readiness Level</i>)</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="trl" name="trl[]" placeholder="Masukkan Jumlah TRL" min="1" max="9">
                            </div>
                        </div>

                        <!-- MRL -->
                        <div class="row mb-3">
                            <label for="mrl" class="text-secondary col-sm-4 col-form-label text-start">MRL (<i>Manufacturing Readiness Level</i>)</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="mrl" name="mrl[]" placeholder="Masukkan Jumlah MRL" min="1" max="9">
                            </div>
                        </div>

                        <!-- KAPASITAS PRODUKSI -->
                        <div class="row mb-3 mt-4">
                            <label for="productionCapacity" class="text-secondary col-sm-4 col-form-label text-start">Kapasitas Produksi</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="number" id="productionCapacity" name="kapasitas_produksi[]" placeholder="Masukkan kapasitas produksi" min="0">
                            </div>
                        </div>

                        <!-- SERTIFIKASI KELAYAKAN -->
                        <div class="row mb-3">
                            <label for="sertifikasi_kelayakan" class="text-secondary col-sm-4 col-form-label text-start">Sertifikasi Kelayakan</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="sertifikasi_kelayakan" name="sertifikasi_kelayakan[]">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- SERTIFIKAT ISO PRODUK -->
                        <div class="row mb-3">
                            <label for="sertifikat_iso" class="text-secondary col-sm-4 col-form-label text-start">Sertifikat ISO Produk</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="sertifikat_iso" name="sertifikat_iso[]">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- NILAI TKDN per PRODUK -->
                        <div class="row mb-3">
                            <label for="tkdnValue" class="text-secondary col-sm-4 col-form-label text-start">Nilai TKDN Per Produk</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input
                                        class="form-control"
                                        type="number"
                                        id="nilai_tkdn"
                                        name="nilai_tkdn[]"
                                        placeholder="Masukkan Nilai TKDN Produk"
                                        min="0"
                                        max="100"
                                        step="0.01"
                                        aria-label="Nilai TKDN"                                  >
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Nomor Sertifikat TKDN -->
                        <div class="row mb-3">
                            <label for="nomor_sertifikat_tkdn" class="text-secondary col-sm-4 col-form-label text-start">Nomor Sertifikat TKDN</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nomor_sertifikat_tkdn" name="nomor_sertifikat_tkdn[]" placeholder="Masukkan Nomor Sertifikat TKDN">
                            </div>
                        </div>

                        <hr>

                        <div id="produkContainer"></div>

                        <!-- Tombol Tambah dan Hapus Produk -->
                        <div class="row mb-3">
                            <div class="col-sm-8 offset-sm-4">
                                <button type="button" class="btn btn-link btn-sm" id="addProduk">+ Tambah Produk</button>
                                <button type="button" class="btn btn-link btn-sm" id="removeProduk">- Hapus Produk</button>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="infoModal1" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title w-100 text-center" id="infoModalLabel">Klasifikasi Produk INDHAN</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <!-- Gambar klasifikasi produk -->
                                        <img src="../assets/img/Paparan-P3DN-19-Juni-2024.png" alt="Klasifikasi Produk INDHAN" class="img-fluid rounded">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title w-100 text-center" id="infoModalLabel">Klasifikasi Produk INDHAN</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center">
                                        <!-- Gambar klasifikasi produk -->
                                        <img src="../assets/img/Paparan-P3DN-19-Juni-2024.png" alt="Klasifikasi Produk INDHAN" class="img-fluid rounded">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Akta Notaris -->
                        <div class="row mb-3">
                            <p class="mb-3"><strong>Akta Notaris</strong></p>

                            <!-- Akta Perusahaan -->
                            <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Akta Perusahaan</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="akta_perusahaan" name="akta_perusahaan">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- Akta Perubahan Terakhir -->
                        <div class="row mb-3">
                            <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Akta Perubahan Terakhir</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="akta_perusahaan_terakhir" name="akta_perusahaan_terakhir">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- Kontrak ICC Pengadaan -->
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <h5 class="mb-3">Kontrak ICC Pengadaan</h5>
                            </div>
                            <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Kontrak
                            </label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="kontrak_icc_pengadaan" name="kontrak_icc_pengadaan">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- Kegiatan KLO -->
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <h5 class="mb-3">Kegiatan KLO (Kandungan Lokal Offset)</h5>
                            </div>
                            <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Materi Offset
                                (<a href="https://docs.google.com/spreadsheets/d/111DXv9aQIGc48dA6-N6csJdqKmR817Q3W7JIUE3jCuY/edit?usp=sharing" id="infoLink" class="text-decoration-underline text-primary">Informasi Materi Offset</a>)
                            </label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="materi_offset" name="materi_offset">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- PERSONIL PENERIMA -->
                        <div class="personil-item mb-3">
                            <p class="mb-3"><strong>Personil 1</strong></p>
                            <div class="row mb-3">
                                <label for="nama_personil" class="text-secondary col-sm-4 col-form-label text-start">Nama Personil Penerima</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama_personil" name="nama_personil[]" placeholder="Masukkan Nama">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="nik_personil" class="text-secondary col-sm-4 col-form-label text-start">NIK Personil Penerima</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nik_personil" name="nik_personil[]" placeholder="Masukkan NIK">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="divisi_personil" class="text-secondary col-sm-4 col-form-label text-start">Divisi Personil Penerima</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="divisi_personil" name="divisi_personil[]" placeholder="Masukkan Divisi" >
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div id="personnilContainer"></div>

                        <!-- Tombol Tambah dan Hapus -->
                        <div class="row">
                            <div class="col-sm-8 offset-sm-4">
                                <button type="button" class="btn btn-link btn-sm" id="addPersonil">+ Tambah Personil</button>
                                <button type="button" class="btn btn-link btn-sm" id="removePersonil">- Hapus Personil</button>
                            </div>
                        </div>

                        <!-- MATERIAL Offset -->
                        <div class="material-item mb-3">
                            <p class="mb-3"><strong>Material 1</strong></p>
                            <div class="row mb-3">
                                <label for="nomor_part_material_offset" class="text-secondary col-sm-4 col-form-label text-start">Part No/SN</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nomor_part_material_offset" name="nomor_part_material_offset[]" placeholder="Masukkan No/SN">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="merk_material_offset" class="text-secondary col-sm-4 col-form-label text-start">Merk/Type</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="merk_material_offset" name="merk_material_offset[]" placeholder="Masukkan Merk/Type">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="deskripsi_material_offset" class="text-secondary col-sm-4 col-form-label text-start">Deskripsi</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="deskripsi_material_offset" name="deskripsi_material_offset[]" placeholder="Masukkan Deskripsi">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="kuantitas_material_offset" class="text-secondary col-sm-4 col-form-label text-start">Kuantitas</label>
                                <div class="col-sm-8">
                                    <input type="number" class="form-control" id="kuantitas_material_offset" name="kuantitas_material_offset[]" placeholder="Masukkan Kuantitas">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="review_material_offset" class="text-secondary col-sm-4 col-form-label text-start">Review dan Saran</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" id="review_material_offset" name="review_material_offset[]" placeholder="Masukkan Review dan Saran" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <!-- Kontainer untuk Material Offset -->
                        <div id="materialContainer"></div>

                        <!-- Tombol Tambah dan Hapus -->
                        <div class="row">
                            <div class="col-sm-8 offset-sm-4">
                                <button type="button" class="btn btn-link btn-sm" id="addMaterial">+ Tambah Material</button>
                                <button type="button" class="btn btn-link btn-sm" id="removeMaterial">- Hapus Material</button>
                            </div>
                        </div>

                        <!-- Kerja Sama Industri -->
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <p class="mb-3"><strong>Kerja Sama Industri 1</strong></p>
                            </div>
                            <label for="nama_industri_yang_bekerja_sama" class="text-secondary col-sm-4 col-form-label text-start">
                                Nama Industri Yang Bekerja Sama
                            </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama_industri_yang_bekerja_sama" name="nama_industri_yang_bekerja_sama[]" placeholder="Masukkan Nama Industri yang Bekerja Sama">
                            </div>
                        </div>

                        <!-- Kategori -->
                        <div class="row mb-3">
                            <label for="kategori" class="text-secondary col-sm-4 col-form-label text-start">
                                Kategori
                            </label>
                            <div class="col-sm-8">
                                <select class="form-select" id="kategori" name="kategori[]">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="Dalam Negeri">Dalam Negeri</option>
                                    <option value="Luar Negeri">Luar Negeri</option>
                                </select>
                            </div>
                        </div>

                        <!-- Bidang Kerja Sama -->
                        <div class="row mb-3">
                            <label for="bidang_kerja_sama" class="text-secondary col-sm-4 col-form-label text-start">
                                Bidang Kerja Sama
                            </label>
                            <div class="col-sm-8">
                                <select class="form-select" id="bidang_kerja_sama" name="bidang_kerja_sama[]">
                                    <option value="" disabled selected>Pilih Bidang Kerja Sama</option>
                                    <option value="Join Venture">Join Venture</option>
                                    <option value="Join Production">Join Production</option>
                                    <option value="Join Development">Join Development</option>
                                </select>
                            </div>
                        </div>

                        <!-- Upload Dokumen LOA&POA atau Sejenis Dokumen Kerja Sama -->
                        <div class="row mb-3">
                            <label for="dokumen_loapoa" class="text-secondary col-sm-4 col-form-label text-start">
                                Upload Dokumen LOA&POA atau Sejenis Dokumen Kerja Sama
                            </label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="dokumen_loapoa" name="dokumen_loapoa[]">
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                            <hr>
                        </div>

                        <!-- Kontainer untuk Kerja Sama -->
                        <div id="kerjaSamaContainer"></div>

                        <!-- Tombol Tambah dan Hapus Kerja Sama -->
                        <div class="row mb-3">
                            <div class="col-sm-8 offset-sm-4">
                                <button type="button" class="btn btn-link btn-sm" id="addKerjaSama" style="font-size: 15px;">+ Tambah Kerja Sama</button>
                                <button type="button" class="btn btn-link btn-sm" id="removeKerjaSama" style="font-size: 15px;">- Hapus Kerja Sama</button>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row">
                            <div class="col-sm-12 text-end mt-5">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <?php
        include "../footer/footer.php";
        ?>
    </footer>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="../assets/demo/chart-area-demo.js"></script>
<script src="../assets/demo/chart-bar-demo.js"></script>
<script src="../js/scripts.js"></script>
<script src="../js/datatables-simple-demo.js"></script>

<!-- JavaScript -->
<script>
    document.getElementById("infoLink").addEventListener("click", function(event) {
        event.preventDefault(); // Mencegah navigasi default

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById("infoModal"));
        modal.show();
    });
</script>

<!-- JavaScript -->
<script>
    document.getElementById("infoLink1").addEventListener("click", function(event) {
        event.preventDefault(); // Mencegah navigasi default

        // Tampilkan modal
        const modal = new bootstrap.Modal(document.getElementById("infoModal1"));
        modal.show();
    });
</script>

<!-- JavaScript Workshop -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let workshopCounter = 2; // Counter untuk menghitung jumlah workshop
        const workshopContainer = document.getElementById("workshopContainer");
        const addWorkshopButton = document.getElementById("addWorkshop");
        const removeWorkshopButton = document.getElementById("removeWorkshop");

        // Fungsi untuk memperbarui nomor workshop
        function updateWorkshopNumbers() {
            const workshopItems = workshopContainer.querySelectorAll(".workshop-item");
            workshopItems.forEach((item, index) => {
                const title = item.querySelector("p strong");
                if (title) title.textContent = `Workshop ${index + 2}`;
            });

            // Perbarui workshopCounter agar sesuai dengan elemen yang ada
            workshopCounter = workshopItems.length + 2;
        }

        // Fungsi untuk menambahkan workshop baru
        addWorkshopButton.addEventListener("click", function() {
            const newWorkshop = document.createElement("div");
            newWorkshop.className = "workshop-item mb-3";
            newWorkshop.innerHTML = `
                <p class="mb-3"><strong>Workshop ${workshopCounter}</strong></p>
                <!-- Nama WorkShop -->
                <div class="row mb-3">
                    <label class="text-secondary col-sm-4 col-form-label text-start">Nama WorkShop</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama_workshop[]" placeholder="Masukkan Nama WorkShop" required>
                    </div>
                </div>
                <!-- Nomor Telepon WorkShop -->
                <div class="row mb-3">
                    <label class="text-secondary col-sm-4 col-form-label text-start">Nomor Telepon WorkShop</label>
                    <div class="col-sm-8">
                        <input type="tel" class="form-control" name="nomor_telp_workshop[]" placeholder="Masukkan nomor telepon workshop (10 - 13 digit angka)" pattern="[0-9]{10,13}" required>
                    </div>
                </div>
                <hr class="mb-4">
            `;

            // Tambahkan elemen baru ke dalam kontainer
            workshopContainer.appendChild(newWorkshop);

            // Increment counter
            workshopCounter++;
        });

        // Fungsi untuk menghapus workshop terakhir
        removeWorkshopButton.addEventListener("click", function() {
            const lastWorkshop = workshopContainer.lastElementChild;
            if (lastWorkshop) {
                workshopContainer.removeChild(lastWorkshop);
                updateWorkshopNumbers();
            } else {
                alert("Tidak ada workshop untuk dihapus.");
            }
        });
    });
</script>

<!-- JavaScript Produk-->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let produkCounter = 2; // Counter untuk menghitung jumlah produk
        const produkContainer = document.getElementById("produkContainer");
        const addProdukButton = document.getElementById("addProduk");
        const removeProdukButton = document.getElementById("removeProduk");

        // Fungsi untuk memperbarui nomor produk
        function updateProdukNumbers() {
            const produkItems = produkContainer.querySelectorAll(".produk-item");
            produkItems.forEach((item, index) => {
                const title = item.querySelector("h5");
                if (title) title.textContent = `Produk ${index + 2}`;
            });

            // Perbarui produkCounter agar sesuai dengan elemen yang ada
            produkCounter = produkItems.length + 2;
        }

        // Fungsi untuk menambahkan produk baru
        addProdukButton.addEventListener("click", function() {
            const newProduk = document.createElement("div");
            newProduk.className = "produk-item mb-3";
            newProduk.innerHTML = `
                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <p class="mb-3"><strong>Produk ${produkCounter}</strong></p>
                        </div>
                        <label class="text-secondary col-sm-4 col-form-label text-start">Nama Produk</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama_produk[]" placeholder="Masukkan Nama Produk" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="text-secondary col-sm-4 col-form-label text-start">Nomor KBLI</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nomor_kbli[]" placeholder="Masukkan KBLI" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="text-secondary col-sm-4 col-form-label text-start">Deskripsi KBLI</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="deskripsi_kbli[]" placeholder="Masukkan Deskripsi KBLI" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="text-secondary col-sm-4 col-form-label text-start">Kelompok Produk</label>
                        <div class="col-sm-8">
                            <select class="form-select" name="kelompok_produk[]" required>
                                <option value="" disabled selected>Pilih Kelompok Produk</option>
                                <option value="Alat Utama">Alat Utama</option>
                                <option value="Komponen Utama">Komponen Utama</option>
                                <option value="Komponen Pendukung">Komponen Pendukung</option>
                                <option value="Komponen Bahan Baku">Komponen Bahan Baku</option>
                            </select>
                        </div>
                    </div>

                            <!-- Klasifikasi Produk INDHAN -->
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <label for="klasifikasi_produk" class="text-secondary col-sm-12 col-form-label text-start">
                                    Klasifikasi Produk INDHAN
                                    (<a href="#" id="infoLink1" class="text-decoration-underline text-primary">Informasi Klasifikasi Produk INDHAN</a>)
                                </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="klasifikasi_produk" name="klasifikasi_produk[]" placeholder="Masukkan Klasifikasi Produk" required>
                            </div>
                        </div>

                        <!-- LEVEL -->
                        <div class="row mb-3">
                            <label for="trl" class="text-secondary col-sm-4 col-form-label text-start">TRL (<i>Technology Readiness Level</i>)</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="trl" name="trl[]" placeholder="Masukkan Jumlah TRL" min="1" max="9" required>
                            </div>
                        </div>

                        <!-- MRL -->
                        <div class="row mb-3">
                            <label for="mrl" class="text-secondary col-sm-4 col-form-label text-start">MRL (<i>Manufacturing Readiness Level</i>)</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="mrl" name="mrl[]" placeholder="Masukkan Jumlah MRL" min="1" max="9" required>
                            </div>
                        </div>

                        <!-- KAPASITAS PRODUKSI -->
                        <div class="row mb-3 mt-4">
                            <label for="productionCapacity" class="text-secondary col-sm-4 col-form-label text-start">Kapasitas Produksi</label>
                            <div class="col-sm-8">
                                <input class="form-control" type="number" id="productionCapacity" name="kapasitas_produksi[]" placeholder="Masukkan kapasitas produksi" min="0" required>
                            </div>
                        </div>

                        <!-- SERTIFIKASI KELAYAKAN -->
                        <div class="row mb-3">
                            <label for="sertifikasi_kelayakan" class="text-secondary col-sm-4 col-form-label text-start">Sertifikasi Kelayakan</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="sertifikasi_kelayakan" name="sertifikasi_kelayakan[]" required>
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- SERTIFIKAT ISO PRODUK -->
                        <div class="row mb-3">
                            <label for="sertifikat_iso" class="text-secondary col-sm-4 col-form-label text-start">Sertifikat ISO Produk</label>
                            <div class="col-sm-8">
                                <input class="text-secondary form-control" type="file" id="sertifikat_iso" name="sertifikat_iso[]" required>
                                <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                            </div>
                        </div>

                        <!-- NILAI TKDN per PRODUK -->
                        <div class="row mb-3">
                            <label for="tkdnValue" class="text-secondary col-sm-4 col-form-label text-start">Nilai TKDN Per Produk</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input
                                        class="form-control"
                                        type="number"
                                        id="nilai_tkdn"
                                        name="nilai_tkdn[]"
                                        placeholder="Masukkan Nilai TKDN Produk"
                                        min="0"
                                        max="100"
                                        step="0.01"
                                        aria-label="Nilai TKDN"
                                        required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Nomor Sertifikat TKDN -->
                        <div class="row mb-3">
                            <label for="nomor_sertifikat_tkdn" class="text-secondary col-sm-4 col-form-label text-start">Nomor Sertifikat TKDN</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nomor_sertifikat_tkdn" name="nomor_sertifikat_tkdn[]" placeholder="Masukkan Nomor Sertifikat TKDN" required>
                            </div>
                        </div>

                    <hr>
                `;

            // Tambahkan elemen baru ke kontainer
            produkContainer.appendChild(newProduk);

            // Increment counter
            produkCounter++;
        });

        // Fungsi untuk menghapus produk terakhir
        removeProdukButton.addEventListener("click", function() {
            const lastProduk = produkContainer.lastElementChild;
            if (lastProduk) {
                produkContainer.removeChild(lastProduk);
                updateProdukNumbers();
            } else {
                alert("Tidak ada produk untuk dihapus.");
            }
        });
    });
</script>

<!-- JavaScript Kerja Sama -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let kerjaSamaCounter = 2; // Counter untuk menghitung jumlah kerja sama
        const kerjaSamaContainer = document.getElementById("kerjaSamaContainer");
        const addKerjaSamaButton = document.getElementById("addKerjaSama");
        const removeKerjaSamaButton = document.getElementById("removeKerjaSama");

        if (!kerjaSamaContainer || !addKerjaSamaButton || !removeKerjaSamaButton) {
            console.error("Element kerjaSamaContainer, addKerjaSamaButton, atau removeKerjaSamaButton tidak ditemukan!");
            return;
        }

        // Fungsi untuk memperbarui nomor kerja sama
        function updateKerjaSamaNumbers() {
            const kerjaSamaItems = kerjaSamaContainer.querySelectorAll(".kerjasama-item");
            kerjaSamaItems.forEach((item, index) => {
                const title = item.querySelector("p strong");
                if (title) title.textContent = `Kerja Sama Industri ${index + 2}`;

                const namaIndustri = item.querySelector("[id^='nama_industri_yang_bekerja_sama_']");
                if (namaIndustri) namaIndustri.id = `nama_industri_yang_bekerja_sama_${index + 2}`;

                const kategori = item.querySelector("[id^='kategori_']");
                if (kategori) kategori.id = `kategori_${index + 2}`;

                const bidangKerjaSama = item.querySelector("[id^='bidang_kerja_sama_']");
                if (bidangKerjaSama) bidangKerjaSama.id = `bidang_kerja_sama_${index + 2}`;

                const dokumen = item.querySelector("[id^='dokumen_loapoa_']");
                if (dokumen) dokumen.id = `dokumen_loapoa_${index + 2}`;
            });

            // Perbarui kerjaSamaCounter agar sesuai dengan elemen yang ada
            kerjaSamaCounter = kerjaSamaItems.length + 2;
        }

        // Fungsi untuk menambahkan elemen kerja sama baru
        addKerjaSamaButton.addEventListener("click", function() {
            const newKerjaSama = document.createElement("div");
            newKerjaSama.className = "kerjasama-item mb-3";
            newKerjaSama.innerHTML = `
                <div class="row mb-3">
                    <div class="col-sm-12">
                        <p class="mb-3"><strong>Kerja Sama Industri ${kerjaSamaCounter}</strong></p>
                    </div>
                    <label for="nama_industri_yang_bekerja_sama_${kerjaSamaCounter}" class="text-secondary col-sm-4 col-form-label text-start">
                        Nama Industri Yang Bekerja Sama
                    </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nama_industri_yang_bekerja_sama_${kerjaSamaCounter}" name="nama_industri_yang_bekerja_sama[]" placeholder="Masukkan Nama Industri yang Bekerja Sama" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="kategori_${kerjaSamaCounter}" class="text-secondary col-sm-4 col-form-label text-start">
                        Kategori
                    </label>
                    <div class="col-sm-8">
                        <select class="form-select" id="kategori_${kerjaSamaCounter}" name="kategori[]" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option value="Dalam Negeri">Dalam Negeri</option>
                            <option value="Luar Negeri">Luar Negeri</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="bidang_kerja_sama_${kerjaSamaCounter}" class="text-secondary col-sm-4 col-form-label text-start">
                        Bidang Kerja Sama
                    </label>
                    <div class="col-sm-8">
                        <select class="form-select" id="bidang_kerja_sama_${kerjaSamaCounter}" name="bidang_kerja_sama[]" required>
                            <option value="" disabled selected>Pilih Bidang Kerja Sama</option>
                            <option value="Join Venture">Join Venture</option>
                            <option value="Join Production">Join Production</option>
                            <option value="Join Development">Join Development</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="dokumen_loapoa_${kerjaSamaCounter}" class="text-secondary col-sm-4 col-form-label text-start">
                        Upload Dokumen LOA&POA atau Sejenis Dokumen Kerja Sama
                    </label>
                    <div class="col-sm-8">
                        <input class="text-secondary form-control" type="file" id="dokumen_loapoa_${kerjaSamaCounter}" name="dokumen_loapoa[]" required>
                        <small class="form-text text-muted ms-3"><i>Format PDF, XLSX</i></small>
                    </div>
                </div>
                <hr>
            `;

            // Tambahkan elemen baru ke dalam kontainer
            kerjaSamaContainer.appendChild(newKerjaSama);

            // Increment counter
            kerjaSamaCounter++;
        });

        // Fungsi untuk menghapus elemen kerja sama terakhir
        removeKerjaSamaButton.addEventListener("click", function() {
            const lastKerjaSama = kerjaSamaContainer.lastElementChild;
            if (lastKerjaSama) {
                kerjaSamaContainer.removeChild(lastKerjaSama);
                updateKerjaSamaNumbers();
            } else {
                alert("Tidak ada elemen kerja sama untuk dihapus.");
            }
        });
    });
</script>

<!-- JavaScript Personil -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let personilCounter = 2; // Mulai dari Personil 2
        const personilContainer = document.getElementById("personnilContainer");
        const addPersonilButton = document.getElementById("addPersonil");
        const removePersonilButton = document.getElementById("removePersonil");

        // Fungsi untuk memperbarui nomor personil
        function updatePersonilNumbers() {
            const personilItems = personilContainer.querySelectorAll(".personil-item");
            personilItems.forEach((item, index) => {
                const title = item.querySelector("p strong");
                if (title) title.textContent = `Personil ${index + 2}`;
            });

            // Perbarui personilCounter agar sesuai dengan elemen yang ada
            personilCounter = personilItems.length + 2;
        }

        // Fungsi untuk menambahkan personil baru
        addPersonilButton.addEventListener("click", function() {
            const newPersonil = document.createElement("div");
            newPersonil.className = "personil-item mb-3";
            newPersonil.innerHTML = `
                <p class="mb-3"><strong>Personil ${personilCounter}</strong></p>
                <div class="row mb-3">
                    <label class="text-secondary col-sm-4 col-form-label text-start">Nama Personil Penerima</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama_personil[]" placeholder="Masukkan Nama" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="text-secondary col-sm-4 col-form-label text-start">NIK Personil Penerima</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nik_personil[]" placeholder="Masukkan NIK" pattern="[0-9]+" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="text-secondary col-sm-4 col-form-label text-start">Divisi Personil Penerima</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="divisi_personil[]" placeholder="Masukkan Divisi" required>
                    </div>
                </div>
                <hr>
            `;

            // Tambahkan elemen baru ke dalam kontainer
            personilContainer.appendChild(newPersonil);

            // Increment counter
            personilCounter++;
        });

        // Fungsi untuk menghapus personil terakhir
        removePersonilButton.addEventListener("click", function() {
            const lastPersonil = personilContainer.lastElementChild;
            if (lastPersonil) {
                personilContainer.removeChild(lastPersonil);
                updatePersonilNumbers();
            } else {
                alert("Tidak ada personil untuk dihapus.");
            }
        });
    });
</script>

<!-- JavaScript Material -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let materialCounter = 2; // Mulai dari Material 2
        const materialContainer = document.getElementById("materialContainer");
        const addMaterialButton = document.getElementById("addMaterial");
        const removeMaterialButton = document.getElementById("removeMaterial");

        // Fungsi untuk memperbarui nomor material
        function updateMaterialNumbers() {
            const materialItems = materialContainer.querySelectorAll(".material-item");
            materialItems.forEach((item, index) => {
                const title = item.querySelector("p strong");
                if (title) title.textContent = `Material ${index + 2}`;
            });

            // Perbarui materialCounter agar sesuai dengan elemen yang ada
            materialCounter = materialItems.length + 2;
        }

        // Fungsi untuk menambahkan material baru
        addMaterialButton.addEventListener("click", function() {
            const newMaterial = document.createElement("div");
            newMaterial.className = "material-item mb-3";
            newMaterial.innerHTML = `
                <p class="mb-3"><strong>Material ${materialCounter}</strong></p>
                <div class="row mb-3">
                    <label for="nomor_part_material_offset" class="text-secondary col-sm-4 col-form-label text-start">Part No/SN</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nomor_part_material_offset" name="nomor_part_material_offset[]" placeholder="Masukkan No/SN" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="merk_material_offset" class="text-secondary col-sm-4 col-form-label text-start">Merk/Type</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="merk_material_offset" name="merk_material_offset[]" placeholder="Masukkan Merk/Type" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="deskripsi_material_offset" class="text-secondary col-sm-4 col-form-label text-start">Deskripsi</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="deskripsi_material_offset" name="deskripsi_material_offset[]" placeholder="Masukkan Deskripsi" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="kuantitas_material_offset" class="text-secondary col-sm-4 col-form-label text-start">Kuantitas</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="kuantitas_material_offset" name="kuantitas_material_offset[]" placeholder="Masukkan Kuantitas" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="review_material_offset" class="text-secondary col-sm-4 col-form-label text-start">Review dan Saran</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="review_material_offset" name="review_material_offset[]" placeholder="Masukkan Review dan Saran" rows="4" required></textarea>
                    </div>
                </div>
                <hr>
            `;

            // Tambahkan elemen baru ke dalam kontainer
            materialContainer.appendChild(newMaterial);

            // Increment counter
            materialCounter++;
        });

        // Fungsi untuk menghapus material terakhir
        removeMaterialButton.addEventListener("click", function() {
            const lastMaterial = materialContainer.lastElementChild;
            if (lastMaterial) {
                materialContainer.removeChild(lastMaterial);
                updateMaterialNumbers();
            } else {
                alert("Tidak ada material untuk dihapus.");
            }
        });
    });
</script>

<script>
    // let materialCounter = 2; // Counter untuk menghitung jumlah material offset

    // document.getElementById('addMaterial').addEventListener('click', function() {
    //     // Elemen kontainer material offset (asumsi ada div dengan id 'materialContainer' sebelum tombol Tambah)
    //     const materialContainer = document.createElement('div');
    //     materialContainer.id = 'materialContainer';

    //     // Cari elemen induk untuk menempatkan kontainer material
    //     const parentElement = document.querySelector('.offset-sm-4').parentElement.parentElement;
    //     parentElement.insertBefore(materialContainer, document.querySelector('#addMaterial').closest('.row'));

    //     // Elemen baru untuk material offset
    //     const newMaterial = document.createElement('div');
    //     newMaterial.className = 'material-item mb-3';
    //     newMaterial.innerHTML = `
    //     <p class="mb-3"><strong>Material Offset ${materialCounter}</strong></p>
    //     <div class="row mb-3">
    //         <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Part No/SN</label>
    //             <div class="col-sm-8">
    //                 <input type="text" class="form-control text-secondary" id="indhanInput" placeholder="Masukkan No/SN" required>
    //              </div>
    //          </div>
    //         <div class="row mb-3">
    //             <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Merk/Type</label>
    //         <div class="col-sm-8">
    //          <input type="text" class="form-control text-secondary" id="indhanInput" placeholder="Masukkan Merk/Type" required>
    //             </div>
    //         </div>
    //          <div class="row mb-3">
    //                     <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Deskripi</label>
    //                     <div class="col-sm-8">
    //                         <input type="text" class="form-control text-secondary" id="indhanInput" placeholder="Masukkan Deskripsi" required>
    //                     </div>
    //                 </div>
    //                 <div class="row mb-3">
    //                     <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Kuantitas</label>
    //                     <div class="col-sm-8">
    //                         <input type="text" class="form-control text-secondary" id="indhanInput" placeholder="Masukkan Kuantitas" required>
    //                     </div>
    //                 </div>
    //                 <div class="row mb-3">
    //                     <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Review dan Saran</label>
    //                     <div class="col-sm-8">
    //                         <textarea class="form-control text-secondary" id="indhanInput" placeholder="Masukkan Review dan Saran" rows="4" required></textarea>
    //                     </div>
    //                 </div>
    // `;

    //     // Tambahkan elemen baru ke kontainer
    //     materialContainer.appendChild(newMaterial);

    //     // Increment counter
    //     materialCounter++;
    // });
</script>

</html>