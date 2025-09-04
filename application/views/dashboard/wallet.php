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
  
  <style>
    :root {
      --primary-color: #1a7f5c;
      --secondary-color: #f8f9fa;
      --accent-color: #28a745;
    }
    
    .btn-primary {
      background-color: var(--primary-color);
      border-color: var(--primary-color);
    }
    
    .btn-primary:hover {
      background-color: #146c4a;
      border-color: #146c4a;
    }
    
    .modal-header {
      background-color: var(--primary-color);
      color: white;
    }
    
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(26, 127, 92, 0.25);
    }
    
    .form-select:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.25rem rgba(26, 127, 92, 0.25);
    }
    
    .bank-logo {
      width: 30px;
      height: 30px;
      margin-right: 10px;
      object-fit: contain;
    }
  </style>
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
          <button type="button" class="btn btn-warning btn-lg" data-bs-toggle="modal" data-bs-target="#withdrawModal">
            <i class="fas fa-arrow-circle-up"></i> Tarik Dana
          </button>
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
            <i class="fas fa-money-bill-wave me-2"></i>Tarik Dana
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="withdrawForm">
            <!-- Informasi Saldo -->
            <div class="alert alert-info">
              <div class="d-flex justify-content-between">
                <span>Saldo Tersedia:</span>
                <strong>Rp <?= number_format($wallet['data']['balance'], 0, ',', '.'); ?></strong>
              </div>
            </div>
            
            <!-- Jumlah Penarikan -->
            <div class="mb-3">
              <label for="amount" class="form-label">Jumlah Penarikan <span class="text-danger">*</span></label>
              <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" class="form-control" id="amount" name="amount" placeholder="Masukkan jumlah penarikan" required min="10000" step="1000">
              </div>
              <div class="form-text">Minimal penarikan: Rp 10.000</div>
            </div>
            
            <!-- Pilih Bank -->
            <div class="mb-3">
              <label for="bank" class="form-label">Pilih Bank <span class="text-danger">*</span></label>
              <select class="form-select" id="bank" name="bank" required>
                <option value="" selected disabled>-- Pilih Bank --</option>
                <option value="bca" data-logo="bca">
                  <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgdmlld0JveD0iMCAwIDI1NiAyNTYiPjxwYXRoIGZpbGw9IiMxMjcxYzEiIGQ9Ik0xMjggMEM1Ny4zIDAgMCA1Ny4zIDAgMTI4czU3LjMgMTI4IDEyOCAxMjhzMTI4LTU3LjMgMTI4LTEyOFMxOTguNyAwIDEyOCAwem01OC40IDE4MC44YzAgNi42LTUuNCAxMi0xMiAxMkg4MS42Yy02LjYgMC0xMi01LjQtMTItMTJWNzUuMmMwLTYuNiA1LjQtMTIgMTItMTJoOTIuOGM2LjYgMCAxMiA1LjQgMTIgMTJ2MTA1LjZ6Ii8+PHBhdGggZmlsbD0iI2ZmZiIgZD0iTTg4LjcgMTE3LjloMjQuNXYyMC4zaC0yNC41em0zNi44IDBoMjQuNXYyMC4zaC0yNC41em0zNi44IDBoMjQuNXYyMC4zaC0yNC41eiIvPjwvc3ZnPg==" class="bank-logo"> BCA (Bank Central Asia)
                </option>
                <option value="bni" data-logo="bni">
                  <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgdmlld0JveD0iMCAwIDI1NiAyNTYiPjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0xMjggMEM1Ny4zIDAgMCA1Ny4zIDAgMTI4czU3LjMgMTI4IDEyOCAxMjhzMTI4LTU3LjMgMTI4LTEyOFMxOTguNyAwIDEyOCAweiIvPjxwYXRoIGZpbGw9IiM4YzEzOGMiIGQ9Ik0xMjggMTkuMmM2MCAwIDEwOC44IDQ4LjggMTA4LjggMTA4LjhTMTg4IDE5LjIgMTI4IDE5LjJ6Ii8+PHBhdGggZmlsbD0iI2ZmZiIgZD0iTTE0OS4zIDk3LjVjMC0xMS44LTkuNi0yMS4zLTIxLjMtMjEuM3MtMjEuMyA5LjYtMjEuMyAyMS4zYzAgMTEuOCA5LjYgMjEuMyAyMS4zIDIxLjNzMjEuMy05LjUgMjEuMy0yMS4zem0yMS4zIDBjMC0yMy41LTE5LjEtNDIuNi00Mi42LTQyLjZzLTQyLjYgMTkuMS00Mi42IDQyLjZjMCAyMy41IDE5LjEgNDIuNiA0Mi42IDQyLjZzNDIuNi0xOS4xIDQyLjYtNDIuNnoiLz48L3N2Zz4=" class="bank-logo"> BNI (Bank Negara Indonesia)
                </option>
                <option value="mandiri" data-logo="mandiri">
                  <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgdmlld0JveD0iMCAwIDI1NiAyNTYiPjxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik0xMjggMEM1Ny4zIDAgMCA1Ny4zIDAgMTI4czU3LjMgMTI4IDEyOCAxMjhzMTI4LTU3LjMgMTI4LTEyOFMxOTguNyAwIDEyOCAweiIvPjxwYXRoIGZpbGw9IiMwMDZiOTUiIGQ9Ik0xMjggMTkuMmM2MCAwIDEwOC44IDQ4LjggMTA4LjggMTA4LjhTMTg4IDE5LjIgMTI4IDE5LjJ6Ii8+PHBhdGggZmlsbD0iI2ZmZiIgZD0iTTE1OC40IDk3LjVjMC0xNi43LTEzLjYtMzAuMy0zMC4zLTMwLjNzLTMwLjMgMTMuNi0zMC4zIDMwLjNjMCAxNi43IDEzLjYgMzAuMyAzMC4zIDMwLjNzMzAuMy0xMy42IDMwLjMtMzAuM3ptLTMwLjMgNDIuNmMtMjMuNSAwLTQyLjYtMTkuMS00Mi42LTQyLjZzMTkuMS00Mi42IDQyLjYtNDIuNiA0Mi42IDE5LjEgNDIuNiA0Mi42YzAgMjMuNS0xOS4xIDQyLjYtNDIuNiA0Mi42eiIvPjwvc3ZnPg==" class="bank-logo"> Bank Mandiri
                </option>
              </select>
            </div>
            
            <!-- Nomor Rekening -->
            <div class="mb-3">
              <label for="accountNumber" class="form-label">Nomor Rekening <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="accountNumber" name="accountNumber" placeholder="Masukkan nomor rekening" required>
            </div>
            
            <!-- Nama Pemilik Rekening -->
            <div class="mb-3">
              <label for="accountName" class="form-label">Nama Pemilik Rekening <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="accountName" name="accountName" placeholder="Masukkan nama pemilik rekening" required>
            </div>
            
            <!-- Email untuk Notifikasi -->
            <div class="mb-3">
              <label for="email" class="form-label">Email untuk Notifikasi</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email untuk notifikasi" value="<?= isset($user['email']) ? $user['email'] : '' ?>">
            </div>
            
            <!-- Informasi Biaya Admin -->
            <div class="alert alert-warning">
              <small>
                <i class="fas fa-info-circle me-1"></i>
                Penarikan dana dikenakan biaya admin sebesar Rp 2.500 per transaksi. Dana akan ditransfer maksimal 1x24 jam pada hari kerja.
              </small>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary" id="submitWithdraw">
            <i class="fas fa-paper-plane me-1"></i> Ajukan Penarikan
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

  submitButton.addEventListener('click', async function() {
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
    if (!confirm(`Yakin tarik Rp ${amount.toLocaleString('id-ID')} ?`)) return;

    // Kirim data ke backend
    const formData = new FormData(withdrawForm);
    try {
      const res = await fetch("<?= base_url('api/payout/withdraw') ?>", {
        method: "POST",
        body: formData
      });
      const data = await res.json();

      if (res.ok) {
        alert("✅ Penarikan berhasil diproses!");
        location.reload();
      } else {
        alert("❌ Gagal: " + data.error);
      }
    } catch (err) {
      alert("Terjadi error: " + err.message);
    }
  });
});
</script>
</body>
</html>