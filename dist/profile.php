<?php
session_start(); // Memastikan session dimulai
include 'config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ambil data perusahaan berdasarkan user_id
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM companies WHERE user_id = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$company = mysqli_fetch_assoc($result);

// Ambil data cabang perusahaan berdasarkan company_id
$queryBranch = "SELECT company_branch_address FROM company_branch WHERE company_id = ?";
$stmtBranch = mysqli_prepare($koneksi, $queryBranch);
mysqli_stmt_bind_param($stmtBranch, "i", $user_id);
mysqli_stmt_execute($stmtBranch);
$resultBranch = mysqli_stmt_get_result($stmtBranch);

$company_address_branch = [];
while ($rowBranch = mysqli_fetch_assoc($resultBranch)) {
    $company_address_branch[] = $rowBranch['company_branch_address'];
}

// Tutup statement
mysqli_stmt_close($stmt);
mysqli_stmt_close($stmtBranch);
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

<style>
    .navbar-active {
        background-color: rgba(22, 19, 19, 0.2);
        /* Warna latar belakang untuk item aktif */
    }

    #notificationPopup {
        border-radius: 8px;
        background-color: #ffffff;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        max-height: 400px;
        overflow-y: auto;
    }
</style>

<style>
    .rounded-circle {
        transition: transform 0.3s ease;
    }

    .rounded-circle:hover {
        transform: scale(1.05);
    }

    #previewImg {
        transition: opacity 0.3s ease;
    }

    .position-absolute {
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }
</style>

<style>
    .custom-file-input:focus+.btn {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }
</style>

