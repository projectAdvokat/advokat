<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Daftar Lawyer</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200">
<?php
// var_dump($current_booking_lawyer);
?>
<div class="max-w-6xl mx-auto py-16">
  <h1 class="text-3xl font-bold mb-8 text-center">Pilih Lawyer</h1>
  
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <?php foreach ($lawyers as $lawyer): ?>
      <div class="card bg-white shadow-lg p-6">
        <h2 class="text-xl font-bold"><?= $lawyer['user_name']; ?></h2>
        <p><?= $lawyer['speciality'] ?? 'Spesialis Hukum'; ?></p>
        <p class="mt-2 text-sm text-gray-500">Status: 
          <?= $lawyer['is_online'] ? '<span class="text-green-500">Online</span>' : '<span class="text-red-500">Offline</span>' ?>
        </p>
        <a href="<?= site_url('lawyers/booking/'.$lawyer['user_id']); ?>" class="btn btn-primary mt-4">Booking</a>
      </div>
    <?php endforeach; ?>
  </div>
</div>
  <h1 class="text-3xl font-bold mb-8 text-center">Baru Saja Di Booking</h1>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <?php foreach ($current_booking_lawyer as $lawyer): ?>
      <div class="card bg-white shadow-lg p-6">
        <h2 class="text-xl font-bold"><?= $lawyer['lawyer_name']; ?></h2>
        <p><?= $lawyer['lawyer_specialties'] ?? 'Spesialis Hukum'; ?></p>
        
        <a href="<?= site_url('lawyers/booking/'.$lawyer['user_id']); ?>" class="btn btn-primary mt-4">Booking</a>
      </div>
    <?php endforeach; ?>
  </div>
</div>

</body>
</html>
