<?php
$host = "localhost";
$user = "root"; // Username default XAMPP
$password = ""; // Password default XAMPP
$database = "db_wisata"; // Nama database yang sudah Anda buat

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (mysqli_connect_errno()){
    echo "Koneksi database gagal: " . mysqli_connect_error();
    exit();
}
// Jika koneksi berhasil, tidak ada output
?>