<style>
    .custom-file-input:lang(en)::after {
        content: none;
    }

    .custom-file-input:lang(en)::before {
        content: none;
    }

    .custom-file-label {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

<body>
    <?php
    include "nav/navbar.php"
    ?>

    <div class="container mx-6 mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
        <main>
            <form action="act/profile-act.php" enctype="multipart/form-data" method="POST">
                <div class="mx-5 mb-5">
                    <div class="row justify-content-center">
                        <div class="col-12 text-center mb-3">
                            <h4 style="color:#152C5B;">Profil Industri Pertahanan</h4>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <!-- Circular Image Container -->
                                    <div class="mx-auto mb-3" style="width: 200px; height: 200px; position: relative;">
                                        <div class="rounded-circle overflow-hidden position-relative" style="width: 100%; height: 100%;">
                                            <img src="uploads/logos/<?php echo $company['company_logo_path'] ?>" id="previewImg" class="w-100 h-100" style="object-fit: cover;" alt="Profil Industri Pertahanan">

                                            <!-- Overlay Upload -->
                                            <div class="position-absolutes position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center" style="opacity: 0; transition: opacity 0.3s;">
                                                <span class="text-white"><i class="fas fa-camera"></i> Ubah Foto</span>
                                            </div>
                                            <input hidden type="file" class="custom-file-input position-absolutes position-absolute" id="logoUpload" name="company_logo_path" accept="image/*" value="uploads/logos/<?php echo $company['company_logo_path'] ?>" style="opacity: 0;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="row mb-3">
                    <label for="inputEmail" class="text-secondary col-sm-4 col-form-label text-start">Email</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputEmail" name="email" placeholder="" value="<?php echo $company['email']; ?>" readonly>
                    </div>
                </div>

                <!-- Nama Indhan -->
                <div class="row mb-3">
                    <label for="inputNamaIndhan" class=" text-secondary col-sm-4 col-form-label text-start">Nama Indhan</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputNamaIndhan" name="company_name" placeholder="" value="<?php echo $company['company_name']; ?>" readonly>
                    </div>
                </div>

                <!-- URL Website -->
                <div class="row mb-3">
                    <label for="inputWebsite" class=" text-secondary col-sm-4 col-form-label text-start">URL Website</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputWebsite" name="url_website" placeholder="" value="<?php echo $company['url_website']; ?>" readonly>
                    </div>
                </div>

                <!-- Nomor Induk Berusaha -->
                <div class="row mb-3">
                    <label for="inputCompanyNib" class=" text-secondary col-sm-4 col-form-label text-start">Nomor Induk Berusaha</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="inputCompanyNib" name="company_nib" placeholder="" value="<?php echo $company['company_nib']; ?>" readonly>
                    </div>
                </div>

                <!-- Informasi Perusahaan -->
                <div class="row mb-3">
                    <label for="indhanInfo" class=" text-secondary col-sm-4 col-form-label text-start">Informasi Perusahaan</label>
                    <div class="col-sm-6">
                        <select class="form-select" id="indhanInfo" name="company_information" value="<?php echo $company['company_information']; ?>" disabled>
                            <option value="<?php echo $company['company_information']; ?>" selected><?php echo $company['company_information']; ?></option>
                            <option value="Memiliki Akun Sistem Informasi Industri Nasional (SIINAS)">Memiliki Akun Sistem Informasi Industri Nasional (SIINAS)</option>
                            <option value="Sudah Terdaftar di OSS (Online Single Submission)">Sudah Terdaftar di OSS (Online Single Submission)</option>
                        </select>
                    </div>
                </div>

                <!-- Penetapan Indhan -->
                <div class="row mb-3">
                    <label for="indhanAssignment" class=" text-secondary col-sm-4 col-form-label text-start">Penetapan Indhan</label>
                    <div class="col-sm-6">
                        <select class="form-select" id="indhanAssignment" name="company_assignment" value="<?php echo $company['company_assignment']; ?>" disabled>
                            <option value="<?php echo $company['company_assignment']; ?>" selected><?php echo $company['company_assignment']; ?></option>
                            <option value="Manual">Manual</option>
                            <option value="OSS">OSS</option>
                        </select>
                    </div>
                </div>

                <!-- Alamat Utama -->
                <div class="row mb-3">
                    <label for="mainAddress" class="text-secondary col-sm-4 col-form-label text-start">Alamat Utama Indhan</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" id="mainAddress" name="company_main_address" placeholder="" readonly><?php echo htmlspecialchars($company['company_main_address'], ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                </div>

                <!-- Nomor Telepon Utama -->
                <div class="row mb-3 form-group">
                    <label for="mainPhone" class="text-secondary col-sm-4 col-form-label text-start">Nomor Telepon Utama</label>
                    <div class="class col-sm-6">
                        <input type="tel" class="form-control" id="mainPhone" name="main_number" placeholder="" value="<?php echo $company['main_number']; ?>" pattern="[0-9]{10,13}" readonly>
                    </div>
                </div>

                <!-- Kategori Indhan -->
                <div class="row mb-3">
                    <label for="companyCategory" class=" text-secondary col-sm-4 col-form-label text-start">Kategori Indhan (BUMN/BUMS)</label>
                    <div class="col-sm-6">
                        <select class="form-select" id="companyCategory" name="company_category" value="<?php echo $company['company_category']; ?>" disabled>
                            <option value="<?php echo $company['company_category']; ?>" selected><?php echo $company['company_category']; ?></option>
                            <option value="BUMN">BUMN</option>
                            <option value="BUMS">BUMS</option>
                        </select>
                    </div>
                </div>

                <div id="alamatContainer">
                    <!-- Alamat Cabang -->
                    <?php foreach ($company_address_branch as $index => $address): ?>
                        <div class="row mb-3">
                            <p class="mb-3"><strong>Alamat Cabang <?php echo $index + 1; ?></strong></p>
                            <label class="text-secondary col-sm-4 col-form-label text-start">Alamat Kantor Cabang</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" readonly><?php echo htmlspecialchars($address, ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Tombol Tambah Alamat -->
                <div class="row mb-3">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-6">
                        <button type="button" id="addAlamat" class="btn btn-link" style="font-size: 15px;">+ Tambah Alamat</button>
                    </div>
                </div>

                <!-- Simpan & Edit -->
                <div class="row mb-3 mt-5 justify-content-end">
                    <div class="col-3 text-end">

                    </div>
                    <div class="col-3 text-center">
                        <button type="submit" class="btn btn-outline-success" style="width: 100px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                                <path d="M11 2H9v3h2z" />
                                <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z" />
                            </svg>
                            Simpan
                        </button>
                    </div>
                    <div class="col-3 text-center">
                        <button type="button" id="toggleAllEdit" class="btn btn-outline-secondary" style="width: 100px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                            </svg>
                            Edit
                        </button>
                    </div>
                    <div class="col-3 text-end">

                    </div>
                </div>
            </form>
        </main>
    </div>

    <!-- Toast untuk notifikasi -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Perhatian</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <!-- Pesan error akan ditampilkan di sini -->
            </div>
        </div>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageContainer = document.querySelector('.rounded-circle');
        const logoUpload = document.getElementById('logoUpload');
        const previewImg = document.getElementById('previewImg');
        const overlay = document.querySelector('.position-absolutes');

        // Fungsi untuk membuka file picker
        function openFilePicker() {
            logoUpload.click();
        }

        // // Tambahkan event listener klik pada container gambar
        // imageContainer.addEventListener('click', openFilePicker);

        // Hover effect
        imageContainer.addEventListener('mouseenter', function() {
            overlay.style.opacity = '1';
            imageContainer.style.cursor = 'pointer';
        });
        imageContainer.addEventListener('mouseleave', function() {
            overlay.style.opacity = '0';
        });

        logoUpload.addEventListener('change', function(event) {
            const file = event.target.files[0];

            if (file) {
                // Validasi tipe file
                const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!validImageTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Harap unggah file gambar yang valid (JPEG, PNG, GIF, atau WebP)'
                    });
                    this.value = '';
                    return;
                }

                // Validasi ukuran file (maks 5MB)
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ukuran File Terlalu Besar',
                        text: 'Maksimal ukuran file adalah 5MB'
                    });
                    this.value = '';
                    return;
                }

                // Baca dan tampilkan gambar
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Animasi transisi gambar
                    previewImg.style.opacity = '0';
                    setTimeout(() => {
                        previewImg.src = e.target.result;
                        previewImg.style.opacity = '1';
                    }, 300);
                }
                reader.readAsDataURL(file);
            }
        });

        // Tambahkan event listener pada overlay
        overlay.addEventListener('click', openFilePicker);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let addressCounter = 2; // Counter untuk menghitung jumlah alamat

        document.getElementById('addAlamat').addEventListener('click', function() {
            // Elemen kontainer alamat
            const alamatContainer = document.getElementById('alamatContainer');

            // Elemen baru untuk alamat
            const newAlamat = document.createElement('div');
            newAlamat.className = 'alamat-item mb-3';
            newAlamat.innerHTML = `
                <p class="mb-3"><strong>Alamat Cabang ${addressCounter}</strong></p>
                <!-- Alamat Kantor Cabang Indhan -->
                <div class="row mb-3">
                    <label for="inputText${addressCounter}" class="text-secondary col-sm-4 col-form-label text-start">Alamat Kantor Cabang Indhan</label>
                    <div class="col-sm-6">
                        <textarea type="text" class="form-control" id="inputText${addressCounter}" name="company_address_branch[]" placeholder=""></textarea>
                    </div>
                </div>
            `;

            // Tambahkan elemen baru ke kontainer
            alamatContainer.appendChild(newAlamat);

            // Increment counter
            addressCounter++;
        });
    });
