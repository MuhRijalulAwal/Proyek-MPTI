<?php

echo '<pre>';
print_r($_POST);
echo '</pre>';

include "../config/koneksi.php";

$nama_obat = $_POST['nama_obat'] ?? null;
$kategori = $_POST['kategori'] ?? null;
$stok = $_POST['stok'] ?? null;
$pedoman_pemakaian = $_POST['pedoman_pemakaian'] ?? null;
$efek_samping = $_POST['efek_samping'] ?? null;
$harga = $_POST['harga'] ?? null;

// if (@$_GET['id_anggota']) {
//     $id = $_GET['id_anggota'];
//     mysqli_query($koneksi, "DELETE FROM anggota WHERE id_anggota = '$id'");
// } elseif (@$_POST['id_anggota']){
//     $id = $_POST['id_anggota'];
//     $query = "UPDATE anggota SET
//         nama_anggota = '$nama_anggota',
//         alamat = '$alamat',
//         email = '$email',
//         telp = '$telp',
//         jk = '$jk'
//         WHERE id_anggota = '$id'
//     ";
//     mysqli_query($koneksi, $query) or die (mysqli_error($koneksi));
// } else {
//     $query = "INSERT INTO anggota (nama_anggota, alamat, email, telp, jk) VALUES ('$nama_anggota', '$alamat', '$email', '$telp', '$jk')";
//     mysqli_query($koneksi, $query) or die (mysqli_error($koneksi));
// }

// header('Location:anggota_read.php');
//


if (@$_GET['id_obat']) {
    // $query = "INSERT INTO obat_sampah (nama_obat, kategori, stok, pedoman_pemakaian, efek_samping, harga) 
    //             VALUES ('$nama_obat', '$kategori', '$stok', '$pedoman_pemakaian', '$efek_samping', '$harga')";
    // $id = $_GET['id_obat'];
    // mysqli_query($koneksi, $query) or die (mysqli_error($koneksi));
    // mysqli_query($koneksi, "DELETE FROM obat WHERE id_obat = '$id'") or die (mysqli_error($koneksi));
    // header('Location: ../obat-tersedia.php');

    $id = $_GET['id_obat'];

    // Select the data from the obat table
    $result = mysqli_query($koneksi, "SELECT * FROM obat WHERE id_obat = '$id'") or die(mysqli_error($koneksi));
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $id_obat = $row['id_obat'];
        $nama_obat = $row['nama_obat'];
        $kategori = $row['kategori'];
        $stok = $row['stok'];
        $pedoman_pemakaian = $row['pedoman_pemakaian'];
        $efek_samping = $row['efek_samping'];
        $harga = $row['harga'];

        // Insert the data into obat_sampah table
        $query = "INSERT INTO obat_sampah (id_obat, nama_obat, kategori, stok, pedoman_pemakaian, efek_samping, harga) 
                  VALUES ('$id_obat', '$nama_obat', '$kategori', '$stok', '$pedoman_pemakaian', '$efek_samping', '$harga')";
        mysqli_query($koneksi, $query) or die(mysqli_error($koneksi));

        // Delete the record from the obat table
        mysqli_query($koneksi, "DELETE FROM obat WHERE id_obat = '$id'") or die(mysqli_error($koneksi));

        header('Location: ../obat-tersedia.php');
    }
} elseif (@$_POST['id_obat']) {
    $id = $_POST['id_obat'];
    $query = "UPDATE obat SET
        nama_obat = '$nama_obat',
        kategori = '$kategori',
        stok = '$stok',
        pedoman_pemakaian = '$pedoman_pemakaian',
        efek_samping = '$efek_samping',
        harga = '$harga'
        WHERE id_obat = '$id'
    ";
    mysqli_query($koneksi, $query) or die (mysqli_error($koneksi));
    header('Location: ../obat-tersedia.php');
} else {
    $query = "INSERT INTO obat (nama_obat, kategori, stok, pedoman_pemakaian, efek_samping, harga) 
                VALUES ('$nama_obat', '$kategori', '$stok', '$pedoman_pemakaian', '$efek_samping', '$harga')";
    mysqli_query($koneksi, $query) or die (mysqli_error($koneksi));
    header('Location: ../obat-tersedia.php');
}

?>