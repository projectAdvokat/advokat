<div class="container mt-4">
  <h2 class="mb-4">Room Chat</h2>

  <?php if (!empty($chats)): ?>
    <div class="row">
      <?php foreach ($chats as $chat): ?>
        <?php
          // Pakai start_time kalau ada, fallback ke opened_at
          $start_time = !empty($chat['start_time']) ? $chat['start_time'] : $chat['opened_at'];
          $duration   = !empty($chat['duration_minutes']) ? $chat['duration_minutes'] : 0;

          $expired_time = $duration > 0 
              ? date('Y-m-d H:i:s', strtotime($start_time . ' +'.$duration.' minutes')) 
              : null;

          $isExpired = $expired_time ? (strtotime($expired_time) < time()) : false;
        ?>
        <div class="col-md-6 mb-4">
          <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="card-title mb-0">
                  <?= htmlspecialchars($chat['client_name'] ?? 'Client #'.$chat['client_id']); ?>
                </h5>
                <?php if ($isExpired): ?>
                  <span class="badge bg-danger">Expired</span>
                <?php else: ?>
                  <span class="badge bg-success">Active</span>
                <?php endif; ?>
              </div>

              <?php if (!empty($chat['last_message'])): ?>
                <p class="card-text text-muted mb-3">
                  <?= word_limiter(strip_tags($chat['last_message']), 15); ?>
                </p>
              <?php else: ?>
                <p class="card-text text-muted mb-3 fst-italic">Belum ada pesan</p>
              <?php endif; ?>

              <div class="small text-muted">
                <i class="bi bi-clock"></i> Mulai: <?= $start_time ? date('d M Y H:i', strtotime($start_time)) : '-'; ?><br>
                <i class="bi bi-hourglass-split"></i> Durasi: <?= $duration ?: '-'; ?> menit<br>
                <i class="bi bi-alarm"></i> Expired: <?= $expired_time ? date('d M Y H:i', strtotime($expired_time)) : '-'; ?>
              </div>
            </div>
            <div class="card-footer bg-transparent border-0 d-flex justify-content-end">
              <?php if (!$isExpired): ?>
                <a href="<?= site_url('dashboard/chats/'.$chat['id']); ?>" class="btn btn-sm btn-primary">
                  <i class="bi bi-chat-dots"></i> Buka Chat
                </a>
              <?php else: ?>
                <button class="btn btn-sm btn-secondary" disabled>
                  <i class="bi bi-x-circle"></i> Tidak Tersedia
                </button>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-info">
      Belum ada room chat yang tersedia.
    </div>
  <?php endif; ?>
</div>
