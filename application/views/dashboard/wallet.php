<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Wallet</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0">Dompet Saya</h3>
      <a href="<?= site_url('dashboard'); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
      </a>
    </div>

    <!-- Card Saldo -->
    <div class="card shadow-sm border-0">
      <div class="card-body text-center">
        <h4 class="mb-3">Saldo Anda</h4>
        <h2 class="text-success">
          <i class="fas fa-wallet"></i>
        
          Rp <?= number_format($wallet['data']['balance'], 0, ',', '.'); ?>
        </h2>

        <!-- Tombol Withdraw -->
        <div class="mt-4">
          <a href="<?= site_url('wallet/withdraw'); ?>" class="btn btn-warning btn-lg">
            <i class="fas fa-arrow-circle-up"></i> Tarik Dana
          </a>
        </div>
      </div>
    </div>

  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
