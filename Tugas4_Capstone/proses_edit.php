<?php
include 'koneksi.php';

if (isset($_POST['edit_simpan'])) {
    // Ambil data dari form
    $id_pesanan = $_POST['id_pesanan'];
    $nama_pemesan = $_POST['nama_pemesan'];
    $nomor_hp = $_POST['nomor_hp'];
    $tanggal_pesan = $_POST['tanggal_pesan'];
    $waktu_perjalanan = $_POST['waktu_perjalanan'];
    $jumlah_peserta = $_POST['jumlah_peserta'];

    // Cek status checkbox (Y = Ya, N = Tidak)
    $penginapan = isset($_POST['penginapan']) ? 'Y' : 'N';
    $transportasi = isset($_POST['transportasi']) ? 'Y' : 'N';
    $service_makan = isset($_POST['service_makan']) ? 'Y' : 'N';

    // Ambil Harga Paket dan Jumlah Tagihan dari hidden input (yang sudah dihitung JavaScript)
    // Walaupun diambil dari hidden, di sini kita RE-CALCULATE lagi untuk keamanan
    
    // **********************************************
    // RE-CALCULATION SERVER-SIDE (Keamanan)
    // **********************************************
    $HARGA_PENGINAPAN = 1000000;
    $HARGA_TRANSPORTASI = 1200000;
    $HARGA_MAKAN = 500000;
    
    $harga_paket = 0;
    if ($penginapan == 'Y') $harga_paket += $HARGA_PENGINAPAN;
    if ($transportasi == 'Y') $harga_paket += $HARGA_TRANSPORTASI;
    if ($service_makan == 'Y') $harga_paket += $HARGA_MAKAN;
    
    $jumlah_tagihan = $waktu_perjalanan * $jumlah_peserta * $harga_paket;
    // **********************************************

    // Query untuk UPDATE data
    $sql = "UPDATE pemesanan SET 
            nama_pemesan = '$nama_pemesan', 
            nomor_hp = '$nomor_hp', 
            tanggal_pesan = '$tanggal_pesan', 
            waktu_perjalanan = '$waktu_perjalanan', 
            jumlah_peserta = '$jumlah_peserta', 
            penginapan = '$penginapan', 
            transportasi = '$transportasi', 
            service_makan = '$service_makan', 
            harga_paket_perjalanan = '$harga_paket', 
            jumlah_tagihan = '$jumlah_tagihan'
            WHERE id_pesanan = '$id_pesanan'";

    if (mysqli_query($koneksi, $sql)) {
        // Redirect kembali ke halaman modifikasi dengan status sukses
        header("Location: modifikasi_pesanan.php?status=edit_sukses");
        exit;
    } else {
        // Redirect kembali ke halaman modifikasi dengan status gagal
        header("Location: modifikasi_pesanan.php?status=edit_gagal");
        exit;
    }
} else {
    header("Location: modifikasi_pesanan.php");
    exit;
}
?>