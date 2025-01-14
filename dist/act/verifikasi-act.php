<?php
include "../config/koneksi.php"; // Pastikan koneksi database

// Pastikan koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah tombol Terima atau Tolak diklik
    if (isset($_POST['action']) && isset($_POST['verification_id'])) {
        $verification_id = $_POST['verification_id'];
        $action = $_POST['action'];
        $reason = isset($_POST['reason']) ? $_POST['reason'] : ''; // Ambil alasan penolakan

        // Cek status aksi, jika "Terima" update status dan kirim email
        if ($action == 'terima') {
            // Update status verifikasi menjadi "Diterima"
            $updateQuery = "UPDATE verification_requests SET status = 1 WHERE verification_id = ?";
            $stmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt, "i", $verification_id);
            $result = mysqli_stmt_execute($stmt);

            // Jika update sukses, kirim email
            if ($result) {
                // Ambil data user yang relevan
                $userQuery = "SELECT u.email, u.username, u.company_name 
                              FROM users u
                              JOIN verification_requests vr ON vr.user_id = u.user_id
                              WHERE vr.verification_id = ?";
                $userStmt = mysqli_prepare($conn, $userQuery);
                mysqli_stmt_bind_param($userStmt, "i", $verification_id);
                mysqli_stmt_execute($userStmt);
                $userResult = mysqli_stmt_get_result($userStmt);

                if ($userRow = mysqli_fetch_assoc($userResult)) {
                    $userEmail = $userRow['email'];
                    $username = $userRow['username'];
                    $company_name = $userRow['company_name'];

                    // Kirim email
                    $subject = "Pendaftaran Diterima - Username Anda";
                    $message = "Halo $company_name,\n\nPendaftaran Anda telah diterima. Berikut adalah username Anda untuk login:\n\nUsername: $username\n\nSilakan login di website kami.\n\nTerima kasih.";
                    $headers = "From: admin@example.com"; // Ganti dengan email admin

                    if (mail($userEmail, $subject, $message, $headers)) {
                        echo "Email berhasil dikirim ke $userEmail.";
                    } else {
                        echo "Gagal mengirim email.";
                    }
                }
            } else {
                echo "Gagal mengupdate status verifikasi.";
            }
        }
        
        // Jika aksi "Tolak", update status menjadi "Ditolak" dan kirim email dengan alasan
        else if ($action == 'tolak') {
            $updateQuery = "UPDATE verification_requests SET status = 2 WHERE verification_id = ?";
            $stmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmt, "i", $verification_id);
            mysqli_stmt_execute($stmt);

            // Ambil data user yang relevan
            $userQuery = "SELECT u.email, u.username, u.company_name 
                          FROM users u
                          JOIN verification_requests vr ON vr.user_id = u.user_id
                          WHERE vr.verification_id = ?";
            $userStmt = mysqli_prepare($conn, $userQuery);
            mysqli_stmt_bind_param($userStmt, "i", $verification_id);
            mysqli_stmt_execute($userStmt);
            $userResult = mysqli_stmt_get_result($userStmt);

            if ($userRow = mysqli_fetch_assoc($userResult)) {
                $userEmail = $userRow['email'];
                $company_name = $userRow['company_name'];

                // Kirim email penolakan
                $subject = "Pendaftaran Ditolak";
                $message = "Halo $company_name,\n\nPendaftaran Anda telah ditolak. Alasan penolakan: $reason\n\nJika Anda merasa ada kesalahan, silakan hubungi kami.\n\nTerima kasih.";
                $headers = "From: admin@example.com"; // Ganti dengan email admin

                if (mail($userEmail, $subject, $message, $headers)) {
                    echo "Email penolakan berhasil dikirim ke $userEmail.";
                } else {
                    echo "Gagal mengirim email penolakan.";
                }
            }
        }
    }
}

// Query untuk menampilkan data
$query = "SELECT 
            vr.verification_id, 
            u.user_id, 
            u.username, 
            u.company_name, 
            u.determination_letter_number, 
            u.determination_letter_number_path, 
            CASE 
                WHEN vr.status = 0 THEN 'Menunggu Keputusan' 
                WHEN vr.status = 1 THEN 'Diterima' 
                WHEN vr.status = 2 THEN 'Ditolak' 
                ELSE 'Status Tidak Diketahui' 
            END AS status_verifikasi
          FROM verification_requests vr
          JOIN users u ON vr.user_id = u.user_id";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    // Menampilkan data dalam tabel HTML
    while ($row = mysqli_fetch_assoc($result)) {
        // Periksa apakah data surat penetapan ada
        $determinationLetterLink = !empty($row['determination_letter_number_path']) ? 
            '<a href="../uploads/' . htmlspecialchars($row['determination_letter_number_path']) . '" target="_blank">Lihat Surat</a>' : 
            'Tidak ada surat';

        echo "<tr>
                <td>{$row['verification_id']}</td>
                <td>{$row['user_id']}</td>
                <td>{$row['username']}</td>
                <td>{$row['company_name']}</td>
                <td>{$row['determination_letter_number']}</td>
                <td>{$determinationLetterLink}</td>
                <td>{$row['status_verifikasi']}</td>
                <td>
                    <form method='POST'>
                        <input type='hidden' name='verification_id' value='{$row['verification_id']}'>
                        <div class='form-group'>
                            <label for='reason'>Alasan Penolakan</label>
                            <textarea class='form-control' id='reason' name='reason' rows='3' placeholder='Masukkan alasan penolakan'></textarea>
                        </div>
                        <button type='submit' name='action' value='terima' class='btn btn-success'>Terima</button>
                        <button type='submit' name='action' value='tolak' class='btn btn-danger'>Tolak</button>
                    </form>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='7' class='text-center'>Tidak ada data tersedia</td></tr>";
}

// Tutup koneksi
mysqli_close($conn);
?>
