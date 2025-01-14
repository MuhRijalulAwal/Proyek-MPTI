<?php

$user_id = $_SESSION['user_id'];
$current_path = $_SERVER['PHP_SELF'];
$home_url = '';
$tentang_pothan_url = '';
$tentang_dittekindhan_url = '';
$tentang_subditindhan_url = '';
$data_laporan_url = '';
$tambah_laporan_url = '';
$tentang_url = '';
$profile_url = '';
$logout_url = '';
$logo_url = '';

// Menentukan URL berdasarkan path saat ini
if (strpos($current_path, '/dist/user/') !== false) {
    $home_url = '../index.php';
    $data_laporan_url = './userLaporan.php';
    $tambah_laporan_url = './userTambahLaporan.php';
    $tentang_pothan_url = '../about-pothan.php';
    $tentang_dittekindhan_url = '../about-dittekindhan.php';
    $tentang_subditindhan_url = '../about-subditindhan.php';
    $profile_url = '../profile.php';
    $logout_url = '../logout.php';
    $logo_url = '../assets/img/logo-proyek-teks.png';
} elseif (strpos($current_path, '/dist/admin') !== false) {
    $home_url = '../index.php';
    $data_laporan_url = './userLaporan.php';
    $tambah_laporan_url = './userTambahLaporan.php';
    $tentang_pothan_url = '../about-pothan.php';
    $tentang_dittekindhan_url = '../about-dittekindhan.php';
    $tentang_subditindhan_url = '../about-subditindhan';
    $profile_url = '../profile.php';
    $logout_url = '../logout_url.php';
    $logo_url = '../assets/img/logo-proyek-teks.png';
} elseif (strpos($current_path, '/dist/') !== false) {
    $home_url = 'index.php';
    $data_laporan_url = 'user/userLaporan.php';
    $tambah_laporan_url = 'user/userTambahLaporan.php';
    $tentang_pothan_url = 'about-pothan.php';
    $tentang_dittekindhan_url = 'about-dittekindhan.php';
    $tentang_subditindhan_url = 'about-subditindhan.php';
    $profile_url = 'profile.php';
    $logout_url = 'logout.php';
    $logo_url = 'assets/img/logo-proyek-teks.png';
} else {
    $home_url = 'index.php';
    $data_laporan_url = 'userLaporan.php';
    $tambah_laporan_url = 'userTambahLaporan.php';
    $tentang_pothan_url = 'about-pothan.php';
    $tentang_dittekindhan_url = 'about-dittekindhan.php';
    $tentang_subditindhan_url = 'about-subditindhan.php';
    $profile_url = 'profile.php';
    $logout_url = 'logout.php';
    $logo_url = 'assets/img/logo-proyek-teks.png';
}

// Ambil notifikasi dari admin
$sql_notif = "SELECT id_note, note, is_read, date FROM note WHERE company_id = ? ORDER BY date DESC";
$stmt_notif = $koneksi->prepare($sql_notif);
$stmt_notif->bind_param("i", $user_id);
$stmt_notif->execute();
$result_notif = $stmt_notif->get_result();

$notes = [];
$unread_count = 0;
while ($row = $result_notif->fetch_assoc()) {
    $notes[] = $row;
    if ($row['is_read'] == 0) {
        $unread_count++;
    }
}

