<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - Kampung Nopia Banyumas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { font-family: 'Poppins', sans-serif; padding-top: 80px; background-color: #f8f9fa; }
        .text-brown { color: #A67C52 !important; }
        .bg-brown { background-color: #A67C52 !important; }
        .btn-brown { background-color: #A67C52; color: white; border: none; }
        .btn-brown:hover { background-color: #8B6340; color: white; }
        .cart-badge { position: absolute; top: -8px; right: -8px; background: #ff6b6b; color: white; border-radius: 50%; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
        .cart-icon-wrapper { position: relative; cursor: pointer; }
        .product-hero { background: linear-gradient(135deg, #A67C52 0%, #8B6340 100%); color: white; padding: 80px 0 60px; margin-top: -80px; padding-top: 160px; }
        .product-card { border: none; border-radius: 20px; overflow: hidden; transition: all 0.3s ease; background: white; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); height: 100%; }
        .product-card:hover { transform: translateY(-10px); box-shadow: 0 8px 30px rgba(166, 124, 82, 0.2); }
        .product-image-wrapper { position: relative; overflow: hidden; height: 280px; }
        .product-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .product-card:hover img { transform: scale(1.1); }
        .product-badge { position: absolute; top: 15px; right: 15px; padding: 6px 15px; border-radius: 50px; font-size: 12px; font-weight: 600; z-index: 1; }
        .badge-bestseller { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); color: white; }
        .badge-new { background: linear-gradient(135deg, #51cf66 0%, #37b24d 100%); color: white; }
        .product-info { padding: 25px; }
        .product-rating { color: #ffd43b; font-size: 14px; margin-bottom: 10px; }
        .product-title { font-size: 20px; font-weight: 700; color: #333; margin-bottom: 10px; }
        .product-description { color: #666; font-size: 14px; line-height: 1.6; margin-bottom: 15px; }
        .price-tag { font-size: 24px; font-weight: 800; color: #A67C52; }
        .cart-sidebar { position: fixed; right: -400px; top: 0; width: 400px; height: 100vh; background: white; box-shadow: -5px 0 15px rgba(0,0,0,0.2); transition: right 0.3s ease; z-index: 1050; overflow-y: auto; }
        .cart-sidebar.active { right: 0; }
        .cart-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; z-index: 1040; }
        .cart-overlay.active { display: block; }
        .cart-item { border-bottom: 1px solid #eee; padding: 15px 0; }
        .cart-item-image { width: 80px; height: 80px; object-fit: cover; border-radius: 10px; }
        .quantity-control { display: flex; align-items: center; gap: 10px; }
        .quantity-btn { width: 30px; height: 30px; border: 1px solid #ddd; background: white; border-radius: 5px; cursor: pointer; }
        .quantity-btn:hover { background: #f0f0f0; }
        .modal-content { border-radius: 20px; }
        .form-control, .form-select { border-radius: 10px; padding: 12px; }
        .dana-box { background: linear-gradient(135deg, #108EE9 0%, #1890FF 100%); color: white; border-radius: 15px; padding: 20px; text-align: center; margin: 15px 0; }
        .dana-logo { font-size: 32px; font-weight: 800; margin-bottom: 10px; }
        .jnt-box { background: #ED1C24; color: white; border-radius: 15px; padding: 20px; margin: 15px 0; }
        .jnt-logo { font-size: 28px; font-weight: 800; }
        .shipping-info { background: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; border-radius: 10px; margin: 15px 0; }
        @keyframes success { 0% { transform: scale(0); opacity: 0; } 50% { transform: scale(1.2); } 100% { transform: scale(1); opacity: 1; } }
        .success-icon { animation: success 0.5s ease; }
        @media (max-width: 768px) { .cart-sidebar { width: 100%; right: -100%; } }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 text-brown" href="/"><i class="bi bi-shop"></i> Kampung Nopia</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link fw-medium px-3" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium px-3 active text-brown" href="/produk">Produk</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium px-3" href="/#tentang">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link fw-medium px-3" href="/#kontak">Kontak</a></li>
                    <li class="nav-item ms-3">
                        <div class="cart-icon-wrapper" onclick="toggleCart()">
                            <i class="bi bi-cart3 fs-4 text-brown"></i>
                            <span class="cart-badge" id="cartCount">0</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="product-hero">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Katalog Produk</h1>
            <p class="lead opacity-90">Pilih produk nopia favorit Anda</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4" id="productGrid"></div>
        </div>
    </section>

    <div class="cart-overlay" id="cartOverlay" onclick="toggleCart()"></div>

    <div class="cart-sidebar" id="cartSidebar">
        <div class="p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">Keranjang Belanja</h4>
                <button class="btn-close" onclick="toggleCart()"></button>
            </div>
            <div id="cartItems"></div>
            <div class="mt-4 pt-4 border-top">
                <div class="d-flex justify-content-between mb-3">
                    <h5>Total:</h5>
                    <h5 class="text-brown fw-bold" id="cartTotal">Rp 0</h5>
                </div>
                <button class="btn btn-brown w-100 rounded-pill py-3 fw-semibold" onclick="openCheckout()" id="checkoutBtn">
                    <i class="bi bi-credit-card me-2"></i>Checkout
                </button>
            </div>
        </div>
    </div>
    <script>

document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const buyId = parseInt(params.get('buy'));

    if (buyId) {
        const product = products.find(p => p.id === buyId);

        if (product) {
            cart.push({ ...product, quantity: 1 });
            updateCart();

            if (params.get('openCart') === 'true') {
                toggleCart();
            }
        }
    }
});


document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);

    if (params.get('openCart') === 'true') {
        // buka sidebar keranjang
        document.getElementById('cartSidebar')?.classList.add('active');
    }
});
</script>


    <div class="modal fade" id="checkoutModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Checkout Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="checkoutForm">
                        <h6 class="fw-bold mb-3">Informasi Pembeli</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control" id="nama" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No. Telepon *</label>
                                <input type="tel" class="form-control" id="telepon" required>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-3">Alamat Pengiriman (Jawa Tengah)</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Kota/Kabupaten *</label>
                                <select class="form-select" id="kota" required onchange="hitungOngkir()">
                                    <option value="">Pilih Kota</option>
                                    <option value="8000">Banyumas / Purwokerto (Rp 8.000)</option>
                                    <option value="12000">Cilacap (Rp 12.000)</option>
                                    <option value="10000">Purbalingga (Rp 10.000)</option>
                                    <option value="12000">Banjarnegara (Rp 12.000)</option>
                                    <option value="15000">Kebumen (Rp 15.000)</option>
                                    <option value="20000">Magelang (Rp 20.000)</option>
                                    <option value="25000">Semarang (Rp 25.000)</option>
                                    <option value="23000">Salatiga (Rp 23.000)</option>
                                    <option value="23000">Solo / Surakarta (Rp 23.000)</option>
                                    <option value="22000">Karanganyar (Rp 22.000)</option>
                                    <option value="24000">Klaten (Rp 24.000)</option>
                                    <option value="28000">Kudus (Rp 28.000)</option>
                                    <option value="30000">Jepara (Rp 30.000)</option>
                                    <option value="30000">Pati (Rp 30.000)</option>
                                    <option value="30000">Tegal (Rp 30.000)</option>
                                    <option value="26000">Pekalongan (Rp 26.000)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kecamatan *</label>
                                <input type="text" class="form-control" id="kecamatan" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat Lengkap *</label>
                                <textarea class="form-control" rows="3" id="alamat" placeholder="Jl. Nama Jalan, No. Rumah, RT/RW" required></textarea>
                            </div>
                        </div>

                        <div class="jnt-box">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <div class="jnt-logo mb-2">J&T EXPRESS</div>
                                    <small>Estimasi pengiriman 2-3 hari kerja</small>
                                </div>
                                <div class="text-end">
                                    <div class="fs-5 fw-bold" id="ongkir">Rp 0</div>
                                    <small>Ongkos Kirim</small>
                                </div>
                            </div>
                        </div>

                        <div class="shipping-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Catatan:</strong> Pengiriman hanya melayani wilayah Jawa Tengah menggunakan J&T Express
                        </div>

                        <div class="dana-box">
                            <div class="dana-logo">DANA</div>
                            <h6 class="mb-2">Metode Pembayaran</h6>
                            <p class="mb-0 small">Pembayaran melalui DANA E-Wallet</p>
                        </div>

                        <div class="bg-light p-3 rounded-3 mb-4">
                            <h6 class="fw-bold mb-3">Ringkasan Pesanan</h6>
                            <div id="orderSummary"></div>
                            <div class="d-flex justify-content-between mt-2">
                                <span>Subtotal Produk:</span>
                                <span class="fw-semibold" id="subtotal">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <span>Ongkos Kirim (J&T):</span>
                                <span class="fw-semibold" id="ongkirSummary">Rp 0</span>
                            </div>
                            <div class="d-flex justify-content-between mt-3 pt-3 border-top">
                                <h5 class="fw-bold">Total Pembayaran:</h5>
                                <h5 class="fw-bold text-brown" id="totalAkhir">Rp 0</h5>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-brown w-100 py-3 rounded-pill fw-semibold">
                            <i class="bi bi-check-circle me-2"></i>Konfirmasi Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 text-center">
      <h4 class="fw-bold mb-3">Pembayaran</h4>

      <div class="dana-box mb-3">
        <div class="dana-logo">DANA</div>
        <p class="mb-1">Nomor DANA:</p>
        <h5 class="fw-bold">0812-3456-7890</h5>
        <p class="mb-0">a/n Kampung Nopia Banyumas</p>
      </div>

      <h5>Total Bayar</h5>
      <h3 class="text-brown fw-bold mb-3" id="totalBayarPembayaran">Rp 0</h3>

      <button class="btn btn-success w-100 rounded-pill mb-2" onclick="konfirmasiPembayaran()">
        <i class="bi bi-check-circle me-2"></i>Saya Sudah Bayar
      </button>

      <button class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">
        Bayar Nanti
      </button>
    </div>
  </div>
</div>


    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="modal-body">
                    <div class="success-icon mb-3">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 80px;"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Pesanan Berhasil!</h4>
                    <div class="dana-box mb-3">
                        <div class="dana-logo mb-3">DANA</div>
                        <h6 class="mb-2">Informasi Pembayaran:</h6>
                        <p class="mb-1"><strong>Nomor DANA: 0812-3456-7890</strong></p>
                        <p class="mb-1"><strong>a/n: Kampung Nopia Banyumas</strong></p>
                        <div class="mt-3 pt-3 border-top">
                            <h5 class="mb-0">Total: <span id="totalBayar">Rp 0</span></h5>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <small><strong>Langkah Selanjutnya:</strong><br>
                        1. Transfer ke nomor DANA di atas<br>
                        2. Kirim bukti transfer via WhatsApp<br>
                        3. Pesanan akan diproses setelah pembayaran dikonfirmasi</small>
                    </div>
                    <button class="btn btn-success w-100 rounded-pill py-3 mb-2" onclick="kirimWhatsApp()">
                        <i class="bi bi-whatsapp me-2"></i>Kirim Bukti via WhatsApp
                    </button>
                    <button class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal" onclick="location.reload()">
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const products = [
              {
        id: 1,
        name: 'Nopia Original',
        price: 45000,
        image: 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400',
        description: 'Nopia khas dengan isian kacang hijau klasik yang lembut dan manis',
        badge: 'Best Seller',
        badgeClass: 'badge-bestseller',
        rating: 5
    },
    {
        id: 2,
        name: 'Nopia Keju',
        price: 50000,
        image: 'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=400',
        description: 'Perpaduan tradisi dan modern dengan isian keju',
        badge: 'New',
        badgeClass: 'badge-new',
        rating: 4.5
    },
    {
        id: 3,
        name: 'Nopia Coklat',
        price: 48000,
        image: 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=400',
        description: 'Varian coklat kaya rasa, favorit semua usia',
        rating: 4.8
    },
            { id: 4, name: 'Mini Nopia Gula Aren', price: 15000, image: 'https://foodnesia.net/wp-content/uploads/2019/12/kue-nopia-khas-purbalingga-mantap.jpg', description: 'Nopia klasik dengan isian kacang hijau lembut', badge: 'Best Seller', badgeClass: 'badge-bestseller', rating: 5 },
            { id: 5, name: 'Mini Nopia Pandan', price: 15000, image: 'https://foodnesia.net/wp-content/uploads/2019/12/kue-nopia-khas-purbalingga-mantap.jpg', description: 'Perpaduan rasa gurih dan manis dari keju pilihan', badge: 'New', badgeClass: 'badge-new', rating: 4.5 },
            { id: 6, name: 'Mini Nopia Durian', price: 15000, image: 'https://foodnesia.net/wp-content/uploads/2019/12/kue-nopia-khas-purbalingga-mantap.jpg', description: 'Kelezatan coklat premium dengan tekstur renyah', rating: 4.8 },
            { id: 7, name: 'Nopia Pandan', price: 15000, image: 'https://foodnesia.net/wp-content/uploads/2019/12/kue-nopia-khas-purbalingga-mantap.jpg', description: 'Harumnya aroma pandan alami yang menyegarkan', rating: 4.7 },
            { id: 8, name: 'Nopia Durian', price: 15000, image: 'https://foodnesia.net/wp-content/uploads/2019/12/kue-nopia-khas-purbalingga-mantap.jpg', description: 'Sensasi durian asli yang kuat', rating: 4.9 },
            { id: 9, name: 'Nopia Gula Aren', price: 15000, image: 'https://foodnesia.net/wp-content/uploads/2019/12/kue-nopia-khas-purbalingga-mantap.jpg', description: 'Kombinasi berbagai rasa dalam satu paket hemat', badge: 'Hemat', badgeClass: 'badge-bestseller', rating: 5 }
            
        ];

        let cart = [];
        let ongkosKirim = 0;
        let orderInfo = {};

       function renderProducts() {
    document.getElementById('productGrid').innerHTML = products.map(p => `
        <div class="col-lg-4 col-md-6">
            <div class="product-card">
                <div class="product-image-wrapper">
                    ${p.badge ? `<span class="product-badge ${p.badgeClass}"><i class="bi bi-fire me-1"></i>${p.badge}</span>` : ''}
                    <img src="${p.image}" alt="${p.name}">
                </div>
                <div class="product-info">
                    <div class="product-rating">
                        ${'<i class="bi bi-star-fill"></i>'.repeat(Math.floor(p.rating))}
                        ${p.rating % 1 ? '<i class="bi bi-star-half"></i>' : ''}
                    </div>

                    <h5 class="product-title">${p.name}</h5>
                    <p class="product-description">${p.description}</p>
                    <div class="mb-3">
                        <span class="price-tag">Rp ${p.price.toLocaleString('id-ID')}</span>
                    </div>

                    <!-- Tombol Tambah ke Keranjang -->
                    <button class="btn btn-brown w-100 rounded-pill fw-semibold mb-2" 
                        onclick="addToCart(${p.id})">
                        <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                    </button>

                    <!-- Tombol Beli Sekarang -->
                    <button class="btn btn-success w-100 rounded-pill fw-semibold" 
                        onclick="buyNow(${p.id})">
                        <i class="bi bi-bag-check me-2"></i>Beli Sekarang
                    </button>
                </div>
            </div>
        </div>
    `).join('');
}


      function buyNow(id) {
        const product = products.find(p => p.id === id);
        if (!product) return;

        // kosongkan cart dan isi 1 produk
        cart = [{ ...product, quantity: 1 }];
        updateCart();

        // tutup sidebar jika sedang terbuka
        document.getElementById('cartSidebar').classList.remove('active');
        document.getElementById('cartOverlay').classList.remove('active');

        // buka checkout
        openCheckout();
    }



    /* ------------------------- KERANJANG ------------------------- */
    function addToCart(id) {
        const product = products.find(p => p.id === id);
        const existing = cart.find(item => item.id === id);
        if (existing) existing.quantity++;
        else cart.push({ ...product, quantity: 1 });
        updateCart();
        showNotif('Produk ditambahkan ke keranjang!');
    }

    function updateCart() {
        const total = cart.reduce((sum, item) => sum + item.quantity, 0);
        const price = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

        document.getElementById('cartCount').textContent = total;
        document.getElementById('cartTotal').textContent = `Rp ${price.toLocaleString('id-ID')}`;

        if (cart.length === 0) {
            document.getElementById('cartItems').innerHTML =
                '<p class="text-center text-muted py-5">Keranjang kosong</p>';
            document.getElementById('checkoutBtn').disabled = true;
        } else {
            document.getElementById('checkoutBtn').disabled = false;
            document.getElementById('cartItems').innerHTML = cart.map(item => `
                <div class="cart-item">
                    <div class="d-flex gap-3">
                        <img src="${item.image}" class="cart-item-image" alt="${item.name}">
                        <div class="flex-grow-1">
                            <h6 class="fw-semibold mb-1">${item.name}</h6>
                            <p class="text-brown fw-bold mb-2">
                                Rp ${item.price.toLocaleString('id-ID')}
                            </p>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="quantity-control">
                                    <button class="quantity-btn" onclick="updateQty(${item.id}, -1)">−</button>
                                    <span class="fw-semibold">${item.quantity}</span>
                                    <button class="quantity-btn" onclick="updateQty(${item.id}, 1)">+</button>
                                </div>

                                <button class="btn btn-sm text-danger" onclick="removeCart(${item.id})">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }
    }

    function updateQty(id, change) {
        const item = cart.find(i => i.id === id);
        if (item) {
            item.quantity += change;
            if (item.quantity <= 0) removeCart(id);
            else updateCart();
        }
    }

    function removeCart(id) {
        cart = cart.filter(item => item.id !== id);
        updateCart();
    }

    function toggleCart() {
        document.getElementById('cartSidebar').classList.toggle('active');
        document.getElementById('cartOverlay').classList.toggle('active');
    }

    /* ------------------------- CHECKOUT ------------------------- */
    function openCheckout() {
        if (cart.length === 0) return;

        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
        document.getElementById('orderSummary').innerHTML = cart.map(item => `
            <div class="d-flex justify-content-between mb-2">
                <span>${item.name} (${item.quantity}x)</span>
                <span class="fw-semibold">Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</span>
            </div>
        `).join('');

        document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;

        hitungOngkir(); // update ongkir otomatis

        toggleCart(); // tutup sidebar

        new bootstrap.Modal(document.getElementById('checkoutModal')).show();
    }

    function hitungOngkir() {
        ongkosKirim = parseInt(document.getElementById('kota').value) || 0;

        document.getElementById('ongkir').textContent = 
            `Rp ${ongkosKirim.toLocaleString('id-ID')}`;
        document.getElementById('ongkirSummary').textContent = 
            `Rp ${ongkosKirim.toLocaleString('id-ID')}`;

        const subtotal = cart.reduce((s, i) => s + (i.price * i.quantity), 0);
        const total = subtotal + ongkosKirim;
        document.getElementById('totalAkhir').textContent = 
            `Rp ${total.toLocaleString('id-ID')}`;
    }

    /* ------------------------- FORM CHECKOUT ------------------------- */
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    const total = subtotal + ongkosKirim;

orderInfo = {
    nama: nama.value,
    telepon: telepon.value,
    kota: kota.options[kota.selectedIndex].text,
    kecamatan: kecamatan.value,
    alamat: alamat.value,
    ongkir: ongkosKirim,
    total: total, // ← INI YANG DIPAKAI
    items: cart.map(item => ({
        name: item.name,
        quantity: item.quantity,
        price: item.price
    }))
};


        simpanTransaksi(orderInfo);

    document.getElementById('totalBayarPembayaran').textContent =
        `Rp ${total.toLocaleString('id-ID')}`;

    bootstrap.Modal.getInstance(checkoutModal).hide();

    setTimeout(() => {
        new bootstrap.Modal(document.getElementById('paymentModal')).show();
    }, 300);
});

function rupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
}


function konfirmasiPembayaran() {
    // tutup modal pembayaran
    bootstrap.Modal.getInstance(
        document.getElementById('paymentModal')
    ).hide();

    // 🔴 INI BAGIAN PALING PENTING
    document.getElementById('totalBayar').textContent =
        rupiah(orderInfo.total);

    setTimeout(() => {
        new bootstrap.Modal(
            document.getElementById('successModal')
        ).show();
    }, 300);
}



function simpanTransaksi(orderInfo) {
    fetch('http://localhost:8000/api/checkout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(orderInfo)
    })
    .then(res => res.json())
    .then(res => console.log('Masuk DB:', res))
    .catch(err => console.error(err));
}




    /* ------------------------- WHATSAPP ------------------------- */
    function kirimWhatsApp() {
        let msg = `*PESANAN NOPIA BANYUMAS*%0A%0A`;

        msg += `Nama: ${orderInfo.nama}%0A`;
        msg += `Telepon: ${orderInfo.telepon}%0A`;
        msg += `Alamat: ${orderInfo.alamat}, ${orderInfo.kecamatan}, ${orderInfo.kota}%0A%0A`;
        msg += `*Detail Pesanan:*%0A`;

        orderInfo.items.forEach(item => {
            msg += `- ${item.name} (${item.quantity}x) = Rp ${(item.price * item.quantity).toLocaleString('id-ID')}%0A`;
        });

        msg += `%0AOngkir J&T: Rp ${orderInfo.ongkir.toLocaleString('id-ID')}%0A`;
        msg += `*TOTAL: Rp ${orderInfo.total.toLocaleString('id-ID')}*%0A%0A`;
        msg += `Pembayaran via DANA: 0812-3456-7890`;

        window.open(`https://wa.me/6281234567890?text=${msg}`, '_blank');
    }

    /* ------------------------- NOTIF ------------------------- */
    function showNotif(msg) {
        const notif = document.createElement('div');
        notif.className = 
            'position-fixed top-0 start-50 translate-middle-x mt-5 alert alert-success shadow';
        notif.style.zIndex = '9999';
        notif.innerHTML = `<i class="bi bi-check-circle me-2"></i>${msg}`;
        document.body.appendChild(notif);
        setTimeout(() => notif.remove(), 2000);
    }

    renderProducts();
    updateCart();
</script>
</body>
</html>