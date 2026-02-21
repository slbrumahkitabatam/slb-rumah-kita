<?php 
if (!isset($active_menu)) $active_menu = ''; 

// Ensure database connection and helper functions are available
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/helper.php';

// Fetch tampilan settings for sidebar color
$tampilan = fetchOne("SELECT warna_utama FROM tampilan LIMIT 1");
$primary_color = $tampilan['warna_utama'] ?? '#667eea';

// Generate secondary color (lighter version)
$secondary_color = adjustColorBrightness($primary_color, 20);
?>
<div class="sidebar-container">
    <!-- Mobile Toggle Button -->
    <button class="sidebar-toggle d-md-none" type="button" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <!-- Logo & Brand -->
        <div class="sidebar-header">
            <div class="logo-section text-center position-relative">
                <div class="logo-circle mb-2">
                    <i class="fas fa-school"></i>
                    <div class="logo-glow"></div>
                </div>
                <h5 class="brand-name mb-0">Admin Panel</h5>
                <small class="brand-subtitle">SLB Rumah Kita Batam</small>
                <div class="header-decoration"></div>
            </div>
        </div>
        
        <!-- User Info -->
        <div class="user-info">
            <div class="d-flex align-items-center position-relative">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                    <div class="avatar-glow"></div>
                </div>
                <div class="user-details ms-3">
                    <h6 class="mb-0"><?php echo htmlspecialchars($_SESSION['nama'] ?? 'Administrator'); ?></h6>
                    <small class="text-white-50"><?php echo htmlspecialchars($_SESSION['username'] ?? 'admin'); ?></small>
                    <div class="user-status">
                        <span class="status-dot"></span>
                        <span>Online</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="sidebar-nav py-2">
            <!-- Main Menu -->
            <div class="nav-section">
                <span class="nav-label">Menu Utama</span>
                <a class="nav-item <?php echo $active_menu === 'dashboard' ? 'active' : ''; ?>" href="index.php">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                <a class="nav-item <?php echo $active_menu === 'berita' ? 'active' : ''; ?>" href="berita.php">
                    <i class="fas fa-newspaper"></i>
                    <span>Berita</span>
                </a>
                <a class="nav-item <?php echo $active_menu === 'galeri' ? 'active' : ''; ?>" href="galeri.php">
                    <i class="fas fa-images"></i>
                    <span>Galeri</span>
                </a>
                <a class="nav-item <?php echo $active_menu === 'profil' ? 'active' : ''; ?>" href="profil.php">
                    <i class="fas fa-user-edit"></i>
                    <span>Profil Sekolah</span>
                </a>
            </div>
            
            <!-- Management Menu -->
            <div class="nav-section">
                <span class="nav-label">Manajemen</span>
                <a class="nav-item <?php echo $active_menu === 'guru' ? 'active' : ''; ?>" href="guru.php">
                    <i class="fas fa-users"></i>
                    <span>Guru & Staf</span>
                </a>
                <a class="nav-item <?php echo $active_menu === 'halaman' ? 'active' : ''; ?>" href="halaman.php">
                    <i class="fas fa-sitemap"></i>
                    <span>Halaman & Menu</span>
                </a>
                <a class="nav-item <?php echo $active_menu === 'tampilan' ? 'active' : ''; ?>" href="tampilan.php">
                    <i class="fas fa-palette"></i>
                    <span>Tampilan Website</span>
                </a>
                <a class="nav-item <?php echo $active_menu === 'kontak' ? 'active' : ''; ?>" href="kontak.php">
                    <i class="fas fa-envelope"></i>
                    <span>Kontak</span>
                </a>
            </div>
            
            <!-- User Management Menu -->
            <div class="nav-section">
                <span class="nav-label">Manajemen User</span>
                <a class="nav-item <?php echo $active_menu === 'user' ? 'active' : ''; ?>" href="user.php">
                    <i class="fas fa-users-cog"></i>
                    <span>Manajemen User</span>
                </a>
            </div>
            
            <!-- Security Menu -->
            <div class="nav-section">
                <span class="nav-label">Keamanan</span>
                <a class="nav-item <?php echo $active_menu === 'security_log' ? 'active' : ''; ?>" href="security_log.php">
                    <i class="fas fa-shield-alt"></i>
                    <span>Security Log</span>
                </a>
            </div>
            
            <!-- Settings Menu -->
            <div class="nav-section">
                <span class="nav-label">Pengaturan</span>
                <a class="nav-item <?php echo $active_menu === 'pengaturan' ? 'active' : ''; ?>" href="pengaturan.php">
                    <i class="fas fa-cog"></i>
                    <span>Pengaturan</span>
                </a>
                <a class="nav-item external" href="../index.php" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Lihat Website</span>
                    <i class="fas fa-arrow-up-right-from-square icon-end"></i>
                </a>
            </div>
            
            <!-- Logout -->
            <div class="nav-section mt-4">
                <a class="nav-item logout" href="logout.php">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </div>
        </nav>
    </aside>
