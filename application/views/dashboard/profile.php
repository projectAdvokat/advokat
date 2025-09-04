<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profil Saya</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0">Profil Saya</h3>
      <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
      </a>
    </div>

    <!-- Profile Card -->
    <div class="card shadow-sm border-0">
      <div class="card-body text-center p-5">

        <!-- Foto Profil -->
        <div class="mb-4">
          <img src="<?= !empty($user['avatar']) 
                        ? base_url('uploads/avatars/'.$user['avatar']) 
                        : 'https://via.placeholder.com/150'; ?>" 
               alt="Foto Profil" 
               class="rounded-circle shadow-sm" 
               style="width: 150px; height: 150px; object-fit: cover;">
        </div>

        <!-- Informasi Utama -->
        <h4 class="mb-1"><?= htmlspecialchars($user['name']); ?></h4>
        <p class="text-muted mb-3">
          <i class="fas fa-envelope"></i> <?= htmlspecialchars($user['email']); ?>
        </p>
        <span class="badge bg-primary px-3 py-2 mb-4">
          <?= ucfirst($user['role']); ?>
        </span>

        <!-- Detail Informasi -->
        <div class="row justify-content-center text-start mb-4">
          <div class="col-md-8">
            <ul class="list-group list-group-flush">
              <li class="list-group-item">
                <strong>ID:</strong> <?= $user['id']; ?>
              </li>
              <li class="list-group-item">
                <i class="fas fa-phone me-2 text-muted"></i> 
                <?= !empty($user['phone']) ? htmlspecialchars($user['phone']) : '-' ?>
              </li>
              <li class="list-group-item">
                <i class="fas fa-key me-2 text-muted"></i> 
                Password: <span class="text-success">Sudah diatur</span>
              </li>
              <li class="list-group-item">
                <i class="fas fa-code me-2 text-muted"></i> 
                Referral Code: <?= !empty($user['ref_code']) ? htmlspecialchars($user['ref_code']) : '-' ?>
              </li>
              <li class="list-group-item">
                <i class="fas fa-user-friends me-2 text-muted"></i> 
                Referrer ID: <?= !empty($user['referrer_id']) ? $user['referrer_id'] : '-' ?>
              </li>
              <li class="list-group-item">
                <i class="fas fa-toggle-on me-2 text-muted"></i> 
                Status: 
                <?php if ($user['status'] == 'active'): ?>
                  <span class="badge bg-success">Aktif</span>
                <?php else: ?>
                  <span class="badge bg-secondary">Nonaktif</span>
                <?php endif; ?>
              </li>
            </ul>
          </div>
        </div>

        <!-- Aksi -->
        <div class="d-flex justify-content-center gap-3">
          <a href="<?= site_url('profile/edit'); ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Edit Profil
          </a>
          <a href="<?= site_url('auth/logout'); ?>" class="btn btn-outline-danger">
            <i class="fas fa-sign-out-alt"></i> Keluar
          </a>
        </div>

      </div>
    </div>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
