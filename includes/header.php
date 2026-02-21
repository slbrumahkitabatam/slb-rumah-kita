<?php
require_once 'config/database.php';

// Ambil pengaturan sekolah
$pengaturan = fetchOne("SELECT * FROM pengaturan WHERE id = 1");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - ' : ''; ?><?php echo htmlspecialchars($pengaturan['nama_sekolah']); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: <?php echo $pengaturan['warna_utama'] ?? '#4A90E2'; ?>;
            --secondary-color: <?php echo $pengaturan['warna_utama'] ?? '#357ABD'; ?>;
            --accent-color: #F5A623;
            --text-color: <?php echo $pengaturan['warna_teks'] ?? '#333'; ?>;
            --light-bg: #F8F9FA;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
        }
        
        .navbar {
            background: <?php echo $pengaturan['warna_utama'] ?? '#4A90E2'; ?> !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 18px 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 1050 !important;
        }
        
        .navbar.scrolled {
            background: <?php echo $pengaturan['warna_utama'] ?? '#4A90E2'; ?> !important;
            padding: 12px 0;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15);
        }
        
        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent-color), #FFD700, var(--accent-color));
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.1rem;
            color: white !important;
            transition: all 0.3s ease;
            letter-spacing: 0.3px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
        }
        
        .navbar-brand:hover {
            transform: scale(1.05);
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .navbar-brand i {
            background: linear-gradient(135deg, #FFD700, var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            filter: drop-shadow(0 2px 4px rgba(255, 215, 0, 0.4));
            font-size: 1.2rem;
            margin-right: 8px;
        }
        
        .navbar-subtitle {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.85);
            letter-spacing: 0.5px;
            font-weight: 500;
            margin-left: 8px;
            border-left: 1px solid rgba(255, 255, 255, 0.3);
            padding-left: 8px;
        }
        
        .nav-link {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.95) !important;
            padding: 12px 24px !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border-radius: 12px;
            margin: 0 4px;
            font-size: 0.95rem;
        }
        
        .nav-link:hover {
            color: white !important;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25), rgba(255,255, 255, 0.15));
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }
        
        .nav-link i {
            color: var(--accent-color);
            transition: all 0.3s ease;
            margin-right: 6px;
        }
        
        .nav-link:hover i {
            transform: scale(1.2);
            color: #FFD700;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 50%;
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent-color), #FFD700);
            border-radius: 2px;
            transition: all 0.3s ease;
            transform: translateX(-50%);
            box-shadow: 0 2px 8px rgba(245, 166, 35, 0.4);
        }
        
        .nav-link:hover::before {
            width: 70%;
        }
        
        .nav-link.active {
            color: white !important;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), rgba(255,255, 255, 0.2));
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }
        
        .nav-link.active::before {
            width: 70%;
        }
        
        .nav-link.active i {
            color: #FFD700;
        }
        
        .navbar-toggler {
            border: 2px solid rgba(255, 255, 255, 0.4);
            padding: 10px 14px;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.1);
        }
        
        .navbar-toggler:hover {
            border-color: var(--accent-color);
            background: rgba(245, 166, 35, 0.2);
            transform: rotate(180deg) scale(1.1);
            box-shadow: 0 4px 15px rgba(245, 166, 35, 0.3);
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 4px rgba(245, 166, 35, 0.3);
            outline: none;
        }
        
        .navbar-toggler-icon {
            width: 1.3em;
            height: 1.3em;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='white' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2.5' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            transition: all 0.3s ease;
        }
        
        .navbar-collapse {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Responsive Navbar */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: linear-gradient(135deg, rgba(74, 144, 226, 0.98) 0%, rgba(53, 122, 189, 0.98) 100%);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                padding: 25px 0;
                border-radius: 0 0 20px 20px;
                margin-top: 15px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.25);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .nav-link {
                padding: 14px 25px !important;
                margin: 6px 12px;
                border-radius: 12px;
                font-size: 1rem;
                display: flex;
                align-items: center;
            }
            
            .nav-link:hover {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.2));
                transform: translateX(8px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            }
            
            .nav-link::before {
                display: none;
            }
            
            .nav-link i {
                width: 28px;
                text-align: center;
                margin-right: 12px;
            }
            
            .nav-link.active {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.35), rgba(255, 255, 255, 0.25));
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            }
        }
        
        @media (max-width: 767px) {
            .navbar {
                padding: 15px 0;
            }
            
            .navbar-brand {
                font-size: 1rem;
            }
            
            .navbar-brand i {
                font-size: 1.1rem;
            }
            
            .navbar-subtitle {
                display: none;
            }
            
            .nav-link {
                font-size: 0.98rem;
                padding: 12px 20px !important;
            }
            
            .nav-link i {
                width: 26px;
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 575px) {
            .navbar {
                padding: 12px 0;
            }
            
            .navbar-brand {
                font-size: 0.95rem;
            }
            
            .navbar-brand i {
                font-size: 1rem;
            }
            
            .navbar-toggler {
                padding: 8px 12px;
            }
            
            .navbar-toggler-icon {
                width: 1.2em;
                height: 1.2em;
            }
            
            .navbar-collapse {
                padding: 20px 0;
                border-radius: 0 0 15px 15px;
            }
            
            .nav-link {
                padding: 10px 16px !important;
                margin: 5px 8px;
                font-size: 0.95rem;
            }
            
            .nav-link i {
                width: 24px;
                margin-right: 10px;
                font-size: 0.85rem;
            }
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 100px 0;
        }
        
        .section-title {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .footer {
            background-color: #2C3E50;
            color: white;
            padding: 50px 0 20px;
        }
        
        .footer a {
            color: white;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--accent-color);
        }
        
        .news-card img {
            height: 200px;
            object-fit: cover;
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            cursor: pointer;
        }
        
        .gallery-item img {
            transition: transform 0.3s ease;
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .contact-info {
            padding: 20px;
            background-color: var(--light-bg);
            border-radius: 10px;
        }
        
        .contact-info i {
            color: var(--primary-color);
            font-size: 1.2rem;
            margin-right: 10px;
        }
        
        /* Hero Section Styles */
        .hero-section {
            padding: 80px 0 60px;
            min-height: auto;
            display: flex;
            align-items: center;
        }
        
        .hero-bg img {
            object-fit: cover;
        }
        
        .hero-overlay {
            background: linear-gradient(135deg, var(--primary-color) 0%, rgba(44, 62, 80, 0.9) 100%);
            opacity: 0.9;
        }
        
        .hero-badge {
            animation: fadeInDown 0.8s ease;
        }
        
        .hero-highlight {
            background: linear-gradient(90deg, #FFD700 0%, #FFA500 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 20px rgba(255, 215, 0, 0.3);
        }
        
        .hero-content h1 {
            animation: fadeInUp 1s ease 0.2s both;
        }
        
        .hero-content p {
            animation: fadeInUp 1s ease 0.4s both;
        }
        
        .hero-buttons {
            animation: fadeInUp 1s ease 0.6s both;
        }
        
        .hero-stats {
            animation: fadeInUp 1s ease 0.8s both;
        }
        
        .btn.hover-lift {
            transition: all 0.3s ease;
        }
        
        .btn.hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .stat-item {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 20px 15px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .stat-item:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-5px);
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 0.875rem;
        }
        
        /* Floating Shapes */
        .hero-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }
        
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }
        
        .shape-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(45deg, #FFD700, #FFA500);
            top: -150px;
            right: -150px;
            animation: float 6s ease-in-out infinite;
        }
        
        .shape-2 {
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, #4A90E2, #357ABD);
            bottom: -100px;
            left: -100px;
            animation: float 8s ease-in-out infinite reverse;
        }
        
        .shape-3 {
            width: 150px;
            height: 150px;
            background: linear-gradient(45deg, #F5A623, #E8941A);
            top: 50%;
            left: 10%;
            animation: float 7s ease-in-out infinite 1s;
        }
        
        /* Scroll Indicator */
        .scroll-indicator {
            animation: bounce 2s infinite;
        }
        
        .scroll-mouse {
            width: 30px;
            height: 50px;
            border: 2px solid white;
            border-radius: 15px;
            position: relative;
            margin: 0 auto;
        }
        
        .scroll-wheel {
            width: 6px;
            height: 10px;
            background: white;
            border-radius: 3px;
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            animation: scroll 1.5s infinite;
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(10deg);
            }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateX(-50%) translateY(0);
            }
            40% {
                transform: translateX(-50%) translateY(-10px);
            }
            60% {
                transform: translateX(-50%) translateY(-5px);
            }
        }
        
        @keyframes scroll {
            0% {
                opacity: 1;
                top: 10px;
            }
            100% {
                opacity: 0;
                top: 30px;
            }
        }
        
        /* Responsive Adjustments */
        @media (max-width: 991px) {
            .hero-section {
                padding: 100px 0 80px;
                min-height: auto;
            }
            
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .stat-number {
                font-size: 1.25rem;
            }
            
            .stat-item {
                padding: 15px 10px;
            }
            
            .shape {
                opacity: 0.05;
            }
        }
        
        @media (max-width: 767px) {
            .hero-section {
                padding: 80px 0 60px;
            }
            
            .hero-content h1 {
                font-size: 2rem;
            }
            
            .hero-content p {
                font-size: 1rem;
            }
            
            .btn.btn-lg {
                padding: 0.75rem 2rem;
                font-size: 1rem;
            }
            
            .stat-number {
                font-size: 1.1rem;
            }
            
            .stat-label {
                font-size: 0.75rem;
            }
            
            .shape {
                display: none;
            }
            
            .scroll-indicator {
                bottom: 20px;
            }
        }
        
        @media (max-width: 575px) {
            .hero-section {
                padding: 60px 0 50px;
            }
            
            .hero-content h1 {
                font-size: 1.75rem;
            }
            
            .hero-badge .badge {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }
            
            .hero-buttons {
                flex-direction: column;
            }
            
            .hero-buttons .btn {
                width: 100%;
                margin: 0 0 10px 0 !important;
            }
            
            .stat-item {
                padding: 12px 8px;
            }
        }
    </style>
</head>
<body>
    <!-- Bootstrap JS Bundle (required for navbar toggle functionality) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-school me-2"></i>
                <span><?php echo htmlspecialchars($pengaturan['nama_sekolah'] ?? 'SLB Rumah Kita Batam'); ?></span>
                <span class="navbar-subtitle"></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" 
                           href="index.php">
                            <i class="fas fa-home me-1"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'profil.php' ? 'active' : ''; ?>" 
                           href="profil.php">
                            <i class="fas fa-user me-1"></i>Profil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'berita.php' ? 'active' : ''; ?>" 
                           href="berita.php">
                            <i class="fas fa-newspaper me-1"></i>Berita
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'program.php' ? 'active' : ''; ?>" 
                           href="program.php">
                            <i class="fas fa-graduation-cap me-1"></i>Program
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'galeri.php' ? 'active' : ''; ?>" 
                           href="galeri.php">
                            <i class="fas fa-images me-1"></i>Galeri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'kontak.php' ? 'active' : ''; ?>" 
                           href="kontak.php">
                            <i class="fas fa-envelope me-1"></i>Kontak
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Close mobile menu on link click
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                const navbarCollapse = document.getElementById('navbarNav');
                if (navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                    bsCollapse.hide();
                }
            });
        });
    </script>