// Jika pengguna menandai semua sebagai sudah dibaca
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_as_read'])) {
    $update_sql = "UPDATE note SET is_read = 1 WHERE company_id = ?";
    $update_stmt = $koneksi->prepare($update_sql);
    $update_stmt->bind_param("i", $user_id);
    $update_stmt->execute();

    // Tarik ulang notifikasi
    $stmt_notif->execute();
    $result_notif = $stmt_notif->get_result();
    $notes = [];
    $unread_count = 0;
    while ($row = $result_notif->fetch_assoc()) {
        $notes[] = $row;
        if ($row['is_read'] == 0) {
            $unread_count++;
        }
    }
}
mysqli_close($koneksi);
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary shadow" style="background-color: #C5AF9A;">
    <div class="container-fluid mx-5">
        <a class="brand my-1" href="<?php echo $home_url; ?>">
            <img src="<?php echo $logo_url; ?>" alt="logo-proyek" style="padding-bottom:0.50px 10px; width: 54px; height: 54px;">
            <img src="https://www.kemhan.go.id/pothan/wp-content/themes/pothan/images/logo.png" alt="logo-kemhan" style="padding-bottom:0.50px 10px; width: 54px; height: 54px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item px-2">
                    <a class="nav-link <?php echo ($current_path == 'index.php') ? 'navbar-active' : ''; ?>" href="<?php echo $home_url; ?>">Beranda</a>
                </li>
                <li class="nav-item dropdown px-2">
                    <a class="nav-link dropdown-toggle <?php echo (in_array($current_path, ['userLaporan.php', 'userTambahLaporan.php'])) ? 'navbar-active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Laporan
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $data_laporan_url; ?>">Data Laporan</a></li>
                        <li><a class="dropdown-item" href="<?php echo $tambah_laporan_url; ?>">Tambah Laporan</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown px-2">
                    <a class="nav-link dropdown-toggle <?php echo (in_array($current_path, ['about-pothan.php', 'about-dittekindhan.php', 'about-subditindhan.php'])) ? 'navbar-active' : ''; ?>" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Tentang
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?php echo $tentang_pothan_url; ?>">Pothan</a></li>
                        <li><a class="dropdown-item" href="<?php echo $tentang_dittekindhan_url; ?>">Dit Tekindhan</a></li>
                        <li><a class="dropdown-item" href="<?php echo $tentang_subditindhan_url; ?>">Subditindhan</a></li>
                    </ul>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item dropdown px-2">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><Strong><?php echo htmlspecialchars($_SESSION['username']); ?></Strong></a></a>
                        <ul class="dropdown-menu">
                            <li class="nav-item px-2">
                                <a class="nav-link" href="<?php echo $profile_url; ?>">Profile</a>
                                <a class="nav-link" href="<?php echo $logout_url; ?>">Logout</a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>

                <?php endif; ?>

                <li class="nav-item px-2 position-relative">
                    <a class="nav-link" href="#" id="notificationIcon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell-fill" viewBox="0 0 16 16">
                            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901" />
                        </svg>
                        <?php if ($unread_count > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php echo $unread_count; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    <div id="notificationPopup" class="card shadow-lg position-absolute end-0 mt-2 p-3" style="width: 300px; display: none; z-index: 1050;">
                        <h6 class="card-title">Notifikasi</h6>
                        <ul class="list-group">
                            <?php if (!empty($notes)): ?>
                                <?php foreach ($notes as $note): ?>
                                    <li class="list-group-item <?php echo $note['is_read'] ? '' : 'fw-bold'; ?>">
                                        <?php echo htmlspecialchars($note['note']); ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li class="list-group-item text-center">Tidak ada notifikasi baru</li>
                            <?php endif; ?>
                        </ul>
                        <form method="POST">
                            <button type="submit" name="mark_as_read" class="btn btn-primary btn-sm mt-2 w-100">Tandai semua sudah dibaca</button>
                        </form>
                    </div>
                </li>
                <script>
                    // Tampilkan / Sembunyikan notifikasi
                    document.getElementById('notificationIcon').addEventListener('click', function(e) {
                        e.preventDefault();
                        const popup = document.getElementById('notificationPopup');
                        popup.style.display = (popup.style.display === 'none' || popup.style.display === '') ? 'block' : 'none';
                    });

                    // Tutup pop-up jika klik di luar area
                    document.addEventListener('click', function(e) {
                        const popup = document.getElementById('notificationPopup');
                        const icon = document.getElementById('notificationIcon');
                        if (!icon.contains(e.target) && !popup.contains(e.target)) {
                            popup.style.display = 'none';
                        }
                    });
                </script>
            </ul>
        </div>
    </div>
</nav>