<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Indhan</title>
    <!-- Styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

    <style>
        .card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-body {
            padding: 15px;
        }

        table.dataTable {
            width: 100% !important;
        }

        th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }

        td, th {
            padding: 12px 15px;
        }

        .dt-buttons button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 5px 10px;
            margin: 2px;
            font-size: 14px;
            border-radius: 4px;
        }

        .dt-buttons button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <button class="btn btn-secondary mb-2" onclick="goBack()">
            <i class="bi bi-arrow-left-square"></i>
        </button>
        <div class="card shadow-sm">
            <div class="card-header">
                Laporan Industri Pertahanan
            </div>
            <div class="card-body mb-4">
                <div class="data-tables datatable-dark">
                    <table class="table table-striped table-hover" id="mauexport" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Indhan</th>
                                <th>Produk Ekspor/Impor</th>
                                <th>Email Indhan</th>
                                <th>URL Website</th>
                                <th>Nomor Induk Berusaha</th>
                                <th>Informasi Perusahaan</th>
                                <th>Penetapan Indhan</th>
                                <th>Alamat Utama Indhan</th>
                                <th>Nomor Telepon Utama</th>
                                <th>Kategori Indhan (BUMN/BUMS)</th>
                                <th>Alamat Kantor Cabang Indhan</th>
                                <th>Nama WorkShop</th>
                                <th>Nomor Telepon WorkShop</th>
                                <th>Nama Direktur Utama</th>
                                <th>Nomor Telepon Direktur Utama</th>
                                <th>Nama PIC</th>
                                <th>Nomor Telepon PIC Utama</th>
                                <th>Nama Kantor Akuntan Public</th>
                                <th>Opini Akuntan Public</th>
                                <th>Kepemilikan Sarana/Prasarana Produksi</th>
                                <th>Nama Produk</th>
                                <th>TRL</th>
                                <th>MRL</th>
                                <th>Nomor KBLI</th>
                                <th>Deskripsi KBLI</th>
                                <th>Kelompok Produk</th>
                                <th>Klasifikasi Produk INDHAN</th>
                                <th>Kapasitas Produksi</th>
                                <th>Nilai TKDN Per Produk</th>
                                <th>Nomor Sertifikat TKDN</th>
                                <th>Nama Personil Penerima</th>
                                <th>NIK Personil Penerima</th>
                                <th>Divisi Personil Penerima</th>
                                <th>Part No/SN</th>
                                <th>Merk/Type</th>
                                <th>Deskripsi</th>
                                <th>Kuantitas</th>
                                <th>Review dan Saran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Koneksi ke database
                            $conn = new mysqli("localhost", "root", "", "db_subditindhan");

                            if ($conn->connect_error) {
                                die("Koneksi gagal: " . $conn->connect_error);
                            }

                            $sql = "SELECT 
                                c.company_name AS nama_indhan,
                                c.email AS email_indhan,
                                c.url_website AS url_website,
                                c.company_nib AS nomor_induk,
                                c.company_information AS informasi_perusahaan,
                                c.company_assignment AS penetapan_indhan,
                                c.company_main_address AS alamat_utama,
                                c.main_number AS nomor_telepon,
                                c.company_category AS kategori_perusahaan,
                                cb.company_branch_address AS kantor_cabang,
                                w.workshop_name AS nama_workshop,
                                w.phone_number AS nomor_telepon_workshop,
                                m.director_name AS nama_direktur_utama,
                                m.director_phone AS nomor_telepon_direktur_utama,
                                m.pic_name AS nama_pic,
                                m.pic_phone AS nomor_telepon_pic,
                                fm.public_accounting_firm AS nama_akuntan_public,
                                fm.public_accountant_opinion AS opini_akuntan_public,
                                pf.ownership_type AS kepemilikan_sarana,
                                p.product_name AS nama_produk,
                                p.trl_level AS trl,
                                p.mrl_level AS mrl,
                                p.kbli_number AS nomor_kbli,
                                p.kbli_description AS deskripsi_kbli,
                                p.product_group AS kelompok_produk,
                                p.product_classification AS klasifikasi_produk,
                                p.production_capacity AS kapasitas_produksi,
                                p.tkdn_value AS nilai_tkdn,
                                p.tkdn_certificate_number AS nomor_sertifikat_tkdn,
                                op.name AS personnel_name,
                                op.nik AS personnel_nik,
                                op.division AS personnel_division,
                                om.part_number,
                                om.brand_type,
                                om.description AS material_description,
                                om.quantity,
                                om.review_suggestions
                            FROM 
                                companies c
                                LEFT JOIN workshop_branch w ON c.company_id = w.workshops_id
                                LEFT JOIN company_management m ON c.company_id = m.management_id
                                LEFT JOIN financial_management fm ON c.company_id = fm.financial_id
                                LEFT JOIN production_facilities pf ON c.company_id = pf.facility_id
                                LEFT JOIN company_branch cb ON c.company_id = cb.company_branch_id
                                LEFT JOIN products_branch p ON c.company_id = p.products_id                                
                                LEFT JOIN offset_personnel op ON m.management_id = op.offset_id
                                LEFT JOIN offset_materials om ON m.management_id = om.offset_id
                                LEFT JOIN report r ON c.company_id = r.company_id
                                GROUP BY r.id_report";

                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                $no = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nama_indhan']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['kelompok_produk']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['email_indhan']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['url_website']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nomor_induk']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['informasi_perusahaan']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['penetapan_indhan']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['alamat_utama']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nomor_telepon']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['kategori_perusahaan']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['kantor_cabang']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nama_workshop']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nomor_telepon_workshop']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nama_direktur_utama']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nomor_telepon_direktur_utama']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nama_pic']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nomor_telepon_pic']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nama_akuntan_public']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['opini_akuntan_public']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['kepemilikan_sarana']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nama_produk']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['trl']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['mrl']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nomor_kbli']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['deskripsi_kbli']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['kelompok_produk']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['klasifikasi_produk']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['kapasitas_produksi']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nilai_tkdn']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nomor_sertifikat_tkdn']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['personnel_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['personnel_nik']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['personnel_division']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['part_number']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['brand_type']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['material_description']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['quantity']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['review_suggestions']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='40' class='text-center'>Tidak ada data</td></tr>";
                            }

                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script>
        function goBack() {
            window.history.back();
        }

        $(document).ready(function() {
            $('#mauexport').DataTable({
                dom: 'Bfrtip',
                responsive: true,
                scrollX: true,
                paging: true, // Pastikan pagination diaktifkan
                pageLength: 5, // Menentukan jumlah baris per halaman
                buttons: [
                    'csv', 'excel' // Menambahkan tombol ekspor
                ],
                error: function(settings, helpPage, message) {
                    console.log(message);
                }
            });
        });
    </script>

</body>

</html>