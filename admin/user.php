<?php
require '../config/database.php';
require '../config/helper.php';
require 'auth.php';

require_admin();

$active_menu = 'user';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $username = sanitize($_POST['username']);
        $nama = sanitize($_POST['nama']);
        $role = sanitize($_POST['role']);
        $password = $_POST['password'];
        
        if (empty($username) || empty($nama) || empty($password) || empty($role)) {
            $error = 'Semua field harus diisi!';
        } else {
            $existing = fetchOne("SELECT id FROM users WHERE username = ?", [$username]);
            if ($existing) {
                $error = 'Username sudah digunakan!';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                execute("INSERT INTO users (username, password, nama, role) VALUES (?, ?, ?, ?)", 
                    [$username, $hashed_password, $nama, $role]);
                set_flash('success', 'User berhasil ditambahkan!');
                header('Location: user.php');
                exit;
            }
        }
    } elseif ($action === 'edit') {
        $id = (int)$_POST['id'];
        $nama = sanitize($_POST['nama']);
        $role = sanitize($_POST['role']);
        $password = $_POST['password'] ?? '';
        
        if (empty($nama) || empty($role)) {
            $error = 'Nama user dan role harus diisi!';
        } else {
            // Jangan ubah role user sendiri ke guru jika dia admin
            if ($id === $_SESSION['user_id'] && $role !== 'admin') {
                $error = 'Tidak dapat mengubah role user yang sedang login!';
            } else {
                if (!empty($password)) {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    execute("UPDATE users SET nama = ?, password = ?, role = ? WHERE id = ?", 
                        [$nama, $hashed_password, $role, $id]);
                } else {
                    execute("UPDATE users SET nama = ?, role = ? WHERE id = ?", [$nama, $role, $id]);
                }
                set_flash('success', 'User berhasil diperbarui!');
                header('Location: user.php');
                exit;
            }
        }
    } elseif ($action === 'delete') {
        $id = (int)$_POST['id'];
        
        if ($id === $_SESSION['user_id']) {
            $error = 'Tidak dapat menghapus user yang sedang login!';
        } else {
            execute("DELETE FROM users WHERE id = ?", [$id]);
            set_flash('success', 'User berhasil dihapus!');
            header('Location: user.php');
            exit;
        }
    }
}

