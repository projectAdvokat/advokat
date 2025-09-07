<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Profil</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">

  <!-- Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Edit Profil</h3>
    <a href="<?= site_url('dashboard/profile/'); ?>" class="btn btn-secondary">
      <i class="fas fa-arrow-left"></i> Kembali
    </a>
  </div>

  <!-- Edit Card -->
  <div class="card shadow-sm border-0">
    <div class="card-body p-4">

      <!-- Form -->
      <form action="<?= site_url('dashboard/profile/update'); ?>" 
            method="post" 
            enctype="multipart/form-data" 
            class="row g-3">

        <!-- Foto Profil -->
        <div class="col-12 text-center mb-4">
          <div class="position-relative d-inline-block">
            <img src="<?= !empty($user['avatar']) 
                          ? base_url('uploads/avatars/'.$user['avatar']) 
                          : 'https://via.placeholder.com/150'; ?>" 
                 class="rounded-circle shadow-sm" 
                 style="width: 150px; height: 150px; object-fit: cover;" 
                 alt="Foto Profil">

            <!-- Input Ganti Foto -->
            <label for="avatar" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 rounded-circle shadow">
              <i class="fas fa-camera"></i>
            </label>
            <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*">
          </div>
        </div>

        <!-- Nama -->
        <div class="col-md-6">
          <label for="name" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control" id="name" name="name" 
                 value="<?= htmlspecialchars($user['name']); ?>" required>
        </div>

        <!-- Email -->
        <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" 
                 value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>

        <!-- Phone -->
        <div class="col-md-6">
          <label for="phone" class="form-label">Nomor Telepon</label>
          <input type="text" class="form-control" id="phone" name="phone" 
                 value="<?= htmlspecialchars($user['phone'] ?? ''); ?>">
        </div>

        <!-- Password -->
        <div class="col-md-6">
          <label for="password" class="form-label">Password Baru</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
        </div>

        <!-- Status -->
        <div class="col-md-6">
          <label for="status" class="form-label">Status</label>
          <select class="form-select" id="status" name="status">
            <option value="active" <?= $user['status'] === 'active' ? 'selected' : ''; ?>>Aktif</option>
            <option value="banned" <?= $user['status'] !== 'active' ? 'selected' : ''; ?>>Nonaktif</option>
          </select>
        </div>

        <!-- Role (readonly agar aman) -->


        <!-- Extra fields untuk lawyer -->
        <?php if ($user['role'] === 'lawyer'): ?>
          <div class="col-12">
            <hr>
            <h5 class="text-muted">Informasi Lawyer</h5>
          </div>

          <div class="col-md-4">
            <label for="years_experience" class="form-label">Years of Experience</label>
            <input type="number" class="form-control" id="years_experience" name="years_experience" 
                   value="<?= htmlspecialchars($user['years_experience'] ?? ''); ?>">
          </div>

          <div class="col-md-8">
            <label for="specialties" class="form-label">Specialties</label>
            <input type="text" class="form-control" id="specialties" name="specialties" 
                   value="<?= htmlspecialchars($user['specialties'] ?? ''); ?>">
          </div>

          <div class="col-md-6">
            <label for="price_30m" class="form-label">Price per 30 Minutes (Rp)</label>
            <input type="number" class="form-control" id="price_30m" name="price_30m" 
                   value="<?= htmlspecialchars((float)$user['price_30m'] ?? ''); ?>">
          </div>

          <div class="col-md-6">
            <label for="bio" class="form-label">Short Bio</label>
            <textarea class="form-control" id="bio" name="bio" rows="3"><?= htmlspecialchars($user['bio'] ?? ''); ?></textarea>
          </div>
        <?php endif; ?>

        <!-- Submit -->
        <div class="col-12 text-center mt-4">
          <button type="submit" class="btn btn-success px-5">
            <i class="fas fa-save"></i> Simpan Perubahan
          </button>
        </div>

      </form>
    </div>
  </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
