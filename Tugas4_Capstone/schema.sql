CREATE DATABASE IF NOT EXISTS db_wisata;

USE db_wisata;

CREATE TABLE IF NOT EXISTS pemesanan (
    id_pesanan INT(11) AUTO_INCREMENT PRIMARY KEY,
    nama_pemesan VARCHAR(100) NOT NULL,
    nomor_hp VARCHAR(20) NOT NULL,
    tanggal_pesan DATE NOT NULL,
    waktu_perjalanan INT(5) NOT NULL, -- Jumlah Hari
    jumlah_peserta INT(5) NOT NULL,
    penginapan ENUM('Y', 'N') NOT NULL DEFAULT 'N', -- Rp 1.000.000
    transportasi ENUM('Y', 'N') NOT NULL DEFAULT 'N', -- Rp 1.200.000
    service_makan ENUM('Y', 'N') NOT NULL DEFAULT 'N', -- Rp 500.000
    harga_paket_perjalanan INT(20) NOT NULL,
    jumlah_tagihan BIGINT(20) NOT NULL
);