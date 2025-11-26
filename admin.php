<?php
session_start();

// Login manual sederhana
if (isset($_POST['username']) && isset($_POST['password'])) {
  if ($_POST['username'] === 'admin1' && $_POST['password'] === '12345') {
    $_SESSION['admin'] = true;
    $_SESSION['login_time'] = time();
    header("Location: admin.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}

if (isset($_GET['logout'])) {
  session_destroy();
  header("Location: admin.php");
  exit;
}

// Auto logout after 1 hour
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 3600)) {
  session_destroy();
  header("Location: admin.php");
  exit;
}

if (!isset($_SESSION['admin'])):
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin | Bakuliner Kalsel</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    .gradient-bg {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    .login-card {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.95);
    }

    .text-high-contrast {
      color: #1a202c;
    }
  </style>
</head>

<body class="gradient-bg flex items-center justify-center min-h-screen p-4">
  <div class="login-card p-8 rounded-2xl shadow-2xl w-full max-w-md border-4 border-green-300">
    <div class="text-center mb-8">
      <div class="text-6xl mb-4">🍽️</div>
      <h2 class="text-3xl font-bold text-high-contrast">Bakuliner Kalsel</h2>
      <p class="text-gray-600 mt-2 font-semibold">Admin Panel</p>
    </div>

    <?php if (isset($error)): ?>
      <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
        <p class="font-medium">⚠️ <?php echo $error; ?></p>
      </div>
    <?php endif; ?>

    <form method="POST" class="space-y-6">
      <div>
        <label class="block text-high-contrast font-bold mb-3 text-lg">Username</label>
        <input type="text" name="username" placeholder="Masukkan username" value="admin1"
          class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast bg-white" required>
      </div>
      <div>
        <label class="block text-high-contrast font-bold mb-3 text-lg">Password</label>
        <input type="password" name="password" placeholder="Masukkan password" value="12345"
          class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast bg-white" required>
      </div>
      <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-3 rounded-lg font-bold hover:from-green-700 hover:to-green-800 transform hover:scale-105 transition duration-200 shadow-lg text-lg">
        🔐 Masuk ke Admin
      </button>
    </form>

    <div class="mt-6 text-center text-sm text-gray-600">
      <p class="font-semibold">Default Login:</p>
      <p>Username: <span class="font-bold">admin1</span></p>
      <p>Password: <span class="font-bold">12345</span></p>
    </div>
  </div>
</body>

</html>
<?php exit;
endif; ?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin | Bakuliner Kalsel</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
    }

    .gradient-header {
      background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    .card {
      transition: all 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .toast {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 16px 24px;
      border-radius: 12px;
      color: white;
      font-weight: 600;
      z-index: 1000;
      animation: slideIn 0.3s ease;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    @keyframes slideIn {
      from {
        transform: translateX(400px);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    .toast.success {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .toast.error {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    .modal-content {
      background-color: white;
      margin: 5% auto;
      padding: 0;
      border-radius: 16px;
      width: 90%;
      max-width: 600px;
      max-height: 85vh;
      overflow-y: auto;
      animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
      from {
        transform: translateY(50px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .stat-card {
      background: linear-gradient(135deg, #10b981 0%, #059669 100%);
      color: white;
    }

    .badge {
      display: inline-block;
      padding: 4px 12px;
      border-radius: 9999px;
      font-size: 0.875rem;
      font-weight: 600;
    }

    .loading {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(255, 255, 255, .3);
      border-radius: 50%;
      border-top-color: #fff;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    .search-box {
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .text-high-contrast {
      color: #1a202c;
    }

    .text-medium-contrast {
      color: #2d3748;
    }
  </style>
  <script>
    let editingId = null;
    let categories = [];

    // Toast notification
    function showToast(message, type = 'success') {
      const toast = document.createElement('div');
      toast.className = `toast ${type}`;
      toast.textContent = message;
      document.body.appendChild(toast);

      setTimeout(() => {
        toast.style.animation = 'slideIn 0.3s ease reverse';
        setTimeout(() => toast.remove(), 300);
      }, 3000);
    }

    // Fetch categories
    async function getCategories() {
      try {
        const res = await fetch("api.php?action=categories");
        const result = await res.json();
        categories = result.data || [];
        return categories;
      } catch (error) {
        showToast('Gagal memuat kategori', 'error');
        return [];
      }
    }

    // Fetch data
    async function getData() {
      try {
        const res = await fetch("api.php");
        const result = await res.json();
        return result.data || result;
      } catch (error) {
        showToast('Gagal memuat data: ' + error.message, 'error');
        return [];
      }
    }

    // Render statistics
    async function renderStats() {
      const data = await getData();
      const totalKuliner = data.length;
      const avgRating = data.reduce((sum, item) => sum + parseFloat(item.rating || 0), 0) / totalKuliner || 0;
      const topRated = data.filter(item => parseFloat(item.rating || 0) >= 4.5).length;
      const featuredItems = data.filter(item => item.is_featured).length;
      const totalCategories = new Set(data.map(item => item.kategori_id)).size;

      document.getElementById('total-kuliner').textContent = totalKuliner;
      document.getElementById('avg-rating').textContent = avgRating.toFixed(1);
      document.getElementById('top-rated').textContent = topRated;
      document.getElementById('featured-items').textContent = featuredItems;
      document.getElementById('total-categories').textContent = totalCategories;
    }

    // Populate category select
    async function populateCategorySelect(selectId, selectedId = null) {
      const select = document.getElementById(selectId);
      const cats = await getCategories();

      select.innerHTML = '<option value="">Pilih Kategori</option>' +
        cats.map(cat => `<option value="${cat.id}" ${selectedId == cat.id ? 'selected' : ''}>${cat.nama_kategori}</option>`).join('');
    }

    // Render data
    async function renderData(searchTerm = '') {
      const data = await getData();
      const filtered = searchTerm ?
        data.filter(item =>
          item.nama.toLowerCase().includes(searchTerm.toLowerCase()) ||
          item.lokasi.toLowerCase().includes(searchTerm.toLowerCase()) ||
          (item.nama_kategori && item.nama_kategori.toLowerCase().includes(searchTerm.toLowerCase()))
        ) :
        data;

      const list = document.getElementById("kuliner-list");

      if (filtered.length === 0) {
        list.innerHTML = `
        <div class="col-span-full text-center py-12">
          <div class="text-6xl mb-4">🔍</div>
          <p class="text-gray-500 text-lg">Tidak ada data ditemukan</p>
        </div>
      `;
        return;
      }

      list.innerHTML = filtered.map(item => `
      <div class="card bg-white rounded-xl shadow-md overflow-hidden border-2 border-green-200">
        <div class="relative">
          <img src="${item.gambar}" alt="${item.nama}" class="w-full h-48 object-cover" 
               onerror="this.src='https://via.placeholder.com/400x300/10b981/ffffff?text=No+Image'">
          <div class="absolute top-3 right-3">
            <span class="badge bg-yellow-400 text-yellow-900">⭐ ${item.rating || 0}</span>
          </div>
          ${item.is_featured ? `<div class="absolute top-3 left-3"><span class="badge bg-red-500 text-white">🔥 Featured</span></div>` : ''}
        </div>
        <div class="p-4">
          <h3 class="text-xl font-bold text-high-contrast mb-2">${item.nama}</h3>
          <div class="space-y-1 mb-3">
            <p class="text-sm text-medium-contrast">📍 ${item.lokasi || '-'}</p>
            <p class="text-sm"><span class="badge bg-green-100 text-green-800">${item.nama_kategori || 'Tanpa Kategori'}</span></p>
            <p class="text-sm font-semibold text-high-contrast">💰 Rp ${item.harga ? item.harga.toLocaleString('id-ID') : '0'}</p>
          </div>
          <p class="text-medium-contrast text-sm line-clamp-2">${item.deskripsi || ''}</p>
          <div class="mt-4 flex gap-2">
            <button onclick="openEditModal(${item.id})" 
                    class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-blue-600 hover:to-blue-700 transition font-medium">
              ✏️ Edit
            </button>
            <button onclick="hapusData(${item.id})" 
                    class="flex-1 bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-2 rounded-lg hover:from-red-600 hover:to-red-700 transition font-medium">
              🗑️ Hapus
            </button>
          </div>
        </div>
      </div>
    `).join("");
    }

    // Search handler
    function handleSearch(event) {
      const searchTerm = event.target.value;
      renderData(searchTerm);
    }

    // Tambah data
    async function tambahData() {
      const btn = event.target;
      const originalText = btn.innerHTML;
      btn.innerHTML = '<span class="loading"></span> Menambahkan...';
      btn.disabled = true;

      const input = {
        nama: document.getElementById("nama").value.trim(),
        lokasi: document.getElementById("lokasi").value.trim(),
        kategori_id: document.getElementById("kategori").value,
        deskripsi: document.getElementById("deskripsi").value.trim(),
        gambar: document.getElementById("gambar").value.trim(),
        rating: document.getElementById("rating").value,
        harga: document.getElementById("harga").value,
        bahan_bahan: document.getElementById("bahan_bahan").value.trim(),
        cara_membuat: document.getElementById("cara_membuat").value.trim(),
        tips_saji: document.getElementById("tips_saji").value.trim(),
        is_featured: document.getElementById("is_featured").checked
      };

      if (!input.nama || !input.kategori_id) {
        showToast('Nama dan kategori wajib diisi!', 'error');
        btn.innerHTML = originalText;
        btn.disabled = false;
        return;
      }

      try {
        const res = await fetch("api.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(input)
        });
        const result = await res.json();

        if (result.success) {
          showToast('✅ Data berhasil ditambahkan!');
          clearForm();
          renderData();
          renderStats();
        } else {
          showToast(result.error || 'Gagal menambahkan data', 'error');
        }
      } catch (error) {
        showToast('Error: ' + error.message, 'error');
      } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
      }
    }

    // Open edit modal
    async function openEditModal(id) {
      editingId = id;
      const data = await getData();
      const item = data.find(d => d.id == id);

      if (!item) {
        showToast('Data tidak ditemukan', 'error');
        return;
      }

      await populateCategorySelect("edit-kategori", item.kategori_id);

      document.getElementById("edit-nama").value = item.nama;
      document.getElementById("edit-lokasi").value = item.lokasi || '';
      document.getElementById("edit-deskripsi").value = item.deskripsi || '';
      document.getElementById("edit-gambar").value = item.gambar || '';
      document.getElementById("edit-rating").value = item.rating || 4.0;
      document.getElementById("edit-harga").value = item.harga || '';
      document.getElementById("edit-bahan_bahan").value = item.bahan_bahan || '';
      document.getElementById("edit-cara_membuat").value = item.cara_membuat || '';
      document.getElementById("edit-tips_saji").value = item.tips_saji || '';
      document.getElementById("edit-is_featured").checked = item.is_featured || false;

      document.getElementById("editModal").style.display = "block";
    }

    // Close modal
    function closeModal() {
      document.getElementById("editModal").style.display = "none";
      editingId = null;
    }

    // Update data
    async function updateData() {
      const btn = event.target;
      const originalText = btn.innerHTML;
      btn.innerHTML = '<span class="loading"></span> Menyimpan...';
      btn.disabled = true;

      const input = {
        id: editingId,
        nama: document.getElementById("edit-nama").value.trim(),
        lokasi: document.getElementById("edit-lokasi").value.trim(),
        kategori_id: document.getElementById("edit-kategori").value,
        deskripsi: document.getElementById("edit-deskripsi").value.trim(),
        gambar: document.getElementById("edit-gambar").value.trim(),
        rating: document.getElementById("edit-rating").value,
        harga: document.getElementById("edit-harga").value,
        bahan_bahan: document.getElementById("edit-bahan_bahan").value.trim(),
        cara_membuat: document.getElementById("edit-cara_membuat").value.trim(),
        tips_saji: document.getElementById("edit-tips_saji").value.trim(),
        is_featured: document.getElementById("edit-is_featured").checked
      };

      try {
        const res = await fetch("api.php", {
          method: "PUT",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(input)
        });
        const result = await res.json();

        if (result.success) {
          showToast('✅ Data berhasil diperbarui!');
          closeModal();
          renderData();
          renderStats();
        } else {
          showToast(result.error || 'Gagal memperbarui data', 'error');
        }
      } catch (error) {
        showToast('Error: ' + error.message, 'error');
      } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
      }
    }

    // Hapus data
    async function hapusData(id) {
      if (!confirm("⚠️ Yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.")) return;

      try {
        const res = await fetch("api.php", {
          method: "DELETE",
          body: new URLSearchParams({
            id
          })
        });
        const result = await res.json();

        if (result.success) {
          showToast('🗑️ Data berhasil dihapus!');
          renderData();
          renderStats();
        } else {
          showToast(result.error || 'Gagal menghapus data', 'error');
        }
      } catch (error) {
        showToast('Error: ' + error.message, 'error');
      }
    }

    // Clear form
    function clearForm() {
      document.getElementById("nama").value = '';
      document.getElementById("lokasi").value = '';
      document.getElementById("kategori").value = '';
      document.getElementById("deskripsi").value = '';
      document.getElementById("gambar").value = '';
      document.getElementById("rating").value = '4.0';
      document.getElementById("harga").value = '';
      document.getElementById("bahan_bahan").value = '';
      document.getElementById("cara_membuat").value = '';
      document.getElementById("tips_saji").value = '';
      document.getElementById("is_featured").checked = false;
    }

    // Initialize
    window.onload = async () => {
      await getCategories();
      await populateCategorySelect("kategori");
      renderData();
      renderStats();

      // Close modal when clicking outside
      window.onclick = function(event) {
        const modal = document.getElementById("editModal");
        if (event.target == modal) {
          closeModal();
        }
      }
    };
  </script>
</head>

<body class="bg-gray-50 min-h-screen">

  <!-- Header -->
  <header class="gradient-header text-white p-4 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
      <div class="flex items-center gap-3">
        <div class="text-3xl">🍽️</div>
        <div>
          <h1 class="text-2xl font-bold">Bakuliner Kalsel Admin</h1>
          <p class="text-sm text-green-100">Panel Manajemen Konten</p>
        </div>
      </div>
      <div class="flex items-center gap-4">
        <a href="index.php" target="_blank" class="bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded-lg transition font-medium">
          🌐 Lihat Website
        </a>
        <a href="?logout=1" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded-lg transition font-medium">
          🚪 Logout
        </a>
      </div>
    </div>
  </header>

  <main class="max-w-7xl mx-auto p-4 md:p-6 space-y-6">

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
      <div class="stat-card p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-100 text-sm font-medium">Total Item</p>
            <p id="total-kuliner" class="text-4xl font-bold mt-2">0</p>
          </div>
          <div class="text-5xl">📦</div>
        </div>
      </div>

      <div class="stat-card p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-100 text-sm font-medium">Rating Rata-rata</p>
            <p id="avg-rating" class="text-4xl font-bold mt-2">0</p>
          </div>
          <div class="text-5xl">⭐</div>
        </div>
      </div>

      <div class="stat-card p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-100 text-sm font-medium">Rating Tinggi (≥4.5)</p>
            <p id="top-rated" class="text-4xl font-bold mt-2">0</p>
          </div>
          <div class="text-5xl">🏆</div>
        </div>
      </div>

      <div class="stat-card p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-100 text-sm font-medium">Featured Items</p>
            <p id="featured-items" class="text-4xl font-bold mt-2">0</p>
          </div>
          <div class="text-5xl">🔥</div>
        </div>
      </div>

      <div class="stat-card p-6 rounded-xl shadow-lg">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-green-100 text-sm font-medium">Total Kategori</p>
            <p id="total-categories" class="text-4xl font-bold mt-2">0</p>
          </div>
          <div class="text-5xl">📂</div>
        </div>
      </div>
    </div>

    <!-- Form Tambah -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-green-200">
      <h2 class="text-2xl font-bold text-high-contrast mb-6 flex items-center gap-2">
        <span>➕</span> Tambah Item Baru
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-high-contrast font-bold mb-2">Nama Item *</label>
          <input id="nama" placeholder="Contoh: Soto Banjar"
            class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast">
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">Lokasi</label>
          <input id="lokasi" placeholder="Contoh: Banjarmasin"
            class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast">
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">Kategori *</label>
          <select id="kategori" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast">
            <option value="">Pilih Kategori</option>
          </select>
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">Harga (Rp)</label>
          <input id="harga" type="number" placeholder="Contoh: 25000"
            class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast">
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">Rating (0-5)</label>
          <input id="rating" type="number" step="0.1" min="0" max="5" value="4.0"
            class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast">
        </div>
        <div class="flex items-center">
          <input id="is_featured" type="checkbox" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
          <label for="is_featured" class="ml-2 text-high-contrast font-bold">Featured Item</label>
        </div>
        <div class="md:col-span-2">
          <label class="block text-high-contrast font-bold mb-2">URL Gambar</label>
          <input id="gambar" placeholder="https://example.com/image.jpg"
            class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast">
        </div>
        <div class="md:col-span-2">
          <label class="block text-high-contrast font-bold mb-2">Bahan-bahan</label>
          <textarea id="bahan_bahan" rows="2" placeholder="Bahan-bahan yang digunakan..."
            class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast"></textarea>
        </div>
        <div class="md:col-span-2">
          <label class="block text-high-contrast font-bold mb-2">Cara Membuat</label>
          <textarea id="cara_membuat" rows="3" placeholder="Langkah-langkah pembuatan..."
            class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast"></textarea>
        </div>
        <div class="md:col-span-2">
          <label class="block text-high-contrast font-bold mb-2">Tips Penyajian</label>
          <textarea id="tips_saji" rows="2" placeholder="Tips untuk penyajian..."
            class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast"></textarea>
        </div>
        <div class="md:col-span-2">
          <label class="block text-high-contrast font-bold mb-2">Deskripsi</label>
          <textarea id="deskripsi" rows="3" placeholder="Deskripsi singkat..."
            class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast"></textarea>
        </div>
      </div>
      <div class="mt-6 flex gap-3">
        <button onclick="tambahData()"
          class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-3 rounded-lg font-bold hover:from-green-700 hover:to-green-800 transition transform hover:scale-105 shadow-lg">
          ➕ Tambah Item
        </button>
        <button onclick="clearForm()"
          class="bg-gray-200 text-high-contrast px-6 py-3 rounded-lg font-bold hover:bg-gray-300 transition">
          🔄 Reset Form
        </button>
      </div>
    </div>

    <!-- Search & List -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-2 border-green-200">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <h2 class="text-2xl font-bold text-high-contrast flex items-center gap-2">
          <span>📋</span> Daftar Konten
        </h2>
        <div class="w-full md:w-96">
          <input type="text"
            onkeyup="handleSearch(event)"
            placeholder="🔍 Cari nama, lokasi, atau kategori..."
            class="search-box w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition text-high-contrast">
        </div>
      </div>
      <div id="kuliner-list" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <!-- Data akan dimuat di sini -->
      </div>
    </div>

  </main>

  <!-- Edit Modal -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-6 rounded-t-2xl">
        <div class="flex justify-between items-center">
          <h3 class="text-2xl font-bold">✏️ Edit Item</h3>
          <button onclick="closeModal()" class="text-3xl hover:text-gray-200 transition">&times;</button>
        </div>
      </div>

      <div class="p-6 space-y-4 bg-white">
        <div>
          <label class="block text-high-contrast font-bold mb-2">Nama Item</label>
          <input id="edit-nama" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast">
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">Lokasi</label>
          <input id="edit-lokasi" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast">
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">Kategori</label>
          <select id="edit-kategori" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast">
            <option value="">Pilih Kategori</option>
          </select>
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">Harga (Rp)</label>
          <input id="edit-harga" type="number" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast">
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">Rating</label>
          <input id="edit-rating" type="number" step="0.1" min="0" max="5" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast">
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">URL Gambar</label>
          <input id="edit-gambar" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast">
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">Bahan-bahan</label>
          <textarea id="edit-bahan_bahan" rows="2" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast"></textarea>
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">Cara Membuat</label>
          <textarea id="edit-cara_membuat" rows="3" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast"></textarea>
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">Tips Penyajian</label>
          <textarea id="edit-tips_saji" rows="2" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast"></textarea>
        </div>
        <div>
          <label class="block text-high-contrast font-bold mb-2">Deskripsi</label>
          <textarea id="edit-deskripsi" rows="3" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast"></textarea>
        </div>
        <div class="flex items-center">
          <input id="edit-is_featured" type="checkbox" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500">
          <label for="edit-is_featured" class="ml-2 text-high-contrast font-bold">Featured Item</label>
        </div>

        <div class="flex gap-3 pt-4">
          <button onclick="updateData()"
            class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-lg font-bold hover:from-green-600 hover:to-green-700 transition shadow-lg">
            💾 Simpan Perubahan
          </button>
          <button onclick="closeModal()"
            class="flex-1 bg-gray-200 text-high-contrast px-6 py-3 rounded-lg font-bold hover:bg-gray-300 transition">
            ❌ Batal
          </button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>