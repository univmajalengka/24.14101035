<?php
// Pastikan file koneksi.php sudah tersedia
include 'koneksi.php';

// Cek apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil dan bersihkan data input dari form
    $nama_pemesan = mysqli_real_escape_string($koneksi, $_POST['nama_pemesan']);
    $nomor_hp = mysqli_real_escape_string($koneksi, $_POST['nomor_hp']);
    $tanggal_pesan = mysqli_real_escape_string($koneksi, $_POST['tanggal_pesan']);
    $waktu_perjalanan = (int)$_POST['waktu_perjalanan'];
    $jumlah_peserta = (int)$_POST['jumlah_peserta'];
    
    // Ambil harga paket dan tagihan dari input tersembunyi/display (seharusnya sudah dihitung JS)
    $harga_paket = (int)$_POST['harga_paket_perjalanan']; 
    $jumlah_tagihan = (int)$_POST['jumlah_tagihan'];

    // Cek status checkbox (Jika harganya ada, berarti Y, jika tidak ada/nol, berarti N)
    // Kita cek berdasarkan harga_paket yang dihitung JS, lalu bandingkan dengan harga dasar.

    $penginapan_status = (isset($_POST['penginapan']) && $harga_paket >= 1000000) ? 'Y' : 'N';
    $transportasi_status = (isset($_POST['transportasi']) && $harga_paket >= 1200000) ? 'Y' : 'N';
    $makan_status = (isset($_POST['service_makan']) && $harga_paket >= 500000) ? 'Y' : 'N';

    // Query untuk menyimpan data
    $sql = "INSERT INTO pemesanan (nama_pemesan, nomor_hp, tanggal_pesan, waktu_perjalanan, jumlah_peserta, penginapan, transportasi, service_makan, harga_paket_perjalanan, jumlah_tagihan)
            VALUES (
                '$nama_pemesan', 
                '$nomor_hp', 
                '$tanggal_pesan', 
                '$waktu_perjalanan', 
                '$jumlah_peserta', 
                '$penginapan_status', 
                '$transportasi_status', 
                '$makan_status', 
                '$harga_paket', 
                '$jumlah_tagihan'
            )";

    if (mysqli_query($koneksi, $sql)) {
        // Redirect ke halaman modifikasi dengan pesan sukses
        header("Location: modifikasi_pesanan.php?status=sukses");
        exit;
    } else {
        // Redirect kembali ke form pemesanan dengan pesan error
        $error_msg = "Gagal menyimpan data: " . mysqli_error($koneksi);
        header("Location: pemesanan.php?error=" . urlencode($error_msg));
        exit;
    }
} else {
    // Jika diakses tanpa POST, arahkan ke beranda
    header("Location: index.php");
    exit;
}
?>