<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>SignUp - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/img/logo-proyek-tanpa-teks.png" rel="shortcut icon">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            background: url('assets/img/bg-login-signup.png') no-repeat center center fixed;
            background-size: cover;
        }

        #layoutAutchentication {
            z-index: 2;
        }
    </style>
</head>

<body>
    <div class="container-fluid h-100 d-flex align-items-center justify-content-center">
        <div class="row px-sm-5">
            <div class="col-6 d-flex flex-column justify-content-center px-sm-5">
                <div class="row">
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-body">
                                <p style="text-align: center;">
                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quibusdam harum veniam similique ducimus molestias,
                                    laborum mollitia rerum consequuntur magni impedit non doloremque dolore sed debitis. Beatae consequatur in
                                    facilis accusantium!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3">
                        <div class="card">
                            <div class="card-body">
                                <p style="text-align: center;">
                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quibusdam harum veniam similique ducimus molestias,
                                    laborum mollitia rerum consequuntur magni impedit non doloremque dolore sed debitis. Beatae consequatur in
                                    facilis accusantium!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 px-sm-5">
                <div id="layoutAutchentication">
                    <div class="my-5">
                        <form method="post" action="act/signup-act2.php" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label text-white" for="inputNamaIndhan"><strong>Nama Indhan</strong></label>
                                <input class="form-control" id="inputNamaIndhan" name="nama_indhan" type="text" placeholder="Masukkan Nama Indhan" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-white" for="inputAlamat"><strong>Alamat</strong></label>
                                <textarea class="form-control" id="inputAlamat" name="alamat" placeholder="Masukkan Alamat Lengkap Indhan" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-white" for="inputNomorSurat"><strong>Nomor Surat Penetapan</strong></label>
                                <input class="form-control" id="inputNomorSurat" name="nomor_surat" type="text" placeholder="Masukkan Nomor Surat" required />
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-white" for="inputDokumen"><strong>Dokumen Surat Penetapan</strong></label>
                                <input class="text-secondary form-control" id="inputDokumen" name="dokumen" type="file" required />
                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary w-25" type="submit">Daftar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        function togglePassword() {
            var passwordInput = document.getElementById("inputPassword");
            var showPasswordCheckbox = document.getElementById("showPassword");
            if (showPasswordCheckbox.checked) {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</body>

</html>