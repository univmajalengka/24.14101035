<?php
include 'koneksi.php'; // Hubungkan ke database

// Mendapatkan semua data pemesanan dari database
$sql_select = "SELECT * FROM pemesanan ORDER BY tanggal_pesan DESC";
$result = mysqli_query($koneksi, $sql_select);

// Cek jika ada pesan status dari aksi hapus/edit
$status_message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'hapus_sukses') {
        $status_message = '<div class="alert alert-success">Data pesanan berhasil dihapus!</div>';
    } elseif ($_GET['status'] == 'hapus_gagal') {
        $status_message = '<div class="alert alert-danger">Gagal menghapus data pesanan.</div>';
    } elseif ($_GET['status'] == 'edit_sukses') {
        $status_message = '<div class="alert alert-success">Data pesanan berhasil diubah!</div>';
    } elseif ($_GET['status'] == 'edit_gagal') {
        $status_message = '<div class="alert alert-danger">Gagal mengubah data pesanan.</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Modifikasi Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-responsive { overflow-x: auto; }
        .action-btns { width: 120px; }
    </style>
</head>
<body>
    <div class="container my-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-info mb-4">
            <div class="container-fluid">
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link text-white" href="index.php">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="index.php#paket">Daftar Paket Wisata</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="modifikasi_pesanan.php">Modifikasi Pesanan</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <h2>Daftar Pesanan</h2>
        
        <?php echo $status_message; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Phone</th>
                        <th>Jml. Peserta</th>
                        <th>Jml. Hari</th>
                        <th>Penginapan (Akomodasi)</th>
                        <th>Transportasi</th>
                        <th>Service/Makan</th>
                        <th>Harga Paket</th>
                        <th>Total Tagihan</th>
                        <th class="action-btns">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if (mysqli_num_rows($result) > 0) {
                        while($data = mysqli_fetch_assoc($result)) {
                            // Format mata uang Rupiah
                            $harga_paket_format = number_format($data['harga_paket_perjalanan'], 0, ',', '.');
                            $total_tagihan_format = number_format($data['jumlah_tagihan'], 0, ',', '.');

                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . htmlspecialchars($data['nama_pemesan']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['nomor_hp']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['jumlah_peserta']) . "</td>";
                            echo "<td>" . htmlspecialchars($data['waktu_perjalanan']) . "</td>";
                            // Akomodasi/Penginapan
                            echo "<td>" . htmlspecialchars($data['penginapan']) . "</td>";
                            // Transportasi
                            echo "<td>" . htmlspecialchars($data['transportasi']) . "</td>";
                            // Service/Makan
                            echo "<td>" . htmlspecialchars($data['service_makan']) . "</td>";
                            // Harga Paket
                            echo "<td>Rp " . $harga_paket_format . "</td>";
                            // Total Tagihan
                            echo "<td>Rp " . $total_tagihan_format . "</td>";
                            echo "<td class='action-btns'>";
                            
                            // Tombol Edit 
                            echo "<a href='edit_pemesanan.php?id=" . $data['id_pesanan'] . "' class='btn btn-sm btn-primary me-2'>Edit</a>";
                            
                            // Tombol Delete dengan konfirmasi pop-up [cite: 62]
                            echo "<a href='#' onclick='konfirmasiHapus(" . $data['id_pesanan'] . ")' class='btn btn-sm btn-danger'>Delete</a>";
                            
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11' class='text-center'>Belum ada data pemesanan yang tersimpan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function konfirmasiHapus(id) {
        // Pop-up konfirmasi akan muncul [cite: 62]
        if (confirm("Anda yakin akan hapus pesanan dengan ID: " + id + "?")) {
            // Jika OK, arahkan ke proses_hapus.php
            window.location.href = 'proses_hapus.php?id=' + id;
        }
    }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>