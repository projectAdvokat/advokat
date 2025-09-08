<?php
function isChatExpired($chat) {
    $end_time = $chat['end_time'] ?? null;
    $current_time = time();
    
    if ($end_time) {
        return $current_time > strtotime($end_time);
    }

    // fallback ke kolom expired kalau ada
    return $chat['expired'] ?? false;
}

// Hitung jumlah chat aktif dan expired untuk badge tab
$activeCount = 0;
$expiredCount = 0;

foreach ($chats as $chat) {
    if (isChatExpired($chat)) {
        $expiredCount++;
    } else {
        $activeCount++;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Chat Konsultasi - Layanan Advokat Online</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a7f5e;
            --primary-light: #e6f4ef;
            --secondary-color: #285c4d;
            --accent-color: #34a37e;
            --light-bg: #f8fdfb;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5fbf9;
            color: #333;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .card {
            border-radius: 12px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            overflow: hidden;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(26, 127, 94, 0.15);
        }
        
        .chat-card {
            border-left: 4px solid var(--primary-color);
        }
        
        .chat-card.expired {
            border-left: 4px solid #dc3545;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            font-weight: 500;
            padding: 10px 20px;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 500;
            border: none;
            padding: 12px 20px;
            border-radius: 8px 8px 0 0;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: white;
            border-bottom: 3px solid var(--primary-color);
            font-weight: 600;
        }
        
        .badge {
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 20px;
        }
        
        .time-count {
            font-weight: 600;
            color: var(--accent-color);
        }
        
        .empty-state {
            padding: 3rem 1rem;
            background-color: white;
            border-radius: 12px;
            text-align: center;
        }
        
        .empty-state i {
            font-size: 4rem;
            color: #c5e9dc;
            margin-bottom: 1rem;
        }
        
        .chat-info {
            background-color: var(--primary-light);
            padding: 15px;
            border-radius: 8px;
        }
        
        .header-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #e6f4ef;
            padding: 1.2rem 1.5rem;
        }
        
        .card-footer {
            background-color: white;
            border-top: 1px solid #e6f4ef;
            padding: 1.2rem 1.5rem;
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <div class="container mt-4">
        <div class="header-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-5 fw-bold"><i class="fas fa-gavel me-3"></i>Room Chat Konsultasi</h1>
                    <p class="lead">Kelola sesi konsultasi hukum Anda Dengan Lawyer</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <span class="badge bg-light text-primary fs-6 px-3 py-2">
                        <i class="fas fa-comments me-2"></i><?= count($chats) ?> Room Chat
                    </span>
                </div>
            </div>
        </div>

        <?php if (!empty($chats)): ?>
        <!-- Filter Tabs -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-0">
                <ul class="nav nav-tabs nav-justified" id="chatTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active d-flex align-items-center justify-content-center" 
                                data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">
                            <i class="fas fa-comment-dots me-2"></i>Aktif
                            <span class="badge bg-success ms-2"><?= $activeCount ?></span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center justify-content-center" 
                                data-bs-toggle="tab" data-bs-target="#expired" type="button" role="tab">
                            <i class="fas fa-clock me-2"></i>Expired
                            <span class="badge bg-danger ms-2"><?= $expiredCount ?></span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link d-flex align-items-center justify-content-center" 
                                data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
                            <i class="fas fa-layer-group me-2"></i>Semua
                            <span class="badge bg-primary ms-2"><?= count($chats) ?></span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="tab-content" id="chatTabsContent">
            <!-- Active Chats -->
            <div class="tab-pane fade show active" id="active" role="tabpanel">
                <div class="row">
                    <?php 
                    $hasActiveChats = false;
                    foreach ($chats as $chat): 
                        $expired = isChatExpired($chat);
                        if (!$expired): 
                        $hasActiveChats = true;
                        $end_time = $chat['end_time'] ?? null;
                        $start_time = !empty($chat['start_time']) ? $chat['start_time'] : $chat['opened_at'];
                        $current_time = time();
                    ?>
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                        <div class="card chat-card h-100 shadow-sm">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0 text-truncate">
                                        <i class="fas fa-user-circle text-primary me-2"></i>
                                        <?= htmlspecialchars($chat['lawyer_name'] ?? 'Klien #'.$chat['client_id']); ?>
                                    </h6>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <div class="chat-info mb-3">
                                    <?php if ($start_time): ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-play-circle text-primary me-2"></i>
                                            <small>Mulai: <?= date('d M Y H:i', strtotime($start_time)) ?></small>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($end_time): ?>
                                        <?php 
                                            $remaining = strtotime($end_time) - $current_time;
                                            $remaining_minutes = max(0, floor($remaining / 60));
                                            $remaining_hours = floor($remaining_minutes / 60);
                                            $remaining_minutes = $remaining_minutes % 60;
                                        ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-clock text-warning me-2"></i>
                                            <small>Waktu tersisa: 
                                                <span class="time-count">
                                                    <?= $remaining_hours > 0 ? $remaining_hours . ' jam ' : '' ?><?= $remaining_minutes ?> menit
                                                </span>
                                            </small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-hourglass-end text-info me-2"></i>
                                            <small>Berakhir: <?= date('d M Y H:i', strtotime($end_time)) ?></small>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-infinity text-secondary me-2"></i>
                                            <small>Belum ada batas waktu</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if (!empty($chat['last_message'])): ?>
                                <div class="last-message bg-light p-2 rounded">
                                    <small class="text-muted">Pesan terakhir:</small>
                                    <p class="mb-0 text-truncate">"<?= htmlspecialchars($chat['last_message']) ?>"</p>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-footer">
                                <a href="<?= site_url('chat/booking/'.$chat['booking_id']); ?>" class="btn btn-primary w-100">
                                    <i class="fas fa-comment-dots me-2"></i> Buka Chat
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endif; endforeach; ?>
                    
                    <?php if (!$hasActiveChats): ?>
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-comment-slash"></i>
                            <h4 class="text-muted mt-3">Tidak ada chat aktif</h4>
                            <p class="text-muted">Semua sesi chat telah expired atau belum dimulai</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Expired Chats -->
            <div class="tab-pane fade" id="expired" role="tabpanel">
                <div class="row">
                    <?php 
                    $hasExpiredChats = false;
                    foreach ($chats as $chat): 
                        $expired = isChatExpired($chat);
                        if ($expired): 
                        $hasExpiredChats = true;
                        $start_time = !empty($chat['start_time']) ? $chat['start_time'] : $chat['opened_at'];
                    ?>
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                        <div class="card chat-card h-100 shadow-sm expired">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0 text-truncate text-muted">
                                        <i class="fas fa-user-circle me-2"></i>
                                        <?= htmlspecialchars($chat['lawyer_name'] ?? 'Advokat #'.$chat['lawyer_id']); ?>
                                    </h6>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>Expired
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <div class="chat-info mb-3 bg-light">
                                    <?php if ($start_time): ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-play-circle text-secondary me-2"></i>
                                            <small>Mulai: <?= date('d M Y H:i', strtotime($start_time)) ?></small>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($chat['end_time'])): ?>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-hourglass-end text-secondary me-2"></i>
                                            <small>Berakhir: <?= date('d M Y H:i', strtotime($chat['end_time'])) ?></small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if (!empty($chat['last_message'])): ?>
                                <div class="last-message bg-light p-2 rounded">
                                    <small class="text-muted">Pesan terakhir:</small>
                                    <p class="mb-0 text-truncate">"<?= htmlspecialchars($chat['last_message']) ?>"</p>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-footer">
                                <button class="btn btn-outline-secondary w-100" disabled>
                                    <i class="fas fa-lock me-2"></i> Sesi Telah Berakhir
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endif; endforeach; ?>
                    
                    <?php if (!$hasExpiredChats): ?>
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-check-circle"></i>
                            <h4 class="text-muted mt-3">Tidak ada chat expired</h4>
                            <p class="text-muted">Semua sesi chat masih aktif atau belum dimulai</p>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- All Chats -->
            <div class="tab-pane fade" id="all" role="tabpanel">
                <div class="row">
                    <?php foreach ($chats as $chat): 
                        $expired = isChatExpired($chat);
                        $start_time = !empty($chat['start_time']) ? $chat['start_time'] : $chat['opened_at'];
                        $end_time = $chat['end_time'] ?? null;
                        $current_time = time();
                    ?>
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                        <div class="card chat-card h-100 shadow-sm <?= $expired ? 'expired' : '' ?>">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="card-title mb-0 text-truncate <?= $expired ? 'text-muted' : '' ?>">
                                        <i class="fas fa-user-circle <?= $expired ? 'text-secondary' : 'text-primary' ?> me-2"></i>
                                        <?= htmlspecialchars($chat['lawyer_name'] ?? 'Klien #'.$chat['client_id']); ?>
                                    </h6>
                                    <span class="badge <?= $expired ? 'bg-danger' : 'bg-success' ?>">
                                        <i class="fas <?= $expired ? 'fa-times-circle' : 'fa-check-circle' ?> me-1"></i>
                                        <?= $expired ? 'Expired' : 'Aktif' ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body">
                                <div class="chat-info mb-3 <?= $expired ? 'bg-light' : 'bg-primary-light' ?>">
                                    <?php if ($start_time): ?>
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-play-circle <?= $expired ? 'text-secondary' : 'text-primary' ?> me-2"></i>
                                            <small>Mulai: <?= date('d M Y H:i', strtotime($start_time)) ?></small>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($end_time): ?>
                                        <?php if (!$expired): ?>
                                            <?php
                                                $remaining = strtotime($end_time) - $current_time;
                                                $remaining_minutes = max(0, floor($remaining / 60));
                                                $remaining_hours = floor($remaining_minutes / 60);
                                                $remaining_minutes = $remaining_minutes % 60;
                                            ?>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-clock text-warning me-2"></i>
                                                <small>Waktu tersisa: 
                                                    <span class="time-count">
                                                        <?= $remaining_hours > 0 ? $remaining_hours . ' jam ' : '' ?><?= $remaining_minutes ?> menit
                                                    </span>
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-hourglass-end <?= $expired ? 'text-secondary' : 'text-info' ?> me-2"></i>
                                            <small>Berakhir: <?= date('d M Y H:i', strtotime($end_time)) ?></small>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-infinity text-secondary me-2"></i>
                                            <small>Belum ada batas waktu</small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if (!empty($chat['last_message'])): ?>
                                <div class="last-message bg-light p-2 rounded">
                                    <small class="text-muted">Pesan terakhir:</small>
                                    <p class="mb-0 text-truncate">"<?= htmlspecialchars($chat['last_message']) ?>"</p>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-footer">
                                <?php if (!$expired): ?>
                                    <a href="<?= site_url('chat/booking/'.$chat['booking_id']); ?>" class="btn btn-primary w-100">
                                        <i class="fas fa-comment-dots me-2"></i> Buka Chat
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-outline-secondary w-100" disabled>
                                        <i class="fas fa-lock me-2"></i> Sesi Telah Berakhir
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-comments"></i>
            <h3 class="text-muted mt-3">Belum ada room chat</h3>
            <p class="text-muted">Mulai konsultasi dengan klien untuk membuat room chat pertama</p>
            <a href="#" class="btn btn-primary mt-3"><i class="fas fa-plus me-2"></i>Buat Konsultasi Baru</a>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto refresh waktu tersisa setiap menit
        setInterval(function() {
            const timeElements = document.querySelectorAll('.time-count');
            timeElements.forEach(el => {
                const text = el.textContent;
                const match = text.match(/(\d+) jam (\d+) menit/) || text.match(/(\d+) menit/);
                
                if (match) {
                    if (match[1] && match[2]) {
                        // Ada jam dan menit
                        let hours = parseInt(match[1]);
                        let minutes = parseInt(match[2]);
                        
                        if (minutes > 0) {
                            minutes--;
                        } else if (hours > 0) {
                            hours--;
                            minutes = 59;
                        }
                        
                        if (hours > 0) {
                            el.textContent = hours + ' jam ' + minutes + ' menit';
                        } else {
                            el.textContent = minutes + ' menit';
                        }
                    } else if (match[1]) {
                        // Hanya menit
                        let minutes = parseInt(match[1]);
                        if (minutes > 0) {
                            minutes--;
                            el.textContent = minutes + ' menit';
                        }
                    }
                }
            });
        }, 60000);
    </script>
</body>
</html>