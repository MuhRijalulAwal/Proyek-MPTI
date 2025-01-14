<?php
session_start(); // Memastikan session dimulai
include '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Ambil user_id dari session
$user_id = $_SESSION['user_id'];

// Pastikan id_report tersedia
if (isset($_GET['id_report'])) {
    $idReport = intval($_GET['id_report']); // Validasi agar hanya menerima angka

    // Query untuk mendapatkan semua kolom berdasarkan id_report
    $queryReport = "SELECT 
                        id_report, 
                        status, 
                        workshops_id, 
                        management_id, 
                        financial_id, 
                        offset_id, 
                        facility_id, 
                        products_id,
                        articles_of_incorporation_id,
                        tech_id, 
                        company_id,
                        id_note,
                        icc_contract_id,
                        industries_id,
                        date 
                    FROM report 
                    WHERE id_report = ?";
    $stmtReport = mysqli_prepare($koneksi, $queryReport);
    mysqli_stmt_bind_param($stmtReport, 'i', $idReport);

    if (mysqli_stmt_execute($stmtReport)) {
        $resultReport = mysqli_stmt_get_result($stmtReport);

        // Cek apakah ada data
        if (mysqli_num_rows($resultReport) > 0) {
            $row = mysqli_fetch_assoc($resultReport);

            // Simpan hasil query ke dalam variabel
            $id_report = $row['id_report'];
            $status = $row['status'];
            $workshops_id = $row['workshops_id'];
            $management_id = $row['management_id'];
            $financial_id = $row['financial_id'];
            $offset_id = $row['offset_id'];
            $facility_id = $row['facility_id'];
            $products_id = $row['products_id'];
            $articles_id = $row['articles_of_incorporation_id'];
            $tech_id = $row['tech_id'];
            $company_id = $row['company_id'];
            $note_id = $row['id_note'];
            $icc_contract_id = $row['icc_contract_id'];
            $industries_id = $row['industries_id'];
            $date = $row['date'];

            // Ambil data dari tabel offset_materials berdasarkan offset_id
            if (!empty($offset_id)) {
                $queryMaterials = "SELECT 
                                        material_id, 
                                        offset_id, 
                                        part_number, 
                                        brand_type, 
                                        description, 
                                        quantity, 
                                        review_suggestions 
                                    FROM offset_materials 
                                    WHERE offset_id = ?";
                $stmtMaterials = mysqli_prepare($koneksi, $queryMaterials);
                mysqli_stmt_bind_param($stmtMaterials, 'i', $offset_id); // 'i' untuk integer

                if (mysqli_stmt_execute($stmtMaterials)) {
                    $resultMaterials = mysqli_stmt_get_result($stmtMaterials);

                    // Cek apakah ada data
                    $materialsData = [];
                    if (mysqli_num_rows($resultMaterials) > 0) {
                        while ($materialRow = mysqli_fetch_assoc($resultMaterials)) {
                            $materialsData[] = $materialRow; // Simpan data dalam array
                        }
                    } else {
                        echo "<p>Data material tidak ditemukan untuk offset_id: $offset_id</p>";
                    }
                } else {
                    echo "<p>Gagal menjalankan query materials: " . mysqli_error($koneksi) . "</p>";
                }

                mysqli_stmt_close($stmtMaterials);
            }

            // Ambil data dari tabel offset_activities berdasarkan offset_id
            if (!empty($offset_id)) {
                $queryOffset = "SELECT 
                                    offset_id, 
                                    company_id, 
                                    offset_material_path 
                                FROM offset_activities 
                                WHERE offset_id = ?";
                $stmtOffset = mysqli_prepare($koneksi, $queryOffset);
                mysqli_stmt_bind_param($stmtOffset, 'i', $offset_id); // 'i' untuk integer

                if (mysqli_stmt_execute($stmtOffset)) {
                    $resultOffset = mysqli_stmt_get_result($stmtOffset);

                    // Cek apakah ada data
                    if (mysqli_num_rows($resultOffset) > 0) {
                        $offsetData = mysqli_fetch_assoc($resultOffset);
                    } else {
                        echo "<p>Data offset tidak ditemukan untuk offset_id: $offset_id</p>";
                    }
                } else {
                    echo "<p>Gagal menjalankan query offset: " . mysqli_error($koneksi) . "</p>";
                }

                mysqli_stmt_close($stmtOffset);
            }

            // Ambil data dari tabel offset_activities berdasarkan offset_id
            if (!empty($offset_id)) {
                $queryOffset = "SELECT 
                                    offset_id, 
                                    company_id, 
                                    offset_material_path 
                                FROM offset_activities 
                                WHERE offset_id = ?";
                $stmtOffset = mysqli_prepare($koneksi, $queryOffset);
                mysqli_stmt_bind_param($stmtOffset, 'i', $offset_id); // 'i' untuk integer

                if (mysqli_stmt_execute($stmtOffset)) {
                    $resultOffset = mysqli_stmt_get_result($stmtOffset);

                    // Cek apakah ada data
                    if (mysqli_num_rows($resultOffset) > 0) {
                        $offsetData = mysqli_fetch_assoc($resultOffset);
                    } else {
                        echo "<p>Data offset tidak ditemukan untuk offset_id: $offset_id</p>";
                    }
                } else {
                    echo "<p>Gagal menjalankan query offset: " . mysqli_error($koneksi) . "</p>";
                }

                mysqli_stmt_close($stmtOffset);
            }

            // Ambil data dari tabel offset_personnel berdasarkan management_id
            if (!empty($management_id)) {
                $queryPersonnel = "SELECT 
                                        personnel_id, 
                                        offset_id, 
                                        name, 
                                        nik, 
                                        division 
                                    FROM offset_personnel 
                                    WHERE offset_id = ?";
                $stmtPersonnel = mysqli_prepare($koneksi, $queryPersonnel);
                mysqli_stmt_bind_param($stmtPersonnel, 'i', $management_id); // 'i' untuk integer

                if (mysqli_stmt_execute($stmtPersonnel)) {
                    $resultPersonnel = mysqli_stmt_get_result($stmtPersonnel);

                    // Cek apakah ada data
                    $personnelData = [];
                    if (mysqli_num_rows($resultPersonnel) > 0) {
                        while ($personnelRow = mysqli_fetch_assoc($resultPersonnel)) {
                            $personnelData[] = $personnelRow; // Simpan data dalam array
                        }
                    } else {
                        echo "<p>Data personel tidak ditemukan untuk offset_id: $management_id</p>";
                    }
                } else {
                    echo "<p>Gagal menjalankan query personnel: " . mysqli_error($koneksi) . "</p>";
                }

                mysqli_stmt_close($stmtPersonnel);
            }

            // Jika workshops_id tersedia, ambil data dari tabel workshop_branch
            if (!empty($workshops_id)) {
                $queryWorkshop = "SELECT 
                                    workshop_branch_id, 
                                    workshops_id, 
                                    workshop_name, 
                                    phone_number 
                                  FROM workshop_branch 
                                  WHERE workshops_id = ?";
                $stmtWorkshop = mysqli_prepare($koneksi, $queryWorkshop);
                mysqli_stmt_bind_param($stmtWorkshop, 'i', $workshops_id);

                if (mysqli_stmt_execute($stmtWorkshop)) {
                    $resultWorkshop = mysqli_stmt_get_result($stmtWorkshop);

                    // Cek apakah ada data
                    $workshopBranches = [];
                    if (mysqli_num_rows($resultWorkshop) > 0) {
                        while ($workshopRow = mysqli_fetch_assoc($resultWorkshop)) {
                            $workshopBranches[] = $workshopRow; // Simpan data dalam array
                        }
                    } else {
                        echo "<p>Data workshop tidak ditemukan untuk workshops_id: $workshops_id</p>";
                    }
                } else {
                    echo "<p>Gagal menjalankan query workshop: " . mysqli_error($koneksi) . "</p>";
                }

                mysqli_stmt_close($stmtWorkshop);
            }

            // Jika industries_id tersedia, ambil data dari tabel industries_branch
            if (!empty($industries_id)) {
                $queryIndustrieBranch = "SELECT 
                                            industries_id,  
                                            industrie_name, 
                                            category,
                                            field_of_cooperation,
                                            document_loapoa_path 
                                        FROM industries_branch 
                                        WHERE industries_id = ?";
                $stmtIndustrieBranch = mysqli_prepare($koneksi, $queryIndustrieBranch);
                mysqli_stmt_bind_param($stmtIndustrieBranch, 'i', $industries_id);

                if (mysqli_stmt_execute($stmtIndustrieBranch)) {
                    $resultIndustries = mysqli_stmt_get_result($stmtIndustrieBranch);

                    // Cek apakah ada data
                    $industriesBranches = [];
                    if (mysqli_num_rows($resultIndustries) > 0) {
                        while ($industriesRow = mysqli_fetch_assoc($resultIndustries)) {
                            $industriesBranches[] = $industriesRow; // Simpan data dalam array
                        }
                    } else {
                        echo "<p>Data industries tidak ditemukan untuk industries_id: $industries_id</p>";
                    }
                } else {
                    echo "<p>Gagal menjalankan query industries: " . mysqli_error($koneksi) . "</p>";
                }

                mysqli_stmt_close($stmtIndustrieBranch);
            }

            // Ambil data dari tabel company_management berdasarkan management_id
            if (!empty($management_id)) {
                $queryManagement = "SELECT 
                                        management_id, 
                                        company_id, 
                                        organization_structure_path, 
                                        director_name, 
                                        director_phone, 
                                        pic_name, 
                                        pic_phone, 
                                        expert_staff_list_path 
                                    FROM company_management 
                                    WHERE management_id = ?";
                $stmtManagement = mysqli_prepare($koneksi, $queryManagement);
                mysqli_stmt_bind_param($stmtManagement, 'i', $management_id);

                if (mysqli_stmt_execute($stmtManagement)) {
                    $resultManagement = mysqli_stmt_get_result($stmtManagement);

                    // Cek apakah ada data
                    if (mysqli_num_rows($resultManagement) > 0) {
                        $managementData = mysqli_fetch_assoc($resultManagement);
                    } else {
                        echo "<p>Data manajemen tidak ditemukan untuk management_id: $management_id</p>";
                    }
                } else {
                    echo "<p>Gagal menjalankan query management: " . mysqli_error($koneksi) . "</p>";
                }

                mysqli_stmt_close($stmtManagement);
            }

            // Ambil data dari tabel financial_management berdasarkan financial_id
            if (!empty($financial_id)) {
                $queryFinancial = "SELECT 
                                        financial_id, 
                                        company_id, 
                                        public_accounting_firm, 
                                        internal_audit_report_path, 
                                        external_audit_report_path, 
                                        financial_development_graph_path, 
                                        public_accountant_opinion, 
                                        marketing_business_sop_path 
                                    FROM financial_management 
                                    WHERE financial_id = ?";
                $stmtFinancial = mysqli_prepare($koneksi, $queryFinancial);
                mysqli_stmt_bind_param($stmtFinancial, 'i', $financial_id); // 'i' untuk integer

                if (mysqli_stmt_execute($stmtFinancial)) {
                    $resultFinancial = mysqli_stmt_get_result($stmtFinancial);

                    // Cek apakah ada data
                    if (mysqli_num_rows($resultFinancial) > 0) {
                        $financialData = mysqli_fetch_assoc($resultFinancial);
                    } else {
                        echo "Data tidak ditemukan untuk financial_id: $financial_id";
                    }
                } else {
                    echo "Gagal menjalankan query: " . mysqli_error($koneksi);
                }

                mysqli_stmt_close($stmtFinancial);
            }

            // Ambil data dari tabel technology_management berdasarkan tech_id
            if (!empty($tech_id)) {
                $queryTechnology = "SELECT 
                                        tech_id, 
                                        company_id, 
                                        technology_project_portfolio_path, 
                                        technology_roadmap_path, 
                                        litbang_r_and_d_path, 
                                        offset_path
                                    FROM technology_management 
                                    WHERE tech_id = ?";
                $stmtTechnology = mysqli_prepare($koneksi, $queryTechnology);
                mysqli_stmt_bind_param($stmtTechnology, 'i', $tech_id); // 'i' untuk integer

                if (mysqli_stmt_execute($stmtTechnology)) {
                    $resultTechnology = mysqli_stmt_get_result($stmtTechnology);

                    // Cek apakah ada data
                    if (mysqli_num_rows($resultTechnology) > 0) {
                        $technologyData = mysqli_fetch_assoc($resultTechnology);
                    } else {
                        echo "Data tidak ditemukan untuk tech_id: $tech_id";
                    }
                } else {
                    echo "Gagal menjalankan query: " . mysqli_error($koneksi);
                }

                mysqli_stmt_close($stmtTechnology);
            }

            // Ambil data dari tabel production_facilities berdasarkan facility_id
            if (!empty($facility_id)) {
                $queryFacility = "SELECT 
                                    facility_id, 
                                    company_id, 
                                    equipment_list_path, 
                                    ownership_type, 
                                    production_layout_path 
                                  FROM production_facilities 
                                  WHERE facility_id = ?";
                $stmtFacility = mysqli_prepare($koneksi, $queryFacility);
                mysqli_stmt_bind_param($stmtFacility, 'i', $facility_id); // 'i' untuk integer

                if (mysqli_stmt_execute($stmtFacility)) {
                    $resultFacility = mysqli_stmt_get_result($stmtFacility);

                    // Cek apakah ada data
                    if (mysqli_num_rows($resultFacility) > 0) {
                        $facilityData = mysqli_fetch_assoc($resultFacility);
                    } else {
                        echo "Data tidak ditemukan untuk facility_id: $facility_id";
                    }
                } else {
                    echo "Gagal menjalankan query: " . mysqli_error($koneksi);
                }

                mysqli_stmt_close($stmtFacility);
            }

            // Ambil data dari tabel products_branch berdasarkan products_id
            $productDataArray = []; // Array untuk menyimpan data produk
            if (!empty($products_id)) {
                $queryProduct = "SELECT * FROM products_branch WHERE products_id = ?";
                $stmtProduct = mysqli_prepare($koneksi, $queryProduct);

                // Pastikan Anda menggunakan nama variabel yang benar untuk parameter
                mysqli_stmt_bind_param($stmtProduct, 'i', $products_id); // 'i' untuk integer

                if (mysqli_stmt_execute($stmtProduct)) {
                    $resultProduct = mysqli_stmt_get_result($stmtProduct);

                    // Loop melalui semua data hasil query dan simpan ke array
                    while ($row = mysqli_fetch_assoc($resultProduct)) {
                        $productDataArray[] = $row; // Tambahkan setiap row ke array
                    }

                    // Cek apakah array kosong (jika tidak ada data ditemukan)
                    if (empty($productDataArray)) {
                        echo "Data tidak ditemukan untuk products_id: $products_id";
                    }
                } else {
                    echo "Gagal menjalankan query: " . mysqli_error($koneksi);
                }

                mysqli_stmt_close($stmtProduct);
            }

            // Ambil data dari tabel articles_of_incorporation berdasarkan articles_of_incorporation_id
            if (!empty($articles_id)) {
                $queryArticles = "SELECT * FROM articles_of_incorporation WHERE articles_of_incorporation_id = ?";
                $stmtArticles = mysqli_prepare($koneksi, $queryArticles); // Gunakan query SQL di sini

                mysqli_stmt_bind_param($stmtArticles, 'i', $articles_id); // 'i' untuk integer

                if (mysqli_stmt_execute($stmtArticles)) {
                    $resultArticles = mysqli_stmt_get_result($stmtArticles);

                    // Cek apakah ada data
                    if (mysqli_num_rows($resultArticles) > 0) {
                        $articlesData = mysqli_fetch_assoc($resultArticles); // Ambil data pertama
                    } else {
                        echo "Data tidak ditemukan untuk articles id: $articles_id";
                    }
                } else {
                    echo "Gagal menjalankan query: " . mysqli_error($koneksi);
                }

                mysqli_stmt_close($stmtArticles);
            }


            // Ambil data dari tabel note berdasarkan id_report
            // if (!empty($id_note)) {
            //     $queryNote = "SELECT 
            //             id_note, 
            //             company_id, 
            //             id_report, 
            //             note 
            //       FROM note 
            //       WHERE id_report = ?";
            //     $stmtNote = mysqli_prepare($koneksi, $queryNote);
            //     mysqli_stmt_bind_param($stmtNote, 'i', $id_report); // 'i' untuk integer

            //     if (mysqli_stmt_execute($stmtNote)) {
            //         $resultNote = mysqli_stmt_get_result($stmtNote);
            //     } else {
            //         echo "Gagal menjalankan query: " . mysqli_error($koneksi);
            //     }

            //     mysqli_stmt_close($stmtNote);
            // }
        } else {
            echo "<p>Data laporan tidak ditemukan untuk id_report: $idReport</p>";
        }
    } else {
        echo "<p>Gagal menjalankan query report: " . mysqli_error($koneksi) . "</p>";
    }

    mysqli_stmt_close($stmtReport);
} else {
    echo "<p>id_report tidak tersedia.</p>";
}

