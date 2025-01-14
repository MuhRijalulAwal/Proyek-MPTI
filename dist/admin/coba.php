<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Laporan - User</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="sb-nav-fixed">
    <!-- Navbar -->
    <?php include "nav/admin-navbar.php"; ?>

    <div id="layoutSidenav">
        <!-- Sidebar -->
        <div id="layoutSidenav_nav" class="bg-light">
            <?php include "nav/admin-sidebar.php"; ?>
        </div>

        <!-- Content -->
        <div id="layoutSidenav_content">
            <!-- main content -->
            <main>
                <div class="wrap" style="margin-left: 47px; margin-right: 47px;">
                    <div class="container-fluid px-4">
                        <h3 style="color:#152C5B;" class="mt-4">Laporan > Detail Laporan </h3>
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
                            <form enctype="multipart/form-data">
                                <!-- Form Utama -->
                                <div id="workshopContainer">
                                    <?php if (!empty($workshopBranches)): ?>
                                        <?php foreach ($workshopBranches as $index => $branch): ?>
                                            <div class="workshop-item mb-3">
                                                <!-- Nama WorkShop -->
                                                <div class="row mb-3">
                                                    <p class="mb-3"><strong>Workshop <?php echo $index + 1; ?></strong></p>
                                                    <label class="text-secondary col-sm-4 col-form-label text-start">Nama WorkShop</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" class="form-control" id="nama_workshop_<?php echo $index; ?>" name="nama_workshop[]" value="<?php echo htmlspecialchars($branch['workshop_name']); ?>" readonly>
                                                    </div>
                                                </div>
                                                <!-- Nomor Telepon WorkShop -->
                                                <div class="row mb-3">
                                                    <label class="text-secondary col-sm-4 col-form-label text-start">Nomor Telepon WorkShop</label>
                                                    <div class="col-sm-8">
                                                        <input type="tel" class="form-control" id="nomor_telp_workshop_<?php echo $index; ?>" name="nomor_telp_workshop[]" value="<?php echo htmlspecialchars($branch['phone_number']); ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>Tidak ada data workshop yang tersedia.</p>
                                    <?php endif; ?>
                                </div>

                                <!-- Manajemen dan Organisasi -->
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <h5 class="mb-3">Manajemen dan Organisasi</h5>
                                    </div>
                                    <label for="formFile" class="text-secondary col-sm-4 col-form-label text-start">Struktur Organisasi</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($managementData['organization_structure_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($managementData['organization_structure_path']); ?>" target="_blank" class="mt-2">Lihat File</a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Nama Direktur Utama -->
                                <div class="row mb-3">
                                    <label for="inputText" class="text-secondary col-sm-4 col-form-label text-start">Nama Direktur Utama</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama_direktur_utama" name="nama_direktur_utama" value="<?php echo htmlspecialchars($managementData['director_name']); ?>" readonly>
                                    </div>
                                </div>

                                <!-- Nomor Telepon Utama -->
                                <div class="row mb-3 form-group">
                                    <label for="phoneInput" class="text-secondary col-sm-4 col-form-label text-start">Nomor Telepon Direktur Utama</label>
                                    <div class="col-sm-8">
                                        <input type="tel" class="form-control" id="telepon_direktur_utama" name="telepon_direktur_utama" value="<?php echo htmlspecialchars($managementData['director_phone']); ?>" readonly>
                                    </div>
                                </div>

                                <!-- Nama PIC -->
                                <div class="row mb-3">
                                    <label for="inputText" class="text-secondary col-sm-4 col-form-label text-start">Nama PIC</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama_pic" name="nama_pic" value="<?php echo htmlspecialchars($managementData['pic_name']); ?>" readonly>
                                    </div>
                                </div>

                                <!-- Nomor Telepon PIC Utama -->
                                <div class="row mb-3 form-group">
                                    <label for="phoneInput" class="text-secondary col-sm-4 col-form-label text-start">Nomor Telepon PIC Utama</label>
                                    <div class="col-sm-8">
                                        <input type="tel" class="form-control" id="telepon_pic" name="telepon_pic" value="<?php echo htmlspecialchars($managementData['pic_phone']); ?>" readonly>
                                    </div>
                                </div>

                                <!-- Daftar Tenaga Ahli -->
                                <div class="row mb-3 align-items-center">
                                    <label for="time" class="text-secondary col-sm-4 col-form-label text-start">Daftar Tenaga Ahli
                                    </label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($managementData['expert_staff_list_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($managementData['expert_staff_list_path']); ?>" target="_blank" class="mt-2">Lihat File </a>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Manajemen Keuangan -->
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <h5 class="mb-3">Manajemen Keuangan</h5>
                                    </div>
                                    <label for="nama_kantor" class="text-secondary col-sm-4 col-form-label text-start">Nama Kantor Akuntan Publik</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama_kantor" name="nama_kantor" value="<?php echo htmlspecialchars($financialData['public_accounting_firm']); ?>" readonly>
                                    </div>
                                </div>

                                <!-- Laporan Keuangan Internal -->
                                <div class="row mb-3">
                                    <label for="laporan_keuangan_internal" class="text-secondary col-sm-4 col-form-label text-start">Laporan Keuangan (Hasil Audit Auditor Internal)</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($financialData['internal_audit_report_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($financialData['internal_audit_report_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Laporan Keuangan External -->
                                <div class="row mb-3">
                                    <label for="laporan_keuangan_external" class="text-secondary col-sm-4 col-form-label text-start">Laporan Keuangan (Hasil Audit Auditor External)</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($financialData['external_audit_report_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($financialData['external_audit_report_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Grafik Perkembangan Finansial (5 thn terakhir) -->
                                <div class="row mb-3">
                                    <label for="grafik_perkembangan" class="text-secondary col-sm-4 col-form-label text-start">Grafik Perkembangan Finansial (5 thn terakhir)</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($financialData['financial_development_graph_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($financialData['financial_development_graph_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Opini Akuntan Publik -->
                                <div class="row mb-3">
                                    <label for="opini_akuntan" class="text-secondary col-sm-4 col-form-label text-start">Opini Akuntan Publik</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="opini_akuntan" name="opini_akuntan" value="<?php echo htmlspecialchars($financialData['public_accountant_opinion']); ?>" readonly>
                                    </div>
                                </div>

                                <!-- SOP Aktivitas Bisnis Pemasaran -->
                                <div class="row mb-3">
                                    <label for="sop_pemasaran" class="text-secondary col-sm-4 col-form-label text-start">SOP Aktivitas Bisnis Pemasaran</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($financialData['marketing_business_sop_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($financialData['marketing_business_sop_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- MANAJEMEN TEKNOLOGI DAN REKAYASA -->
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <h5 class="mb-3">Manajemen Teknologi dan Rekayasa</h5>
                                    </div>
                                    <label for="teknologi_project_portfolio" class="text-secondary col-sm-4 col-form-label text-start">Technologi Project Portofolio</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($technologyData['technology_project_portfolio_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($technologyData['technology_project_portfolio_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- RoadMap Pengembangan Teknologi -->
                                <div class="row mb-3">
                                    <label for="roadmap_pengembangan" class="text-secondary col-sm-4 col-form-label text-start">RoadMap Pengembangan Teknologi</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($technologyData['technology_roadmap_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($technologyData['technology_roadmap_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- LITBANG R & D (Produk ALPALHANKAM) -->
                                <div class="row mb-3">
                                    <label for="litbang_rd" class="text-secondary col-sm-4 col-form-label text-start">LITBANG R & D (Produk ALPALHANKAM)</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($technologyData['litbang_r_and_d_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($technologyData['litbang_r_and_d_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Offset -->
                                <div class="row mb-3">
                                    <label for="offset" class="text-secondary col-sm-4 col-form-label text-start">Offset</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($technologyData['offset_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($technologyData['offset_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- LEVEL -->
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <h5 class="mb-3">LEVEL</h5>
                                    </div>
                                    <label for="trl" class="text-secondary col-sm-4 col-form-label text-start">TRL (<i>Technology Readiness Level</i>)</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="trl" name="trl" value="<?php echo htmlspecialchars($technologyData['trl_level']); ?>" readonly>
                                    </div>
                                </div>

                                <!-- MRL -->
                                <div class="row mb-3">
                                    <label for="mrl" class="text-secondary col-sm-4 col-form-label text-start">MRL (<i>Manufacturing Readiness Level</i>)</label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control" id="mrl" name="mrl" value="<?php echo htmlspecialchars($technologyData['mrl_level']); ?>" readonly>
                                    </div>
                                </div>

                                <!-- FASILITAS PERALATAN DAN PRODUKSI -->
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <h5 class="mb-3">Fasilitas Peralatan dan Produksi</h5>
                                    </div>
                                    <label for="daftar_peralatan" class="text-secondary col-sm-4 col-form-label text-start">Daftar Peralatan</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($facilityData['equipment_list_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($facilityData['equipment_list_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- KEPEMILIKAN SARANA/PRASARANA PRODUKSI -->
                                <div class="row mb-3">
                                    <label for="kepemilikan_sarana" class="text-secondary col-sm-4 col-form-label text-start">Kepemilikan Sarana/Prasarana Produksi</label>
                                    <div class="col-sm-8">
                                        <select class="form-select" id="kepemilikan_sarana" name="kepemilikan_sarana" disabled>
                                            <option value="" disabled <?php echo empty($facilityData['ownership_type']) ? 'selected' : ''; ?>>Pilih Kepemilikan</option>
                                            <option value="Sewa" <?php echo $facilityData['ownership_type'] === 'Sewa' ? 'selected' : ''; ?>>Sewa</option>
                                            <option value="Milik Sendiri" <?php echo $facilityData['ownership_type'] === 'Milik Sendiri' ? 'selected' : ''; ?>>Milik Sendiri</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- LAYOUT PRODUKSI & JASA PEMELIHARAAN -->
                                <div class="row mb-3">
                                    <label for="layout_produksi" class="text-secondary col-sm-4 col-form-label text-start">Layout Produksi & Jasa Pemeliharaan</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($facilityData['production_layout_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($facilityData['production_layout_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- PRODUK PERUSAHAAN -->
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <h5 class="mb-3">Produk Perusahaan</h5>
                                    </div>
                                    <label for="nama_produk" class="text-secondary col-sm-4 col-form-label text-start">Nama Produk</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo htmlspecialchars($productData['product_name']); ?>" readonly>
                                    </div>
                                </div>

                                <!-- Nomor KBLI -->
                                <div class="row mb-3">
                                    <label for="nomor_kbli" class="text-secondary col-sm-4 col-form-label text-start">Nomor KBLI
                                        (<a href="https://docs.google.com/document/d/1PWSdth5JC4JnI-hwnM4snxbLwSUPnvTb9ZM40Uwfe8I/edit?usp=sharing" class="text-decoration-underline text-primary">Informasi KBLI</a>)
                                    </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nomor_kbli" name="nomor_kbli" value="<?php echo htmlspecialchars($productData['kbli_number']); ?>" readonly>
                                    </div>
                                </div>

                                <!-- Deskripsi KBLI -->
                                <div class="row mb-3">
                                    <label for="deskripsi_kbli" class="text-secondary col-sm-4 col-form-label text-start">Deskripsi KBLI</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="deskripsi_kbli" name="deskripsi_kbli" value="<?php echo htmlspecialchars($productData['kbli_description']); ?>" readonly>
                                    </div>
                                </div>

                                <!-- Informasi Produk Ekspor/Impor -->
                                <div class="row mb-3">
                                    <label for="kelompok_produk" class="text-secondary col-sm-4 col-form-label text-start">
                                        Kelompok Produk
                                        (<a href="#" id="infoLink" class="text-decoration-underline text-primary">Informasi Produk INDHAN</a>)
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-select" id="kelompok_produk" name="kelompok_produk" disabled>
                                            <option value="" disabled <?php echo empty($productData['product_group']) ? 'selected' : ''; ?>>Pilih Produk</option>
                                            <option value="1" <?php echo $productData['product_group'] === '1' ? 'selected' : ''; ?>>Alat Utama</option>
                                            <option value="2" <?php echo $productData['product_group'] === '2' ? 'selected' : ''; ?>>Komponen Utama</option>
                                            <option value="3" <?php echo $productData['product_group'] === '3' ? 'selected' : ''; ?>>Komponen Pendukung</option>
                                            <option value="4" <?php echo $productData['product_group'] === '4' ? 'selected' : ''; ?>>Komponen Bahan Baku</option>
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
                                        <input type="text" class="form-control" id="klasifikasi_produk" name="klasifikasi_produk" value="<?php echo htmlspecialchars($productData['product_classification']); ?>" placeholder="Masukkan Klasifikasi Produk" readonly>
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

                                <!-- KAPASITAS PRODUKSI -->
                                <div class="row mb-3 mt-4">
                                    <label for="productionCapacity" class="text-secondary col-sm-4 col-form-label text-start">Kapasitas Produksi</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="number" id="productionCapacity" name="kapasitas_produksi" value="<?php echo htmlspecialchars($productData['production_capacity'] ?? ''); ?>" placeholder="Masukkan kapasitas produksi" min="0" readonly>
                                    </div>
                                </div>

                                <!-- SERTIFIKASI KELAYAKAN -->
                                <div class="row mb-3">
                                    <label for="sertifikasi_kelayakan" class="text-secondary col-sm-4 col-form-label text-start">Sertifikasi Kelayakan</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($productData['fitness_certification_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($productData['fitness_certification_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- SERTIFIKAT ISO PRODUK -->
                                <div class="row mb-3">
                                    <label for="sertifikat_iso" class="text-secondary col-sm-4 col-form-label text-start">Sertifikat ISO Produk</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($productData['iso_certificate_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($productData['iso_certificate_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
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
                                                name="nilai_tkdn"
                                                value="<?php echo htmlspecialchars($productData['tkdn_value']); ?>"
                                                placeholder="Masukkan Nilai TKDN Produk"
                                                min="0"
                                                max="100"
                                                step="0.01"
                                                aria-label="Nilai TKDN"
                                                readonly>
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Nomor Sertifikat TKDN -->
                                <div class="row mb-3">
                                    <label for="nomor_sertifikat_tkdn" class="text-secondary col-sm-4 col-form-label text-start">Nomor Sertifikat TKDN</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="nomor_sertifikat_tkdn" name="nomor_sertifikat_tkdn" value="<?php echo htmlspecialchars($productData['tkdn_certificate_number']); ?>" placeholder="Masukkan Nomor Sertifikat TKDN" readonly>
                                    </div>
                                </div>

                                <!-- Akta Notaris -->
                                <div class="row mb-3">
                                    <p class="mb-3"><strong>Akta Notaris</strong></p>

                                    <!-- Akta Perusahaan -->
                                    <label for="akta_perusahaan" class="text-secondary col-sm-4 col-form-label text-start">Akta Perusahaan</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($productData['articles_of_incorporation_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($productData['articles_of_incorporation_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Akta Perubahan Terakhir -->
                                <div class="row mb-3">
                                    <label for="akta_perusahaan_terakhir" class="text-secondary col-sm-4 col-form-label text-start">Akta Perubahan Terakhir</label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($productData['last_articles_of_incorporation_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($productData['last_articles_of_incorporation_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Kegiatan KLO -->
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <h5 class="mb-3">Kegiatan KLO (Kandungan Lokal Offset)</h5>
                                    </div>
                                    <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Materi Offset
                                    </label>
                                    <div class="col-sm-8">
                                        <?php if (!empty($offsetData['offset_material_path'])): ?>
                                            <a href="<?php echo htmlspecialchars($offsetData['offset_material_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                        <?php else: ?>
                                            <span>Tidak ada file yang diunggah.</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- PERSONIL PENERIMA -->
                                <?php if (!empty($personnelData)): ?>
                                    <?php foreach ($personnelData as $index => $personnel): ?>
                                        <div class="row mb-3">
                                            <p class="mb-3"><strong>Personil <?php echo $index + 1; ?></strong></p>
                                            <label for="nama_personil_<?php echo $index; ?>" class="text-secondary col-sm-4 col-form-label text-start">Nama Personil Penerima</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="nama_personil_<?php echo $index; ?>" name="nama_personil[]" value="<?php echo htmlspecialchars($personnel['name']); ?>" placeholder="Masukkan Nama" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="nik_personil_<?php echo $index; ?>" class="text-secondary col-sm-4 col-form-label text-start">NIK Personil Penerima</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="nik_personil_<?php echo $index; ?>" name="nik_personil[]" value="<?php echo htmlspecialchars($personnel['nik']); ?>" placeholder="Masukkan NIK" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="divisi_personil_<?php echo $index; ?>" class="text-secondary col-sm-4 col-form-label text-start">Divisi Personil Penerima</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="divisi_personil_<?php echo $index; ?>" name="divisi_personil[]" value="<?php echo htmlspecialchars($personnel['division']); ?>" placeholder="Masukkan Divisi" readonly>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Tidak ada data personil yang tersedia.</p>
                                <?php endif; ?>

                                <!-- MATERIAL Offset -->
                                <?php if (!empty($materialsData)): ?>
                                    <p class="mb-3"><strong>Material Offset yang Diterima</strong></p>
                                    <?php foreach ($materialsData as $index => $material): ?>
                                        <div class="row mb-3">
                                            <label for="nomor_part_material_offset_<?php echo $index; ?>" class="text-secondary col-sm-4 col-form-label text-start">Part No/SN</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="nomor_part_material_offset_<?php echo $index; ?>" name="nomor_part_material_offset[]" value="<?php echo htmlspecialchars($material['part_number']); ?>" placeholder="Masukkan No/SN" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="merk_material_offset_<?php echo $index; ?>" class="text-secondary col-sm-4 col-form-label text-start">Merk/Type</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="merk_material_offset_<?php echo $index; ?>" name="merk_material_offset[]" value="<?php echo htmlspecialchars($material['brand_type']); ?>" placeholder="Masukkan Merk/Type" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="deskripsi_material_offset_<?php echo $index; ?>" class="text-secondary col-sm-4 col-form-label text-start">Deskripsi</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="deskripsi_material_offset_<?php echo $index; ?>" name="deskripsi_material_offset[]" value="<?php echo htmlspecialchars($material['description']); ?>" placeholder="Masukkan Deskripsi" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="kuantitas_material_offset_<?php echo $index; ?>" class="text-secondary col-sm-4 col-form-label text-start">Kuantitas</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="kuantitas_material_offset_<?php echo $index; ?>" name="kuantitas_material_offset[]" value="<?php echo htmlspecialchars($material['quantity']); ?>" placeholder="Masukkan Kuantitas" readonly>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="review_material_offset_<?php echo $index; ?>" class="text-secondary col-sm-4 col-form-label text-start">Review dan Saran</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" id="review_material_offset_<?php echo $index; ?>" name="review_material_offset[]" placeholder="Masukkan Review dan Saran" rows="4" readonly><?php echo htmlspecialchars($material['review_suggestions']); ?></textarea>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Tidak ada data material yang tersedia.</p>
                                <?php endif; ?>
                            </form>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
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

    <!-- JavaScript -->
    <script>
        let workshopCounter = 2; // Counter untuk menghitung jumlah workshop

        document.getElementById('addWorkshop').addEventListener('click', function() {
            // Elemen kontainer workshop
            const workshopContainer = document.getElementById('workshopContainer');

            // Elemen baru untuk workshop
            const newWorkshop = document.createElement('div');
            newWorkshop.className = 'workshop-item mb-3';
            newWorkshop.innerHTML = `
            <p class="mb-3"><strong>Workshop ${workshopCounter}</strong></p>
            <!-- Nama WorkShop -->
            <div class="row mb-3">
                <label class="text-secondary col-sm-4 col-form-label text-start">Nama WorkShop</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" placeholder="Masukkan Nama WorkShop" required>
                </div>
            </div>
            <!-- Nomor Telepon WorkShop -->
            <div class="row mb-3">
                <label class="text-secondary col-sm-4 col-form-label text-start">Nomor Telepon WorkShop</label>
                <div class="col-sm-8">
                    <input type="tel" class="form-control" placeholder="Masukkan nomor telepon workshop (10 - 13 digit angka)" pattern="[0-9]{10,13}" required>
                </div>
            </div>
            <hr class="mb-4">
        `;

            // Tambahkan elemen baru ke kontainer
            workshopContainer.appendChild(newWorkshop);

            // Increment counter
            workshopCounter++;
        });
    </script>

    <script>
        let personilCounter = 2; // Counter untuk menghitung jumlah personil

        document.getElementById('addPersonil').addEventListener('click', function() {
            // Elemen kontainer personil (asumsi ada div dengan id 'personilContainer' sebelum tombol Tambah)
            const personilContainer = document.createElement('div');
            personilContainer.id = 'personilContainer';

            // Cari elemen induk untuk menempatkan kontainer personil
            const parentElement = document.querySelector('.offset-sm-4').parentElement.parentElement;
            parentElement.insertBefore(personilContainer, document.querySelector('#addPersonil').closest('.row'));

            // Elemen baru untuk personil
            const newPersonil = document.createElement('div');
            newPersonil.className = 'personil-item mb-3';
            newPersonil.innerHTML = `
            <p class="mb-3"><strong>Personil ${personilCounter}</strong></p>
            <!-- Nama Personil Penerima -->
            <div class="row mb-3">
                <label class="text-secondary col-sm-4 col-form-label text-start">Nama Personil Penerima</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control text-secondary" placeholder="Masukkan Nama Personil" required>
                </div>
            </div>
            <!-- NIK Personil Penerima -->
            <div class="row mb-3">
                <label class="text-secondary col-sm-4 col-form-label text-start">NIK Personil Penerima</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control text-secondary" placeholder="Masukkan NIK Personil" pattern="[0-9]+" required>
                </div>
            </div>
            <!-- Divisi Personil Penerima -->
            <div class="row mb-3">
                <label class="text-secondary col-sm-4 col-form-label text-start">Divisi Personil Penerima</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control text-secondary" placeholder="Masukkan Divisi Personil" required>
                </div>
            </div>
            <hr class="mb-4">
        `;

            // Tambahkan elemen baru ke kontainer
            personilContainer.appendChild(newPersonil);

            // Increment counter
            personilCounter++;
        });
    </script>
</body>

</html>