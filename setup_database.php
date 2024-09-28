<?php
require_once 'config.php';

try {
    $pdo->exec("CREATE TABLE IF NOT EXISTS master_kata (
        id INT AUTO_INCREMENT PRIMARY KEY,
        kata VARCHAR(255) NOT NULL,
        clue VARCHAR(255) NOT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS point_game (
        id_point INT AUTO_INCREMENT PRIMARY KEY,
        nama_user VARCHAR(255) NOT NULL,
        total_point INT NOT NULL
    )");

    $stmt = $pdo->prepare("INSERT INTO master_kata (kata, clue) VALUES (?, ?)");

    $kata_list = [
        ['LEMARI', 'Aku tempat menyimpan pakaian?'],
        ['KOMPUTER', 'Alat elektronik untuk mengolah data.'],
        ['PERPUSTAKAAN', 'Tempat menyimpan banyak buku.'],
        ['MEJA', 'Aku digunakan untuk bekerja atau belajar.'],
        ['KURSUS', 'Tempat untuk belajar sesuatu yang baru.'],
        ['LAPTOP', 'Alat portabel untuk melakukan pekerjaan kantor.'],
        ['KAMERA', 'Alat untuk mengambil gambar.'],
        ['KULIAH', 'Proses belajar di perguruan tinggi.'],
        ['SMARTPHONE', 'Telepon cerdas yang bisa mengakses internet.'],
        ['BOLA', 'Aku bulat dan sering digunakan dalam permainan.'],
        ['PULPEN', 'Alat tulis yang menggunakan tinta.'],
        ['JAM', 'Aku menunjukkan waktu dan bisa di pakai di tangan.'],
        ['KOTAK', 'Aku digunakan untuk menyimpan barang-barang.'],
        ['KEDAI', 'Tempat untuk membeli makanan dan minuman.'],
        ['KOTAK PERSIMPANGAN', 'Aku tempat menunggu transportasi umum.'],
        ['MOBIL', 'Kendaraan yang bisa membawamu ke mana saja.'],
        ['PASAR', 'Tempat membeli barang-barang kebutuhan sehari-hari.'],
        ['SCHOOL', 'Tempat untuk anak-anak belajar di tingkat dasar.'],
        ['KULINER', 'Makanan khas dari suatu daerah.'],
        ['TAMAN', 'Tempat untuk bersantai dan menikmati alam.'],
        ['TELEVISI', 'Alat untuk menonton berbagai acara.']
    ];

    foreach ($kata_list as $kata) {
        $stmt->execute($kata);
    }

    echo "Tabel berhasil dibuat dan diisi dengan data awal.";
} catch (PDOException $e) {
    die("Error setting up database: " . $e->getMessage());
}
?>
