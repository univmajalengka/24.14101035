<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_pesanan = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // Query hapus
    $sql_delete = "DELETE FROM pemesanan WHERE id_pesanan='$id_pesanan'";

    if (mysqli_query($koneksi, $sql_delete)) {
        // Redirect kembali ke halaman modifikasi dengan status sukses
        header("Location: modifikasi_pesanan.php?status=hapus_sukses");
        exit;
    } else {
        // Redirect kembali ke halaman modifikasi dengan status gagal
        header("Location: modifikasi_pesanan.php?status=hapus_gagal");
        exit;
    }
} else {
    // Jika tidak ada ID, redirect kembali
    header("Location: modifikasi_pesanan.php");
    exit;
}
?>