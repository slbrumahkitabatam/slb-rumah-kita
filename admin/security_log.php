<?php
require_once '../config/database.php';
require_once 'auth.php';

// Get filter parameters
$event_type = $_GET['event_type'] ?? '';
$days = $_GET['days'] ?? '7';

// Build query
$where = "WHERE event_time >= DATE_SUB(NOW(), INTERVAL ? DAY)";
$params = [$days];

if ($event_type) {
    $where .= " AND event_type = ?";
    $params[] = $event_type;
}

// Get logs
$logs = fetchAll("SELECT * FROM security_logs $where ORDER BY event_time DESC LIMIT 100", $params);

// Get statistics
$stats = fetchOne("
    SELECT 
        COUNT(*) as total_logs,
        SUM(CASE WHEN event_type = 'LOGIN_SUCCESS' THEN 1 ELSE 0 END) as successful_logins,
        SUM(CASE WHEN event_type = 'LOGIN_FAILED' THEN 1 ELSE 0 END) as failed_logins,
        SUM(CASE WHEN event_type = 'LOGIN_BLOCKED' THEN 1 ELSE 0 END) as blocked_logins
    FROM security_logs 
    WHERE event_time >= DATE_SUB(NOW(), INTERVAL ? DAY)
", [$days]);

// Get event type counts
$event_counts = fetchAll("
    SELECT event_type, COUNT(*) as count 
    FROM security_logs 
    WHERE event_time >= DATE_SUB(NOW(), INTERVAL ? DAY)
    GROUP BY event_type
    ORDER BY count DESC
", [$days]);

$active_menu = 'security_log';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Log - Admin Panel</title>
    <link rel="shortcut icon" href="../gambar/icon.jpg">
    <link rel="icon" href="../gambar/icon.jpg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .stat-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .log-table {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .log-table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            border: none;
            padding: 12px;
        }
        .log-table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }
        .badge-success {
            background: linear-gradient(135deg, #4ade80 0%, #3cb371 100%);
        }
        .badge-danger {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .badge-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .badge-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .badge-secondary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .btn-filter {
            border-radius: 8px;
            border: 2px solid #dee2e6;
            padding: 8px 16px;
            transition: all 0.3s;
        }
        .btn-filter:hover {
            border-color: #667eea;
            background-color: rgba(102, 126, 234, 0.1);
        }
        .btn-filter.active {
            background-color: #667eea;
            border-color: #667eea;
            color: white;
        }
    </style>
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0"><i class="fas fa-shield-alt text-primary me-2"></i>Security Log</h2>
                <p class="text-muted mb-0">Monitor aktivitas keamanan sistem</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-danger btn-sm" onclick="if(confirm('Apakah Anda yakin ingin membersihkan log lama?')) { window.location.href='security_log.php?action=clean'; }">
                    <i class="fas fa-trash me-1"></i>Bersihkan Log
                </button>
                <button class="btn btn-outline-primary btn-sm" onclick="window.location.reload()">
                    <i class="fas fa-sync-alt me-1"></i>Refresh
                </button>
            </div>
        </div>
        
        <?php
        if (isset($_GET['action']) && $_GET['action'] === 'clean') {
            // Clean old logs (older than 90 days)
            execute("DELETE FROM security_logs WHERE event_time < DATE_SUB(NOW(), INTERVAL 90 DAY)");
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo 'Log lama berhasil dibersihkan!';
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
            echo '</div>';
        }
        ?>
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-4">
                <div class="stat-card card p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Total Log</h6>
                            <h3 class="fw-bold mb-0"><?php echo $stats['total_logs'] ?? 0; ?></h3>
                        </div>
                        <div class="stat-icon bg-secondary text-white">
                            <i class="fas fa-list"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-card card p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Login Berhasil</h6>
                            <h3 class="fw-bold mb-0 text-success"><?php echo $stats['successful_logins'] ?? 0; ?></h3>
                        </div>
                        <div class="stat-icon badge-success text-white">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-card card p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Login Gagal</h6>
                            <h3 class="fw-bold mb-0 text-danger"><?php echo $stats['failed_logins'] ?? 0; ?></h3>
                        </div>
                        <div class="stat-icon badge-danger text-white">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="stat-card card p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="text-muted mb-1">Login Diblok</h6>
                            <h3 class="fw-bold mb-0 text-warning"><?php echo $stats['blocked_logins'] ?? 0; ?></h3>
                        </div>
                        <div class="stat-icon badge-warning text-white">
                            <i class="fas fa-ban"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0 fw-semibold">Periode:</label>
                        <div class="btn-group">
                            <button class="btn btn-filter <?php echo $days === '1' ? 'active' : ''; ?>" onclick="window.location.href='security_log.php?days=1<?php echo $event_type ? "&event_type=$event_type" : ""; ?>'">1 Hari</button>
                            <button class="btn btn-filter <?php echo $days === '7' ? 'active' : ''; ?>" onclick="window.location.href='security_log.php?days=7<?php echo $event_type ? "&event_type=$event_type" : ""; ?>'">7 Hari</button>
                            <button class="btn btn-filter <?php echo $days === '30' ? 'active' : ''; ?>" onclick="window.location.href='security_log.php?days=30<?php echo $event_type ? "&event_type=$event_type" : ""; ?>'">30 Hari</button>
                            <button class="btn btn-filter <?php echo $days === '90' ? 'active' : ''; ?>" onclick="window.location.href='security_log.php?days=90<?php echo $event_type ? "&event_type=$event_type" : ""; ?>'">90 Hari</button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0 fw-semibold">Tipe Event:</label>
                        <select class="form-select" style="width: 200px;" onchange="window.location.href='security_log.php?days=<?php echo $days; ?>&event_type=' + this.value">
                            <option value="">Semua</option>
                            <option value="LOGIN_SUCCESS" <?php echo $event_type === 'LOGIN_SUCCESS' ? 'selected' : ''; ?>>Login Berhasil</option>
                            <option value="LOGIN_FAILED" <?php echo $event_type === 'LOGIN_FAILED' ? 'selected' : ''; ?>>Login Gagal</option>
                            <option value="LOGIN_BLOCKED" <?php echo $event_type === 'LOGIN_BLOCKED' ? 'selected' : ''; ?>>Login Diblok</option>
                            <option value="CUSTOM_EVENT" <?php echo $event_type === 'CUSTOM_EVENT' ? 'selected' : ''; ?>>Custom Event</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Event Type Distribution -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-chart-pie text-primary me-2"></i>Distribusi Tipe Event</h5>
            </div>
            <div class="card-body">
                <?php if ($event_counts): ?>
                    <div class="row">
                        <?php foreach ($event_counts as $count): ?>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                                    <div>
                                        <strong><?php echo htmlspecialchars($count['event_type']); ?></strong>
                                        <small class="text-muted">kejadian</small>
                                    </div>
                                    <span class="badge badge-secondary text-white fs-6"><?php echo $count['count']; ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">Belum ada data log untuk periode ini</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Log Table -->
        <div class="log-table">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tipe Event</th>
                            <th>Deskripsi</th>
                            <th>Username</th>
                            <th>IP Address</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if ($logs):
                            $no = 1;
                            foreach ($logs as $log):
                                $badgeClass = 'badge-secondary';
                                $icon = 'fa-info-circle';
                                
                                if ($log['event_type'] === 'LOGIN_SUCCESS') {
                                    $badgeClass = 'badge-success';
                                    $icon = 'fa-check-circle';
                                } elseif ($log['event_type'] === 'LOGIN_FAILED') {
                                    $badgeClass = 'badge-danger';
                                    $icon = 'fa-times-circle';
                                } elseif ($log['event_type'] === 'LOGIN_BLOCKED') {
                                    $badgeClass = 'badge-warning';
                                    $icon = 'fa-ban';
                                } elseif ($log['event_type'] === 'CUSTOM_EVENT') {
                                    $badgeClass = 'badge-info';
                                    $icon = 'fa-info-circle';
                                }
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td>
                                <span class="badge <?php echo $badgeClass; ?> text-white">
                                    <i class="fas <?php echo $icon; ?> me-1"></i>
                                    <?php echo htmlspecialchars($log['event_type']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($log['description']); ?></td>
                            <td>
                                <?php if ($log['username'] === 'anonymous'): ?>
                                    <span class="text-muted">-</span>
                                <?php else: ?>
                                    <strong><?php echo htmlspecialchars($log['username']); ?></strong>
                                <?php endif; ?>
                            </td>
                            <td><code><?php echo htmlspecialchars($log['ip_address']); ?></code></td>
                            <td>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    <?php echo date('d/m/Y H:i:s', strtotime($log['event_time'])); ?>
                                </small>
                            </td>
                        </tr>
                        <?php 
                            endforeach;
                        else:
                        ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted">Belum ada log keamanan untuk periode ini</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Info -->
        <div class="alert alert-info mt-4">
            <i class="fas fa-info-circle me-2"></i>
            <strong>Informasi:</strong>
            <ul class="mb-0 mt-2">
                <li>Log yang lebih dari 90 hari akan otomatis dibersihkan</li>
                <li>Login gagal lebih dari 5 kali akan otomatis diblokir</li>
                <li>Session akan expire setelah 30 menit tidak aktif</li>
                <li>Gunakan log ini untuk monitoring aktivitas mencurigakan</li>
            </ul>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>