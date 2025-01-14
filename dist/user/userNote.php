<?php
session_start();
include '../config/koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

$id_report = isset($_GET['id_report']) ? intval($_GET['id_report']) : null;
$user_id = $_SESSION['user_id'];

$notesDetail = [];
if ($id_report !== null) {
    $sql = "SELECT id_note, company_id, id_report, note, date FROM note WHERE id_report = ? AND company_id = ?";
    $stmt = $koneksi->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $koneksi->error);
    }

    $stmt->bind_param("ii", $id_report, $user_id);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $notesDetail[] = $row;
        }
    } else {
        echo "<p>Debug: No data found for id_report = $id_report and user_id = $user_id</p>";
    }
}

?>

<!DOCTYPE html>
<html>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="sb-nav-fixed">
    <?php include "../nav/navbar.php"; ?>
    <main>
        <div class="wrap" style="margin-left: 47px; margin-right: 47px;">
            <div class="container-fluid px-4">
                <h3 style="color:#152C5B;" class="mt-4">Laporan > Pesan</h3>
                <ol class="breadcrumb mb-4"></ol>
                <div class="container mt-4">
                    <?php if (!empty($notesDetail)): ?>
                        <?php foreach ($notesDetail as $note): ?>
                            <div class="card mb-4 shadow-lg border-0" style="border-radius: 10px;">
                                <h5 class="card-header bg-info text-white" style="border-radius: 10px 10px 0 0;">Pesan</h5>
                                <div class="card-body">
                                    <p class="card-text"><strong>ID Note:</strong> <?php echo htmlspecialchars($note['id_note']); ?></p>
                                    <p class="card-text"><strong>Note:</strong> <?php echo htmlspecialchars($note['note']); ?></p>
                                    <p class="card-text"><strong>Tanggal:</strong> <?php echo htmlspecialchars($note['date']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center">Tidak ada data yang tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</body>

</html>