</script>
<!-- Sweet Alert untuk notifikasi yang lebih cantik -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleEditButton = document.getElementById("toggleAllEdit");
        const saveButton = document.querySelector('button[type="submit"]');
        const formElements = document.querySelectorAll(
            "input, textarea, select"
        );

        // Mulai dalam kondisi read-only
        saveButton.disabled = true;

        // Fungsi untuk mengaktifkan atau menonaktifkan input
        function toggleFormEditable(enable) {
            formElements.forEach((element) => {
                if (enable) {
                    element.removeAttribute("readonly");
                    element.removeAttribute("disabled");
                } else {
                    element.setAttribute("readonly", true);
                    if (element.tagName === "SELECT") {
                        element.setAttribute("disabled", true);
                    }
                }
            });
        }

        // Event untuk tombol Edit
        toggleEditButton.addEventListener("click", function() {
            const isEditing = saveButton.disabled === false;

            if (!isEditing) {
                // Masuk ke mode edit
                toggleFormEditable(true);
                saveButton.disabled = false;
                toggleEditButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zm-1 1H3v12h10V2z"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                </svg>
                Batal
            `;
            } else {
                // Keluar dari mode edit
                toggleFormEditable(false);
                saveButton.disabled = true;
                toggleEditButton.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                </svg>
                Edit
            `;
            }
        });
    });
</script>

</html>