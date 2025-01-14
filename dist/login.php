<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/img/logo-proyek-tanpa-teks.png" rel="shortcut icon">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: url('assets/img/bg-login-signup.png') no-repeat center center fixed;
            background-size: cover;
            /* background-color: rgb(103, 88, 74); */
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(103, 88, 74, 0.7);
            z-index: 1;
        }

        .form-control {
            padding: 10px 15px;
        }
    </style>
</head>

<body>
    <!-- Overlay -->
    <div class="overlay">
        <div class="d-flex align-items-center justify-content-center vh-100">
            <div id="layoutAuthentication" class="col-lg-4 col-md-6">
                <?php if (isset($_GET['error'])) : ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($_GET['error']) ?>
                    </div>
                <?php endif; ?>
                <form method="post" action="config/authen.php">
                    <div class="mb-3">
                        <label class="form-label text-white" for="inputUser"><strong>Username</strong></label>
                        <input class="form-control" id="inputUser" name="username" type="text" placeholder="Masukkan username" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-white" for="inputPassword"><strong>Password</strong></label>
                        <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Masukkan password" />
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="showPassword" onclick="togglePassword()" />
                        <label class="form-check-label text-white" for="showPassword">Show Password</label>
                    </div>
                    <div class="justify-content-center mb-3 mt-5">
                        <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="justify-content-center">
                        <a class="link-light" href="signup.php">Sign Up</a>
                    </div>
                </form>
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