function hitungDiskon() {
  // MINTA INPUT DARI USER
  const hargaAsli = parseFloat(prompt("Masukkan harga asli (contoh: 100000):"));
  const persenDiskon = parseFloat(prompt("Masukkan persen diskon (contoh: 20):"));

  // VALIDASI (jika salah input)
  if (isNaN(hargaAsli) || isNaN(persenDiskon)) {
    alert("Input tidak valid! Masukkan angka saja.");
    return;
  }

  // HITUNG POTONGAN
  const potongan = (hargaAsli * persenDiskon) / 100;

  // HITUNG HARGA AKHIR
  const hargaAkhir = hargaAsli - potongan;

  // TAMPILKAN OUTPUT
  alert(
    "=== HASIL PERHITUNGAN ===\n" +
    "Harga Asli: Rp " + hargaAsli + "\n" +
    "Diskon: " + persenDiskon + "%\n" +
    "Potongan: Rp " + potongan + "\n" +
    "Harga Akhir: Rp " + hargaAkhir
  );
}

// PANGGIL FUNGSI
hitungDiskon();