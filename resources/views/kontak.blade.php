<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Kampung Nopia Banyumas</title>

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
            padding-top: 80px;
            background-color: #f8f9fa;
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
            border: none;
        }

        .btn-brown:hover {
            background-color: #8B6340;
            color: white;
        }

        /* Contact Section */
        .contact-section {
            padding: 80px 0;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .contact-title {
            font-size: 36px;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }

        .contact-subtitle {
            color: #666;
            font-size: 16px;
        }

        /* Contact Form */
        .contact-form-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 15px;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #A67C52;
            box-shadow: 0 0 0 0.2rem rgba(166, 124, 82, 0.15);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s;
            background: linear-gradient(135deg, #A67C52 0%, #A67C52 100%);
            border: none;
            color: white;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #A67C52 0%, #A67C52 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(91, 196, 191, 0.3);
            color: white;
        }

        /* Contact Info Cards */
        .contact-cards {
            display: flex;
            gap: 30px;
            margin-top: 50px;
        }

        .contact-card {
            flex: 1;
            background: linear-gradient(135deg, #A67C52 0%, #A67C52 100%);
            color: white;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(91, 196, 191, 0.2);
        }

        .contact-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(91, 196, 191, 0.3);
        }

        .contact-card-icon {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 32px;
            color: #A67C52;
        }

        .contact-card-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .contact-card-detail {
            font-size: 14px;
            line-height: 1.8;
            opacity: 0.95;
        }

        .contact-card-link {
            color: white;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            margin-top: 5px;
        }

        .contact-card-link:hover {
            color: white;
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .contact-cards {
                flex-direction: column;
            }

            .contact-form-box {
                padding: 25px;
            }

            .contact-title {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4 text-brown" href="/">
                <i class="bi bi-shop"></i> Kampung Nopia
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
                        <a class="nav-link fw-medium px-3" href="/#tentang">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium px-3 active text-brown" href="/kontak">Kontak</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="container">
            
            <!-- Header -->
            <div class="contact-header">
                <h1 class="contact-title">Contact Us</h1>
                <p class="contact-subtitle">Any questions or remarks? Just write us a message!</p>
            </div>

            <!-- Contact Form -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="contact-form-box">
                        <form id="contactForm">
                            <div class="mb-3">
                                <input type="text" class="form-control" id="name" placeholder="Name" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="email" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="tel" class="form-control" id="phone" placeholder="Phone" required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" id="message" placeholder="Write your message..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-submit">
                                Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Cards -->
            <div class="contact-cards">
                
                <!-- Card 1: About Us -->
                <div class="contact-card">
                    <div class="contact-card-icon">
                        <i class="bi bi-shop"></i>
                    </div>
                    <h5 class="contact-card-title">About Us</h5>
                    <div class="contact-card-detail">
                        Kampung Nopia<br>
                        Desa Pekunden, Banyumas<br>
                        Jawa Tengah, Indonesia
                    </div>
                </div>

                <!-- Card 2: Phone -->
                <div class="contact-card">
                    <div class="contact-card-icon">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <h5 class="contact-card-title">Phone (Landline)</h5>
                    <div class="contact-card-detail">
                        <a href="tel:+622812345678" class="contact-card-link">+62 281-234-5678</a><br>
                        <a href="tel:+6281234567890" class="contact-card-link">+62 812-3456-7890</a><br>
                        Senin - Sabtu: 08:00 - 17:00
                    </div>
                </div>

                <!-- Card 3: Location -->
                <div class="contact-card">
                    <div class="contact-card-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5 class="contact-card-title">Our Office Location</h5>
                    <div class="contact-card-detail">
                        Visit us at Kampung Nopia<br>
                        Traditional nopia production center<br>
                        <a href="#" class="contact-card-link">Get Directions →</a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brown text-white py-5">
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
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const data = {
        name: document.getElementById('name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        message: document.getElementById('message').value,
    };

    fetch('/contact/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            alert('Pesan berhasil dikirim. Admin akan segera menghubungi Anda.');
            document.getElementById('contactForm').reset();
        }
    });
});
</script>

</body>
</html>