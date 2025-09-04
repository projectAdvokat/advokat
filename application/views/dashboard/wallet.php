<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dompet Saya - Advokat Online</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    :root {
      --primary-color: #1a7f5c;
      --primary-light: #e8f5f0;
      --secondary-color: #f8f9fa;
      --accent-color: #28a745;
      --dark-color: #2c3e50;
      --light-color: #ffffff;
      --border-radius: 12px;
      --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9fbfa;
      color: #4a4a4a;
      padding-bottom: 2rem;
    }
    
    .navbar-brand {
      font-weight: 700;
      color: var(--primary-color);
    }
    
    .card {
      border-radius: var(--border-radius);
      border: none;
      box-shadow: var(--box-shadow);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
    }
    
    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
      border-radius: 8px;
      padding: 10px 20px;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .btn-primary:hover {
      background-color: #146c4a;
      border-color: #146c4a;
      transform: translateY(-2px);
    }
    
    .btn-warning {
      border-radius: 8px;
      padding: 12px 24px;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .btn-warning:hover {
      transform: translateY(-2px);
    }
    
    .modal-header {
      background-color: var(--primary-color);
      color: white;
      border-top-left-radius: var(--border-radius);
      border-top-right-radius: var(--border-radius);
    }
    
    .modal-content {
      border-radius: var(--border-radius);
      border: none;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }
    
    .form-control, .form-select {
      border-radius: 8px;
      padding: 12px 16px;
      border: 1px solid #e2e8f0;
      transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(26, 127, 92, 0.25);
    }
    
    .bank-logo {
      width: 32px;
      height: 32px;
      margin-right: 12px;
      object-fit: contain;
      border-radius: 6px;
      background: white;
      padding: 4px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .balance-card {
      background: linear-gradient(135deg, var(--primary-color) 0%, #2d9770 100%);
      color: white;
      padding: 2rem;
      margin-bottom: 2rem;
    }
    
    .balance-amount {
      font-size: 2.5rem;
      font-weight: 700;
      margin: 1rem 0;
    }
    
    .wallet-icon {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      background: rgba(255, 255, 255, 0.2);
      width: 70px;
      height: 70px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
    }
    
    .info-card {
      background-color: var(--primary-light);
      border-left: 4px solid var(--primary-color);
    }
    
    .feature-icon {
      font-size: 1.5rem;
      color: var(--primary-color);
      margin-bottom: 1rem;
    }
    
    .withdraw-btn {
      background: linear-gradient(to right, #ff9a3d, #ff7b00);
      border: none;
      border-radius: 10px;
      padding: 16px 32px;
      font-size: 1.1rem;
      font-weight: 600;
      box-shadow: 0 4px 12px rgba(255, 154, 61, 0.3);
      transition: all 0.3s ease;
    }
    
    .withdraw-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 16px rgba(255, 154, 61, 0.4);
    }
    
    .bank-option {
      display: flex;
      align-items: center;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 8px;
      transition: background-color 0.2s;
    }
    
    .bank-option:hover {
      background-color: #f5f5f5;
    }
    
    .input-group-text {
      background-color: #f8f9fa;
      border-radius: 8px 0 0 8px;
    }
    
    @media (max-width: 768px) {
      .balance-amount {
        font-size: 2rem;
      }
      
      .withdraw-btn {
        padding: 14px 24px;
        font-size: 1rem;
      }
      
      .container {
        padding-left: 15px;
        padding-right: 15px;
      }
    }
    
    /* Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fadeIn {
      animation: fadeIn 0.6s ease forwards;
    }
    
    /* Loading spinner */
    .spinner {
      width: 24px;
      height: 24px;
      border: 3px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: white;
      animation: spin 1s ease-in-out infinite;
      display: inline-block;
      margin-right: 8px;
    }
    
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="#">
        <i class="fas fa-scale-balanced me-2"></i>Advokat Online
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a href="<?= site_url('dashboard'); ?>" class="btn btn-outline-secondary">
              <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4 animate-fadeIn">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h3 class="mb-0 fw-bold text-dark">Dompet Saya</h3>
        <p class="text-muted">Kelola saldo dan penarikan dana Anda</p>
      </div>
    </div>

    <!-- Card Saldo -->
    <div class="card balance-card mb-4">
      <div class="card-body text-center py-4">
        <div class="wallet-icon">
          <i class="fas fa-wallet"></i>
        </div>
        <p class="mb-1">Saldo Tersedia</p>
        <h2 class="balance-amount">
          Rp <?= number_format($wallet['data']['balance'], 0, ',', '.'); ?>
        </h2>
        
        <!-- Tombol Withdraw -->
        <div class="mt-4">
          <button type="button" class="btn withdraw-btn" data-bs-toggle="modal" data-bs-target="#withdrawModal">
            <i class="fas fa-arrow-circle-up me-2"></i> Tarik Dana
          </button>
        </div>
      </div>
    </div>

    <!-- Info Cards -->
    <div class="row">
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          <div class="card-body text-center">
            <div class="feature-icon">
              <i class="fas fa-clock"></i>
            </div>
            <h5>Proses Cepat</h5>
            <p class="text-muted">Penarikan diproses dalam 1x24 jam pada hari kerja</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          <div class="card-body text-center">
            <div class="feature-icon">
              <i class="fas fa-shield-alt"></i>
            </div>
            <h5>Aman & Terpercaya</h5>
            <p class="text-muted">Transaksi dijamin aman dengan enkripsi standar bank</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="card h-100">
          <div class="card-body text-center">
            <div class="feature-icon">
              <i class="fas fa-headset"></i>
            </div>
            <h5>Bantuan 24/7</h5>
            <p class="text-muted">Tim support siap membantu kapan pun Anda perlu</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Withdraw -->
  <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="withdrawModalLabel">
            <i class="fas fa-money-bill-wave me-2"></i> Tarik Dana
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="withdrawForm">
            <!-- Informasi Saldo -->
            <div class="alert alert-info d-flex align-items-center">
              <i class="fas fa-info-circle me-2"></i>
              <div>
                <strong>Saldo Tersedia:</strong> Rp <?= number_format($wallet['data']['balance'], 0, ',', '.'); ?>
              </div>
            </div>
            
            <!-- Jumlah Penarikan -->
            <div class="mb-4">
              <label for="amount" class="form-label fw-semibold">Jumlah Penarikan <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text bg-light">Rp</span>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Masukkan jumlah penarikan" required min="10000" step="1000">
              </div>
              <div class="form-text text-muted">Minimal penarikan: Rp 10.000</div>
            </div>
            
            <!-- Pilih Bank -->
            <div class="mb-4">
              <label for="bank" class="form-label fw-semibold">Pilih Bank <span class="text-danger">*</span></label>
              <select class="form-select" id="bank" name="bank" required>
                <option value="" selected disabled>-- Pilih Bank --</option>
                <option value="bca">
                  <div class="bank-option">
                    <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgdmlld0JveD0iMCAwIDI1NiAyNTYiPjxwYXRoIGZpbGw9IiMxMjcxYzEiIGQ9Ik0xMjggMEM1Ny4zIDAgMCA1Ny4zIDAgMTI4czU3LjMgMTI4IDEyOCAxMjhzMTI4LTU3LjMgMTI4LTEyOFMxOTguNyAwIDEyOCAwem01OC40IDE4MC44YzAgNi42LTUuNCAxMi0xMiAxMkg4MS42Yy02LjYgMC0xMi01LjQtMTItMTJWNzUuMmMwLTYuNiA1LjQtMTIgMTItMTJoOTIuOGM2LjYgMCAxMiA1LjQgMTIgMTJ2MTA1LjZ6Ii8+PHBhdGggZmlsbD0iI2ZmZiIgZD0iTTg4LjcgMTE3LjloMjQuNXYyMC4zaC0yNC41em0zNi44IDBoMjQuNXYyMC4zaC0yNC41em0zNi44IDBoMjQuNXYyMC4zaC0yNC41eiIvPjwvc3ZnPg==" class="bank-logo"> BCA (Bank Central Asia)
                  </div>
                </option>
                <option value="bni">
                  <div class="bank-option">
                    <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgdmlld0JveD0iMCAwIDI1NiAyNTYiPjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0xMjggMEM1Ny4zIDAgMCA1Ny4zIDAgMTI4czU3LjMgMTI4IDEyOCAxMjhzMTI4LTU3LjMgMTI4LTEyOFMxOTguNyAwIDEyOCAweiIvPjxwYXRoIGZpbGw9IiM4YzEzOGMiIGQ9Ik0xMjggMTkuMmM2MCAwIDEwOC44IDQ4LjggMTA4LjggMTA4LjhTMTg4IDE5LjIgMTI4IDE5LjJ6Ii8+PHBhdGggZmlsbD0iI2ZmZiIgZD0iTTE0OS4zIDk3LjVjMC0xMS44LTkuNi0yMS4zLTIxLjMtMjEuM3MtMjEuMyA5LjYtMjEuMyAyMS4zYzAgMTEuOCA9LjYgMjEuMyAyMS4zIDIxLjNzMjEuMy05LjUgMjEuMy0yMS4zem0yMS4zIDBjMC0yMy41LTE5LjEtNDIuNi00Mi42LTQyLjZzLTQyLjYgMTkuMS00Mi42IDQyLjZjMCAyMy41IDE5LjEgNDIuNiA0Mi42IDQyLjZzNDIuNi0xOS4xIDQyLjYtNDIuNnoiLz48L3N2Zz4=" class="bank-logo"> BNI (Bank Negara Indonesia)
                  </div>
                </option>
                <option value="mandiri">
                  <div class="bank-option">
                    <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgdmlld0JveD0iMCAwIDI1NiAyNTYiPjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0xMjggMEM1Ny4zIDAgMCA1Ny4zIDAgMTI4czU3LjMgMTI4IDEyOCAxMjhzMTI4LTU3LjMgMTI4LTEyOFMxOTguNyAwIDEyOCAweiIvPjxwYXRoIGZpbGw9IiMwMDZiOTUiIGQ9Ik0xMjggMTkuMmM2MCAwIDEwOC44IDQ4LjggMTA4LjggMTA4LjhTMTg4IDE5LjIgMTI4IDE5LjJ6Ii8+PHBhdGggZmlsbD0iI2ZmZiIgZD0iTTE1OC40IDk3LjVjMC0xNi43LTEzLjYtMzAuMy0zMC4zLTMwLjNzLTMwLjMgMTMuNi0zMC4zIDMwLjNjMCAxNi43IDEzLjYgMzAuMyAzMC4zIDMwLjNzMzAuMy0xNS42IDMwLjMtMzAuM3ptLTMwLjMgNDIuNmMtMjMuNSAwLTQyLjYtMTkuMS00Mi42LTQyLjZzMTkuMS00Mi42IDQyLjYtNDIuNiA0Mi42IDE5LjEgNDIuNiA0Mi42YzAgMjMuNS0xOS4xIDQyLjYtNDIuNiA0Mi42eiIvPjwvc3ZnPg==" class="bank-logo"> Bank Mandiri
                  </div>
                </option>
              </select>
            </div>
            
            <!-- Nomor Rekening -->
            <div class="mb-4">
              <label for="accountNumber" class="form-label fw-semibold">Nomor Rekening <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="accountNumber" name="accountNumber" placeholder="Masukkan nomor rekening" required>
            </div>
            
            <!-- Nama Pemilik Rekening -->
            <div class="mb-4">
              <label for="accountName" class="form-label fw-semibold">Nama Pemilik Rekening <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="accountName" name="accountName" placeholder="Masukkan nama pemilik rekening" required>
            </div>
            
            <!-- Email untuk Notifikasi -->
            <div class="mb-4">
              <label for="email" class="form-label fw-semibold">Email untuk Notifikasi</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email untuk notifikasi" value="<?= isset($user['email']) ? $user['email'] : '' ?>">
            </div>
            
            <!-- Informasi Biaya Admin -->
            <div class="alert alert-warning">
              <div class="d-flex">
                <i class="fas fa-exclamation-circle me-2 mt-1"></i>
                <div>
                  <strong>Informasi Penting</strong><br>
                  Penarikan dana dikenakan biaya admin sebesar Rp 2.500 per transaksi. Dana akan ditransfer maksimal 1x24 jam pada hari kerja.
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="submitWithdraw">
            <i class="fas fa-paper-plane me-2"></i> Ajukan Penarikan
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
document.addEventListener('DOMContentLoaded', function() {
  const withdrawForm = document.getElementById('withdrawForm');
  const submitButton = document.getElementById('submitWithdraw');
  const amountInput = document.getElementById('amount');
  const balance = <?= (int) $wallet['data']['balance'] ?>;
  const withdrawModal = document.getElementById('withdrawModal');
  const modalInstance = new bootstrap.Modal(withdrawModal);

  // Format input jumlah uang
  amountInput.addEventListener('input', function() {
    if (this.value) {
      const amount = parseInt(this.value);
      if (amount < 10000) {
        this.classList.add('is-invalid');
        document.querySelector('.form-text').classList.add('text-danger');
      } else if (amount > balance) {
        this.classList.add('is-invalid');
        document.querySelector('.form-text').innerHTML = 'Jumlah penarikan melebihi saldo yang tersedia.';
        document.querySelector('.form-text').classList.add('text-danger');
      } else {
        this.classList.remove('is-invalid');
        document.querySelector('.form-text').innerHTML = 'Minimal penarikan: Rp 10.000';
        document.querySelector('.form-text').classList.remove('text-danger');
      }
    }
  });

  submitButton.addEventListener('click', async function() {
    // Validasi form
    if (!withdrawForm.checkValidity()) {
      withdrawForm.classList.add('was-validated');
      return;
    }

    const amount = parseInt(amountInput.value);
    if (amount < 10000 || amount > balance) {
      amountInput.classList.add('is-invalid');
      return;
    }

    // Konfirmasi
    if (!confirm(`Anda yakin ingin menarik dana sebesar Rp ${amount.toLocaleString('id-ID')}?`)) return;

    // Tampilkan loading state
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<span class="spinner"></span> Memproses...';
    submitButton.disabled = true;

    // Kirim data ke backend
    const formData = new FormData(withdrawForm);
    try {
      const res = await fetch("<?= base_url('api/payout/withdraw') ?>", {
        method: "POST",
        body: formData
      });
      const data = await res.json();

      if (res.ok) {
        alert("✅ Penarikan dana berhasil diproses! Dana akan ditransfer dalam 1x24 jam.");
        modalInstance.hide();
        location.reload();
      } else {
        alert("❌ Gagal: " + (data.error || 'Terjadi kesalahan pada server'));
      }
    } catch (err) {
      alert("❌ Terjadi error: " + err.message);
    } finally {
      submitButton.innerHTML = originalText;
      submitButton.disabled = false;
    }
  });

  // Reset form validation ketika modal ditutup
  withdrawModal.addEventListener('hidden.bs.modal', function () {
    withdrawForm.classList.remove('was-validated');
    const inputs = withdrawForm.querySelectorAll('.is-invalid');
    inputs.forEach(input => input.classList.remove('is-invalid'));
  });
});
</script>
</body>
</html>