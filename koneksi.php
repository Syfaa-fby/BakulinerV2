<?php
// Konfigurasi Database dengan error handling yang lebih baik
$host = "localhost";
$user = "root";
$pass = "";
$db   = "bakuliner_db";

// Koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    error_log("Database connection failed: " . mysqli_connect_error());
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

// Buat tabel jika belum ada
function createTables($conn) {
    $queries = [
        "CREATE TABLE IF NOT EXISTS kategori (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama_kategori VARCHAR(100) NOT NULL,
            deskripsi TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        
        "CREATE TABLE IF NOT EXISTS kuliner (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nama VARCHAR(255) NOT NULL,
            lokasi VARCHAR(255),
            kategori_id INT,
            deskripsi TEXT,
            gambar TEXT,
            rating DECIMAL(3,2) DEFAULT 0,
            harga DECIMAL(10,2),
            bahan_bahan TEXT,
            cara_membuat TEXT,
            tips_saji TEXT,
            is_featured BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (kategori_id) REFERENCES kategori(id)
        )",
        
        "CREATE TABLE IF NOT EXISTS ulasan (
            id INT AUTO_INCREMENT PRIMARY KEY,
            kuliner_id INT,
            nama_user VARCHAR(100),
            rating INT,
            komentar TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (kuliner_id) REFERENCES kuliner(id)
        )",
        
        "CREATE TABLE IF NOT EXISTS pesanan (
            id INT AUTO_INCREMENT PRIMARY KEY,
            kode_pesanan VARCHAR(20),
            nama_pemesan VARCHAR(100),
            email VARCHAR(100),
            telepon VARCHAR(20),
            alamat TEXT,
            items TEXT,
            total_harga DECIMAL(10,2),
            status ENUM('pending', 'diproses', 'dikirim', 'selesai') DEFAULT 'pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"
    ];

    foreach ($queries as $query) {
        if (!mysqli_query($conn, $query)) {
            error_log("Table creation failed: " . mysqli_error($conn));
        }
    }

    // Insert default categories jika belum ada
    $checkCategories = "SELECT COUNT(*) as total FROM kategori";
    $result = mysqli_query($conn, $checkCategories);
    $row = mysqli_fetch_assoc($result);
    
    if ($row['total'] == 0) {
        $defaultCategories = [
            "Makanan Berat",
            "Kue Tradisional", 
            "Minuman Khas",
            "Pakaian Adat",
            "Souvenir",
            "Oleh-oleh"
        ];
        
        foreach ($defaultCategories as $category) {
            mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$category')");
        }
    }
}

// Panggil fungsi create tables
createTables($conn);
?>