$users = fetchAll("SELECT * FROM users ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - Admin Panel</title>
    <link rel="shortcut icon" href="../gambar/icon.jpg">
    <link rel="icon" href="../gambar/icon.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding-bottom: 50px;
        }
        
        .main-content {
            margin-left: 280px;
            padding: 30px;
        }
        
        /* Elegant Header */
        .elegant-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.4);
        }
        
        .elegant-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 15s infinite;
        }
        
        @keyframes shimmer {
            0%, 100% { transform: rotate(0deg); }
            50% { transform: rotate(180deg); }
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .header-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin-bottom: 20px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .elegant-header h2 {
            color: white;
            font-weight: 700;
            font-size: 2rem;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 0;
            font-weight: 300;
            letter-spacing: 0.5px;
        }
        
        .btn-elegant {
            background: white;
            color: #667eea;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-elegant:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            color: #764ba2;
        }
        
        .decorative-dots {
            position: absolute;
            bottom: 20px;
            right: 30px;
            display: flex;
            gap: 10px;
        }
        
        .decorative-dots .dot {
            width: 10px;
            height: 10px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        
        .decorative-dots .dot:nth-child(2) {
            animation-delay: 0.4s;
        }
        
        .decorative-dots .dot:nth-child(3) {
            animation-delay: 0.8s;
        }
        
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.4;
            }
            50% {
                transform: scale(1.3);
                opacity: 0.8;
            }
        }
        
        /* Card Enhancement */
        .card {
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
            background: white;
        }
        
        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        }
        
        /* Table Enhancement */
        .table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            border: none;
            padding: 15px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody tr {
            transition: all 0.3s;
        }
        
        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
            transform: scale(1.01);
        }
        
        .table td {
            vertical-align: middle;
            padding: 15px;
        }
        
        /* Badge Enhancement */
        .badge-admin {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.85rem;
            box-shadow: 0 2px 10px rgba(240, 147, 251, 0.3);
        }
        
        .badge-guru {
            background: linear-gradient(135deg, #4ade80 0%, #3cb371 100%);
            padding: 8px 16px;
            font-weight: 600;
            font-size: 0.85rem;
            box-shadow: 0 2px 10px rgba(74, 222, 128, 0.3);
        }
        
        /* Button Enhancement */
        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #138496);
            border: none;
            transition: all 0.3s;
            border-radius: 8px;
        }
        
        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.4);
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
            transition: all 0.3s;
            border-radius: 8px;
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            transition: all 0.3s;
            border-radius: 8px;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        
        /* Modal Enhancement */
        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 16px 16px 0 0;
            padding: 20px;
        }
        
        .modal-title {
            color: white;
            font-weight: 600;
        }
        
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }
        
        .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s;
        }
        
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }
        
        /* Alert Enhancement */
        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }
        
        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        }
        
        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state i {
            font-size: 5rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }
        
        /* User Avatar */
        .user-avatar-small {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
        }
        
        @media (max-width: 991.98px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    
    <div class="main-content">
        <!-- Elegant Header -->
        <div class="elegant-header">
            <div class="header-content d-flex justify-content-between align-items-center">
                <div>
                    <div class="header-icon">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h2>Manajemen User</h2>
                    <p class="subtitle">Kelola akses dan hak user sistem</p>
                </div>
                <button class="btn btn-elegant" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fas fa-plus me-2"></i>Tambah User
                </button>
            </div>
            <div class="decorative-dots">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
        
        <!-- Alerts -->
        <?php 
        $flash_success = get_flash('success');
        $flash_error = get_flash('error');
        ?>
        <?php if ($flash_success): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i><?= $flash_success ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if ($flash_error): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= $flash_error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?= $error ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- User Table -->
        <div class="card">
            <div class="card-body p-0">
                <?php if (empty($users)): ?>
                    <div class="empty-state">
                        <i class="fas fa-users-slash"></i>
                        <h4 class="text-muted mb-3">Belum ada user terdaftar</h4>
                        <p class="text-muted">Silakan tambahkan user baru untuk memulai</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="fas fa-plus me-2"></i>Tambah User
                        </button>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="20%">User</th>
                                    <th width="20%">Username</th>
                                    <th width="15%">Role</th>
                                    <th width="20%">Tanggal Dibuat</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar-small me-3">
                                                    <?= strtoupper(substr($user['nama'], 0, 1)) ?>
                                                </div>
                                                <div>
                                                    <strong><?= htmlspecialchars($user['nama']) ?></strong>
                                                    <?php if ($user['id'] === $_SESSION['user_id']): ?>
                                                        <small class="d-block text-muted"><i class="fas fa-user-shield"></i> Anda</small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="bg-light px-2 py-1 rounded"><?= htmlspecialchars($user['username']) ?></code>
                                        </td>
                                        <td>
                                            <?php 
                                            $role = $user['role'];
                                            $badgeClass = $role === 'admin' ? 'badge-admin' : 'badge-guru';
                                            $icon = $role === 'admin' ? 'fa-crown' : 'fa-user-graduate';
                                            ?>
                                            <span class="badge <?= $badgeClass ?> text-white">
                                                <i class="fas <?= $icon ?> me-1"></i>
                                                <?= ucfirst($role) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                <?= tgl_singkat($user['created_at']) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-info btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editUserModal<?= $user['id'] ?>"
                                                        title="Edit User">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                                    <form method="POST" class="d-inline" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus User">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <button class="btn btn-secondary btn-sm" disabled title="Tidak bisa menghapus user sendiri">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1">Total User</h6>
                                <h3 class="fw-bold mb-0"><?= count($users) ?></h3>
                            </div>
                            <div class="user-avatar-small" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 60px; height: 60px; font-size: 1.8rem;">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-muted mb-1">User Administrator</h6>
                                <h3 class="fw-bold mb-0 text-danger">
                                    <?= count(array_filter($users, fn($u) => $u['role'] === 'admin')) ?>
                                </h3>
                            </div>
                            <div class="user-avatar-small" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); width: 60px; height: 60px; font-size: 1.8rem;">
                                <i class="fas fa-crown"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Tambah User -->
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i>Tambah User Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form method="POST">
                        <input type="hidden" name="action" value="add">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user me-2 text-primary"></i>Username
                            </label>
                            <input type="text" class="form-control" name="username" required
                                   placeholder="Masukkan username unik">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-id-card me-2 text-primary"></i>Nama Lengkap
                            </label>
                            <input type="text" class="form-control" name="nama" required
                                   placeholder="Masukkan nama lengkap">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-shield-alt me-2 text-primary"></i>Role
                            </label>
                            <select class="form-select" name="role" required>
                                <option value="">Pilih Role</option>
                                <option value="admin">Administrator</option>
                                <option value="guru" selected>Guru</option>
                            </select>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Administrator memiliki akses penuh ke semua menu
                            </small>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-lock me-2 text-primary"></i>Password
                            </label>
                            <input type="password" class="form-control" name="password" required minlength="6"
                                   placeholder="Masukkan password">
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-3">
                            <i class="fas fa-save me-2"></i>Simpan User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Edit User -->
    <?php foreach ($users as $user): ?>
        <div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Edit User</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form method="POST">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-user me-2 text-primary"></i>Username
                                </label>
                                <input type="text" class="form-control" name="username" 
                                       value="<?= htmlspecialchars($user['username']) ?>" disabled>
                                <small class="text-muted">Username tidak dapat diubah</small>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-id-card me-2 text-primary"></i>Nama Lengkap
                                </label>
                                <input type="text" class="form-control" name="nama" 
                                       value="<?= htmlspecialchars($user['nama']) ?>" required
                                       placeholder="Masukkan nama lengkap">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-shield-alt me-2 text-primary"></i>Role
                                </label>
                                <?php 
                                $currentRole = $user['role'];
                                $isSelf = $user['id'] === $_SESSION['user_id'];
                                ?>
                                <select class="form-select" name="role" required 
                                        <?= $isSelf ? 'disabled' : '' ?>>
                                    <option value="">Pilih Role</option>
                                    <option value="admin" <?= $currentRole === 'admin' ? 'selected' : '' ?>>
                                        Administrator
                                    </option>
                                    <option value="guru" <?= $currentRole === 'guru' ? 'selected' : '' ?>>
                                        Guru
                                    </option>
                                </select>
                                <?php if ($isSelf): ?>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Role user sendiri tidak dapat diubah
                                    </small>
                                <?php endif; ?>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-lock me-2 text-primary"></i>Password Baru
                                </label>
                                <input type="password" class="form-control" name="password" 
                                       placeholder="Biarkan kosong jika tidak ingin mengubah" minlength="6">
                                <small class="text-muted">Minimal 6 karakter (opsional)</small>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 py-3">
                                <i class="fas fa-save me-2"></i>Update User
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>