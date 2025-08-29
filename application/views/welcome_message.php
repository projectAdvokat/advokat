<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Advokat Online</title>
	<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-100">

<!-- Hero Section -->
<div class="hero min-h-screen" style="background-image: url('<?= base_url('assets/images/hero.jpg'); ?>');">
  <div class="hero-overlay bg-black bg-opacity-60"></div>
  <div class="hero-content text-center text-neutral-content">
    <div class="max-w-xl">
      <h1 class="mb-5 text-5xl font-bold">Konsultasi Hukum Online Dengan Advokat Terpercaya</h1>
      <p class="mb-5">
        Solusi hukum cepat, mudah, dan aman langsung dari pengacara berlisensi.
      </p>
      <a href="<?=  $this->session->userdata('user_id') ?'lawyers/list':'login' ?>" class="btn btn-success" >Mulai Konsultasi</a>
      <!-- <button class="btn btn-outline-light ml-4 bg-co" >Cari Lawyer</button> -->
    </div>
  </div>
</div>

<!-- Why Choose Us -->
<section class="py-16 bg-white">
  <div class="max-w-6xl mx-auto text-center">
    <h2 class="text-3xl font-bold mb-10">Kenapa Memilih Kami</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
      <div class="p-6 bg-base-200 rounded-xl">
        <div class="text-4xl">✅</div>
        <h3 class="font-semibold mt-4">Advokat Berlisensi</h3>
        <p>Semua pengacara terverifikasi</p>
      </div>
      <div class="p-6 bg-base-200 rounded-xl">
        <div class="text-4xl">⚡</div>
        <h3 class="font-semibold mt-4">Cepat & Mudah</h3>
        <p>Konsultasi kapan saja, dimana saja</p>
      </div>
      <div class="p-6 bg-base-200 rounded-xl">
        <div class="text-4xl">🔒</div>
        <h3 class="font-semibold mt-4">Privasi Terjamin</h3>
        <p>Data Anda aman dan terlindungi</p>
      </div>
      <div class="p-6 bg-base-200 rounded-xl">
        <div class="text-4xl">💬</div>
        <h3 class="font-semibold mt-4">Multi Channel</h3>
        <p>Chat, Video Call, atau Telepon</p>
      </div>
    </div>
  </div>
</section>

<!-- How It Works -->
<section class="py-16 bg-base-200">
  <div class="max-w-6xl mx-auto text-center">
    <h2 class="text-3xl font-bold mb-10">Cara Kerja</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="p-6">
        <div class="text-4xl mb-4">1️⃣</div>
        <h3 class="font-semibold">Pilih Advokat</h3>
        <p>Cari sesuai kebutuhan hukum Anda</p>
      </div>
      <div class="p-6">
        <div class="text-4xl mb-4">2️⃣</div>
        <h3 class="font-semibold">Atur Jadwal</h3>
        <p>Pilih waktu yang cocok</p>
      </div>
      <div class="p-6">
        <div class="text-4xl mb-4">3️⃣</div>
        <h3 class="font-semibold">Mulai Konsultasi</h3>
        <p>Chat/Telepon/Video call dengan lawyer</p>
      </div>
    </div>
  </div>
</section>

<!-- Popular Lawyers -->
<section class="py-16 bg-white">
  <div class="max-w-6xl mx-auto text-center">
    <h2 class="text-3xl font-bold mb-10">Lawyer Populer</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
  <?php foreach ($lawyers as $lawyer): ?>
    <div class="card bg-base-200 shadow-xl">
      <div class="card-body">
        <h3 class="font-bold"><?= $lawyer['user_name']; ?></h3>
        <!-- <p><?= $lawyer['speciality']; ?></p> -->
       
        <button class="btn btn-sm btn-primary mt-4">Lihat Profil</button>
      </div>
    </div>
  <?php endforeach; ?>
</div>

  </div>
</section>

<!-- Testimonial -->
<section class="py-16 bg-base-200">
  <div class="max-w-4xl mx-auto text-center">
    <h2 class="text-3xl font-bold mb-10">Testimoni Klien</h2>
    <div class="carousel w-full">
      <div class="carousel-item w-full">
        <div class="bg-white shadow-lg p-8 rounded-xl">
          <p>"Pelayanan cepat, lawyer profesional, saya sangat terbantu!"</p>
          <h4 class="mt-4 font-semibold">- Siti Lestari</h4>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="py-16 bg-primary text-white text-center">
  <h2 class="text-3xl font-bold mb-6">Butuh bantuan hukum sekarang juga?</h2>
  <button class="btn btn-secondary">Konsultasi Sekarang</button>
</section>

<!-- Footer -->
<footer class="footer footer-center p-10 bg-base-300 text-base-content">
  <nav class="grid grid-flow-col gap-4">
    <a class="link link-hover">Tentang Kami</a>
    <a class="link link-hover">Syarat & Ketentuan</a>
    <a class="link link-hover">Privasi</a>
    <a class="link link-hover">Hubungi Kami</a>
  </nav>
  <aside>
    <p>© 2025 Advokat Online</p>
  </aside>
</footer>

</body>
</html>
