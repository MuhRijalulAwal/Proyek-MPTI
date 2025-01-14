<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <!-- Link to Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Link to Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="assets/img/logo-proyek-tanpa-teks.png" rel="shortcut icon">
</head>

<body style="background: url('assets/img/bg-login-signup.png') no-repeat center center; background-size: cover;">
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <div class="container mt-3 mb-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-header text-white text-center" style="background-color: #C5AF9A;">
                        <h3>Form Pendaftaran</h3>
                    </div>
                    <div class="card-body p-3">
                        <form method="post" action="act/signup-act.php" enctype="multipart/form-data">
                            <div class="mb-2">
                                <label for="company_name" class="form-label">Nama Indhan</label>
                                <input type="text" class="form-control form-control-sm" id="company_name" name="company_name" placeholder="Masukkan Nama Indhan" required>
                            </div>
                            <div class="mb-2">
                                <label for="company_address" class="form-label">Alamat</label>
                                <textarea class="form-control form-control-sm" id="company_address" name="company_address" rows="2" placeholder="Masukkan Alamat Lengkap" required></textarea>
                            </div>
                            <div class="mb-2">
                                <label for="determination_letter_number" class="form-label">Nomor Surat Penetapan</label>
                                <input type="text" class="form-control form-control-sm" id="determination_letter_number" name="determination_letter_number" placeholder="Masukkan Nomor Surat" required>
                            </div>
                            <div class="mb-2">
                                <label for="determination_letter_number_path" class="form-label">Dokumen Surat Penetapan</label>
                                <input type="file" class="form-control form-control-sm" id="determination_letter_number_path" name="determination_letter_number_path" required>
                                <small class="form-text text-muted">Hanya file PDF, JPG, JPEG, atau PNG yang diperbolehkan (maksimal 2MB).</small>
                            </div>
                            <div class="mb-2">
                                <label for="username" class="form-label">Username</label>
                                <small class="form-label text-secondary" for="inputUser">*Username tidak boleh ada spasi</small>
                                <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Masukkan Username Indhan" required>
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Masukkan email" required>
                            </div>
                            <div class="mb-2">
                                <label for="phone_number" class="form-label">No. Handphone</label>
                                <input type="text" class="form-control form-control-sm" id="phone_number" name="phone_number" placeholder="Masukkan No. Handphone" required>
                            </div>
                            <div class="mb-2">
                                <label for="password_hash" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-sm" id="password_hash" name="password_hash" placeholder="Masukkan password" required>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="togglePassword('password_hash', this)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control form-control-sm" id="confirmPassword" name="confirmPassword" placeholder="Konfirmasi password" required>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="togglePassword('confirmPassword', this)">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn text-white btn-sm w-100" style="background-color: #C5AF9A;">Daftar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pop-up -->
    <div class="modal fade" id="signupSuccessModal" tabindex="-1" aria-labelledby="signupSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="signupSuccessModalLabel">Pendaftaran Berhasil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Data yang Anda kirimkan sedang dalam proses verifikasi oleh admin.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script>
        function togglePassword(inputId, toggleButton) {
            const inputField = document.getElementById(inputId);
            const icon = toggleButton.querySelector('i');
            if (inputField.type === 'password') {
                inputField.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                inputField.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'success') {
                const myModal = new bootstrap.Modal(document.getElementById('signupSuccessModal'));
                myModal.show();
                document.getElementById('signupSuccessModal').addEventListener('hidden.bs.modal', () => {
                    window.location.href = "login.php";
                });
            }
        };
    </script>
</body>

</html>