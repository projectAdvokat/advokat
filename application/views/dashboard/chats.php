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
?>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Room Chat Konsultasi</h2>
    <span class="badge bg-primary"><?= count($chats) ?> Room</span>
  </div>

  <?php if (!empty($chats)): ?>
    <!-- Filter Tabs -->
    <ul class="nav nav-tabs mb-4" id="chatTabs" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">
          <i class="bi bi-chat-dots-fill me-1"></i> Aktif
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#expired" type="button" role="tab">
          <i class="bi bi-clock-history me-1"></i> Expired
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#all" type="button" role="tab">
          <i class="bi bi-grid-3x3-gap-fill me-1"></i> Semua
        </button>
      </li>
    </ul>

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
            <div class="card chat-card h-100 border-0 shadow-sm">
              <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="card-title mb-0 text-truncate">
                    <i class="bi bi-person-circle text-primary me-2"></i>
                    <?= htmlspecialchars($chat['client_name'] ?? 'Client #'.$chat['client_id']); ?>
                  </h6>
                  <span class="badge bg-success">
                    <i class="bi bi-check-circle-fill me-1"></i>Aktif
                  </span>
                </div>
              </div>
              
              <div class="card-body">
                
                <div class="chat-info">
                  <?php if ($start_time): ?>
                    <div class="d-flex align-items-center mb-2">
                      <i class="bi bi-play-circle text-primary me-2"></i>
                      <small>Mulai: <?= date('d M Y H:i', strtotime($start_time)) ?></small>
                    </div>
                  <?php endif; ?>
                  
                  <?php if ($end_time): ?>
                    <?php 
                      $remaining = strtotime($end_time) - $current_time;
                      $remaining_minutes = max(0, floor($remaining / 60));
                    ?>
                    <div class="d-flex align-items-center mb-2">
                      <i class="bi bi-clock text-warning me-2"></i>
                      <small>Waktu tersisa: <?= $remaining_minutes ?> menit</small>
                    </div>
                    <div class="d-flex align-items-center">
                      <i class="bi bi-hourglass-bottom text-info me-2"></i>
                      <small>Berakhir: <?= date('d M Y H:i', strtotime($end_time)) ?></small>
                    </div>
                  <?php else: ?>
                    <div class="d-flex align-items-center">
                      <i class="bi bi-infinity text-secondary me-2"></i>
                      <small>Tidak ada batas waktu</small>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              
              <div class="card-footer bg-transparent border-0 pt-0">
                <a href="<?= site_url('chat/booking/'.$chat['booking_id']); ?>" class="btn btn-primary w-100">
                  <i class="bi bi-chat-dots-fill me-1"></i> Buka Chat
                </a>
              </div>
            </div>
          </div>
          <?php endif; endforeach; ?>
          
          <?php if (!$hasActiveChats): ?>
            <div class="col-12">
              <div class="text-center py-5">
                <i class="bi bi-chat-x display-4 text-muted"></i>
                <h5 class="text-muted mt-3">Tidak ada chat aktif</h5>
                <p class="text-muted">Semua chat session telah expired atau belum dimulai</p>
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
            <div class="card chat-card h-100 border-0 shadow-sm opacity-75">
              <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="card-title mb-0 text-truncate text-muted">
                    <i class="bi bi-person-circle me-2"></i>
                    <?= htmlspecialchars($chat['client_name'] ?? 'Client #'.$chat['client_id']); ?>
                  </h6>
                  <span class="badge bg-danger">
                    <i class="bi bi-x-circle-fill me-1"></i>Expired
                  </span>
                </div>
              </div>
              
              <div class="card-body">
                <?php if (!empty($chat['last_message'])): ?>
                  <p class="card-text text-muted mb-3">
                    <i class="bi bi-chat-quote me-1"></i>
                    <?= word_limiter(strip_tags($chat['last_message']), 12); ?>
                  </p>
                <?php else: ?>
                  <p class="card-text text-muted mb-3 fst-italic">
                    <i class="bi bi-chat me-1"></i>Belum ada pesan
                  </p>
                <?php endif; ?>

                <div class="chat-info">
                  <?php if ($start_time): ?>
                    <div class="d-flex align-items-center mb-2">
                      <i class="bi bi-play-circle text-secondary me-2"></i>
                      <small>Mulai: <?= date('d M Y H:i', strtotime($start_time)) ?></small>
                    </div>
                  <?php endif; ?>
                  
                  <?php if (!empty($chat['end_time'])): ?>
                    <div class="d-flex align-items-center">
                      <i class="bi bi-hourglass-bottom text-secondary me-2"></i>
                      <small>Berakhir: <?= date('d M Y H:i', strtotime($chat['end_time'])) ?></small>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              
              <div class="card-footer bg-transparent border-0 pt-0">
                <button class="btn btn-secondary w-100" disabled>
                  <i class="bi bi-lock-fill me-1"></i> Session Expired
                </button>
              </div>
            </div>
          </div>
          <?php endif; endforeach; ?>
          
          <?php if (!$hasExpiredChats): ?>
            <div class="col-12">
              <div class="text-center py-5">
                <i class="bi bi-check-circle display-4 text-muted"></i>
                <h5 class="text-muted mt-3">Tidak ada chat expired</h5>
                <p class="text-muted">Semua chat session masih aktif atau belum dimulai</p>
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
          ?>
          <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
            <div class="card chat-card h-100 border-0 shadow-sm <?= $expired ? 'opacity-75' : '' ?>">
              <div class="card-header bg-transparent border-0 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                  <h6 class="card-title mb-0 text-truncate <?= $expired ? 'text-muted' : '' ?>">
                    <i class="bi bi-person-circle <?= $expired ? 'text-secondary' : 'text-primary' ?> me-2"></i>
                    <?= htmlspecialchars($chat['client_name'] ?? 'Client #'.$chat['client_id']); ?>
                  </h6>
                  <span class="badge <?= $expired ? 'bg-danger' : 'bg-success' ?>">
                    <i class="bi <?= $expired ? 'bi-x-circle-fill' : 'bi-check-circle-fill' ?> me-1"></i>
                    <?= $expired ? 'Expired' : 'Aktif' ?>
                  </span>
                </div>
              </div>
              
              <div class="card-body">
                <?php if (!empty($chat['last_message'])): ?>
                  <p class="card-text text-muted mb-3">
                    <i class="bi bi-chat-quote me-1"></i>
                    <?= word_limiter(strip_tags($chat['last_message']), 12); ?>
                  </p>
                <?php else: ?>
                  <p class="card-text text-muted mb-3 fst-italic">
                    <i class="bi bi-chat me-1"></i>Belum ada pesan
                  </p>
                <?php endif; ?>

                <div class="chat-info">
                  <?php if ($start_time): ?>
                    <div class="d-flex align-items-center mb-2">
                      <i class="bi bi-play-circle <?= $expired ? 'text-secondary' : 'text-primary' ?> me-2"></i>
                      <small>Mulai: <?= date('d M Y H:i', strtotime($start_time)) ?></small>
                    </div>
                  <?php endif; ?>
                  
                  <?php if ($end_time): ?>
                    <?php if (!$expired): ?>
                      <?php
                        $remaining = strtotime($end_time) - time();
                        $remaining_minutes = max(0, floor($remaining / 60));
                      ?>
                      <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-clock text-warning me-2"></i>
                        <small>Waktu tersisa: <?= $remaining_minutes ?> menit</small>
                      </div>
                    <?php endif; ?>
                    <div class="d-flex align-items-center">
                      <i class="bi bi-hourglass-bottom <?= $expired ? 'text-secondary' : 'text-info' ?> me-2"></i>
                      <small>Berakhir: <?= date('d M Y H:i', strtotime($end_time)) ?></small>
                    </div>
                  <?php else: ?>
                    <div class="d-flex align-items-center">
                      <i class="bi bi-infinity text-secondary me-2"></i>
                      <small>Tidak ada batas waktu</small>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
              
              <div class="card-footer bg-transparent border-0 pt-0">
                <?php if (!$expired): ?>
                  <a href="<?= site_url('chat/booking/'.$chat['booking_id']); ?>" class="btn btn-primary w-100">
                    <i class="bi bi-chat-dots-fill me-1"></i> Buka Chat
                  </a>
                <?php else: ?>
                  <button class="btn btn-secondary w-100" disabled>
                    <i class="bi bi-lock-fill me-1"></i> Session Expired
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
    <div class="text-center py-5">
      <i class="bi bi-chat-dots display-1 text-muted"></i>
      <h3 class="text-muted mt-3">Belum ada room chat</h3>
      <p class="text-muted">Mulai konsultasi dengan lawyer untuk membuat chat session pertama Anda</p>
      <a href="<?= site_url('lawyers/list') ?>" class="btn btn-primary mt-3">
        <i class="bi bi-search me-1"></i> Cari Lawyer
      </a>
    </div>
  <?php endif; ?>
</div>
