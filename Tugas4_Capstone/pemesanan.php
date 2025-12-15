<?php include 'koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pemesanan Paket Wisata</title>
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
        
        <h2>Form Pemesanan Paket Wisata</h2>

        <?php 
        // Pesan sukses/error dari proses_simpan.php
        if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
            echo '<div class="alert alert-success">Pemesanan berhasil disimpan!</div>';
        } else if (isset($_GET['status']) && $_GET['status'] == 'gagal') {
             echo '<div class="alert alert-danger">Pemesanan gagal disimpan. Mohon coba lagi.</div>';
        }
        ?>

        <form action="proses_simpan.php" method="POST" id="formPemesanan">
            <div class="mb-3">
                <label for="nama_pemesan" class="form-label">Nama Pemesan:</label>
                <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" required>
            </div>
            <div class="mb-3">
                <label for="nomor_hp" class="form-label">Nomor HP/Telp:</label>
                <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_pesan" class="form-label">Tanggal Pesan:</label>
                <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" required>
            </div>
            <div class="mb-3">
                <label for="waktu_perjalanan" class="form-label">Waktu Pelaksanaan Perjalanan (Hari):</label>
                <input type="number" class="form-control" id="waktu_perjalanan" name="waktu_perjalanan" min="1" value="1" onchange="hitungTagihan()" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Pelayanan Paket Perjalanan:</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="penginapan" id="penginapan" value="Y" onclick="hitungTagihan()">
                    <label class="form-check-label" for="penginapan">
                        Penginapan (Rp 1.000.000)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="transportasi" id="transportasi" value="Y" onclick="hitungTagihan()">
                    <label class="form-check-label" for="transportasi">
                        Transportasi (Rp 1.200.000)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="service_makan" id="service_makan" value="Y" onclick="hitungTagihan()">
                    <label class="form-check-label" for="service_makan">
                        Service/Makan (Rp 500.000)
                    </label>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="jumlah_peserta" class="form-label">Jumlah Peserta:</label>
                <input type="number" class="form-control" id="jumlah_peserta" name="jumlah_peserta" min="1" value="1" onchange="hitungTagihan()" required>
            </div>
            
            <div class="mb-3">
                <label for="harga_paket_perjalanan" class="form-label">Harga Paket Perjalanan:</label>
                <input type="text" class="form-control" id="harga_paket_perjalanan" name="harga_paket_perjalanan" readonly value="0">
            </div>
            
            <div class="mb-3">
                <label for="jumlah_tagihan" class="form-label">Jumlah Tagihan:</label>
                <input type="text" class="form-control" id="jumlah_tagihan" name="jumlah_tagihan" readonly value="0">
            </div>

            <button type="submit" class="btn btn-primary" name="simpan">Simpan</button>
            <button type="button" class="btn btn-warning" onclick="hitungTagihan()">Hitung</button>
            <button type="reset" class="btn btn-danger">Reset</button>
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

            // 1. Hitung Harga Paket Perjalanan (Total Layanan yang Dipilih) [cite: 57]
            if (is_penginapan) {
                hargaPaket += HARGA_PENGINAPAN; // Rp 1.000.000 [cite: 53]
            }
            if (is_transportasi) {
                hargaPaket += HARGA_TRANSPORTASI; // Rp 1.200.000 [cite: 54]
            }
            if (is_makan) {
                hargaPaket += HARGA_MAKAN; // Rp 500.000 [cite: 56]
            }

            // 2. Hitung Jumlah Tagihan (Waktu x Peserta x Harga Paket) [cite: 58]
            // Contoh: 2 hari x 2 peserta x 2.200.000 = 8.800.000 (Jika Penginapan dan Transportasi) [cite: 28]
            let jumlahTagihan = waktu_perjalanan * jumlah_peserta * hargaPaket;
            
            // Tampilkan hasil
            document.getElementById('harga_paket_perjalanan').value = hargaPaket.toLocaleString('id-ID'); // Format mata uang
            document.getElementById('jumlah_tagihan').value = jumlahTagihan.toLocaleString('id-ID'); // Format mata uang
        }

        // Jalankan perhitungan saat halaman dimuat (untuk inisiasi nilai 0 atau default)
        document.addEventListener('DOMContentLoaded', hitungTagihan);
        
        // Validasi Sederhana sebelum submit (Optional, PHP validation is also needed)
        document.getElementById('formPemesanan').addEventListener('submit', function(event) {
            const requiredFields = ['nama_pemesan', 'nomor_hp', 'tanggal_pesan', 'waktu_perjalanan', 'jumlah_peserta'];
            let isValid = true;
            requiredFields.forEach(field => {
                if (document.getElementById(field).value.trim() === '') {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                alert('Semua field isian wajib diisi!'); // Pesan jika form belum di input [cite: 50]
                event.preventDefault(); // Mencegah submit jika validasi gagal
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>