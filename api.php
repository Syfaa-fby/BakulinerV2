<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include 'koneksi.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Helper function untuk response JSON
function jsonResponse($success, $data = null, $error = null) {
    echo json_encode([
        "success" => $success,
        "data" => $data,
        "error" => $error,
        "timestamp" => time()
    ]);
    exit();
}

switch ($method) {
    case 'GET':
        handleGetRequest();
        break;
        
    case 'POST':
        handlePostRequest();
        break;
        
    case 'PUT':
        handlePutRequest();
        break;
        
    case 'DELETE':
        handleDeleteRequest();
        break;
        
    default:
        jsonResponse(false, null, "Metode HTTP tidak didukung");
}

function handleGetRequest() {
    global $conn;
    
    // Get categories
    if (isset($_GET['action']) && $_GET['action'] === 'categories') {
        $query = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
        $result = mysqli_query($conn, $query);
        $categories = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[] = $row;
        }
        jsonResponse(true, $categories);
    }
    
    // Get featured items
    if (isset($_GET['action']) && $_GET['action'] === 'featured') {
        $query = "SELECT k.*, kat.nama_kategori 
                  FROM kuliner k 
                  LEFT JOIN kategori kat ON k.kategori_id = kat.id 
                  WHERE k.is_featured = TRUE 
                  ORDER BY k.rating DESC 
                  LIMIT 6";
        $result = mysqli_query($conn, $query);
        $featured = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $featured[] = $row;
        }
        jsonResponse(true, $featured);
    }
    
    // Get ulasan by kuliner_id
    if (isset($_GET['action']) && $_GET['action'] === 'reviews' && isset($_GET['kuliner_id'])) {
        $kuliner_id = intval($_GET['kuliner_id']);
        $query = "SELECT * FROM ulasan WHERE kuliner_id = $kuliner_id ORDER BY created_at DESC";
        $result = mysqli_query($conn, $query);
        $reviews = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[] = $row;
        }
        jsonResponse(true, $reviews);
    }
    
    // Get semua data kuliner (default)
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, trim($_GET['search'])) : '';
    $kategori_id = isset($_GET['kategori_id']) ? intval($_GET['kategori_id']) : 0;
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 100;
    $offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
    
    $query = "SELECT k.*, kat.nama_kategori 
              FROM kuliner k 
              LEFT JOIN kategori kat ON k.kategori_id = kat.id 
              WHERE 1=1";
    
    if ($search) {
        $query .= " AND (k.nama LIKE '%$search%' OR k.lokasi LIKE '%$search%' OR k.deskripsi LIKE '%$search%' OR kat.nama_kategori LIKE '%$search%')";
    }
    
    if ($kategori_id > 0) {
        $query .= " AND k.kategori_id = $kategori_id";
    }
    
    $query .= " ORDER BY k.is_featured DESC, k.rating DESC LIMIT $limit OFFSET $offset";
    
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        jsonResponse(false, null, "Query gagal: " . mysqli_error($conn));
    }
    
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    
    jsonResponse(true, $data);
}

