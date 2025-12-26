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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.clientKey') }}"></script>
    
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
const cartCount = document.getElementById('cartCount');
const cartTotal = document.getElementById('cartTotal');
const cartItems = document.getElementById('cartItems');
const checkoutBtn = document.getElementById('checkoutBtn');

const nama = document.getElementById('nama');
const telepon = document.getElementById('telepon');
const alamat = document.getElementById('alamat');
const kecamatan = document.getElementById('kecamatan');
const kota = document.getElementById('kota');
const ongkir = document.getElementById('ongkir');
const ongkirSummary = document.getElementById('ongkirSummary');
const totalAkhir = document.getElementById('totalAkhir');

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
}


    function updateCart() {
    const totalQty = cart.reduce((s, i) => s + i.quantity, 0);
    const totalPrice = cart.reduce((s, i) => s + (i.price * i.quantity), 0);

    cartCount.textContent = totalQty;
    cartTotal.textContent = `Rp ${totalPrice.toLocaleString('id-ID')}`;

    if (!cart.length) {
        cartItems.innerHTML = '<p class="text-center text-muted">Keranjang kosong</p>';
        checkoutBtn.disabled = true;
        return;
    }

    checkoutBtn.disabled = false;
    cartItems.innerHTML = cart.map(item => `
        <div class="cart-item">
            <div class="d-flex gap-3">
                <img src="${item.image}" class="cart-item-image">
                <div class="flex-grow-1">
                    <h6>${item.name}</h6>
                    <p class="text-brown fw-bold">
                        Rp ${(item.price * item.quantity).toLocaleString('id-ID')}
                    </p>
                    <div class="quantity-control">
                        <button onclick="updateQty(${item.id},-1)">−</button>
                        <span>${item.quantity}</span>
                        <button onclick="updateQty(${item.id},1)">+</button>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
}


    function updateQty(id, c) {
    const item = cart.find(x => x.id === id);
    item.quantity += c;
    if (item.quantity <= 0) cart = cart.filter(x => x.id !== id);
    updateCart();
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
            <span class="fw-semibold">
                Rp ${(item.price * item.quantity).toLocaleString('id-ID')}
            </span>
        </div>
    `).join('');

    document.getElementById('subtotal').textContent =
        `Rp ${subtotal.toLocaleString('id-ID')}`;

    hitungOngkir();

    toggleCart();

    new bootstrap.Modal(
        document.getElementById('checkoutModal')
    ).show();
}

 function hitungOngkir() {
    ongkosKirim = parseInt(kota.value) || 0;
    ongkir.textContent = `Rp ${ongkosKirim.toLocaleString('id-ID')}`;
    ongkirSummary.textContent = ongkir.textContent;

    const subtotal = cart.reduce((s, i) => s + i.price * i.quantity, 0);
    totalAkhir.textContent =
        `Rp ${(subtotal + ongkosKirim).toLocaleString('id-ID')}`;
}

    /* ------------------------- MIDTRANS ------------------------- */
function prosesMidtrans() {
    if (!nama.value || !telepon.value || !alamat.value || !kota.value) {
        alert('Lengkapi data pembeli!');
        return;
    }

    const subtotal = cart.reduce((s,i)=>s+i.price*i.quantity,0);
    const total = subtotal + ongkosKirim;

    fetch('/api/checkout-midtrans', {
        method: 'POST',
        headers: {'Content-Type':'application/json'},
        body: JSON.stringify({
            nama: nama.value,
            telepon: telepon.value,
            alamat: alamat.value,
            kecamatan: kecamatan.value,
            kota: kota.options[kota.selectedIndex].text,
            total: total,
            items: cart.map(i => ({
                name: i.name,
                price: i.price,
                quantity: i.quantity
            }))
        })
    })
    .then(res => res.json())
    .then(res => {
        if (!res.success) {
            alert(res.message);
            return;
        }

        snap.pay(res.snap_token, {
            onSuccess: () => alert('Pembayaran berhasil'),
            onPending: () => alert('Menunggu pembayaran'),
            onError: () => alert('Pembayaran gagal')
        });
    });
}

function tampilSukses(total) {
    document.getElementById('totalBayar').textContent =
        `Rp ${total.toLocaleString('id-ID')}`;

    bootstrap.Modal.getInstance(
        document.getElementById('checkoutModal')
    ).hide();

    new bootstrap.Modal(
        document.getElementById('successModal')
    ).show();

    cart = [];
    updateCart();
}


