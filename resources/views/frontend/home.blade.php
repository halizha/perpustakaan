@extends('frontend.layouts.main')

@section('title', 'Beranda | Perpustakaan')

@section('content')

    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        main {
            height: 100vh;
            overflow-y: scroll;
            scroll-snap-type: y mandatory;
            scrollbar-width: none;
            scroll-behavior: smooth;
        }

        main::-webkit-scrollbar {
            display: none;
        }

        section.fullscreen {
            height: 100vh;
            scroll-snap-align: start;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            /* ✅ tengah horizontal */
            justify-content: center;
            /* ✅ tengah vertikal */
            text-align: center;
            /* ✅ teks tengah */
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
            padding: 2rem;
        }

        section.fullscreen.active {
            opacity: 1;
            transform: translateY(0);
        }

        #home {
            height: 100vh;
            scroll-snap-align: start;
            background: url('{{ asset('storage/sekolah.png') }}') no-repeat center center;
            background-size: cover;
            color: white;
            display: flex;
            align-items: center;
            /* ✅ tengah horizontal */
            justify-content: center;
            /* ✅ tengah vertikal */
            text-align: center;
            box-sizing: border-box;
            opacity: 1 !important;
            transform: none !important;
        }

        #home h1 {
            font-size: 2.5rem;
            max-width: 800px;
        }

        /* Kotak kategori */
        .kategori-card {
            background: var(--bg-color, #0d6efd);
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            width: 160px;
            aspect-ratio: 1 / 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 15px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .kategori-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .kategori-icon {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .kategori-nama {
            font-size: 1.1rem;
            text-align: center;

        }

        #kategori {
            justify-content: flex-start;
            padding-top: 130px;
            /* awalnya 80px */
        }

        #kategori h1 {
            margin-top: 0;
            margin-bottom: 30px;
            text-align: center;
            width: 100%;
        }
    </style>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('storage/logo.png') }}" alt="Logo" width="40" height="40" class="me-2">
                Perpustakaan SMA Negeri 1 Bumiayu
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kategori">Kategori</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <section id="home">
            <h1>Selamat Datang di Perpustakaan SMA Negeri 1 Bumiayu</h1>
        </section>

        @include('livewire.frontend.kategori-list')

        <section id="kontak" class="fullscreen" style="background: #f8f9fa; color: #000;">
            <div class="w-100 py-5 text-center">
                <h2>Contact</h2>
                <div>
                    <span>Need Help?</span>
                    <span class="fw-bold">Contact Us</span>
                </div>
            </div>
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4">
                        <div class="d-flex mb-4">
                            <i class="bi bi-geo-alt fs-3 text-primary me-3"></i>
                            <div>
                                <h3>Address</h3>
                                <p>A108 Adam Street, New York, NY 535022</p>
                            </div>
                        </div>
                        <div class="d-flex mb-4">
                            <i class="bi bi-telephone fs-3 text-primary me-3"></i>
                            <div>
                                <h3>Call Us</h3>
                                <p>+1 5589 55488 55</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <i class="bi bi-envelope fs-3 text-primary me-3"></i>
                            <div>
                                <h3>Email Us</h3>
                                <p>info@example.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <form method="post" action="#" class="p-4 border rounded bg-white shadow-sm">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name"
                                        required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control" placeholder="Your Email"
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <input type="text" name="subject" class="form-control" placeholder="Subject"
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <textarea name="message" rows="6" class="form-control" placeholder="Message" required></textarea>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary px-5">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <footer style="background: #343a40; color: #fff; padding: 10px 0; text-align: center;">
            <p class="mb-0">© {{ date('Y') }} Perpustakaan SMA Negeri 1</p>
        </footer>
    </main>

    <script>
        const sections = document.querySelectorAll('section.fullscreen');

        function animateSections() {
            sections.forEach(sec => {
                const rect = sec.getBoundingClientRect();
                if (rect.top >= 0 && rect.top < window.innerHeight / 1.5) {
                    sec.classList.add('active');
                }
            });
        }
        document.querySelector('main').addEventListener('scroll', animateSections);
        window.addEventListener('load', animateSections);
    </script>

@endsection
