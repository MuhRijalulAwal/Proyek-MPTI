<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Ambil data perusahaan berdasarkan user_id
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Variabel dari form
    $directorName = isset($_POST['nama_direktur_utama']) ? mysqli_real_escape_string($koneksi, $_POST['nama_direktur_utama']) : null;
    $directorPhone = isset($_POST['telepon_direktur_utama']) ? mysqli_real_escape_string($koneksi, $_POST['telepon_direktur_utama']) : null;
    $picName = isset($_POST['nama_pic']) ? mysqli_real_escape_string($koneksi, $_POST['nama_pic']) : null;
    $picPhone = isset($_POST['telepon_pic']) ? mysqli_real_escape_string($koneksi, $_POST['telepon_pic']) : null;

    // Variabel untuk manajemen keuangan
    $accountingFirm = isset($_POST['nama_kantor']) ? mysqli_real_escape_string($koneksi, $_POST['nama_kantor']) : null;
    $publicAccountantOpinion = isset($_POST['opini_akuntan']) ? mysqli_real_escape_string($koneksi, $_POST['opini_akuntan']) : null;

    // Variabel untuk teknologi
    $trlLevel = isset($_POST['trl']) ? intval($_POST['trl']) : null;
    $mrlLevel = isset($_POST['mrl']) ? intval($_POST['mrl']) : null;

    // Variabel untuk fasilitas produksi
    $ownershipType = isset($_POST['kepemilikan_sarana']) ? mysqli_real_escape_string($koneksi, $_POST['kepemilikan_sarana']) : null;

    $uploadDir = '../uploads/management_files/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Fungsi untuk upload file
    function uploadFile($file, $uploadDir)
    {
        if (isset($file) && $file['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $file['tmp_name'];
            $fileName = uniqid() . '_' . basename($file['name']);
            $filePath = $uploadDir . $fileName;

            // Validasi ekstensi file
            $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'xlsx']; // Tipe file yang diizinkan

            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($fileTmpPath, $filePath)) {
                    return $filePath;
                } else {
                    return ["error" => "Gagal memindahkan file yang diunggah."];
                }
            } else {
                return ["error" => "Format file tidak valid. Hanya JPG, PNG, dan PDF yang diperbolehkan."];
            }
        } elseif($file['error'] !== UPLOAD_ERR_NO_FILE) {
            return ["error" => "Terjadi kesalahan saat mengunggah file."];
        }
        return null;
    }

    function uploadFilesArray($files, $uploadDir)
{
    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            return [
                'uploaded' => null,
                'errors' => ["Gagal membuat direktori upload."]
            ];
        }
    }

    $uploadedFiles = [];
    $errors = [];

    foreach ($files['name'] as $key => $fileName) {
        $fileTmpPath = $files['tmp_name'][$key];
        $fileError = $files['error'][$key];

        if ($fileError === UPLOAD_ERR_OK) {
            // Generate unique file name and path
            $uniqueFileName = uniqid() . '_' . basename($fileName);
            $filePath = $uploadDir . $uniqueFileName;

            // Validate file extension
            $fileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'xlsx']; // Configurable allowed types

            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($fileTmpPath, $filePath)) {
                    $uploadedFiles[] = $filePath;
                } else {
                    $errors[] = "Gagal memindahkan file {$fileName}.";
                }
            } else {
                $errors[] = "Format file {$fileName} tidak valid. Hanya " . implode(', ', $allowedTypes) . " yang diperbolehkan.";
            }
        } elseif ($fileError !== UPLOAD_ERR_NO_FILE) {
            // Use PHP file upload error messages
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE   => "Ukuran file {$fileName} melebihi batas yang diizinkan oleh konfigurasi server.",
                UPLOAD_ERR_FORM_SIZE  => "Ukuran file {$fileName} melebihi batas yang diizinkan oleh formulir.",
                UPLOAD_ERR_PARTIAL    => "File {$fileName} hanya terunggah sebagian.",
                UPLOAD_ERR_NO_TMP_DIR => "Folder sementara untuk file {$fileName} tidak ditemukan.",
                UPLOAD_ERR_CANT_WRITE => "Gagal menulis file {$fileName} ke disk.",
                UPLOAD_ERR_EXTENSION  => "Unggahan file {$fileName} dihentikan oleh ekstensi PHP."
            ];

            $errors[] = $errorMessages[$fileError] ?? "Terjadi kesalahan saat mengunggah file {$fileName}.";
        }
    }

    // Return null if no files were successfully uploaded
    if (empty($uploadedFiles) && empty($errors)) {
        return null;
    }

    // Return uploaded files and errors
    return [
        'uploaded' => $uploadedFiles,
        'errors' => $errors
    ];
}


    // Variabel untuk Offset
    $offsetPath = isset($_FILES['offset']) ? uploadFile($_FILES['offset'], $uploadDir) : null;
    if (isset($offsetPath['error'])) {
        die($offsetPath['error']);
    }

    // Variable untuk Daftar Tenaga Ahli
    $expertStaffFilePath = isset($_FILES['daftar_tenaga_ahli']) ? uploadFile($_FILES['daftar_tenaga_ahli'], $uploadDir) : null;
    if (isset($expertStaffFilePath['error'])) {
        die($expertStaffFilePath['error']);
    }

    // Variabel untuk ICC Kontrak Pengadaan
    $iccContract = isset($_FILES['kontrak_icc_pengadaan']) ? uploadFile($_FILES['kontrak_icc_pengadaan'], $uploadDir) : null;
    if (isset($iccContract['error'])) {
        die($iccContract['error']);
    }

    // Variabel untuk kegiatan KLO
    $offsetMaterialPath = isset($_FILES['materi_offset']) ? uploadFile($_FILES['materi_offset'], $uploadDir) : null;
    if (isset($offsetMaterialPath['error'])) {
        die($offsetMaterialPath['error']);
    }

    // Proses upload file dengan validasi
    $organizationFilePath = isset($_FILES['struktur_organisasi']) ? uploadFile($_FILES['struktur_organisasi'], $uploadDir) : null;
    if (isset($organizationFilePath['error'])) {
        die($organizationFilePath['error']);
    }

    // Upload Laporan Keuangan (Hasil Audit Auditor Internal)
    $internalAuditFilePath = isset($_FILES['laporan_keuangan_internal']) ? uploadFile($_FILES['laporan_keuangan_internal'], $uploadDir) : null;
    if (isset($internalAuditFilePath['error'])) {
        die($internalAuditFilePath['error']);
    }

    // Upload Laporan Keuangan (Hasil Audit Auditor External)
    $externalAuditFilePath = isset($_FILES['laporan_keuangan_external']) ? uploadFile($_FILES['laporan_keuangan_external'], $uploadDir) : null;
    if (isset($externalAuditFilePath['error'])) {
        die($externalAuditFilePath['error']);
    }

    // Upload Akta Perusahaan
    $articlesofIncorporationPath = isset($_FILES['akta_perusahaan']) ? uploadFile($_FILES['akta_perusahaan'], $uploadDir) : null;
    if (isset($articlesofIncorporationPath['error'])) {
        die($articlesofIncorporationPath['error']);
    }

    // Upload Akta Perubahan Terakhir
    $lastArticlesofIncorporationPath = isset($_FILES['akta_perusahaan_terakhir']) ? uploadFile($_FILES['akta_perusahaan_terakhir'], $uploadDir) : null;
    if (isset($lastArticlesofIncorporationPath['error'])) {
        die($lastArticlesofIncorporationPath['error']);
    }

    // Upload Grafik Perkembangan Finansial
    $financialGraphFilePath = isset($_FILES['grafik_perkembangan']) ? uploadFile($_FILES['grafik_perkembangan'], $uploadDir) : null;
    if (isset($financialGraphFilePath['error'])) {
        die($financialGraphFilePath['error']);
    }

    // Upload SOP Aktivitas Bisnis Pemasaran
    $marketingSopFilePath = isset($_FILES['sop_pemasaran']) ? uploadFile($_FILES['sop_pemasaran'], $uploadDir) : null;
    if (isset($marketingSopFilePath['error'])) {
        die($marketingSopFilePath['error']);
    }

    // Upload Teknologi Project Portofolio
    $technologyPortfolioPath = isset($_FILES['teknologi_project_portofolio']) ? uploadFile($_FILES['teknologi_project_portofolio'], $uploadDir) : null;
    if (isset($technologyPortfolioPath['error'])) {
        die($technologyPortfolioPath['error']);
    }

    // Upload RoadMap Pengembangan Teknologi
    $technologyRoadmapPath = isset($_FILES['roadmap_pengembangan']) ? uploadFile($_FILES['roadmap_pengembangan'], $uploadDir) : null;
    if (isset($technologyRoadmapPath['error'])) {
        die($technologyRoadmapPath['error']);
    }

    // Upload LITBANG R & D
    $litbangRdPath = isset($_FILES['litbang_rd']) ? uploadFile($_FILES['litbang_rd'], $uploadDir) : null;
    if (isset($litbangRdPath['error'])) {
        die($litbangRdPath['error']);
    }

    // Upload Daftar Peralatan
    $equipmentListPath = isset($_FILES['daftar_peralatan']) ? uploadFile($_FILES['daftar_peralatan'], $uploadDir) : null;
    if (isset($equipmentListPath['error'])) {
        die($equipmentListPath['error']);
    }

    // Upload Layout Produksi
    $productionLayoutPath = isset($_FILES['layout_produksi']) ? uploadFile($_FILES['layout_produksi'], $uploadDir) : null;
    if (isset($productionLayoutPath['error'])) {
        die($productionLayoutPath['error']);
    }

    // Query INSERT ke tabel company_management
    $queryCompany = "INSERT INTO company_management (
                        company_id,
                        organization_structure_path,
                        director_name,
                        director_phone,
                        pic_name,
                        pic_phone,
                        expert_staff_list_path
                    ) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmtCompany = mysqli_prepare($koneksi, $queryCompany);
    mysqli_stmt_bind_param(
        $stmtCompany,
        'issssss',
        $_SESSION['user_id'],
        $organizationFilePath,
        $directorName,
        $directorPhone,
        $picName,
        $picPhone,
        $expertStaffFilePath
    );

    if (mysqli_stmt_execute($stmtCompany)) {
        $managementId = mysqli_insert_id($koneksi);
        mysqli_stmt_close($stmtCompany);

        // Query INSERT ke tabel financial_management
        $queryFinancial = "INSERT INTO financial_management (
                             company_id,
                             public_accounting_firm,
                             internal_audit_report_path,
                             external_audit_report_path,
                             financial_development_graph_path,
                             public_accountant_opinion,
                             marketing_business_sop_path
                           ) VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmtFinancial = mysqli_prepare($koneksi, $queryFinancial);
        mysqli_stmt_bind_param(
            $stmtFinancial,
            'issssss',
            $_SESSION['user_id'],
            $accountingFirm,
            $internalAuditFilePath,
            $externalAuditFilePath,
            $financialGraphFilePath,
            $publicAccountantOpinion,
            $marketingSopFilePath
        );

        if (mysqli_stmt_execute($stmtFinancial)) {
            $financialId = mysqli_insert_id($koneksi);
            mysqli_stmt_close($stmtFinancial);

            // Query INSERT ke tabel technology_management
            $queryTechnology = "INSERT INTO technology_management (
                                 company_id,
                                 technology_project_portfolio_path,
                                 technology_roadmap_path,
                                 litbang_r_and_d_path,
                                 offset_path
                               ) VALUES (?, ?, ?, ?, ?)";

            $stmtTechnology = mysqli_prepare($koneksi, $queryTechnology);
            mysqli_stmt_bind_param(
                $stmtTechnology,
                'issss',
                $_SESSION['user_id'],
                $technologyPortfolioPath,
                $technologyRoadmapPath,
                $litbangRdPath,
                $offsetPath
            );

            if (mysqli_stmt_execute($stmtTechnology)) {
                $techId = mysqli_insert_id($koneksi);
                mysqli_stmt_close($stmtTechnology);

                // Query INSERT ke tabel production_facilities
                $queryFacilities = "INSERT INTO production_facilities (
                                     company_id,
                                     equipment_list_path,
                                     ownership_type,
                                     production_layout_path
                                   ) VALUES (?, ?, ?, ?)";

                $stmtFacilities = mysqli_prepare($koneksi, $queryFacilities);
                mysqli_stmt_bind_param(
                    $stmtFacilities,
                    'isss',
                    $_SESSION['user_id'],
                    $equipmentListPath,
                    $ownershipType,
                    $productionLayoutPath
                );

                if (mysqli_stmt_execute($stmtFacilities)) {
                    $facilityId = mysqli_insert_id($koneksi);
                    // Query INSERT ke tabel products
                    $queryProducts = "INSERT INTO products (company_id) VALUES (?)";
                    $stmtProducts = mysqli_prepare($koneksi, $queryProducts);
                    mysqli_stmt_bind_param($stmtProducts, 'i', $_SESSION['user_id']);

                    if (mysqli_stmt_execute($stmtProducts)) {
                        $productsId = mysqli_insert_id($koneksi); // Ambil products_id yang baru dibuat

                        // Query INSERT ke tabel products_branch
                        if (isset($_POST['nama_produk'])) {
                            $nameProducts = isset($_POST['nama_produk']) ? $_POST['nama_produk'] : [];
                            $kbliNumberProducts = isset($_POST['nomor_kbli']) ? $_POST['nomor_kbli'] : [];
                            $kbliDescProducts = isset($_POST['deskripsi_kbli']) ? $_POST['deskripsi_kbli'] : [];
                            $groupProducts = isset($_POST['kelompok_produk']) ? $_POST['kelompok_produk'] : [];
                            $classificationProducts = isset($_POST['klasifikasi_produk']) ? $_POST['klasifikasi_produk'] : [];
                            $trlProducts = isset($_POST['trl']) ? $_POST['trl'] : [];
                            $mrlProducts = isset($_POST['mrl']) ? $_POST['mrl'] : [];
                            $capacityProducts = isset($_POST['kapasitas_produksi']) ? $_POST['kapasitas_produksi'] : [];

                            $documentFitnessCertificationFiles = $_FILES['sertifikasi_kelayakan'] ?? [];
                            // Upload Fitness Certification
                            $documentFitnessCertificationPaths = uploadFilesArray($documentFitnessCertificationFiles, $uploadDir);
                            if (!empty($documentFitnessCertificationPaths['errors'])) {
                                foreach ($documentFitnessCertificationPaths['errors'] as $error) {
                                    echo "Error: $error <br>";
                                }
                            }
                            $documentIsoCertificateFiles = $_FILES['sertifikat_iso'] ?? [];
                            // Upload Dokumen Iso Ceriticicate
                            $documentIsoCertificatePaths = uploadFilesArray($documentIsoCertificateFiles, $uploadDir);
                            if (!empty($documentIsoCertificatePaths['errors'])) {
                                foreach ($documentIsoCertificatePaths['errors'] as $error) {
                                    echo "Error: $error <br>";
                                }
                            }
                            $tkdnValueProducts = isset($_POST['nilai_tkdn']) ? $_POST['nilai_tkdn'] : [];
                            $tkdnCertificateNumberProducts = isset($_POST['nomor_sertifikat_tkdn']) ? $_POST['nomor_sertifikat_tkdn'] : [];

                            foreach ($nameProducts as $index => $nameProduct) {
                                $kbliNumberProduct = isset($kbliNumberProducts[$index]) ? $kbliNumberProducts[$index] : '';
                                $kbliDescProduct = isset($kbliDescProducts[$index]) ? $kbliDescProducts[$index] : '';
                                $classificationProduct = isset($classificationProducts[$index]) ? $classificationProducts[$index] : '';
                                $groupProduct = isset($groupProducts[$index]) ? $groupProducts[$index] : '';
                                $trlProduct = isset($trlProducts[$index]) ? $trlProducts[$index] : '';
                                $mrlProduct = isset($mrlProducts[$index]) ? $mrlProducts[$index] : '';
                                $capacityProduct = isset($capacityProducts[$index]) ? $capacityProducts[$index] : '';
                                $documentFitnessCertificationPath = $documentFitnessCertificationPaths['uploaded'][$index] ?? '';
                                $documentIsoCertificatePath = $documentIsoCertificatePaths['uploaded'][$index] ?? '';
                                $tkdnValueProduct = isset($tkdnValueProducts[$index]) ? $tkdnValueProducts[$index] : '';
                                $tkdnCertificateNumberProduct = isset($tkdnCertificateNumberProducts[$index]) ? $tkdnCertificateNumberProducts[$index] : '';

                                $queryProductsBranch = "
                                    INSERT INTO products_branch (
                                        products_id,
                                        company_id,
                                        product_name,
                                        kbli_number,
                                        kbli_description,
                                        product_group,
                                        product_classification,
                                        trl_level,
                                        mrl_level,
                                        production_capacity,
                                        fitness_certification_path,
                                        iso_certificate_path,
                                        tkdn_value,
                                        tkdn_certificate_number
                                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                                $stmtProductsBranch = mysqli_prepare($koneksi, $queryProductsBranch);

                                mysqli_stmt_bind_param(
                                    $stmtProductsBranch,
                                    'iisssssiiissss', // Tipe data 15 kolom
                                    $productsId,
                                    $_SESSION['user_id'],
                                    $nameProduct,
                                    $kbliNumberProduct, // Perbaikan dari $kbliDescProduct
                                    $kbliDescProduct,
                                    $groupProduct,
                                    $classificationProduct,
                                    $trlProduct,
                                    $mrlProduct,
                                    $capacityProduct,
                                    $documentFitnessCertificationPath,
                                    $documentIsoCertificatePath,
                                    $tkdnValueProduct,
                                    $tkdnCertificateNumberProduct
                                );

                                if (!mysqli_stmt_execute($stmtProductsBranch)) {
                                    echo "Gagal menyimpan data ke tabel products_branch: " . mysqli_error($koneksi) . "<br>";
                                } else {
                                    echo "Berhasil menyimpan data products_branch: $nameProduct <br>";
                                }
                                mysqli_stmt_close($stmtProductsBranch);
                            }
                        } else {
                            echo "Data nama_products tidak ditemukan.";
                        }
                    } else {
                        echo "Gagal menyimpan data ke tabel products: " . mysqli_error($koneksi);
                    }

                    mysqli_stmt_close($stmtProducts);

                    // Query INSERT ke tabel offset_activities
                    $queryOffsetActivities = "INSERT INTO offset_activities (
                                                   company_id,
                                                   offset_material_path
                                                 ) VALUES (?, ?)";

                    $stmtOffsetActivities = mysqli_prepare($koneksi, $queryOffsetActivities);
                    mysqli_stmt_bind_param(
                        $stmtOffsetActivities,
                        'is',
                        $_SESSION['user_id'],
                        $offsetMaterialPath
                    );

                    // Query INSERT ke tabel icc_contract
                    $queryIccContract = "INSERT INTO icc_contract (
                                                   company_id,
                                                   icc_contract_path    
                                                 ) VALUES (?, ?)";

                    $stmtIccContract = mysqli_prepare($koneksi, $queryIccContract);
                    mysqli_stmt_bind_param(
                        $stmtIccContract,
                        'is',
                        $_SESSION['user_id'],
                        $iccContract
                    );

                    if (mysqli_stmt_execute($stmtOffsetActivities) && mysqli_stmt_execute($stmtIccContract)) {
                        $iccContractId = mysqli_insert_id($koneksi);
                        $offsetId = mysqli_insert_id($koneksi); // Ambil ID dari offset_activities
                        mysqli_stmt_close($stmtOffsetActivities);
                        mysqli_stmt_close($stmtIccContract);
                        if (isset($_POST['nama_personil'])) {
                            $names = isset($_POST['nama_personil']) ? $_POST['nama_personil'] : [];
                            $niks = isset($_POST['nik_personil']) ? $_POST['nik_personil'] : [];
                            $divisions = isset($_POST['divisi_personil']) ? $_POST['divisi_personil'] : [];

                            // // Debugging POST data
                            // echo "<pre>";
                            // print_r($names);
                            // print_r($niks);
                            // print_r($divisions);
                            // echo "</pre>";

                            foreach ($names as $index => $name) {
                                $nik = isset($niks[$index]) ? $niks[$index] : '';
                                $division = isset($divisions[$index]) ? $divisions[$index] : '';

                                $queryPersonnel = "INSERT INTO offset_personnel (
                                                    offset_id,
                                                    name,
                                                    nik,
                                                    division
                                                ) VALUES (?, ?, ?, ?)";

                                $stmtPersonnel = mysqli_prepare($koneksi, $queryPersonnel);
                                if ($stmtPersonnel) {
                                    mysqli_stmt_bind_param(
                                        $stmtPersonnel,
                                        'isss',
                                        $offsetId, // Pastikan offset_id valid
                                        $name,
                                        $nik,
                                        $division
                                    );

                                    if (!mysqli_stmt_execute($stmtPersonnel)) {
                                        echo "Gagal menyimpan data ke tabel offset_personnel: " . mysqli_stmt_error($stmtPersonnel);
                                    } else {
                                        echo "Berhasil menyimpan personil: $name <br>";
                                    }

                                    mysqli_stmt_close($stmtPersonnel);
                                }
                            }

                            // Query INSERT ke tabel offset_materials
                            if (isset($_POST['nomor_part_material_offset'])) {
                                $partNumbers = $_POST['nomor_part_material_offset'] ?? [];
                                $brands = $_POST['merk_material_offset'] ?? [];
                                $descriptions = $_POST['deskripsi_material_offset'] ?? [];
                                $quantities = $_POST['kuantitas_material_offset'] ?? [];
                                $reviews = $_POST['review_material_offset'] ?? [];

                                foreach ($partNumbers as $index => $partNumber) {
                                    $brand = isset($brands[$index]) ? $brands[$index] : '';
                                    $description = isset($descriptions[$index]) ? $descriptions[$index] : '';
                                    $quantity = isset($quantities[$index]) ? $quantities[$index] : 0;
                                    $review = isset($reviews[$index]) ? $reviews[$index] : '';

                                    $queryMaterials = "INSERT INTO offset_materials (
                                                        offset_id,
                                                        part_number,
                                                        brand_type,
                                                        description,
                                                        quantity,
                                                        review_suggestions
                                                      ) VALUES (?, ?, ?, ?, ?, ?)";

                                    $stmtMaterials = mysqli_prepare($koneksi, $queryMaterials);
                                    mysqli_stmt_bind_param(
                                        $stmtMaterials,
                                        'isssis',
                                        $offsetId, // Menggunakan offset_id dari offset_activities
                                        $partNumber,
                                        $brand,
                                        $description,
                                        $quantity,
                                        $review
                                    );

                                    if (!mysqli_stmt_execute($stmtMaterials)) {
                                        echo "Gagal menyimpan data ke tabel offset_materials: " . mysqli_error($koneksi);
                                    } else {
                                        echo "Berhasil menyimpan material: $partNumber <br>";
                                    }
                                    mysqli_stmt_close($stmtMaterials);
                                }
                            }

                            // Query INSERT ke tabel articles_of_incorporation
                            $queryArticles = "INSERT INTO articles_of_incorporation (
                                                    articles_of_incorporation_path,
                                                    last_articles_of_incorporation_path
                                                ) VALUES (?, ?)";

                            $stmtArticles = mysqli_prepare($koneksi, $queryArticles); // Use a distinct variable for the statement
                            mysqli_stmt_bind_param(
                                $stmtArticles,
                                'ss',
                                $articlesofIncorporationPath,
                                $lastArticlesofIncorporationPath
                            );

                            // Execute the statement and handle errors correctly
                            if (!mysqli_stmt_execute($stmtArticles)) {
                                echo "Gagal menyimpan data ke tabel articles_of_incorporation: " . mysqli_error($koneksi);
                            } else {
                                echo "Berhasil menyimpan data ke tabel articles_of_incorporation.<br>";
                            }

                            // Get the last inserted ID for further operations
                            $articlesofIncorporationId = mysqli_insert_id($koneksi);

                            // Close the statement
                            mysqli_stmt_close($stmtArticles);

                            // Query INSERT ke tabel workshops
                            $queryWorkshops = "INSERT INTO workshops (company_id) VALUES (?)";
                            $stmtWorkshops = mysqli_prepare($koneksi, $queryWorkshops);
                            mysqli_stmt_bind_param($stmtWorkshops, 'i', $_SESSION['user_id']);

                            if (mysqli_stmt_execute($stmtWorkshops)) {
                                $workshopsId = mysqli_insert_id($koneksi); // Ambil workshops_id yang baru dibuat

                                // Query INSERT ke tabel workshop_branch
                                if (isset($_POST['nama_workshop'])) {
                                    $nameWorkshops = isset($_POST['nama_workshop']) ? $_POST['nama_workshop'] : [];
                                    $numberWorkshops = isset($_POST['nomor_telp_workshop']) ? $_POST['nomor_telp_workshop'] : [];

                                    foreach ($nameWorkshops as $index => $nameWorkshop) {
                                        $numberWorkshop = isset($numberWorkshops[$index]) ? $numberWorkshops[$index] : '';

                                        $queryWorkshopBranch = "
                                                                    INSERT INTO workshop_branch (
                                                                        workshop_name,
                                                                        workshops_id,
                                                                        phone_number
                                                                    ) VALUES (?, ?, ?)";

                                        $stmtWorkshopBranch = mysqli_prepare($koneksi, $queryWorkshopBranch);
                                        mysqli_stmt_bind_param(
                                            $stmtWorkshopBranch,
                                            'sis',
                                            $nameWorkshop,
                                            $workshopsId,
                                            $numberWorkshop
                                        );

                                        if (!mysqli_stmt_execute($stmtWorkshopBranch)) {
                                            echo "Gagal menyimpan data ke tabel workshop_branch: " . mysqli_error($koneksi) . "<br>";
                                        } else {
                                            echo "Berhasil menyimpan data workshop_branch: $nameWorkshop <br>";
                                        }
                                        mysqli_stmt_close($stmtWorkshopBranch);
                                    }
                                } else {
                                    echo "Data nama_workshop tidak ditemukan.";
                                }
                            } else {
                                echo "Gagal menyimpan data ke tabel workshops: " . mysqli_error($koneksi);
                            }

                            // Query INSERT ke tabel industries
                            $queryIndustries = "INSERT INTO industries (company_id) VALUES (?)";
                            $stmtIndustries = mysqli_prepare($koneksi, $queryIndustries);
                            mysqli_stmt_bind_param($stmtIndustries, 'i', $_SESSION['user_id']);

                            if (mysqli_stmt_execute($stmtIndustries)) {
                                $industriesId = mysqli_insert_id($koneksi); // Ambil industries_id yang baru dibuat

                                // Query INSERT ke tabel industries_branch
                                if (isset($_POST['nama_industri_yang_bekerja_sama'])) {
                                    $nameIndustries = $_POST['nama_industri_yang_bekerja_sama'] ?? [];
                                    $categoryIndustries = $_POST['kategori'] ?? [];
                                    $fieldOfCooperations = $_POST['bidang_kerja_sama'] ?? [];
                                    $documentLoaPoaFiles = $_FILES['dokumen_loapoa'] ?? [];

                                    // Upload Dokumen Loa&Poa
                                    $documentLoaPoaPaths = uploadFilesArray($documentLoaPoaFiles, $uploadDir);
                                    if (!empty($documentLoaPoaPaths['errors'])) {
                                        foreach ($documentLoaPoaPaths['errors'] as $error) {
                                            echo "Error: $error <br>";
                                        }
                                    }

                                    foreach ($nameIndustries as $index => $nameIndustrie) {
                                        $categoryIndustrie = $categoryIndustries[$index] ?? '';
                                        $fieldOfCooperation = $fieldOfCooperations[$index] ?? '';
                                        $documentLoaPoaPath = $documentLoaPoaPaths['uploaded'][$index] ?? '';

                                        $queryIndustrieBranch = "
                                                                INSERT INTO industries_branch (
                                                                    industries_id,
                                                                    company_id,
                                                                    industrie_name,
                                                                    category,
                                                                    field_of_cooperation,
                                                                    document_loapoa_path
                                                                ) VALUES (?, ?, ?, ?, ?, ?)";

                                        $stmtIndustrieBranch = mysqli_prepare($koneksi, $queryIndustrieBranch);
                                        mysqli_stmt_bind_param(
                                            $stmtIndustrieBranch,
                                            'iissss',
                                            $industriesId,
                                            $_SESSION['user_id'],
                                            $nameIndustrie,
                                            $categoryIndustrie,
                                            $fieldOfCooperation,
                                            $documentLoaPoaPath
                                        );

                                        if (!mysqli_stmt_execute($stmtIndustrieBranch)) {
                                            echo "Gagal menyimpan data ke tabel industries_branch: " . mysqli_error($koneksi) . "<br>";
                                        } else {
                                            echo "Berhasil menyimpan data industries_branch: $nameIndustrie <br>";
                                        }
                                        mysqli_stmt_close($stmtIndustrieBranch);
                                    }
                                } else {
                                    echo "Data nama_industri tidak ditemukan.";
                                }
                            } else {
                                echo "Gagal menyimpan data ke tabel industries: " . mysqli_error($koneksi);
                            }

                            // Query INSERT ke tabel report
                            $queryReport = "INSERT INTO report (
                                    workshops_id,
                                    management_id,
                                    financial_id,
                                    offset_id,
                                    facility_id,
                                    products_id,
                                    articles_of_incorporation_id,
                                    tech_id,
                                    company_id,
                                    icc_contract_id,
                                    industries_id
                                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                            $stmtReport = mysqli_prepare($koneksi, $queryReport);
                            mysqli_stmt_bind_param(
                                $stmtReport,
                                'iiiiiiiiiii', // All parameters are integers
                                $workshopsId,
                                $managementId,
                                $financialId,
                                $offsetId,
                                $facilityId,
                                $productsId,
                                $articlesofIncorporationId,
                                $techId,
                                $_SESSION['user_id'],
                                $iccContractId,
                                $industriesId
                                // Using user_id from session
                            );

                            if (mysqli_stmt_execute($stmtReport)) {
                                mysqli_stmt_close($stmtReport);
                                header("Location: ../user/userLaporan.php");
                                exit;
                            } else {
                                echo "Gagal menyimpan data ke tabel report: " . mysqli_error($koneksi);
                            }
                            header("Location: ../user/userLaporan.php");
                            exit;
                        }
                    } else {
                        echo "Gagal menyimpan data ke tabel offset_activities: " . mysqli_error($koneksi);
                    }
                } else {
                    echo "Gagal menyimpan data ke tabel production_facilities: " . mysqli_error($koneksi);
                }
            } else {
                echo "Gagal menyimpan data ke tabel technology_management: " . mysqli_error($koneksi);
            }
        } else {
            echo "Gagal menyimpan data ke tabel financial_management: " . mysqli_error($koneksi);
        }
    } else {
        echo "Gagal menyimpan data ke tabel company_management: " . mysqli_error($koneksi);
    }
} else {
    echo "Metode request tidak valid.";
}