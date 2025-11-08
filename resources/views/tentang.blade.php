<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - Nopia Banyumas</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding-top: 80px;
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
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 text-brown" href="/">Kampung Nopia Banyumas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3" href="/produk">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3 active text-brown" href="/#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3" href="/#kontak">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- About Section -->
   <section id="tentang" class="bg-light py-5">
    <div class="container py-5">
        <!-- Title -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="display-5 fw-bold text-brown">Kampung Nopia</h2>
            </div>
        </div>

        <!-- Description Box -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="about-box p-4 p-md-5 rounded-4 shadow-sm">
                    <p class="text-dark lh-lg mb-0" style="text-align: justify;">
                        Kampung Nopia di Desa Pekunden, Banyumas, merupakan sentra produksi sekaligus wisata edukasi kuliner khas Banyumas yang terkenal dengan olahan tradisional Nopia atau Mino. Nopia adalah kue berbentuk bulat lonjong dengan isian inti kacang hijau, dipanggang dalam tungku tanah dan hingga menghasilkan cita rasa unik dan gurih. Kampung ini berkembang dari industri rumahan turun-temurun menjadi desa wisata sejak 2018, dengan aktivitas edukatif seperti praktik membuat Nopia, homestay, hingga penyajian berbagai varian rasa modern seperti cokelat, durian, dan nanas. Selain melestarikan warisan kuliner lokal, Kampung Nopia juga meningkatkan perekonomian warga melalui UMKM, wisata budaya, dan pemasaran produk yang kini sudah mendapatkan sertifikasi halal.
                    </p>
                </div>
            </div>
        </div>

        <!-- Gallery -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="gallery-item rounded-4 overflow-hidden shadow">
                    <img src="{{asset('image/bakar-nopia.webp')}}" 
                         class="img-fluid w-100" 
                         alt="Proses pembuatan nopia tradisional"
                         style="height: 300px; object-fit: cover;">
                </div>
            </div>
            <div class="col-md-4">
                <div class="gallery-item rounded-4 overflow-hidden shadow">
                    <img src="{{asset('image/nopia.webp')}}" 
                         class="img-fluid w-100" 
                         alt="Nopia khas Banyumas"
                         style="height: 300px; object-fit: cover;">
                </div>
            </div>
            <div class="col-md-4">
                <div class="gallery-item rounded-4 overflow-hidden shadow">
                    <img src="{{asset('image/masak-nopia.webp')}}" 
                         class="img-fluid w-100" 
                         alt="Tungku pembakaran nopia"
                         style="height: 300px; object-fit: cover;">
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .text-brown {
        color: #8B6914;
    }

    .about-box {
        background-color: #E8DCC4;
        border: none;
    }

    .gallery-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .gallery-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    }

    .gallery-item img {
        transition: transform 0.3s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .about-box {
            padding: 1.5rem !important;
        }
    }
</style>