// mysqli_close($koneksi);

// Data dari tabel report tersedia di variabel berikut:
// $id_report, $status, $workshops_id, $management_id, $financial_id, $offset_id, 
// $facility_id, $product_id, $tech_id, $company_id, $date.

// Data dari tabel workshop_branch tersedia di array $workshopBranches (jika ada).
// Data dari tabel company_management tersedia di array $managementData (jika ada).
// Data dari tabel financial_management tersedia di array $financialData (jika ada).
// Data dari tabel technology_management tersedia di array $technologyData (jika ada).
// Data dari tabel production_facilities tersedia di array $facilityData (jika ada).
// Data dari tabel products tersedia di array $productData (jika ada).
// Data dari tabel offset_activities tersedia di array $offsetData (jika ada).
// Data dari tabel offset_personnel tersedia di array $personnelData (jika ada).
// Data dari tabel offset_materials tersedia di array $materialsData (jika ada).
?>

<!DOCTYPE html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Detail Laporan - User</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="../assets/img/logo-proyek-tanpa-teks.png" rel="shortcut icon">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="sb-nav-fixed">
    <?php
    include "../nav/navbar.php"
    ?>
    <main>
        <div class="wrap" style="margin-left: 47px; margin-right: 47px;">
            <div class="container-fluid px-4">
                <h3 style="color:#152C5B;" class="mt-4">Laporan > Detail Laporan </h3>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">*Semua kolom wajib diisi, kecuali disebutkan sebagai
                        (opsional).</li>
                </ol>
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

                        <h5 class="mb-3">Produk Perusahaan</h5>
                        <?php if (!empty($productDataArray)): ?>
                            <?php foreach ($productDataArray as $index => $product): ?>
                                <div class="product-item mb-3">
                                    <!-- PRODUK PERUSAHAAN -->
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <p><strong>Produk <?php echo $index + 1; ?></strong></p>
                                        </div>
                                        <label for="nama_produk" class="text-secondary col-sm-4 col-form-label text-start">Nama Produk</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nama_produk" name="nama_produk" value="<?php echo htmlspecialchars($product['product_name']); ?>" readonly>
                                        </div>
                                    </div>

                                    <!-- Nomor KBLI -->
                                    <div class="row mb-3">
                                        <label for="nomor_kbli" class="text-secondary col-sm-4 col-form-label text-start">Nomor KBLI
                                            (<a href="https://docs.google.com/document/d/1PWSdth5JC4JnI-hwnM4snxbLwSUPnvTb9ZM40Uwfe8I/edit?usp=sharing" class="text-decoration-underline text-primary">Informasi KBLI</a>)
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nomor_kbli" name="nomor_kbli" value="<?php echo htmlspecialchars($product['kbli_number']); ?>" readonly>
                                        </div>
                                    </div>

                                    <!-- Deskripsi KBLI -->
                                    <div class="row mb-3">
                                        <label for="deskripsi_kbli" class="text-secondary col-sm-4 col-form-label text-start">Deskripsi KBLI</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="deskripsi_kbli" name="deskripsi_kbli" value="<?php echo htmlspecialchars($product['kbli_description']); ?>" readonly>
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
                                                <option value="" disabled <?php echo empty($product['product_group']) ? 'selected' : ''; ?>>Pilih Produk</option>
                                                <option value="1" <?php echo $product['product_group'] === '1' ? 'selected' : ''; ?>>Alat Utama</option>
                                                <option value="2" <?php echo $product['product_group'] === '2' ? 'selected' : ''; ?>>Komponen Utama</option>
                                                <option value="3" <?php echo $product['product_group'] === '3' ? 'selected' : ''; ?>>Komponen Pendukung</option>
                                                <option value="4" <?php echo $product['product_group'] === '4' ? 'selected' : ''; ?>>Komponen Bahan Baku</option>
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
                                            <input type="text" class="form-control" id="klasifikasi_produk" name="klasifikasi_produk" value="<?php echo htmlspecialchars($product['product_classification']); ?>" placeholder="Masukkan Klasifikasi Produk" readonly>
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

                                    <!-- LEVEL -->
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                        </div>
                                        <label for="trl" class="text-secondary col-sm-4 col-form-label text-start">TRL (<i>Technology Readiness Level</i>)</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="trl" name="trl" value="<?php echo htmlspecialchars($product['trl_level']); ?>" readonly>
                                        </div>
                                    </div>

                                    <!-- MRL -->
                                    <div class="row mb-3">
                                        <label for="mrl" class="text-secondary col-sm-4 col-form-label text-start">MRL (<i>Manufacturing Readiness Level</i>)</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control" id="mrl" name="mrl" value="<?php echo htmlspecialchars($product['mrl_level']); ?>" readonly>
                                        </div>
                                    </div>

                                    <!-- KAPASITAS PRODUKSI -->
                                    <div class="row mb-3 mt-4">
                                        <label for="productionCapacity" class="text-secondary col-sm-4 col-form-label text-start">Kapasitas Produksi</label>
                                        <div class="col-sm-8">
                                            <input class="form-control" type="number" id="productionCapacity" name="kapasitas_produksi" value="<?php echo htmlspecialchars($product['production_capacity'] ?? ''); ?>" placeholder="Masukkan kapasitas produksi" min="0" readonly>
                                        </div>
                                    </div>

                                    <!-- SERTIFIKASI KELAYAKAN -->
                                    <div class="row mb-3">
                                        <label for="sertifikasi_kelayakan" class="text-secondary col-sm-4 col-form-label text-start">Sertifikasi Kelayakan</label>
                                        <div class="col-sm-8">
                                            <?php if (!empty($product['fitness_certification_path'])): ?>
                                                <a href="<?php echo htmlspecialchars($product['fitness_certification_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                            <?php else: ?>
                                                <span>Tidak ada file yang diunggah.</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- SERTIFIKAT ISO PRODUK -->
                                    <div class="row mb-3">
                                        <label for="sertifikat_iso" class="text-secondary col-sm-4 col-form-label text-start">Sertifikat ISO Produk</label>
                                        <div class="col-sm-8">
                                            <?php if (!empty($product['iso_certificate_path'])): ?>
                                                <a href="<?php echo htmlspecialchars($product['iso_certificate_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
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
                                                    value="<?php echo htmlspecialchars($product['tkdn_value']); ?>"
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
                                            <input type="text" class="form-control" id="nomor_sertifikat_tkdn" name="nomor_sertifikat_tkdn" value="<?php echo htmlspecialchars($product['tkdn_certificate_number']); ?>" placeholder="Masukkan Nomor Sertifikat TKDN" readonly>
                                        </div>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Tidak ada data produk yang tersedia.</p>
                            <?php endif; ?>


                            <!-- Akta Notaris -->
                            <div class="row mb-3">
                                <p class="mb-3"><strong>Akta Notaris</strong></p>

                                <!-- Akta Perusahaan -->
                                <label for="akta_perusahaan" class="text-secondary col-sm-4 col-form-label text-start">Akta Perusahaan</label>
                                <div class="col-sm-8">
                                    <?php if (!empty($articlesData['articles_of_incorporation_path'])): ?>
                                        <a href="<?php echo htmlspecialchars($articlesData['articles_of_incorporation_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                    <?php else: ?>
                                        <span>Tidak ada file yang diunggah.</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Akta Perubahan Terakhir -->
                            <div class="row mb-3">
                                <label for="akta_perusahaan_terakhir" class="text-secondary col-sm-4 col-form-label text-start">Akta Perubahan Terakhir</label>
                                <div class="col-sm-8">
                                    <?php if (!empty($articlesData['last_articles_of_incorporation_path'])): ?>
                                        <a href="<?php echo htmlspecialchars($articlesData['last_articles_of_incorporation_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                    <?php else: ?>
                                        <span>Tidak ada file yang diunggah.</span>
                                    <?php endif; ?>
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
                                    <?php if (!empty($offsetData['offset_material_path'])): ?>
                                        <a href="<?php echo htmlspecialchars($offsetData['offset_material_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
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

                            <!-- Kerja Sama Industri -->
                            <?php if (!empty($industriesBranches)): ?>
                                <?php foreach ($industriesBranches as $index => $industriesBranches): ?>
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <p class="mb-3"><strong>Kerja Sama Industri</strong></p>
                                        </div>
                                        <label for="nama_industri_yang_bekerja_sama" class="text-secondary col-sm-4 col-form-label text-start">
                                            Nama Industri Yang Bekerja Sama
                                        </label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" id="nama_industri_yang_bekerja_sama" name="nama_industri_yang_bekerja_sama[]" value="<?php echo htmlspecialchars($industriesBranches['industrie_name']); ?>" placeholder="Masukkan Nama Industri yang Bekerja Sama" required>
                                        </div>
                                    </div>
                                    <!-- Kategori -->
                                    <div class="row mb-3">
                                        <label for="kategori" class="text-secondary col-sm-4 col-form-label text-start">
                                            Kategori
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="form-select" id="kategori" name="kategori[]" disabled>
                                                <option value="" disabled<?php echo empty($industriesBranches['category']) ? 'selected' : ''; ?> disabled>Pilih Kategori</option>
                                                <option value="Dalam Negeri" <?php echo $industriesBranches['category'] == 'Dalam Negeri' ? 'selected' : ''; ?>>Dalam Negeri</option>
                                                <option value="Luar Negeri" <?php echo $industriesBranches['category'] == 'Luar Negeri' ? 'selected' : ''; ?>>Luar Negeri</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Bidang Kerja Sama -->
                                    <div class="row mb-3">
                                        <label for="bidang_kerja_sama" class="text-secondary col-sm-4 col-form-label text-start">
                                            Bidang Kerja Sama
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="form-select" id="bidang_kerja_sama" name="bidang_kerja_sama[]" disabled>
                                                <option value="" <?php echo empty($industriesBranches['field_of_cooperation']) ? 'selected' : ''; ?> disabled>Pilih Bidang Kerja Sama</option>
                                                <option value="Join Venture" <?php echo $industriesBranches['field_of_cooperation'] == 'Join Venture' ? 'selected' : ''; ?>>Join Venture</option>
                                                <option value="Join Production" <?php echo $industriesBranches['field_of_cooperation'] == 'Join Production' ? 'selected' : ''; ?>>Join Production</option>
                                                <option value="Join Development" <?php echo $industriesBranches['field_of_cooperation'] == 'Join Development' ? 'selected' : ''; ?>>Join Development</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Upload Dokumen LOA&POA atau Sejenis Dokumen Kerja Sama -->
                                    <div class="row mb-3">
                                        <label for="dokumen_loapoa" class="text-secondary col-sm-4 col-form-label text-start">
                                            Upload Dokumen LOA&POA atau Sejenis Dokumen Kerja Sama
                                        </label>
                                        <div class="col-sm-8">
                                            <?php if (!empty($industriesBranches['document_loapoa_path'])): ?>
                                                <a href="<?php echo htmlspecialchars($industriesBranches['document_loapoa_path']); ?>" target="_blank" class="text-decoration-underline">Lihat File</a>
                                            <?php else: ?>
                                                <span>Tidak ada file yang diunggah.</span>
                                            <?php endif; ?>
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
    <footer>
        <?php
        include "../footer/footer.php";
        ?>
    </footer>
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
                    <input type="text" class="form-control" id="nama_workshop" name="nama_workshop[]" placeholder="Masukkan Nama WorkShop" required>
                </div>
            </div>
            <!-- Nomor Telepon WorkShop -->
            <div class="row mb-3">
                <label class="text-secondary col-sm-4 col-form-label text-start">Nomor Telepon WorkShop</label>
                <div class="col-sm-8">
                    <input type="tel" class="form-control" id="nomor_telp_workshop" name="nomor_telp_workshop[]" placeholder="Masukkan nomor telepon workshop (10 - 13 digit angka)" pattern="[0-9]{10,13}" required>
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
        let personilCounter = 2; // Mulai dari Personil 2

        document.getElementById('addPersonil').addEventListener('click', function() {
            const container = document.getElementById('personilContainer');

            // Buat elemen input untuk personil baru
            const newPersonil = document.createElement('div');
            newPersonil.className = 'personil-item mb-3';
            newPersonil.innerHTML = `
            <p class="mb-3"><strong>Personil ${personilCounter}</strong></p>
            <div class="row mb-3">
                <label class="text-secondary col-sm-4 col-form-label text-start">Nama Personil Penerima</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="nama_personil[]" placeholder="Masukkan Nama">
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
                    <input type="text" class="form-control" name="divisi_personil[]" placeholder="Masukkan Divisi">
                </div>
            </div>
            <hr>
        `;

            // Tambahkan elemen baru ke dalam kontainer
            container.appendChild(newPersonil);

            // Increment counter
            personilCounter++;
        });
    </script>

    <script>
        let materialCounter = 2; // Mulai dari Personil 2

        document.getElementById('addMaterial').addEventListener('click', function() {
            const container = document.getElementById('materialContainer');

            // Buat elemen input untuk personil baru
            const newMaterial = document.createElement('div');
            newMaterial.className = 'material-item mb-3';
            newMaterial.innerHTML = `
            <p class="mb-3"><strong>Material ${materialCounter}</strong></p>
            <div class="row mb-3">
                <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Part No/SN</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nomor_part_material_offset" name="nomor_part_material_offset[]" placeholder="Masukkan No/SN" required>
                     </div>
                 </div>
                <div class="row mb-3">
                    <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Merk/Type</label>
                <div class="col-sm-8">
                 <input type="text" class="form-control" id="merk_material_offset" name="merk_material_offset[]" placeholder="Masukkan Merk/Type" required>
                    </div>
                </div>
                 <div class="row mb-3">
                            <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Deskripi</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="deskripsi_material_offset" name="deskripsi_material_offset[]" placeholder="Masukkan Deskripsi" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Kuantitas</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="kuantitas_material_offset" name="kuantitas_material_offset[]" placeholder="Masukkan Kuantitas" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="indhanInput" class="text-secondary col-sm-4 col-form-label text-start">Review dan Saran</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" id="review_material_offset" name="review_material_offset[]" placeholder="Masukkan Review dan Saran" rows="4" required></textarea>
                            </div>
                        </div>
                </div>
            <hr>
        `;

            // Tambahkan elemen baru ke dalam kontainer
            container.appendChild(newMaterial);

            // Increment counter
            materialCounter++;
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
</body>

</html>