<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nopia Banyumas - Manisnya Tradisi Banyumas</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .text-brown {
            color: #A67C52 !important;
        }

        .bg-brown {
            background-color: #A67C52 !important;
        }

        .btn-brown {
            background-color: #A67C52;
            color: white;
        }

        .btn-brown:hover {
            background-color: #8B6340;
            color: white;
        }

        /* Hero Carousel Styles */
        .hero-carousel {
            margin-top: 76px;
        }

        .carousel-item {
            height: 500px;
        }

        .carousel-item img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        .carousel-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(166, 124, 82, 0.85) 0%, rgba(139, 99, 64, 0.75) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-content {
            text-align: center;
            color: white;
            padding: 0 20px;
            max-width: 800px;
        }

        .badge-discount {
            background-color: #ff4757;
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 15px;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            width: 50px;
            height: 50px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
        }

        /* Category Section */
        .category-section {
            padding: 60px 0;
            background-color: #fff;
        }

        .category-card {
            text-align: center;
            padding: 30px 20px;
            border-radius: 20px;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(166, 124, 82, 0.2);
            border-color: #A67C52;
        }

        .category-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #A67C52 0%, #8B6340 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 40px;
            color: white;
        }

        .category-name {
            font-weight: 600;
            font-size: 18px;
            color: #333;
            margin-bottom: 8px;
        }

        .category-count {
            color: #999;
            font-size: 14px;
        }

        /* Featured Products */
        .featured-section {
            background: linear-gradient(135deg, #FFF8F0 0%, #FFEFD5 100%);
            padding: 60px 0;
        }

        .section-title {
            position: relative;
            display: inline-block;
            padding-bottom: 15px;
            margin-bottom: 40px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, #A67C52 0%, #8B6340 100%);
            border-radius: 2px;
        }

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, #A67C52 0%, #8B6340 100%);
            padding: 60px 0;
            color: white;
        }

        .stat-card {
            text-align: center;
            padding: 30px;
        }

        .stat-number {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 10px;
            display: block;
        }

        .stat-label {
            font-size: 16px;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .carousel-item {
                height: 400px;
            }

            .carousel-content h1 {
                font-size: 2rem !important;
            }

            .category-card {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 text-brown" href="#home">
                <i class="bi bi-shop"></i> Kampung Nopia
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3" href="/produk">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3" href="/tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3" href="/kontak">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide hero-carousel" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active">
                <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?w=1200&h=500&fit=crop" alt="Nopia Special">
                <div class="carousel-overlay">
                    <div class="carousel-content">
                        <span class="badge-discount">🎉 DISKON 30% OFF</span>
                        <h1 class="display-3 fw-bold mb-4">Penawaran Spesial!</h1>
                        <h2 class="display-6 mb-4">Nikmati Kelezatan Nopia Original</h2>
                        <p class="lead mb-4">Dibuat dengan resep turun-temurun untuk cita rasa autentik</p>
                        <a href="#produk" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-semibold">
                            Pesan Sekarang <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=1200&h=500&fit=crop" alt="Varian Baru">
                <div class="carousel-overlay">
                    <div class="carousel-content">
                        <span class="badge-discount">✨ VARIAN BARU</span>
                        <h1 class="display-3 fw-bold mb-4">Nopia Coklat & Keju</h1>
                        <h2 class="display-6 mb-4">Inovasi Rasa Tradisional</h2>
                        <p class="lead mb-4">Kombinasi sempurna antara tradisi dan modernitas</p>
                        <a href="#produk" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-semibold">
                            Lihat Produk <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=1200&h=500&fit=crop" alt="Proses Pembuatan">
                <div class="carousel-overlay">
                    <div class="carousel-content">
                        <span class="badge-discount">🏆 KUALITAS TERBAIK</span>
                        <h1 class="display-3 fw-bold mb-4">Tradisi Yang Terjaga</h1>
                        <h2 class="display-6 mb-4">Dibuat dengan Cinta & Keahlian</h2>
                        <p class="lead mb-4">Setiap nopia dipanggang dalam tungku tradisional</p>
                        <a href="#tentang" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-semibold">
                            Pelajari Lebih Lanjut <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Category Section -->
    <section class="category-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold section-title text-brown">Kategori Produk</h2>
                <p class="lead text-secondary">Pilih kategori favorit Anda</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <div class="category-name">Nopia Original</div>
                        <div class="category-count">3 Items</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="bi bi-emoji-smile"></i>
                        </div>
                        <div class="category-name">Nopia Keju</div>
                        <div class="category-count">2 Items</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <div class="category-name">Nopia Coklat</div>
                        <div class="category-count">2 Items</div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="category-card">
                        <div class="category-icon">
                            <i class="bi bi-gift-fill"></i>
                        </div>
                        <div class="category-name">Paket Hampers</div>
                        <div class="category-count">5 Items</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <span class="stat-number"><i class="bi bi-people-fill"></i> 500+</span>
                        <div class="stat-label">Pelanggan Puas</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <span class="stat-number"><i class="bi bi-box-seam"></i> 1000+</span>
                        <div class="stat-label">Produk Terjual</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <span class="stat-number"><i class="bi bi-award-fill"></i> 10+</span>
                        <div class="stat-label">Tahun Berpengalaman</div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-card">
                        <span class="stat-number"><i class="bi bi-star-fill"></i> 4.9</span>
                        <div class="stat-label">Rating Pelanggan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Section -->
    <section id="produk" class="featured-section">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold section-title text-brown">Produk Unggulan</h2>
                <p class="lead text-secondary">Coba menu pilihan kami</p>
            </div>

            <div class="row g-4">
                <!-- Product 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1509440159596-0249088772ff?w=400&h=300&fit=crop" class="card-img-top" alt="Nopia Original" style="height: 250px; object-fit: cover;">
                            <span class="badge bg-danger position-absolute top-0 end-0 m-3">Best Seller</span>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3">Nopia Original</h5>
                            <p class="card-text text-secondary mb-3">Nopia khas dengan isian kacang hijau klasik yang lembut dan manis</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="fs-4 fw-bold mb-0 text-brown">Rp 45.000</p>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                                <a href="/produk?buy=1&openCart=true"
                                class="btn btn-brown w-100 rounded-pill fw-medium">
                                    <i class="bi bi-cart-plus me-2"></i>Beli Sekarang
                                </a>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=400&h=300&fit=crop" class="card-img-top" alt="Nopia Keju" style="height: 250px; object-fit: cover;">
                            <span class="badge bg-success position-absolute top-0 end-0 m-3">New</span>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3">Nopia Keju</h5>
                            <p class="card-text text-secondary mb-3">Perpaduan sempurna antara tradisi dan modernitas dengan isian keju</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="fs-4 fw-bold mb-0 text-brown">Rp 50.000</p>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                            </div>
                          <a href="/produk?buy=2&openCart=true"
                                class="btn btn-brown w-100 rounded-pill fw-medium">
                                    <i class="bi bi-cart-plus me-2"></i>Beli Sekarang
                                </a>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm rounded-4">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1511381939415-e44015466834?w=400&h=300&fit=crop" class="card-img-top" alt="Nopia Coklat" style="height: 250px; object-fit: cover;">
                            <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3">Hot</span>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3">Nopia Coklat</h5>
                            <p class="card-text text-secondary mb-3">Varian coklat yang kaya rasa, favorit anak-anak dan dewasa</p>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="fs-4 fw-bold mb-0 text-brown">Rp 48.000</p>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star"></i>
                                </div>
                            </div>
                           <a href="/produk?buy=3&openCart=true"
                                class="btn btn-brown w-100 rounded-pill fw-medium">
                                    <i class="bi bi-cart-plus me-2"></i>Beli Sekarang
                                </a>
                        </div>
                    </div>
                </div>
            </div>

       <div class="text-center mt-5">
    <a href="/produk" class="btn btn-brown btn-lg rounded-pill px-5 fw-medium">
        Lihat Semua Produk <i class="bi bi-arrow-right ms-2"></i>
    </a>
</div>

        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-brown text-white py-5">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-shop me-2"></i>Kampung Nopia</h5>
                    <p class="opacity-75">Nikmati manisnya tradisi Banyumas dalam setiap gigitan nopia kami. Dibuat dengan cinta dan resep turun-temurun.</p>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Kontak Kami</h5>
                    <p class="opacity-75 mb-2"><i class="bi bi-geo-alt me-2"></i>Desa Pekunden, Banyumas, Jawa Tengah</p>
                    <p class="opacity-75 mb-2"><i class="bi bi-telephone me-2"></i>+62 812-3456-7890</p>
                    <p class="opacity-75 mb-2"><i class="bi bi-envelope me-2"></i>info@kampungnopia.com</p>
                </div>
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3">Ikuti Kami</h5>
                    <div class="d-flex gap-3 fs-4">
                        <a href="#" class="text-white text-decoration-none"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white text-decoration-none"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white text-decoration-none"><i class="bi bi-whatsapp"></i></a>
                        <a href="#" class="text-white text-decoration-none"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 opacity-25">
            <div class="text-center opacity-75">
                <p class="mb-0">&copy; 2024 Kampung Nopia Banyumas. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const navbarHeight = document.querySelector('.navbar').offsetHeight;
                    const targetPosition = target.offsetTop - navbarHeight;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Category card click
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('click', function() {
                const category = this.querySelector('.category-name').textContent;
                console.log('Kategori dipilih:', category);
                // Bisa diarahkan ke halaman produk dengan filter kategori
            });
        });

        // Button buy handler
   
    document.querySelectorAll('.btn-buy').forEach(button => {
        button.addEventListener('click', function () {
            const productName = this.closest('.card-body').querySelector('h5').textContent;
            const url = this.dataset.url;

            // optional: simpan produk ke localStorage
            localStorage.setItem('selectedProduct', productName);

            // redirect ke halaman produk / cart
            window.location.href = url;
        });
    });
</script>


</body>

</html>