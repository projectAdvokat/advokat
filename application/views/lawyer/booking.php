<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Midtrans -->
  <script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="<?= $this->config->item('midtrans_client_key') ?>"></script>

  <title>Booking Konsultasi - Advokat Online</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #16a34a;
      --primary-hover: #15803d;
      --secondary-color: #f0fdf4;
    }
    
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      min-height: 100vh;
      color: #1f2937;
    }
    
    .header-section {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
      color: white;
      padding: 3rem 0;
      text-align: center;
      border-radius: 0 0 2rem 2rem;
      margin-bottom: 3rem;
      position: relative;
      overflow: hidden;
    }
    
    .header-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
      opacity: 0.1;
    }
    
    .card-lawyer {
      border: none;
      border-radius: 1.5rem;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      transition: all 0.3s ease;
    }
    
    .card-lawyer:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
    }
    
    .avatar {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      font-weight: bold;
      margin-right: 1.5rem;
      flex-shrink: 0;
    }
    
    .lawyer-info {
      flex: 1;
    }
    
    .badge-experience {
      background: var(--secondary-color);
      color: var(--primary-color);
      padding: 0.4rem 1rem;
      border-radius: 20px;
      font-weight: 600;
      font-size: 0.875rem;
    }
    
    .form-control {
      border: 2px solid #e5e7eb;
      border-radius: 12px;
      padding: 0.875rem 1.25rem;
      font-size: 1rem;
      transition: all 0.3s ease;
    }
    
    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }
    
    .form-label {
      font-weight: 600;
      color: #374151;
      margin-bottom: 0.5rem;
    }
    
    .btn-booking {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
      color: white;
      border: none;
      border-radius: 12px;
      padding: 1rem 2rem;
      font-weight: 600;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      width: 100%;
      margin-top: 1.5rem;
    }
    
    .btn-booking:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(22, 163, 74, 0.3);
    }
    
    .btn-booking:active {
      transform: translateY(0);
    }
    
    .price-display {
      background: var(--secondary-color);
      padding: 1.5rem;
      border-radius: 12px;
      margin-top: 1.5rem;
      text-align: center;
    }
    
    .price-label {
      color: #6b7280;
      font-size: 0.95rem;
      margin-bottom: 0.5rem;
    }
    
    .price-amount {
      color: var(--primary-color);
      font-size: 1.5rem;
      font-weight: 700;
    }
    
    .feature-list {
      list-style: none;
      padding: 0;
      margin: 1.5rem 0;
    }
    
    .feature-list li {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 0.75rem;
      color: #4b5563;
    }
    
    .feature-list li i {
      color: var(--primary-color);
      font-size: 1.1rem;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .header-section {
        padding: 2rem 0;
        margin-bottom: 2rem;
      }
      
      .avatar {
        width: 70px;
        height: 70px;
        font-size: 1.75rem;
        margin-right: 1rem;
      }
      
      .d-flex.align-items-center {
        flex-direction: column;
        text-align: center;
      }
      
      .avatar {
        margin-right: 0;
        margin-bottom: 1rem;
      }
    }
    
    @media (max-width: 576px) {
      .header-section {
        border-radius: 0 0 1.5rem 1.5rem;
      }
      
      .card-lawyer {
        border-radius: 1rem;
      }
      
      .btn-booking {
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
      }
      
      .container {
        padding-left: 1rem;
        padding-right: 1rem;
      }
    }
    
    .loading-spinner {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(255,255,255,0.3);
      border-radius: 50%;
      border-top-color: #fff;
      animation: spin 1s ease-in-out infinite;
      margin-right: 0.5rem;
    }
    
    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header-section">
    <div class="container">
      <h1 class="fw-bold mb-3">Booking Konsultasi</h1>
      <p class="lead mb-0">Konsultasi hukum jadi lebih mudah dan cepat dengan advokat profesional</p>
    </div>
  </div>

  <div class="container mb-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card card-lawyer">
          <div class="card-body p-4">
            <!-- Profile Lawyer -->
            <div class="d-flex align-items-center mb-4">
              <div class="avatar">
                <?= isset($lawyer['name']) ? strtoupper(substr($lawyer['name'], 0, 1)) : 'L'; ?>
              </div>
              <div class="lawyer-info">
                <h3 class="mb-2"><?= isset($lawyer['name']) ? $lawyer['name'] : 'Nama Tidak Ada'; ?></h3>
                <p class="text-muted mb-2"><?= isset($lawyer['specialties']) ? $lawyer['specialties'] : 'Spesialis Hukum'; ?></p>
                <span class="badge-experience">
                  <i class="fas fa-award me-2"></i>
                  <?= isset($lawyer['years_experience']) ? $lawyer['years_experience'] : 0; ?> tahun pengalaman
                </span>
              </div>
            </div>

            <!-- Bio -->
            <?php if (isset($lawyer['bio']) && !empty($lawyer['bio'])): ?>
              <div class="mb-4">
                <p class="text-muted mb-0"><?= $lawyer['bio']; ?></p>
              </div>
            <?php endif; ?>

            <!-- Features -->
            <ul class="feature-list">
              <li><i class="fas fa-check-circle"></i> Konsultasi via chat, telepon, atau video call</li>
              <li><i class="fas fa-check-circle"></i> Dokumen hukum terjamin kerahasiaannya</li>
              <li><i class="fas fa-check-circle"></i> Respons cepat dari lawyer profesional</li>
            </ul>

            <!-- Booking Form -->
            <form id="bookingForm">
              <input type="hidden" name="lawyer_id" id="lawyer_id" value="<?= isset($lawyer['user_id']) ? $lawyer['user_id'] : ''; ?>">
              <input type="hidden" name="client_id" id="client_id" value="<?= $this->session->userdata('user_id'); ?>">

              <div class="mb-4">
                <label class="form-label">Durasi Konsultasi (menit)</label>
                <input type="number" name="duration" id="duration" class="form-control" min="30" value="30" required>
                <div class="form-text">Durasi minimal 30 menit. Setiap 30 menit tambahan akan dikenakan biaya sesuai tarif lawyer.</div>
              </div>

              <!-- Price Display -->
              <div class="price-display">
                <div class="price-label">Perkiraan Biaya Konsultasi</div>
                <div class="price-amount" id="priceDisplay">Rp 150.000</div>
                <small class="text-muted">*Biaya akhir dapat berubah sesuai durasi</small>
              </div>

              <button type="submit" class="btn-booking" id="submitButton">
                <span id="buttonText">Booking & Bayar Sekarang</span>
                <span id="loadingSpinner" class="loading-spinner" style="display: none;"></span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Script -->
  <script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById("bookingForm");
    const durationInput = document.getElementById("duration");
    const priceDisplay = document.getElementById("priceDisplay");
    const submitButton = document.getElementById("submitButton");
    const buttonText = document.getElementById("buttonText");
    const loadingSpinner = document.getElementById("loadingSpinner");
    
    // Calculate price based on duration
    function calculatePrice(duration) {
      const pricePer30Minutes = 150000;
      const intervals = Math.ceil(duration / 30);
      return intervals * pricePer30Minutes;
    }
    
    // Update price display
    function updatePriceDisplay() {
      const duration = parseInt(durationInput.value) || 30;
      const price = calculatePrice(duration);
      priceDisplay.textContent = `Rp ${price.toLocaleString('id-ID')}`;
    }
    
    // Initial price calculation
    updatePriceDisplay();
    
    // Update price when duration changes
    durationInput.addEventListener('input', updatePriceDisplay);
    
    // Form submission
    // Form submission
bookingForm.addEventListener("submit", async function(e) {
  e.preventDefault();
  
  // Show loading state
  buttonText.textContent = "Memproses...";
  loadingSpinner.style.display = "inline-block";
  submitButton.disabled = true;
  
  const lawyerId = document.getElementById("lawyer_id").value;
  const clientId = document.getElementById("client_id").value;
  const duration = document.getElementById("duration").value;

  try {
    // Step 1: Create payment with Xendit
    const response = await fetch(`/advokat/api/booking/pay/${lawyerId}`, {
      method: "POST",
      headers: { 
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest"
      },
      body: JSON.stringify({ duration: duration })
    });

    const result = await response.json();
    
    if (result.status === 'success' && result.data) {
      // Redirect to Xendit payment page
      window.location.href = result.data.invoice_url;
    } else {
      throw new Error(result.message || 'Gagal membuat transaksi');
    }
  } catch (error) {
  console.error("Error:", error);
    alert("Terjadi kesalahan saat memproses booking: " + error.message);
    resetButtonState();
  }
});
    // Reset button state
    function resetButtonState() {
      buttonText.textContent = "Booking & Bayar Sekarang";
      loadingSpinner.style.display = "none";
      submitButton.disabled = false;
    }
  });
  </script>
</body>
</html>