</div>

<style>
/* Sidebar Container */
.sidebar-container {
    position: relative;
}

/* Mobile Overlay */
.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    backdrop-filter: blur(5px);
    transition: all 0.3s;
}

.sidebar-overlay.show {
    display: block;
}

/* Mobile Toggle Button */
.sidebar-toggle {
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 1001;
    background: linear-gradient(135deg, <?php echo $primary_color; ?> 0%, <?php echo $secondary_color; ?> 100%);
    color: white;
    border: none;
    padding: 12px 18px;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(<?php echo hexToRgb($primary_color); ?>, 0.5);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    gap: 8px;
    position: relative;
    overflow: hidden;
}

.sidebar-toggle::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.sidebar-toggle:hover::before {
    width: 300px;
    height: 300px;
}

.sidebar-toggle:hover {
    background: linear-gradient(135deg, <?php echo $secondary_color; ?> 0%, <?php echo $primary_color; ?> 100%);
    transform: translateX(5px) scale(1.05);
    box-shadow: 0 6px 25px rgba(<?php echo hexToRgb($primary_color); ?>, 0.6);
}

.sidebar-toggle:active {
    transform: translateX(5px) scale(0.95);
}

/* Sidebar */
.sidebar {
    background: linear-gradient(180deg, 
        <?php echo $primary_color; ?> 0%, 
        <?php echo $secondary_color; ?> 25%, 
        <?php echo adjustColorBrightness($primary_color, -20); ?> 50%, 
        <?php echo adjustColorBrightness($primary_color, -30); ?> 75%,
        <?php echo adjustColorBrightness($primary_color, -40); ?> 100%);
    height: 100vh;
    max-height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    width: 280px;
    z-index: 1000;
    overflow-y: auto;
    overflow-x: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 4px 0 30px rgba(<?php echo hexToRgb($primary_color); ?>, 0.3);
}

/* Sidebar Header */
.sidebar-header {
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.15) 0%, rgba(0, 0, 0, 0.05) 100%);
    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    padding: 1.2rem 0;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.sidebar-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.08) 0%, transparent 70%);
    animation: shimmer 4s infinite;
    pointer-events: none;
}

@keyframes shimmer {
    0% { transform: translate(-30%, -30%) rotate(0deg); }
    50% { transform: translate(30%, 30%) rotate(180deg); }
    100% { transform: translate(-30%, -30%) rotate(360deg); }
}

.header-decoration {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 2px;
    background: linear-gradient(90deg, 
        transparent 0%, 
        rgba(255, 255, 255, 0.5) 50%, 
        transparent 100%);
}

.logo-circle {
    width: 65px;
    height: 65px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    border: 3px solid rgba(255, 255, 255, 0.3);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    cursor: pointer;
}

.logo-glow {
    position: absolute;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
    animation: pulse 2s ease-in-out infinite;
    pointer-events: none;
}

.logo-circle:hover {
    transform: rotate(360deg) scale(1.1);
    border-color: rgba(255, 255, 255, 0.6);
    box-shadow: 0 0 30px rgba(255, 255, 255, 0.3);
}

.logo-circle i {
    font-size: 1.8rem;
    color: white;
    z-index: 1;
    position: relative;
}

.brand-name {
    color: #000000;
    font-weight: 700;
    font-size: 1.15rem;
    letter-spacing: 0.5px;
    text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
    margin-top: 0.5rem;
}

.brand-subtitle {
    color: rgba(255, 255, 255, 0.75);
    font-size: 0.8rem;
    font-weight: 400;
    letter-spacing: 0.3px;
}

/* User Info */
.user-info {
    background: linear-gradient(180deg, rgba(0, 0, 0, 0.08) 0%, rgba(0, 0, 0, 0.02) 100%);
    padding: 0.8rem 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.3);
    position: relative;
    transition: all 0.3s;
}

.avatar-glow {
    position: absolute;
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 70%);
    animation: pulse 3s ease-in-out infinite;
    pointer-events: none;
}

.user-avatar:hover {
    border-color: rgba(255, 255, 255, 0.5);
    transform: scale(1.05);
}

.user-avatar i {
    font-size: 1.3rem;
    color: white;
    z-index: 1;
    position: relative;
}

.user-details h6 {
    color: white;
    font-weight: 600;
    font-size: 0.95rem;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.user-details small {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.6);
}

.user-status {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 4px;
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.7);
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #4ade80;
    animation: blink 2s ease-in-out infinite;
    box-shadow: 0 0 10px rgba(74, 222, 128, 0.6);
}

/* Navigation */
.sidebar-nav {
    padding: 0.5rem 8px;
    position: relative;
    z-index: 5;
}

.nav-section {
    margin-bottom: 20px;
    position: relative;
    z-index: 5;
}

.nav-label {
    display: block;
    color: rgba(255, 255, 255, 0.6);
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    padding: 0 12px;
    margin-bottom: 8px;
}

