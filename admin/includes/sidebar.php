<?php if (!isset($active_menu)) $active_menu = ''; ?>
<div class="sidebar-container">
    <!-- Mobile Toggle Button -->
    <button class="sidebar-toggle d-md-none" type="button" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <!-- Logo & Brand -->
        <div class="sidebar-header">
            <div class="logo-section text-center">
                <div class="logo-circle mb-2">
                    <i class="fas fa-school fa-lg"></i>
                </div>
                <h5 class="brand-name mb-0">Admin Panel</h5>
                <small class="brand-subtitle">SLB Rumah Kita Batam</small>
            </div>
        </div>
        
        <!-- User Info -->
        <div class="user-info border-bottom border-light">
            <div class="d-flex align-items-center">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-details ms-3">
                    <h6 class="mb-0"><?php echo htmlspecialchars($_SESSION['nama'] ?? 'Administrator'); ?></h6>
                    <small class="text-white-50"><?php echo htmlspecialchars($_SESSION['username'] ?? 'admin'); ?></small>
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
                    <?php
                    $count_berita = fetchOne("SELECT COUNT(*) as total FROM berita");
                    if ($count_berita['total'] > 0):
                    ?>
                    <span class="badge"><?php echo $count_berita['total']; ?></span>
                    <?php endif; ?>
                </a>
                <a class="nav-item <?php echo $active_menu === 'galeri' ? 'active' : ''; ?>" href="galeri.php">
                    <i class="fas fa-images"></i>
                    <span>Galeri</span>
                    <?php
                    $count_galeri = fetchOne("SELECT COUNT(*) as total FROM galeri");
                    if ($count_galeri['total'] > 0):
                    ?>
                    <span class="badge"><?php echo $count_galeri['total']; ?></span>
                    <?php endif; ?>
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
                    <?php
                    $count_guru = fetchOne("SELECT COUNT(*) as total FROM guru WHERE aktif = 1");
                    if ($count_guru['total'] > 0):
                    ?>
                    <span class="badge"><?php echo $count_guru['total']; ?></span>
                    <?php endif; ?>
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

/* Mobile Toggle Button */
.sidebar-toggle {
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 1001;
    background: #4A90E2;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(74, 144, 226, 0.4);
    transition: all 0.3s;
}

.sidebar-toggle:hover {
    background: #357ABD;
    transform: translateX(5px);
}

/* Sidebar */
.sidebar {
    background: linear-gradient(180deg, #4A90E2 0%, #357ABD 50%, #2a5f8f 100%);
    height: 100vh;
    max-height: 100vh;
    position: fixed;
    left: 0;
    top: 0;
    width: 280px;
    z-index: 1000;
    overflow-y: auto;
    overflow-x: hidden;
    transition: all 0.3s ease-in-out;
    box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
}

/* Sidebar Header */
.sidebar-header {
    background: rgba(0, 0, 0, 0.1);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding: 0.8rem 0;
}

.logo-circle {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    border: 2px solid rgba(255, 255, 255, 0.3);
    transition: all 0.3s;
}

.logo-circle:hover {
    transform: rotate(360deg);
    border-color: rgba(255, 255, 255, 0.5);
}

.brand-name {
    color: white;
    font-weight: 600;
    font-size: 1rem;
    letter-spacing: 0.5px;
}

.brand-subtitle {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.75rem;
}

/* User Info */
.user-info {
    background: rgba(0, 0, 0, 0.05);
    padding: 0.6rem 0.8rem;
}

.user-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.3);
}

.user-details h6 {
    color: white;
    font-weight: 500;
    font-size: 0.85rem;
}

.user-details small {
    font-size: 0.75rem;
}

/* Navigation */
.sidebar-nav {
    padding: 0 8px;
}

.nav-section {
    margin-bottom: 15px;
}

.nav-label {
    display: block;
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.65rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 0 12px;
    margin-bottom: 6px;
}

.nav-item {
    display: flex;
    align-items: center;
    color: rgba(255, 255, 255, 0.85);
    padding: 9px 12px;
    margin: 3px 4px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.nav-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 3px;
    height: 100%;
    background: white;
    border-radius: 3px 0 0 3px;
    transform: scaleY(0);
    transition: transform 0.3s;
}

.nav-item:hover {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    transform: translateX(5px);
}

.nav-item:hover::before {
    transform: scaleY(1);
}

.nav-item.active {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    font-weight: 500;
}

.nav-item.active::before {
    transform: scaleY(1);
}

.nav-item i {
    width: 24px;
    font-size: 1.1rem;
    margin-right: 12px;
    transition: transform 0.3s;
}

.nav-item:hover i {
    transform: scale(1.2);
}

.nav-item span {
    flex-grow: 1;
    font-size: 0.95rem;
    font-weight: 400;
}

.nav-item .badge {
    background: rgba(255, 255, 255, 0.25);
    color: white;
    font-size: 0.75rem;
    padding: 3px 10px;
    border-radius: 15px;
    font-weight: 600;
    margin-left: auto;
}

.nav-item.logout {
    background: rgba(220, 53, 69, 0.15);
}

.nav-item.logout:hover {
    background: rgba(220, 53, 69, 0.3);
    color: #ffcfcf;
}

.nav-item.external .icon-end {
    font-size: 0.7rem;
    margin-left: 8px;
    opacity: 0.6;
}

/* Scrollbar */
.sidebar::-webkit-scrollbar {
    width: 5px;
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
        width: 280px;
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
    
    .main-content {
        margin-left: 0 !important;
        padding: 20px 15px;
    }
}

@media (min-width: 992px) {
    .main-content {
        margin-left: 280px;
        padding: 30px;
    }
    
    .sidebar-toggle {
        display: none;
    }
}
</style>

<script>
// Sidebar Toggle for Mobile
document.getElementById('sidebarToggle')?.addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('show');
});

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebarToggle');
    
    if (window.innerWidth < 992 && 
        sidebar.classList.contains('show') && 
        !sidebar.contains(e.target) && 
        !toggle.contains(e.target)) {
        sidebar.classList.remove('show');
    }
});

// Close sidebar on window resize
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    if (window.innerWidth >= 992) {
        sidebar.classList.remove('show');
    }
});
</script>