function handlePostRequest() {
    global $conn;
    $input = json_decode(file_get_contents("php://input"), true);
    
    // Handle new order
    if (isset($_GET['action']) && $_GET['action'] === 'order') {
        $kode_pesanan = 'ORD' . date('Ymd') . rand(1000, 9999);
        $nama_pemesan = mysqli_real_escape_string($conn, $input['nama_pemesan']);
        $email = mysqli_real_escape_string($conn, $input['email']);
        $telepon = mysqli_real_escape_string($conn, $input['telepon']);
        $alamat = mysqli_real_escape_string($conn, $input['alamat']);
        $items = mysqli_real_escape_string($conn, json_encode($input['items']));
        $total_harga = floatval($input['total_harga']);
        
        $sql = "INSERT INTO pesanan (kode_pesanan, nama_pemesan, email, telepon, alamat, items, total_harga) 
                VALUES ('$kode_pesanan', '$nama_pemesan', '$email', '$telepon', '$alamat', '$items', $total_harga)";
        
        if (mysqli_query($conn, $sql)) {
            jsonResponse(true, [
                "kode_pesanan" => $kode_pesanan,
                "id" => mysqli_insert_id($conn)
            ], "Pesanan berhasil dibuat");
        } else {
            jsonResponse(false, null, "Gagal membuat pesanan: " . mysqli_error($conn));
        }
    }
    
    // Handle new review
    if (isset($_GET['action']) && $_GET['action'] === 'review') {
        $kuliner_id = intval($input['kuliner_id']);
        $nama_user = mysqli_real_escape_string($conn, $input['nama_user']);
        $rating = intval($input['rating']);
        $komentar = mysqli_real_escape_string($conn, $input['komentar']);
        
        $sql = "INSERT INTO ulasan (kuliner_id, nama_user, rating, komentar) 
                VALUES ($kuliner_id, '$nama_user', $rating, '$komentar')";
        
        if (mysqli_query($conn, $sql)) {
            // Update rating kuliner
            updateKulinerRating($kuliner_id);
            jsonResponse(true, null, "Ulasan berhasil ditambahkan");
        } else {
            jsonResponse(false, null, "Gagal menambah ulasan: " . mysqli_error($conn));
        }
    }
    
    // Default: tambah kuliner baru
    if (!$input || !isset($input['nama']) || !isset($input['kategori_id'])) {
        jsonResponse(false, null, "Data tidak lengkap");
    }
    
    $nama = mysqli_real_escape_string($conn, trim($input['nama']));
    $lokasi = mysqli_real_escape_string($conn, trim($input['lokasi'] ?? ''));
    $kategori_id = intval($input['kategori_id']);
    $deskripsi = mysqli_real_escape_string($conn, trim($input['deskripsi'] ?? ''));
    $gambar = mysqli_real_escape_string($conn, trim($input['gambar'] ?? ''));
    $rating = max(0, min(5, floatval($input['rating'] ?? 0)));
    $harga = floatval($input['harga'] ?? 0);
    $bahan_bahan = mysqli_real_escape_string($conn, trim($input['bahan_bahan'] ?? ''));
    $cara_membuat = mysqli_real_escape_string($conn, trim($input['cara_membuat'] ?? ''));
    $tips_saji = mysqli_real_escape_string($conn, trim($input['tips_saji'] ?? ''));
    $is_featured = isset($input['is_featured']) ? (bool)$input['is_featured'] : false;

    $sql = "INSERT INTO kuliner (nama, lokasi, kategori_id, deskripsi, gambar, rating, harga, bahan_bahan, cara_membuat, tips_saji, is_featured)
            VALUES ('$nama', '$lokasi', $kategori_id, '$deskripsi', '$gambar', $rating, $harga, '$bahan_bahan', '$cara_membuat', '$tips_saji', $is_featured)";
    
    if (mysqli_query($conn, $sql)) {
        jsonResponse(true, [
            "id" => mysqli_insert_id($conn),
            "message" => "Data berhasil ditambahkan"
        ]);
    } else {
        jsonResponse(false, null, "Gagal menambahkan data: " . mysqli_error($conn));
    }
}

function handlePutRequest() {
    global $conn;
    $input = json_decode(file_get_contents("php://input"), true);
    
    if (!$input || !isset($input['id'])) {
        jsonResponse(false, null, "ID tidak ditemukan");
    }
    
    $id = intval($input['id']);
    $nama = mysqli_real_escape_string($conn, trim($input['nama']));
    $lokasi = mysqli_real_escape_string($conn, trim($input['lokasi'] ?? ''));
    $kategori_id = intval($input['kategori_id']);
    $deskripsi = mysqli_real_escape_string($conn, trim($input['deskripsi'] ?? ''));
    $gambar = mysqli_real_escape_string($conn, trim($input['gambar'] ?? ''));
    $rating = max(0, min(5, floatval($input['rating'] ?? 0)));
    $harga = floatval($input['harga'] ?? 0);
    $bahan_bahan = mysqli_real_escape_string($conn, trim($input['bahan_bahan'] ?? ''));
    $cara_membuat = mysqli_real_escape_string($conn, trim($input['cara_membuat'] ?? ''));
    $tips_saji = mysqli_real_escape_string($conn, trim($input['tips_saji'] ?? ''));
    $is_featured = isset($input['is_featured']) ? (bool)$input['is_featured'] : false;

    $sql = "UPDATE kuliner SET 
            nama='$nama', lokasi='$lokasi', kategori_id=$kategori_id,
            deskripsi='$deskripsi', gambar='$gambar', rating=$rating,
            harga=$harga, bahan_bahan='$bahan_bahan', cara_membuat='$cara_membuat',
            tips_saji='$tips_saji', is_featured=$is_featured
            WHERE id=$id";
    
    if (mysqli_query($conn, $sql)) {
        jsonResponse(true, null, "Data berhasil diperbarui");
    } else {
        jsonResponse(false, null, "Gagal memperbarui data: " . mysqli_error($conn));
    }
}

function handleDeleteRequest() {
    global $conn;
    parse_str(file_get_contents("php://input"), $input);
    
    if (!isset($input['id'])) {
        jsonResponse(false, null, "ID tidak ditemukan");
    }
    
    $id = intval($input['id']);
    
    // Hapus ulasan terkait terlebih dahulu
    mysqli_query($conn, "DELETE FROM ulasan WHERE kuliner_id = $id");
    
    $sql = "DELETE FROM kuliner WHERE id=$id";
    
    if (mysqli_query($conn, $sql)) {
        jsonResponse(true, null, "Data berhasil dihapus");
    } else {
        jsonResponse(false, null, "Gagal menghapus data: " . mysqli_error($conn));
    }
}

function updateKulinerRating($kuliner_id) {
    global $conn;
    
    $query = "SELECT AVG(rating) as avg_rating FROM ulasan WHERE kuliner_id = $kuliner_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $avg_rating = round($row['avg_rating'], 2);
    
    mysqli_query($conn, "UPDATE kuliner SET rating = $avg_rating WHERE id = $kuliner_id");
}

mysqli_close($conn);
?>