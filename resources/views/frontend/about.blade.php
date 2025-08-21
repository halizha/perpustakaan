@extends('frontend.layouts.main')

@section('title', 'Beranda | Perpustakaan')

@section('content')

<style>
    html, body {
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

    /* Default section */
    section.fullscreen {
        height: 100vh;
        scroll-snap-align: start;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
        opacity: 0;
        transform: translateY(50px);
        transition: all 0.8s ease;
        padding-top: 80px; 
        padding-left: 2rem;
        padding-right: 2rem;
    }
    section.fullscreen.active {
        opacity: 1;
        transform: translateY(0);
    }

    /* HERO khusus, bukan fullscreen */
    #hero {
        height: 100vh;
        scroll-snap-align: start;
        background: url('{{ asset('storage/sekolah.png') }}') no-repeat center center;
        background-size: cover;
        color: white;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        padding-left: 2rem;
        padding-right: 2rem;
        padding-top: 80px;
        box-sizing: border-box;
        opacity: 1 !important;
        transform: none !important;
    }
    #hero h1 {
        font-size: 2.5rem;
        max-width: 800px;
    }

    /* Section lain */
    #kategori {
        background: #f8f9fa;
    }
    #kontak {
        background: #343a40;
        color: white;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Perpustakaan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="#hero">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#kategori">Kategori</a></li>
                <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
            </ul>
        </div>
    </div>
</nav>

<main>
    
    <section id="hero">
        <h1>Selamat Datang di Perpustakaan SMA Negeri 1 Bumiayu</h1>
    </section>

    <section id="kategori" class="fullscreen">
        <h1>Daftar Kategori Buku</h1>
        <div>
            @foreach($kategori as $item)
                <a href="{{ url('kategori/' . $item->id) }}" class="btn btn-outline-primary m-1">
                    {{ $item->nama }}
                </a>
            @endforeach
        </div>
    </section>

    <section id="kontak" class="fullscreen" style="background: #f8f9fa; color: #000;">
    
    <!-- Section Title -->
    <div class="w-100 py-5 text-center">
        <h2>Contact</h2>
        <div>
            <span>Need Help?</span>
            <span class="fw-bold">Contact Us</span>
        </div>
    </div>

    <div class="container">
        <div class="row gy-4">

            <!-- Info Column -->
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

            <!-- Form Column -->
            <div class="col-lg-8">
                <form method="post" action="#" class="p-4 border rounded bg-white shadow-sm">
                    <div class="row gy-4">

                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>

                        <div class="col-md-6">
                            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        </div>

                        <div class="col-md-12">
                            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
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
