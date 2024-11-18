@extends('layouts.front')

@section('meta')
<meta name="description" content="PKM-RES - Sistem Reservasi Ruang Modern Di Gedung PKM">
@endsection

@section('title')
    <title>PKM-RES - Sistem Reservasi Ruang Di Gedung PKM</title>
@endsection

@section('style')
    <style>
        /* Global Styles */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                        url('{{ asset('images/PKM.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Navbar Styles */
        .navbar {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo-section {
            margin-left: -15rem;
        }

        .logo {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo img {
            width: 45px;
            height: 45px;
            margin-right: 0.75rem;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .buttons-section {
            margin-right: -15rem;
        }

        .nav-button {
            background: transparent;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 600;
            border: 2px solid white;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
            margin-left: 1rem;
        }

        .nav-button:hover {
            background: white;
            color: #2124e3;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 255, 255, 0.2);
        }

        /* Hero Section Styles */
        .hero-section {
            padding: 8rem 2rem 4rem;
            color: white;
            position: relative;
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            animation: fadeInDown 1s ease-out;
        }

        .hero-description {
            font-size: 1.25rem;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            animation: fadeIn 1s ease-out 0.5s both;
        }

        .see-more-button {
            background: #2124e3;
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            animation: fadeInUp 1s ease-out 1s both;
        }

        .see-more-button:hover {
            background: #1618b0;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(33, 36, 227, 0.4);
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
            }

            .navbar-container {
                padding: 0 1rem;
            }

            .logo-section {
                margin-left: -1rem;
            }

            .buttons-section {
                margin-right: -1rem;
            }

            .nav-button {
                padding: 0.5rem 1.25rem;
                margin-left: 0.5rem;
                font-size: 0.8rem;
            }

            .hero-section {
                padding: 6rem 1rem 3rem;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-description {
                font-size: 1.1rem;
            }
        }
    </style>
@endsection

@section('content')
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="logo-section">
                <a href="/" class="logo">
                    <img src="{{ asset('images/Logo_UNIB.png') }}" alt="PKM-RES Logo">
                    <span>PKM-RES</span>
                </a>
            </div>
            <div class="buttons-section">
                <a href="{{ route('login') }}" class="nav-button">Login</a>
                <a href="{{ route('register') }}" class="nav-button">Register</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto">
        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <h1 class="hero-title">Sistem Reservasi Ruang Di Gedung PKM</h1>
                <div class="hero-description">
                    <p id="short-description">
                        Selamat datang di PKM-RES, solusi praktis untuk peminjaman ruangan PKM. 
                        Gunakan PKM-RES untuk peminjaman ruang dengan cepat dan efisien. 
                        <span id="more-text" style="display:none;">
                            Sistem kami dirancang untuk memberikan pengalaman terbaik dalam 
                            proses peminjaman ruangan. Dengan antarmuka yang intuitif dan 
                            proses yang streamlined, Anda dapat dengan mudah memesan ruangan 
                            sesuai kebutuhan Anda.
                        </span>
                    </p>
                </div>
                <button class="see-more-button" id="see-more-button">
                    Lihat Selengkapnya
                </button>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    document.getElementById("see-more-button").addEventListener("click", function() {
        const moreText = document.getElementById("more-text");
        const button = document.getElementById("see-more-button");
        
        moreText.style.transition = "opacity 0.3s ease";
        
        if (moreText.style.display === "none") {
            moreText.style.display = "inline";
            moreText.style.opacity = "0";
            setTimeout(() => {
                moreText.style.opacity = "1";
            }, 10);
            button.textContent = "Lihat Lebih Sedikit";
        } else {
            moreText.style.opacity = "0";
            setTimeout(() => {
                moreText.style.display = "none";
            }, 300);
            button.textContent = "Lihat Selengkapnya";
        }
    });
</script>
@endsection