.nav-item {
    display: flex;
    align-items: center;
    color: rgba(255, 255, 255, 0.9);
    padding: 11px 14px;
    margin: 4px 6px;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: visible;
    cursor: pointer;
    z-index: 100 !important;
}

.nav-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #ffffff 0%, rgba(255, 255, 255, 0.7) 100%);
    border-radius: 4px 0 0 4px;
    transform: scaleY(0);
    transition: transform 0.3s;
    pointer-events: none;
    z-index: -1;
}

.nav-item::after {
    content: '';
    position: absolute;
    left: 50%;
    top: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    transform: translate(-50%, -50%);
    transition: all 0.4s;
    pointer-events: none;
    z-index: -1;
}

.nav-item i,
.nav-item span,
.nav-item .badge,
.nav-item .icon-end {
    position: relative;
    z-index: 2;
}

.nav-item:hover {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    transform: translateX(8px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.nav-item:hover::after {
    width: 200%;
    height: 200%;
}

.nav-item:hover::before {
    transform: scaleY(1);
}

.nav-item.active {
    background: rgba(255, 255, 255, 0.25);
    color: white;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
}

.nav-item.active::before {
    transform: scaleY(1);
}

.nav-item i {
    width: 28px;
    font-size: 1.15rem;
    margin-right: 12px;
    transition: transform 0.3s;
    position: relative;
    z-index: 1;
}

.nav-item:hover i {
    transform: scale(1.15) rotate(5deg);
}

.nav-item span {
    flex-grow: 1;
    font-size: 0.95rem;
    font-weight: 400;
    position: relative;
    z-index: 1;
}

.nav-item .badge {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    font-size: 0.7rem;
    padding: 4px 10px;
    border-radius: 12px;
    font-weight: 700;
    margin-left: auto;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.4);
    position: relative;
    z-index: 1;
}

.nav-item.logout {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(220, 53, 69, 0.1) 100%);
    border: 1px solid rgba(220, 53, 69, 0.3);
}

.nav-item.logout:hover {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.35) 0%, rgba(220, 53, 69, 0.2) 100%);
    border-color: rgba(220, 53, 69, 0.5);
    color: #ffcccc;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}

.nav-item.external .icon-end {
    font-size: 0.75rem;
    margin-left: 8px;
    opacity: 0.6;
    transition: all 0.3s;
    position: relative;
    z-index: 1;
}

.nav-item.external:hover .icon-end {
    opacity: 1;
    transform: translateX(3px);
}

/* Animations */
@keyframes pulse {
    0%, 100% {
        opacity: 0.5;
        transform: scale(1);
    }
    50% {
        opacity: 0.8;
        transform: scale(1.1);
    }
}

@keyframes blink {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

/* Custom Scrollbar */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 10px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

/* Responsive */
@media (max-width: 991.98px) {
    .sidebar {
        transform: translateX(-100%);
        width: 300px;
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
    
    .sidebar-overlay.show {
        display: block;
    }
    
    .main-content {
        margin-left: 0 !important;
        padding: 20px 15px 20px 20px;
    }
    
    .sidebar-toggle {
        display: flex !important;
    }
}

@media (min-width: 992px) {
    .main-content {
        margin-left: 280px;
        padding: 30px;
    }
    
    .sidebar-toggle {
        display: none !important;
    }
    
    .sidebar-overlay {
        display: none !important;
    }
}

/* Extra Small Devices */
@media (max-width: 575.98px) {
    .sidebar {
        width: 280px;
    }
    
    .sidebar-toggle {
        top: 10px;
        left: 10px;
        padding: 10px 14px;
    }
    
    .sidebar-header {
        padding: 1rem 0;
    }
    
    .logo-circle {
        width: 55px;
        height: 55px;
    }
    
    .brand-name {
        font-size: 1rem;
    }
    
    .brand-subtitle {
        font-size: 0.75rem;
    }
    
    .nav-item {
        padding: 10px 12px;
    }
    
    .nav-item span {
        font-size: 0.9rem;
    }
}
</style>

<script>
// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (!sidebar || !toggle || !overlay) return;
    
    // Ensure all nav items are clickable
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(item => {
        item.style.pointerEvents = 'auto';
        item.style.cursor = 'pointer';
        item.style.position = 'relative';
        item.style.zIndex = '1000';
    });
    
    // Sidebar Toggle for Mobile
    toggle.addEventListener('click', function(e) {
        e.preventDefault();
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
        document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
    });
    
    // Close sidebar when clicking overlay
    overlay.addEventListener('click', function() {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    });
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        if (window.innerWidth < 992 && 
            sidebar.classList.contains('show') && 
            !sidebar.contains(e.target) && 
            !toggle.contains(e.target) &&
            !overlay.contains(e.target)) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
    
    // Close sidebar on window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
        }, 250);
    });
    
    // Close sidebar when pressing ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        }
    });
    
    // Debug: Log click events on nav items
    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            console.log('Nav item clicked:', this.href);
        });
    });
});
</script>
