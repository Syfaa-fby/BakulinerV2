<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bakuliner Kalsel - Kuliner & Budaya Kalimantan Selatan 🍜</title>
  <meta
    name="description"
    content="Temukan kuliner khas, pakaian adat, dan souvenir Kalimantan Selatan di Bakuliner Kalsel!" />
  <link
    href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"
    rel="stylesheet" />
  <style>
    * {
      box-sizing: border-box;
    }

    /* Custom Color Palette */
    :root {
      --dark-green: #043915;
      --medium-green: #4c763b;
      --light-green: #b0ce88;
      --light-yellow: #fffd8f;
    }

    .gradient-hero {
      background: linear-gradient(135deg, #043915 0%, #4c763b 100%);
    }

    .bg-dark-green {
      background-color: #043915;
    }

    .bg-medium-green {
      background-color: #4c763b;
    }

    .bg-light-green {
      background-color: #b0ce88;
    }

    .bg-light-yellow {
      background-color: #fffd8f;
    }

    .text-dark-green {
      color: #043915;
    }

    .text-medium-green {
      color: #4c763b;
    }

    .text-light-green {
      color: #b0ce88;
    }

    .border-medium-green {
      border-color: #4c763b;
    }

    .card-hover {
      transition: all 0.3s ease;
      border: 2px solid transparent;
    }

    .card-hover:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 40px rgba(4, 57, 21, 0.2);
      border-color: #4c763b;
    }

    .category-badge {
      display: inline-block;
      padding: 8px 20px;
      border-radius: 25px;
      font-size: 0.875rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      border: 2px solid #4c763b;
      background: white;
      color: #4c763b;
    }

    .category-badge:hover {
      transform: scale(1.05);
      background: #b0ce88;
      color: #043915;
    }

    .category-badge.active {
      background: linear-gradient(135deg, #4c763b 0%, #043915 100%);
      color: white;
      border-color: #043915;
    }

    .loading-spinner {
      border: 4px solid #f3f4f6;
      border-top: 4px solid #4c763b;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      margin: 40px auto;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .hero-pattern {
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23B0CE88' fill-opacity='0.15'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .rating-stars {
      color: #fffd8f;
      text-shadow: 0 0 3px rgba(0, 0, 0, 0.3);
    }

    .search-input {
      border: 3px solid #4c763b;
    }

    .search-input:focus {
      outline: none;
      border-color: #043915;
      box-shadow: 0 0 0 4px rgba(76, 118, 59, 0.1);
    }

    .btn-primary {
      background: linear-gradient(135deg, #4c763b 0%, #043915 100%);
      color: white;
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(4, 57, 21, 0.3);
    }

    .stat-badge {
      background: linear-gradient(135deg, #fffd8f 0%, #b0ce88 100%);
      color: #043915;
      font-weight: bold;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.75rem;
    }

    .reko-card {
      background: linear-gradient(135deg, #b0ce88 0%, #fffd8f 100%);
    }

    /* Modal Styles */
    .modal {
      display: flex;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      animation: fadeIn 0.3s ease;
    }

    .modal.hidden {
      display: none;
    }

    .modal-content {
      background-color: white;
      margin: auto;
      border-radius: 16px;
      width: 90%;
      max-width: 500px;
      max-height: 90vh;
      overflow-y: auto;
      animation: slideUp 0.3s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }

      to {
        opacity: 1;
      }
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

    /* Toast Styles */
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

    /* Improved text contrast */
    .text-high-contrast {
      color: #1a202c;
      /* Very dark gray almost black */
    }

    .text-medium-contrast {
      color: #2d3748;
      /* Dark gray */
    }

    .bg-high-contrast {
      background-color: #1a202c;
    }

    .btn-cart {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      color: white;
      transition: all 0.3s ease;
    }

    .btn-cart:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
    }

    @media (max-width: 640px) {
      .hero-title {
        font-size: 2rem;
      }
    }
  </style>
</head>

<body
  class="bg-gradient-to-b from-dark-green via-dark-green to-[#2A4D2E] text-gray-100">
  <!-- Navbar -->
  <nav
    class="bg-white shadow-lg sticky top-0 z-50 border-b-4 border-medium-green">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <div class="flex items-center gap-3">
          <span class="text-4xl">🌴</span>
          <div>
            <h1 class="text-2xl font-bold text-dark-green">
              Bakuliner Kalsel
            </h1>
            <p class="text-xs text-medium-green font-medium">
              Kalimantan Selatan
            </p>
          </div>
        </div>
        <div class="flex items-center gap-4">
          <a
            href="#rekomendasi"
            class="hidden sm:block text-medium-green hover:text-dark-green font-semibold transition">
            ⭐ Rekomendasi
          </a>
          <a
            href="#katalog"
            class="hidden sm:block text-medium-green hover:text-dark-green font-semibold transition">
            📦 Katalog
          </a>
          <button onclick="openOrderModal()" class="relative btn-cart px-4 py-2 rounded-full font-semibold transition">
            🛒 Keranjang
            <span id="cart-badge" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 text-xs flex items-center justify-center hidden">0</span>
          </button>
          <a
            href="admin.php"
            class="bg-gradient-to-r from-red-500 to-red-600 text-white px-5 py-2 rounded-full font-semibold shadow-lg hover:from-red-600 hover:to-red-700 transition">
            🔐 Login Admin
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="gradient-hero hero-pattern text-white py-24">
    <div class="max-w-7xl mx-auto px-4 text-center">
      <div class="text-8xl mb-6 animate-bounce">🍽️</div>
      <h1
        class="hero-title text-5xl md:text-6xl font-extrabold mb-4 drop-shadow-lg text-light-yellow">
        Budaya & Kuliner Kalimantan Selatan
      </h1>
      <p class="text-xl md:text-2xl text-light-green mb-10 font-medium">
        Dari makanan khas, kue tradisional, hingga pakaian adat & souvenir
        asli Kalsel
      </p>
      <div class="max-w-2xl mx-auto">
        <div class="relative">
          <input
            type="text"
            onkeyup="handleSearch(event)"
            placeholder="🔍 Cari kuliner, pakaian, atau souvenir..."
            class="search-input w-full px-6 py-5 rounded-full text-gray-800 text-lg shadow-2xl bg-white" />
          <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
            <span class="text-3xl">🔍</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Categories -->
  <section class="max-w-7xl mx-auto px-4 -mt-10">
    <div
      class="bg-white rounded-3xl shadow-2xl p-6 border-4 border-medium-green">
      <h3 class="text-center text-dark-green font-bold text-lg mb-4">
        📂 Pilih Kategori
      </h3>
      <div class="flex flex-wrap gap-3 justify-center" id="category-list">
        <!-- Categories will be loaded here -->
      </div>
    </div>
  </section>

  <!-- Rekomendasi -->
  <section id="rekomendasi" class="max-w-7xl mx-auto px-4 py-20">
    <div class="text-center mb-12">
      <div
        class="inline-block bg-light-yellow text-dark-green px-6 py-2 rounded-full font-bold text-sm mb-4 border-2 border-medium-green">
        ⭐ PILIHAN TERBAIK
      </div>
      <h2 class="text-5xl font-extrabold text-dark-green mb-4">
        Rekomendasi Unggulan
      </h2>
      <p class="text-gray-600 text-lg">
        Produk dengan rating tertinggi dari Kalimantan Selatan
      </p>
    </div>
    <div
      id="rekomendasi-list"
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <!-- Recommendations will be loaded here -->
    </div>
  </section>

  <!-- Katalog Lengkap -->
  <section
    id="katalog"
    class="max-w-7xl mx-auto px-4 py-20 bg-gradient-to-b from-white to-light-green">
    <div class="text-center mb-12">
      <div
        class="inline-block bg-medium-green text-white px-6 py-2 rounded-full font-bold text-sm mb-4">
        📦 KATALOG LENGKAP
      </div>
      <h2 class="text-5xl font-extrabold text-dark-green mb-4">
        Jelajahi Semua Produk
      </h2>
      <p class="text-gray-700 text-lg">
        Menampilkan
        <span id="result-count" class="font-bold text-medium-green text-2xl">0</span>
        item pilihan
      </p>
    </div>
    <div
      id="kuliner-list"
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
      <!-- All items will be loaded here -->
    </div>
  </section>

  <!-- Modal Pemesanan -->
  <div id="orderModal" class="modal hidden">
    <div class="modal-content">
      <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-6 rounded-t-2xl">
        <div class="flex justify-between items-center">
          <h3 class="text-2xl font-bold">🛒 Pesan Sekarang</h3>
          <button onclick="closeOrderModal()" class="text-3xl hover:text-gray-200 transition">&times;</button>
        </div>
      </div>
      <div class="p-6 bg-white">
        <form id="orderForm" class="space-y-4">
          <div>
            <label class="block text-high-contrast font-bold mb-2 text-lg">Nama Lengkap *</label>
            <input type="text" name="nama_pemesan" required
              class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast bg-white placeholder-green-400">
          </div>
          <div>
            <label class="block text-high-contrast font-bold mb-2 text-lg">Email *</label>
            <input type="email" name="email" required
              class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast bg-white placeholder-green-400">
          </div>
          <div>
            <label class="block text-high-contrast font-bold mb-2 text-lg">Telepon *</label>
            <input type="tel" name="telepon" required
              class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast bg-white placeholder-green-400">
          </div>
          <div>
            <label class="block text-high-contrast font-bold mb-2 text-lg">Alamat Pengiriman *</label>
            <textarea name="alamat" rows="3" required
              class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 text-high-contrast bg-white placeholder-green-400"></textarea>
          </div>

          <div class="border-t-2 border-green-300 pt-4">
            <h4 class="text-high-contrast font-bold text-lg mb-3">🛍️ Produk Dipesan:</h4>
            <div id="order-items" class="space-y-3">
              <!-- Items will be loaded here -->
            </div>
          </div>

          <div class="flex justify-between items-center pt-4 border-t-2 border-green-300">
            <span class="text-xl font-bold text-high-contrast">Total Pembayaran:</span>
            <span id="order-total" class="text-3xl font-bold text-green-600 bg-green-50 px-4 py-2 rounded-lg">Rp 0</span>
          </div>

          <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <span class="text-yellow-500 text-xl">💡</span>
              </div>
              <div class="ml-3">
                <p class="text-yellow-700 text-sm">
                  <strong>Info:</strong> Pesanan akan diproses dalam 1x24 jam. Tim kami akan menghubungi Anda untuk konfirmasi.
                </p>
              </div>
            </div>
          </div>

          <button type="submit"
            class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-4 rounded-lg font-bold text-lg hover:from-green-700 hover:to-green-800 transition shadow-lg transform hover:scale-105">
            🚀 Konfirmasi Pesanan
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer
    class="bg-dark-green text-white py-12 border-t-8 border-light-yellow">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
        <div>
          <div class="flex items-center gap-3 mb-4">
            <span class="text-4xl">🌴</span>
            <div>
              <span class="text-2xl font-bold">Bakuliner Kalsel</span>
              <p class="text-sm text-light-green">Kalimantan Selatan</p>
            </div>
          </div>
          <p class="text-light-green leading-relaxed">
            Platform digital untuk mempromosikan kuliner, budaya, dan produk
            lokal Kalimantan Selatan kepada dunia.
          </p>
        </div>
        <div>
          <h3 class="text-xl font-bold mb-4 text-light-yellow">
            📂 Kategori
          </h3>
          <ul class="space-y-2 text-light-green">
            <li class="hover:text-light-yellow transition cursor-pointer">
              🍛 Makanan Berat
            </li>
            <li class="hover:text-light-yellow transition cursor-pointer">
              🍰 Kue Tradisional
            </li>
            <li class="hover:text-light-yellow transition cursor-pointer">
              👕 Pakaian Khas Daerah
            </li>
            <li class="hover:text-light-yellow transition cursor-pointer">
              🎁 Souvenir & Oleh-oleh
            </li>
          </ul>
        </div>
        <div>
          <h3 class="text-xl font-bold mb-4 text-light-yellow">📞 Kontak</h3>
          <div class="space-y-3 text-light-green">
            <p class="flex items-center gap-2">
              <span>📧</span> info@bakulinerkalsel.id
            </p>
            <p class="flex items-center gap-2">
              <span>📱</span> +62 812-3456-7890
            </p>
            <p class="flex items-center gap-2">
              <span>📍</span> Banjarmasin, Kalimantan Selatan
            </p>
          </div>
        </div>
      </div>
      <div class="border-t-2 border-medium-green pt-8 text-center">
        <p class="text-light-yellow font-semibold text-lg mb-2">
          🌟 Bangga Produk Lokal Kalimantan Selatan 🌟
        </p>
        <p class="text-light-green text-sm">
          &copy; 2025 Bakuliner Kalsel. Dibuat dengan ❤️ untuk Borneo
        </p>
      </div>
    </div>
  </footer>

  <script>
    let allData = [];
    let currentCategory = 0;
    let currentSearch = "";
    let categories = [];
    let cart = [];

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

    async function getCategories() {
      try {
        const res = await fetch("api.php?action=categories");
        const result = await res.json();
        categories = result.data || [];
        return categories;
      } catch (error) {
        console.error("Error fetching categories:", error);
        showToast('Gagal memuat kategori', 'error');
        return [];
      }
    }

    async function getData() {
      try {
        const res = await fetch("api.php");
        const result = await res.json();
        allData = result.data || result;
        return allData;
      } catch (error) {
        console.error("Error fetching data:", error);
        showToast('Gagal memuat data produk', 'error');
        return [];
      }
    }

    function filterData() {
      let filtered = allData;

      if (currentCategory > 0) {
        filtered = filtered.filter(
          (item) => item.kategori_id == currentCategory
        );
      }

      if (currentSearch) {
        filtered = filtered.filter(
          (item) =>
          item.nama.toLowerCase().includes(currentSearch.toLowerCase()) ||
          (item.lokasi &&
            item.lokasi
            .toLowerCase()
            .includes(currentSearch.toLowerCase())) ||
          (item.deskripsi &&
            item.deskripsi
            .toLowerCase()
            .includes(currentSearch.toLowerCase())) ||
          (item.nama_kategori &&
            item.nama_kategori
            .toLowerCase()
            .includes(currentSearch.toLowerCase()))
        );
      }

      return filtered;
    }

    function renderStars(rating) {
      const numericRating = parseFloat(rating) || 0;
      const fullStars = Math.floor(numericRating);
      const hasHalfStar = numericRating % 1 >= 0.5;
      let stars = "";

      for (let i = 0; i < fullStars; i++) {
        stars += "⭐";
      }
      if (hasHalfStar && fullStars < 5) {
        stars += "⭐";
      }

      // Fill remaining stars with outline
      const remainingStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
      for (let i = 0; i < remainingStars; i++) {
        stars += "☆";
      }

      return stars;
    }

    function renderKuliner() {
      const filtered = filterData();
      const list = document.getElementById("kuliner-list");

      if (filtered.length === 0) {
        list.innerHTML = `
        <div class="col-span-full text-center py-16">
          <div class="text-7xl mb-4">🔍</div>
          <h3 class="text-2xl font-bold text-dark-green mb-2">Tidak Ada Hasil</h3>
          <p class="text-gray-600">Coba kata kunci atau kategori lain</p>
        </div>
      `;
        return;
      }

      list.innerHTML = filtered
        .map((item) => {
          const categoryIcons = {
            "Makanan Berat": "🍛",
            "Kue Tradisional": "🍰",
            "Minuman Khas": "🥤",
            "Pakaian Adat": "👕",
            "Souvenir": "🎁",
            "Oleh-oleh": "🛍️"
          };
          const icon = categoryIcons[item.nama_kategori] || "📦";
          const harga = item.harga ? `Rp ${item.harga.toLocaleString('id-ID')}` : 'Hubungi Admin';

          return `
      <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-lg">
        <div class="relative">
          <img src="${item.gambar}" alt="${item.nama}" 
               class="h-56 w-full object-cover"
               onerror="this.src='https://via.placeholder.com/400x300/4C763B/ffffff?text=${encodeURIComponent(
                 item.nama
               )}'">
          <div class="absolute top-4 right-4 bg-dark-green px-3 py-2 rounded-full shadow-lg">
            <span class="rating-stars font-bold text-sm">${renderStars(
              parseFloat(item.rating || 0)
            )}</span>
          </div>
          <div class="absolute top-4 left-4 bg-light-yellow text-dark-green px-3 py-2 rounded-full text-xs font-bold shadow-lg border-2 border-medium-green">
            ${icon} ${item.nama_kategori || "Lainnya"}
          </div>
        </div>
        <div class="p-5 bg-gradient-to-b from-white to-gray-50">
          <h3 class="text-xl font-bold text-dark-green mb-2 line-clamp-1">${
            item.nama
          }</h3>
          <p class="text-medium-green font-semibold mb-3 flex items-center gap-1">
            <span>📍</span> ${item.lokasi || "Kalimantan Selatan"}
          </p>
          <p class="text-gray-700 text-sm mb-3 line-clamp-2">${
            item.deskripsi || "Tidak ada deskripsi"
          }</p>
          <div class="flex items-center justify-between mt-4 pt-3 border-t border-light-green">
            <span class="text-lg font-bold text-dark-green">${harga}</span>
            <span class="text-medium-green font-bold">${
              item.rating || 0
            }/5</span>
          </div>
          <div class="mt-4 flex gap-2">
            <button onclick="addToCart(${item.id})" 
                    class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white px-4 py-2 rounded-lg hover:from-green-700 hover:to-green-800 transition font-medium">
              🛒 Tambah
            </button>
            <button onclick="showDetail(${item.id})" 
                    class="flex-1 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-blue-600 hover:to-blue-700 transition font-medium">
              ℹ️ Detail
            </button>
          </div>
        </div>
      </div>
    `;
        })
        .join("");

      document.getElementById("result-count").textContent = filtered.length;
    }

    async function renderRekomendasi() {
      const data = await getData();
      const top = data
        .filter((d) => parseFloat(d.rating || 0) >= 4.5)
        .slice(0, 4);
      const list = document.getElementById("rekomendasi-list");

      if (top.length === 0) {
        list.innerHTML =
          '<p class="text-center text-gray-500 col-span-full">Belum ada rekomendasi</p>';
        return;
      }

      list.innerHTML = top
        .map(
          (item) => `
      <div class="card-hover reko-card rounded-2xl overflow-hidden shadow-xl border-2 border-medium-green">
        <div class="relative">
          <img src="${item.gambar}" 
               class="h-44 w-full object-cover"
               onerror="this.src='https://via.placeholder.com/400x200/4C763B/ffffff?text=${encodeURIComponent(
                 item.nama
               )}'">
          <div class="absolute top-3 right-3 bg-dark-green px-3 py-1 rounded-full shadow-lg">
            <span class="rating-stars font-bold text-xs">${renderStars(
              parseFloat(item.rating || 0)
            )}</span>
          </div>
        </div>
        <div class="p-4">
          <h4 class="font-bold text-dark-green text-lg mb-2 line-clamp-1">${
            item.nama
          }</h4>
          <p class="text-sm text-medium-green mb-3 font-medium">📍 ${
            item.lokasi || "Kalsel"
          }</p>
          <div class="flex items-center justify-between pt-2 border-t-2 border-medium-green">
            <span class="text-xs font-semibold text-dark-green bg-white px-2 py-1 rounded">${
              item.nama_kategori || "Item"
            }</span>
            <span class="text-dark-green font-bold text-xl">${
              item.rating || 0
            }</span>
          </div>
          <button onclick="addToCart(${item.id})" 
                  class="w-full mt-3 bg-gradient-to-r from-green-600 to-green-700 text-white py-2 rounded-lg hover:from-green-700 hover:to-green-800 transition font-medium">
            🛒 Tambah ke Keranjang
          </button>
        </div>
      </div>
    `
        )
        .join("");
    }

    function setCategory(categoryId) {
      currentCategory = categoryId;

      document.querySelectorAll(".category-badge").forEach((badge) => {
        badge.classList.remove("active");
      });

      if (event) {
        event.target.classList.add("active");
      }

      renderKuliner();
    }

    function handleSearch(event) {
      currentSearch = event.target.value.trim();
      renderKuliner();
    }

    // Cart functionality
    function addToCart(itemId) {
      const item = allData.find(d => d.id == itemId);
      if (!item) {
        showToast('Produk tidak ditemukan', 'error');
        return;
      }

      const existingItem = cart.find(cartItem => cartItem.id == itemId);
      if (existingItem) {
        existingItem.quantity += 1;
      } else {
        cart.push({
          id: item.id,
          nama: item.nama,
          harga: item.harga || 0,
          quantity: 1,
          gambar: item.gambar
        });
      }

      updateCartBadge();
      showToast(`✅ ${item.nama} ditambahkan ke keranjang`, 'success');
    }

    function updateCartBadge() {
      const badge = document.getElementById('cart-badge');
      const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);

      if (badge) {
        badge.textContent = totalItems;
        badge.classList.toggle('hidden', totalItems === 0);
      }
    }

    function openOrderModal() {
      if (cart.length === 0) {
        showToast('Keranjang masih kosong', 'error');
        return;
      }

      const modal = document.getElementById('orderModal');
      const itemsContainer = document.getElementById('order-items');
      const totalElement = document.getElementById('order-total');

      itemsContainer.innerHTML = cart.map(item => `
        <div class="flex justify-between items-center py-3 border-b border-green-200">
          <div class="flex items-center gap-3">
            <img src="${item.gambar}" alt="${item.nama}" 
                 class="w-12 h-12 object-cover rounded-lg border-2 border-green-200"
                 onerror="this.src='https://via.placeholder.com/100/4C763B/ffffff?text=IMG'">
            <div>
              <h4 class="font-bold text-high-contrast">${item.nama}</h4>
              <p class="text-sm text-green-600 font-semibold">Rp ${item.harga.toLocaleString('id-ID')}</p>
            </div>
          </div>
          <div class="flex items-center gap-2 bg-green-50 rounded-lg px-2 py-1">
            <button type="button" onclick="updateQuantity(${item.id}, -1)" 
                    class="w-8 h-8 bg-green-200 text-green-800 rounded-full hover:bg-green-300 transition font-bold">-</button>
            <span class="w-8 text-center font-bold text-high-contrast">${item.quantity}</span>
            <button type="button" onclick="updateQuantity(${item.id}, 1)" 
                    class="w-8 h-8 bg-green-200 text-green-800 rounded-full hover:bg-green-300 transition font-bold">+</button>
          </div>
        </div>
      `).join('');

      const total = cart.reduce((sum, item) => sum + (item.harga * item.quantity), 0);
      totalElement.textContent = `Rp ${total.toLocaleString('id-ID')}`;

      modal.classList.remove('hidden');
    }

    function updateQuantity(itemId, change) {
      const item = cart.find(i => i.id === itemId);
      if (item) {
        item.quantity = Math.max(0, item.quantity + change);

        if (item.quantity === 0) {
          cart = cart.filter(i => i.id !== itemId);
        }

        updateCartBadge();

        if (cart.length === 0) {
          closeOrderModal();
        } else {
          openOrderModal(); // Refresh modal
        }
      }
    }

    function closeOrderModal() {
      document.getElementById('orderModal').classList.add('hidden');
    }

    function showDetail(itemId) {
      const item = allData.find(d => d.id == itemId);
      if (!item) {
        showToast('Detail produk tidak ditemukan', 'error');
        return;
      }

      const harga = item.harga ? `Rp ${item.harga.toLocaleString('id-ID')}` : 'Hubungi Admin untuk harga';

      const detailHTML = `
        <div class="modal">
          <div class="modal-content" style="max-width: 600px;">
            <div class="bg-gradient-to-r from-green-600 to-green-700 text-white p-6 rounded-t-2xl">
              <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold">📋 Detail Produk</h3>
                <button onclick="this.closest('.modal').remove()" class="text-3xl hover:text-gray-200 transition">&times;</button>
              </div>
            </div>
            <div class="p-6 bg-white">
              <div class="mb-6">
                <img src="${item.gambar}" alt="${item.nama}" 
                     class="w-full h-64 object-cover rounded-lg mb-4 border-4 border-green-200"
                     onerror="this.src='https://via.placeholder.com/600x400/4C763B/ffffff?text=No+Image'">
                <h4 class="text-2xl font-bold text-high-contrast mb-2">${item.nama}</h4>
                <p class="text-medium-green font-semibold mb-2">📍 ${item.lokasi || 'Kalimantan Selatan'}</p>
                <div class="flex items-center gap-4 mb-4 flex-wrap">
                  <span class="bg-light-yellow text-dark-green px-3 py-1 rounded-full text-sm font-bold">
                    ${item.nama_kategori || 'Lainnya'}
                  </span>
                  <span class="text-lg font-bold text-high-contrast bg-green-50 px-3 py-1 rounded-lg">${harga}</span>
                  <span class="text-lg font-bold text-high-contrast bg-yellow-50 px-3 py-1 rounded-lg">${renderStars(item.rating)} ${item.rating || 0}/5</span>
                </div>
              </div>
              
              ${item.deskripsi ? `
              <div class="mb-4">
                <h5 class="font-bold text-high-contrast mb-2 text-lg">📝 Deskripsi</h5>
                <p class="text-medium-contrast bg-gray-50 p-3 rounded-lg">${item.deskripsi}</p>
              </div>
              ` : ''}
              
              ${item.bahan_bahan ? `
              <div class="mb-4">
                <h5 class="font-bold text-high-contrast mb-2 text-lg">🛒 Bahan-bahan</h5>
                <p class="text-medium-contrast bg-green-50 p-3 rounded-lg whitespace-pre-line">${item.bahan_bahan}</p>
              </div>
              ` : ''}
              
              ${item.cara_membuat ? `
              <div class="mb-4">
                <h5 class="font-bold text-high-contrast mb-2 text-lg">👨‍🍳 Cara Membuat</h5>
                <p class="text-medium-contrast bg-blue-50 p-3 rounded-lg whitespace-pre-line">${item.cara_membuat}</p>
              </div>
              ` : ''}
              
              ${item.tips_saji ? `
              <div class="mb-4">
                <h5 class="font-bold text-high-contrast mb-2 text-lg">💡 Tips Penyajian</h5>
                <p class="text-medium-contrast bg-yellow-50 p-3 rounded-lg whitespace-pre-line">${item.tips_saji}</p>
              </div>
              ` : ''}
              
              <div class="flex gap-3 mt-6">
                <button onclick="addToCart(${item.id}); this.closest('.modal').remove();" 
                        class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white py-3 rounded-lg font-bold hover:from-green-700 hover:to-green-800 transition text-lg">
                  🛒 Tambah ke Keranjang
                </button>
                <button onclick="this.closest('.modal').remove()" 
                        class="flex-1 bg-gray-200 text-high-contrast py-3 rounded-lg font-bold hover:bg-gray-300 transition text-lg">
                  ❌ Tutup
                </button>
              </div>
            </div>
          </div>
        </div>
      `;

      document.body.insertAdjacentHTML('beforeend', detailHTML);
    }

    // Handle form submission
    document.getElementById('orderForm')?.addEventListener('submit', async function(e) {
      e.preventDefault();

      const formData = new FormData(this);
      const orderData = {
        nama_pemesan: formData.get('nama_pemesan'),
        email: formData.get('email'),
        telepon: formData.get('telepon'),
        alamat: formData.get('alamat'),
        items: cart,
        total_harga: cart.reduce((sum, item) => sum + (item.harga * item.quantity), 0)
      };

      // Show loading state
      const submitBtn = this.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      submitBtn.innerHTML = '<span class="loading"></span> Memproses...';
      submitBtn.disabled = true;

      try {
        const res = await fetch("api.php?action=order", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(orderData)
        });
        const result = await res.json();

        if (result.success) {
          showToast(`✅ Pesanan berhasil! Kode: ${result.data.kode_pesanan}`, 'success');
          cart = [];
          updateCartBadge();
          closeOrderModal();
          this.reset();
        } else {
          showToast(result.error || 'Gagal membuat pesanan', 'error');
        }
      } catch (error) {
        showToast('Error: Gagal membuat pesanan', 'error');
      } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
      }
    });

    async function init() {
      document.getElementById("kuliner-list").innerHTML =
        '<div class="loading-spinner col-span-full"></div>';

      const cats = await getCategories();
      await getData();
      await renderRekomendasi();
      renderKuliner();

      const categoryList = document.getElementById("category-list");
      const categoryIcons = {
        "Makanan Berat": "🍛",
        "Kue Tradisional": "🍰",
        "Minuman Khas": "🥤",
        "Pakaian Adat": "👕",
        "Souvenir": "🎁",
        "Oleh-oleh": "🛍️"
      };

      const categoryHTML = cats
        .map(
          (cat) => `
      <button onclick="setCategory(${cat.id})" 
              class="category-badge">
        ${categoryIcons[cat.nama_kategori] || "📦"} ${cat.nama_kategori}
      </button>
    `
        )
        .join("");

      categoryList.innerHTML = `
      <button onclick="setCategory(0)" 
              class="category-badge active">
        🌟 Semua Kategori
      </button>
      ${categoryHTML}
    `;
    }

    window.onload = init;
  </script>
</body>

</html>``