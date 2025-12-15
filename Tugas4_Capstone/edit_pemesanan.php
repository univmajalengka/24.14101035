<?php 
include 'koneksi.php';

$data = null;
if (isset($_GET['id'])) {
    $id_pesanan = mysqli_real_escape_string($koneksi, $_GET['id']);
    $sql_edit = "SELECT * FROM pemesanan WHERE id_pesanan = '$id_pesanan'";
    $result_edit = mysqli_query($koneksi, $sql_edit);

    if (mysqli_num_rows($result_edit) > 0) {
        $data = mysqli_fetch_assoc($result_edit);
    } else {
        // Data tidak ditemukan
        header("Location: modifikasi_pesanan.php?status=data_tidak_ditemukan");
        exit;
    }
} else {
    // Tidak ada ID
    header("Location: modifikasi_pesanan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Pemesanan Paket Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        
        <h2>Form Edit Pemesanan Paket Wisata</h2>

        <form action="proses_edit.php" method="POST" id="formPemesanan">
            <input type="hidden" name="id_pesanan" value="<?php echo htmlspecialchars($data['id_pesanan']); ?>">

            <div class="mb-3">
                <label for="nama_pemesan" class="form-label">Nama Pemesan:</label>
                <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" value="<?php echo htmlspecialchars($data['nama_pemesan']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nomor_hp" class="form-label">Nomor HP/Telp:</label>
                <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="<?php echo htmlspecialchars($data['nomor_hp']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_pesan" class="form-label">Tanggal Pesan:</label>
                <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" value="<?php echo htmlspecialchars($data['tanggal_pesan']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="waktu_perjalanan" class="form-label">Waktu Pelaksanaan Perjalanan (Hari):</label>
                <input type="number" class="form-control" id="waktu_perjalanan" name="waktu_perjalanan" min="1" value="<?php echo htmlspecialchars($data['waktu_perjalanan']); ?>" onchange="hitungTagihan()" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Pelayanan Paket Perjalanan:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="penginapan" id="penginapan" value="Y" <?php echo ($data['penginapan'] == 'Y') ? 'checked' : ''; ?> onclick="hitungTagihan()">
                    <label class="form-check-label" for="penginapan">
                        Penginapan (Rp 1.000.000)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="transportasi" id="transportasi" value="Y" <?php echo ($data['transportasi'] == 'Y') ? 'checked' : ''; ?> onclick="hitungTagihan()">
                    <label class="form-check-label" for="transportasi">
                        Transportasi (Rp 1.200.000)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="service_makan" id="service_makan" value="Y" <?php echo ($data['service_makan'] == 'Y') ? 'checked' : ''; ?> onclick="hitungTagihan()">
                    <label class="form-check-label" for="service_makan">
                        Service/Makan (Rp 500.000)
                    </label>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="jumlah_peserta" class="form-label">Jumlah Peserta:</label>
                <input type="number" class="form-control" id="jumlah_peserta" name="jumlah_peserta" min="1" value="<?php echo htmlspecialchars($data['jumlah_peserta']); ?>" onchange="hitungTagihan()" required>
            </div>
            
            <div class="mb-3">
                <label for="harga_paket_perjalanan" class="form-label">Harga Paket Perjalanan:</label>
                <input type="text" class="form-control" id="harga_paket_perjalanan" name="harga_paket_perjalanan_display" readonly value="<?php echo number_format($data['harga_paket_perjalanan'], 0, ',', '.'); ?>">
                <input type="hidden" id="harga_paket_perjalanan" name="harga_paket_perjalanan_hidden" value="<?php echo $data['harga_paket_perjalanan']; ?>">
            </div>
            
            <div class="mb-3">
                <label for="jumlah_tagihan" class="form-label">Jumlah Tagihan:</label>
                <input type="text" class="form-control" id="jumlah_tagihan" name="jumlah_tagihan_display" readonly value="<?php echo number_format($data['jumlah_tagihan'], 0, ',', '.'); ?>">
                <input type="hidden" id="jumlah_tagihan_hidden" name="jumlah_tagihan_hidden" value="<?php echo $data['jumlah_tagihan']; ?>">
            </div>

            <button type="submit" class="btn btn-primary" name="edit_simpan">Simpan Perubahan</button>
            <button type="button" class="btn btn-warning" onclick="hitungTagihan()">Hitung Ulang</button>
            <a href="modifikasi_pesanan.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script>
        function hitungTagihan() {
            // Harga layanan
            const HARGA_PENGINAPAN = 1000000;
            const HARGA_TRANSPORTASI = 1200000;
            const HARGA_MAKAN = 500000;

            // Ambil nilai dari input
            const waktu_perjalanan = parseInt(document.getElementById('waktu_perjalanan').value) || 0;
            const jumlah_peserta = parseInt(document.getElementById('jumlah_peserta').value) || 0;

            // Ambil status checkbox
            const is_penginapan = document.getElementById('penginapan').checked;
            const is_transportasi = document.getElementById('transportasi').checked;
            const is_makan = document.getElementById('service_makan').checked;

            let hargaPaket = 0;

            // 1. Hitung Harga Paket Perjalanan (Total Layanan yang Dipilih)
            if (is_penginapan) {
                hargaPaket += HARGA_PENGINAPAN;
            }
            if (is_transportasi) {
                hargaPaket += HARGA_TRANSPORTASI;
            }
            if (is_makan) {
                hargaPaket += HARGA_MAKAN;
            }

            // 2. Hitung Jumlah Tagihan (Waktu x Peserta x Harga Paket)
            let jumlahTagihan = waktu_perjalanan * jumlah_peserta * hargaPaket;
            
            // Tampilkan hasil di input display
            document.getElementById('harga_paket_perjalanan').value = hargaPaket.toLocaleString('id-ID'); 
            document.getElementById('jumlah_tagihan').value = jumlahTagihan.toLocaleString('id-ID'); 

            // Simpan nilai sebenarnya di hidden input untuk dikirim ke PHP
            document.querySelector('[name="harga_paket_perjalanan_hidden"]').value = hargaPaket;
            document.querySelector('[name="jumlah_tagihan_hidden"]').value = jumlahTagihan;
        }

        document.addEventListener('DOMContentLoaded', hitungTagihan); // Pastikan perhitungan berjalan saat load data lama
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>