renderProducts();
updateCart();
</script>

<div class="modal fade" id="checkoutModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Checkout Pesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <h6 class="fw-bold mb-3">Informasi Pembeli</h6>

        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label">Nama Lengkap *</label>
            <input type="text" id="nama" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">No. Telepon *</label>
            <input type="text" id="telepon" class="form-control">
          </div>
        </div>

        <h6 class="fw-bold mb-3">Alamat Pengiriman</h6>

        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label class="form-label">Kota *</label>
            <select id="kota" class="form-select" onchange="hitungOngkir()">
               <option value="20000">Kota Semarang</option>
      <option value="18000">Kota Surakarta</option>
      <option value="15000">Kota Magelang</option>
      <option value="16000">Kota Pekalongan</option>
      <option value="17000">Kota Tegal</option>
      <option value="14000">Kota Salatiga</option>

      <!-- KABUPATEN -->
      <option value="8000">Kabupaten Banyumas</option>
      <option value="12000">Kabupaten Cilacap</option>
      <option value="10000">Kabupaten Purbalingga</option>
      <option value="11000">Kabupaten Banjarnegara</option>
      <option value="13000">Kabupaten Kebumen</option>
      <option value="14000">Kabupaten Purworejo</option>
      <option value="15000">Kabupaten Wonosobo</option>
      <option value="16000">Kabupaten Magelang</option>
      <option value="17000">Kabupaten Temanggung</option>
      <option value="18000">Kabupaten Kendal</option>
      <option value="19000">Kabupaten Demak</option>
      <option value="20000">Kabupaten Semarang</option>
      <option value="21000">Kabupaten Grobogan</option>
      <option value="22000">Kabupaten Blora</option>
      <option value="23000">Kabupaten Rembang</option>
      <option value="24000">Kabupaten Pati</option>
      <option value="25000">Kabupaten Kudus</option>
      <option value="26000">Kabupaten Jepara</option>
      <option value="27000">Kabupaten Sragen</option>
      <option value="28000">Kabupaten Karanganyar</option>
      <option value="29000">Kabupaten Boyolali</option>
      <option value="30000">Kabupaten Klaten</option>
      <option value="31000">Kabupaten Sukoharjo</option>
      <option value="32000">Kabupaten Wonogiri</option>
      <option value="33000">Kabupaten Pekalongan</option>
      <option value="34000">Kabupaten Pemalang</option>
      <option value="35000">Kabupaten Batang</option>
      <option value="36000">Kabupaten Brebes</option>
      <option value="37000">Kabupaten Tegal</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Kecamatan *</label>
            <input type="text" id="kecamatan" class="form-control">
          </div>
          <div class="col-12">
            <label class="form-label">Alamat Lengkap *</label>
            <textarea id="alamat" class="form-control"></textarea>
          </div>
        </div>

        <div class="jnt-box">
          <div class="d-flex justify-content-between">
            <div>
              <div class="jnt-logo">J&T EXPRESS</div>
              <small>Estimasi 2–3 hari</small>
            </div>
            <div class="text-end">
              <div id="ongkir">Rp 0</div>
            </div>
          </div>
        </div>

        <div class="bg-light p-3 rounded mb-4">
          <h6 class="fw-bold mb-3">Ringkasan Pesanan</h6>

          <div id="orderSummary"></div>

          <div class="d-flex justify-content-between mt-2">
            <span>Subtotal</span>
            <span id="subtotal">Rp 0</span>
          </div>

          <div class="d-flex justify-content-between mt-2">
            <span>Ongkir</span>
            <span id="ongkirSummary">Rp 0</span>
          </div>

          <div class="d-flex justify-content-between mt-3 pt-3 border-top">
            <strong>Total</strong>
            <strong id="totalAkhir">Rp 0</strong>
          </div>
        </div>

        <button class="btn btn-brown w-100 py-3 rounded-pill"
                onclick="prosesMidtrans()">
          Bayar Sekarang
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="successModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center p-4">
      <div class="modal-body">
        <i class="bi bi-check-circle-fill text-success fs-1 mb-3 success-icon"></i>
        <h4 class="fw-bold">Pembayaran Berhasil</h4>
        <p>Total pembayaran:</p>
        <h5 id="totalBayar" class="text-brown fw-bold"></h5>
        <button class="btn btn-brown mt-3 rounded-pill" data-bs-dismiss="modal">
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>


</body>
</html>