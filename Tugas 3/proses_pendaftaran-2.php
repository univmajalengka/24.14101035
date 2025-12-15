<?php

include("koneksi.php");

// cek apakah tombol daftar sudah diklik atau belum?
if(isset($_POST['daftar'])){

    // Ambil data dari formulir (Input yang perlu disiapkan)
    $nama           = $_POST['nama'];
    $alamat         = $_POST['alamat'];
    $jk             = $_POST['jenis_kelamin'];
    $agama          = $_POST['agama'];
    $sekolah_asal   = $_POST['sekolah_asal']; // Perbaikan: variabel sudah diawali $

    // 1. Buat SQL Query dengan placeholder (?)
    $sql = "INSERT INTO calon_siswa (nama, alamat, jenis_kelamin, agama, sekolah_asal) VALUES (?, ?, ?, ?, ?)";

    // 2. Persiapkan statement (prepared statement)
    $stmt = mysqli_prepare($db, $sql);

    // Cek apakah statement berhasil dipersiapkan
    if ($stmt) {
        // 3. Bind parameter: "sssss" = lima parameter bertipe string
        mysqli_stmt_bind_param($stmt, "sssss", $nama, $alamat, $jk, $agama, $sekolah_asal);

        // 4. Eksekusi statement
        $query = mysqli_stmt_execute($stmt);

        // 5. Tutup statement
        mysqli_stmt_close($stmt);

        // Apakah query simpan berhasil?
        if( $query ) {
            // kalau berhasil alihkan ke halaman index.php dengan status=sukses
            header('Location: index.php?status=sukses');
        } else {
            // kalau gagal alihkan ke halaman index.php dengan status=gagal
            header('Location: index.php?status=gagal'); // Perbaikan: Mengubah 'indek.ph' menjadi 'index.php'
        }
    } else {
        // Jika prepared statement gagal
        die("Query preparation failed: " . mysqli_error($db));
    }
} else {
    die("Akses dilarang...");
}

?>