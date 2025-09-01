<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Lawyer - Advokat Online</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    :root {
      --primary-color: #16a34a;
      --primary-hover: #15803d;
      --secondary-color: #f0fdf4;
    }
    
    body {
      font-family: 'Inter', 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      min-height: 100vh;
    }
    
    .header-title {
      position: relative;
      display: inline-block;
      margin-bottom: 3rem;
    }
    
    .header-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: var(--primary-color);
      border-radius: 2px;
    }
    
    .lawyer-card {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      height: 100%;
    }
    
    .lawyer-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    .card-content {
      padding: 1.5rem;
    }
    
    .lawyer-avatar {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 2rem;
      font-weight: bold;
      margin: 0 auto 1rem;
    }
    
    .lawyer-name {
      font-weight: 700;
      color: #1f2937;
      text-align: center;
      margin-bottom: 0.5rem;
    }
    
    .lawyer-specialty {
      color: #6b7280;
      text-align: center;
      margin-bottom: 1rem;
      font-size: 0.95rem;
    }
    
    .lawyer-status {
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      padding: 0.25rem 0.75rem;
      border-radius: 20px;
      font-size: 0.875rem;
      font-weight: 500;
      margin-bottom: 1rem;
    }
    
    .status-online {
      background-color: #dcfce7;
      color: #16a34a;
    }
    
    .status-offline {
      background-color: #f3f4f6;
      color: #6b7280;
    }
    
    .btn-booking {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
      color: white;
      border: none;
      border-radius: 10px;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
      width: 100%;
      text-align: center;
    }
    
    .btn-booking:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    }
    
    .section-title {
      color: #1f2937;
      font-weight: 700;
      margin-bottom: 2rem;
      position: relative;
      padding-bottom: 0.5rem;
    }
    
    .section-title::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 40px;
      height: 3px;
      background: var(--primary-color);
      border-radius: 2px;
    }
    
    .badge-new {
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 12px;
      font-size: 0.75rem;
      font-weight: 600;
      position: absolute;
      top: -10px;
      right: -10px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .grid-cols-1 {
        grid-template-columns: 1fr;
      }
      
      .md\:grid-cols-2 {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .md\:grid-cols-3 {
        grid-template-columns: repeat(2, 1fr);
      }
      
      .lawyer-card {
        margin-bottom: 1.5rem;
      }
    }
    
    @media (max-width: 640px) {
      .md\:grid-cols-2 {
        grid-template-columns: 1fr;
      }
      
      .md\:grid-cols-3 {
        grid-template-columns: 1fr;
      }
      
      .header-title {
        font-size: 2rem;
      }
    }
    
    .recent-badge {
      position: relative;
    }
    
    .recent-badge::before {
      content: 'Baru';
      position: absolute;
      top: -8px;
      right: -8px;
      background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 12px;
      font-size: 0.75rem;
      font-weight: 600;
      z-index: 10;
    }
  </style>
</head>
<body class="min-h-screen py-8">
<div class="max-w-7xl mx-auto px-4">
  <!-- Header -->
  <div class="text-center mb-12">
    <h1 class="text-4xl font-bold text-gray-800 header-title">Daftar Lawyer</h1>
    <p class="text-gray-600 mt-4 max-w-2xl mx-auto">
      Pilih lawyer profesional sesuai kebutuhan hukum Anda. Konsultasi online dengan advokat berlisensi.
    </p>
  </div>
  
  <!-- Available Lawyers Section -->
  <div class="mb-16">
    <h2 class="text-2xl font-bold text-gray-800 mb-8 section-title">Lawyer Tersedia</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($lawyers as $lawyer): ?>
        <div class="lawyer-card">
          <div class="card-content">
            <div class="lawyer-avatar">
              <?= substr($lawyer['user_name'], 0, 1) ?>
            </div>
            <h3 class="lawyer-name"><?= $lawyer['user_name']; ?></h3>
            <p class="lawyer-specialty"><?= $lawyer['speciality'] ?? 'Spesialis Hukum'; ?></p>
            
            <div class="text-center mb-4">
              <span class="lawyer-status <?= $lawyer['is_online'] ? 'status-online' : 'status-offline' ?>">
                <i class="fas fa-circle text-xs"></i>
                <?= $lawyer['is_online'] ? 'Online' : 'Offline' ?>
              </span>
            </div>
            
            <a href="<?= site_url('lawyers/booking/'.$lawyer['user_id']); ?>" class="btn-booking">
              <i class="fas fa-calendar-check mr-2"></i> Booking Konsultasi
            </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Recently Booked Lawyers Section -->
  <?php if (!empty($current_booking_lawyer)): ?>
    <div class="mb-16">
      <h2 class="text-2xl font-bold text-gray-800 mb-8 section-title">Baru Saja Diboooking</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($current_booking_lawyer as $lawyer): ?>
          <div class="lawyer-card recent-badge">
            <div class="card-content">
              <div class="lawyer-avatar">
                <?= substr($lawyer['lawyer_name'], 0, 1) ?>
              </div>
              <h3 class="lawyer-name"><?= $lawyer['lawyer_name']; ?></h3>
              <p class="lawyer-specialty"><?= $lawyer['lawyer_specialties'] ?? 'Spesialis Hukum'; ?></p>
              
              <div class="text-center mb-4">
                <span class="lawyer-status status-online">
                  <i class="fas fa-bolt text-xs"></i>
                  Populer
                </span>
              </div>
              
              <a href="<?= site_url('lawyers/booking/'.$lawyer['user_id']); ?>" class="btn-booking">
                <i class="fas fa-calendar-check mr-2"></i> Booking Sekarang
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>
</div>

<!-- Footer -->
<footer class="text-center py-8 text-gray-600">
  <p>© 2024 Advokat Online. All rights reserved.</p>
</footer>

<script>
  // Animation for cards
  document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.lawyer-card');
    
    cards.forEach((card, index) => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(20px)';
      
      setTimeout(() => {
        card.style.transition = 'all 0.5s ease';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
      }, index * 100);
    });
  });
</script>
</body>
</html>