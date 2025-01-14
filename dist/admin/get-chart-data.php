<?php
header('Content-Type: application/json');

include "../config/koneksi.php";

if ($koneksi->connect_error) {
    die(json_encode(["error" => "Koneksi gagal: " . $koneksi->connect_error]));
}

// Tentukan parameter untuk query
$type = isset($_GET['type']) ? $_GET['type'] : 'category';

if ($type === 'category') {
    $sql = "
        SELECT company_category AS label, COUNT(*) AS value 
        FROM companies 
        GROUP BY company_category
    ";
} elseif ($type === 'assignment') {
    $sql = "
        SELECT company_assignment AS label, COUNT(*) AS value 
        FROM companies 
        GROUP BY company_assignment
    ";
} elseif ($type === 'product_group') {
    $sql = "
        SELECT product_group AS label, COUNT(*) AS value 
        FROM products 
        GROUP BY product_group
    ";
} elseif ($type === 'classification_name_alat_utama') {
    $sql = "
        SELECT classification_name AS label, COUNT(*) AS value 
        FROM product_classifications 
        WHERE classification_name IN (
            'Senjata, Munisi', 
            'Bom', 
            'Roket', 
            'Pesawat Terbang', 
            'Perkapalan dan Kemaritiman', 
            'Kendaraan', 
            'Radar dan Navigasi', 
            'Alkapsus', 
            'Kaporlap', 
            'MRO Alutsista/Alpalhankam'
        )
        GROUP BY classification_name
    ";
} elseif ($type === 'classification_name_komponen_utama') {
    $sql = "
        SELECT classification_name AS label, COUNT(*) AS value 
        FROM product_classifications 
        WHERE classification_name IN (
            'FAS LAN/Jembatan', 
            'FAS LAN/PUMP INS AIR', 
            'Alat Komunikasi', 
            'Alat Kesehatan', 
            'PAL/Alat Ukur', 
            'IT, Simulator, Along dan Alongins', 
            'Sistem Listrik dan Energi', 
            'Kendaraan Atas Air' 
        )
        GROUP BY classification_name
    ";
} elseif ($type === 'classification_name_komponen_pendukung') {
    $sql = "
        SELECT classification_name AS label, COUNT(*) AS value 
        FROM product_classifications 
        WHERE classification_name IN (
            'Perbekalan', 
            'Suku Cadang', 
            'FAS Pendukung' 
        )
        GROUP BY classification_name
    ";
} elseif ($type === 'classification_name_bahan_baku') {
    $sql = "
        SELECT classification_name AS label, COUNT(*) AS value 
        FROM product_classifications 
        WHERE classification_name = 'Bahan Baku'
        GROUP BY classification_name
    ";
}

$result = $koneksi->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
$koneksi->close();
