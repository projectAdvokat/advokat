<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Advokat Online - Konsultasi Hukum Profesional</title>
	<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<style>
		:root {
			--primary-color: #16a34a;
			--primary-hover: #15803d;
			--secondary-color: #f0fdf4;
		}

		* {
			box-sizing: border-box;
			margin: 0;
			padding: 0;
		}
		
		body {
			font-family: 'Inter', sans-serif;
			line-height: 1.6;
			color: #1f2937;
			overflow-x: hidden;
			padding-top: 76px; /* Height of navbar */
		}
		
		.navbar {
			position: fixed;
			top: 0;
			width: 100%;
			z-index: 1000;
			background: rgba(255, 255, 255, 0.95);
			backdrop-filter: blur(10px);
			transition: all 0.3s ease;
			padding: 0.8rem 1.5rem;
			box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
		}
		
		.navbar-scrolled {
			background: rgba(255, 255, 255, 0.98);
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
		}
		
		.hero-content {
			opacity: 0;
			transform: translateY(30px);
			animation: fadeInUp 1s ease-out 0.5s forwards;
		}
		
		.feature-card {
			transition: all 0.3s ease;
			border-radius: 16px;
			overflow: hidden;
			height: 100%;
		}
		
		.feature-card:hover {
			transform: translateY(-8px);
			box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
		}
		
		.lawyer-card {
			transition: all 0.3s ease;
			border-radius: 16px;
			overflow: hidden;
		}
		
		.lawyer-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
		}
		
		.article-card {
			transition: all 0.3s ease;
			border-radius: 16px;
			overflow: hidden;
			height: 100%;
		}
		
		.article-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
		}
		
		.testimonial-card {
			background: linear-gradient(135deg, #4ade80 0%, #15803d 100%);
			color: white;
			border-radius: 16px;
			padding: 2.5rem;
		}
		
		.cta-section {
			background: linear-gradient(135deg, #4ade80 0%, #15803d 100%);
			color: white;
			padding: 5rem 1rem;
		}
		
		.btn-primary-custom {
			background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
			border: none;
			color: white;
			padding: 0.8rem 2rem;
			border-radius: 12px;
			font-weight: 600;
			transition: all 0.3s ease;
			box-shadow: 0 4px 6px rgba(22, 163, 74, 0.25);
		}
		
		.btn-primary-custom:hover {
			transform: translateY(-2px);
			box-shadow: 0 6px 12px rgba(22, 163, 74, 0.3);
		}
		
		@keyframes fadeInUp {
			from {
				opacity: 0;
				transform: translateY(30px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}
		
		@keyframes float {
			0% {
				transform: translateY(0px);
			}
			50% {
				transform: translateY(-10px);
			}
			100% {
				transform: translateY(0px);
			}
		}
		
		.floating {
			animation: float 3s ease-in-out infinite;
		}
		
		.section-title {
			position: relative;
			display: inline-block;
			margin-bottom: 3rem;
		}
		
		.section-title::after {
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

		/* Mobile Menu Styles */
		#mobile-menu {
			position: fixed;
			top: 76px;
			left: 0;
			right: 0;
			background: white;
			z-index: 999;
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
			transform: translateY(-100%);
			transition: transform 0.3s ease;
		}
		
		#mobile-menu.show {
			transform: translateY(0);
		}
		
		/* Responsive adjustments */
		@media (max-width: 768px) {
			.navbar {
				padding: 0.7rem 1rem;
			}
			
			.hero-content h1 {
				font-size: 2.5rem;
			}
			
			.feature-card, .lawyer-card, .article-card {
				margin-bottom: 1.5rem;
			}
			
			.testimonial-card {
				padding: 1.5rem;
			}
		}
		
		@media (max-width: 576px) {
			.hero-content h1 {
				font-size: 2rem;
			}
			
			.hero-content p {
				font-size: 1rem;
			}
			
			.section-title {
				font-size: 1.8rem;
			}
			
			body {
				padding-top: 70px;
			}
			
			#mobile-menu {
				top: 70px;
			}
		}
	</style>
</head>
<body class="bg-base-100">
	<!-- Navbar -->
	<nav class="navbar bg-base-100 shadow-md px-4" id="navbar">
		<div class="flex-1">
			<a href="<?= base_url() ?>" class="btn btn-ghost normal-case text-xl font-bold text-green-700">
				<i class="fas fa-scale-balanced mr-2"></i>Advokat Online
			</a>
		</div>

		<!-- Menu untuk Desktop -->
		<div class="hidden lg:flex">
			<ul class="menu menu-horizontal px-1">
				<?php if (!$this->session->userdata('user_id')): ?>
					<li><a href="<?= site_url('login') ?>" class="font-medium">Login</a></li>
					<li><a href="<?= site_url('register') ?>" class="font-medium">Register</a></li>
				<?php else: ?>
					<?php if (in_array($this->session->userdata('user_role'), ['admin','lawyer'])): ?>
						<li><a href="<?= site_url('dashboard') ?>" class="font-medium">Dashboard</a></li>
					<?php else: ?>
						<li><a href="<?= site_url('lawyers/list') ?>" class="font-medium">Cari Lawyer</a></li>
					<?php endif; ?>
					
					<!-- User dropdown for desktop -->
					<li class="ml-4">
						<details class="dropdown dropdown-end">
							<summary class="btn btn-ghost avatar">
								<div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center">
									<?= strtoupper(substr($this->session->userdata('user_name'), 0, 1)) ?>
								</div>
								<span class="ml-2 font-medium"><?= $this->session->userdata('user_name') ?></span>
							</summary>
							<ul class="p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-52">
								<!-- <li><a href="<?= site_url('profile') ?>"><i class="fas fa-user mr-2"></i>Profile</a></li> -->
								<li><a href="<?= site_url('logout') ?>"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a></li>
							</ul>
						</details>
					</li>
				<?php endif; ?>
			</ul>
		</div>

		<!-- Burger Button (Mobile Only) -->
		<div class="flex-none lg:hidden">
			<button class="btn btn-square btn-ghost" id="mobile-menu-button">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
				</svg>
			</button>
		</div>
	</nav>

	<!-- Menu Mobile -->
	<div id="mobile-menu" class="lg:hidden hidden bg-base-100 shadow-lg border-t">
		<ul class="menu menu-vertical p-4 space-y-2">
			<?php if (!$this->session->userdata('user_id')): ?>
				<li><a href="<?= site_url('login') ?>" class="font-medium py-3"><i class="fas fa-sign-in-alt mr-3"></i>Login</a></li>
				<li><a href="<?= site_url('register') ?>" class="font-medium py-3"><i class="fas fa-user-plus mr-3"></i>Register</a></li>
			<?php else: ?>
				<?php if (in_array($this->session->userdata('user_role'), ['admin','lawyer'])): ?>
					<li><a href="<?= site_url('dashboard') ?>" class="font-medium py-3"><i class="fas fa-tachometer-alt mr-3"></i>Dashboard</a></li>
				<?php else: ?>
					<li><a href="<?= site_url('lawyers/list') ?>" class="font-medium py-3"><i class="fas fa-search mr-3"></i>Cari Lawyer</a></li>
				<?php endif; ?>
				
				<!-- Additional menu items for logged in users -->
				<!-- <li><a href="<?= site_url('profile') ?>" class="font-medium py-3"><i class="fas fa-user mr-3"></i>Profile</a></li> -->
				<li><a href="<?= site_url('logout') ?>" class="font-medium py-3 text-red-600"><i class="fas fa-sign-out-alt mr-3"></i>Logout</a></li>
				
				<!-- User info in mobile menu -->
				<li class="pt-4 mt-4 border-t">
					<div class="flex items-center px-2 py-2">
						<div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center mr-3">
							<?= strtoupper(substr($this->session->userdata('user_name'), 0, 1)) ?>
						</div>
						<div>
							<p class="font-semibold"><?= $this->session->userdata('user_name') ?></p>
							<p class="text-sm text-gray-500"><?= ucfirst($this->session->userdata('user_role')) ?></p>
						</div>
					</div>
				</li>
			<?php endif; ?>
		</ul>
	</div>

	<!-- Hero Section -->
	<section class="hero min-h-screen" style="background-image: url('<?= base_url('assets/images/hero.jpg'); ?>');">
		<div class="hero-overlay bg-black bg-opacity-60"></div>
		<div class="hero-content text-center text-neutral-content px-4">
			<div class="max-w-2xl lg:max-w-3xl xl:max-w-4xl">
				<h1 class="mb-5 text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
					Konsultasi Hukum Online Dengan Advokat Terpercaya
				</h1>
				<p class="mb-8 text-lg sm:text-xl md:text-2xl opacity-90 max-w-2xl mx-auto leading-relaxed">
					Solusi hukum cepat, mudah, dan aman langsung dari pengacara berlisensi.
				</p>
				<div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
					<a href="<?= $this->session->userdata('user_id') ? 'lawyers/list' : 'login' ?>" 
						class="btn btn-success btn-lg sm:btn-wide md:btn-xl rounded-full px-8 py-3 text-sm sm:text-base md:text-lg font-semibold transition-all duration-300 hover:scale-105">
						<span>Mulai Konsultasi</span>
						<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
							<path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
						</svg>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Rest of your content remains the same -->
	<!-- Why Choose Us -->
	<section id="features" class="py-16 bg-white">
		<div class="container mx-auto px-4 text-center">
			<h2 class="text-3xl font-bold mb-12 section-title">Kenapa Memilih Kami</h2>
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
				<!-- Feature cards content -->
			</div>
		</div>
	</section>

	<!-- How It Works -->
	<section class="py-16 bg-base-200">
		<div class="container mx-auto px-4">
			<h2 class="text-3xl font-bold text-center mb-12 section-title">Cara Kerja</h2>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
				<!-- How it works content -->
			</div>
		</div>
	</section>

	<!-- Popular Lawyers -->
	<section class="py-16 bg-white">
		<div class="container mx-auto px-4">
			<h2 class="text-3xl font-bold text-center mb-12 section-title">Lawyer Terpopuler</h2>
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
				<!-- Lawyers content -->
			</div>
		</div>
	</section>

	<!-- Articles Section -->
	<section class="py-16 bg-base-200">
		<div class="container mx-auto px-4">
			<h2 class="text-3xl font-bold text-center mb-12 section-title">Artikel Terbaru</h2>
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<!-- Articles content -->
			</div>
		</div>
	</section>

	<!-- Testimonial -->
	<section class="py-16 bg-white">
		<div class="container mx-auto px-4">
			<h2 class="text-3xl font-bold text-center mb-12 section-title">Apa Kata Klien Kami</h2>
			<div class="max-w-4xl mx-auto">
				<!-- Testimonial content -->
			</div>
		</div>
	</section>

	<!-- CTA -->
	<section class="cta-section">
		<div class="container mx-auto px-4 text-center">
			<!-- CTA content -->
		</div>
	</section>

	<!-- Footer -->
	<footer class="footer footer-center p-10 bg-base-300 text-base-content">
		<!-- Footer content -->
	</footer>

	<script>
		// Navbar scroll effect
		window.addEventListener('scroll', function() {
			const navbar = document.getElementById('navbar');
			if (window.scrollY > 50) {
				navbar.classList.add('navbar-scrolled');
			} else {
				navbar.classList.remove('navbar-scrolled');
			}
		});
		
		// Mobile menu functionality
		document.addEventListener('DOMContentLoaded', function() {
			const mobileMenuButton = document.getElementById('mobile-menu-button');
			const mobileMenu = document.getElementById('mobile-menu');
			
			// Toggle mobile menu
			mobileMenuButton.addEventListener('click', function(e) {
				e.stopPropagation();
				mobileMenu.classList.toggle('show');
				mobileMenu.classList.toggle('hidden');
			});
			
			// Close mobile menu when clicking outside
			document.addEventListener('click', function(e) {
				if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
					mobileMenu.classList.remove('show');
					mobileMenu.classList.add('hidden');
				}
			});
			
			// Close mobile menu when clicking on a link
			mobileMenu.querySelectorAll('a').forEach(link => {
				link.addEventListener('click', function() {
					mobileMenu.classList.remove('show');
					mobileMenu.classList.add('hidden');
				});
			});
			
			// Close mobile menu on escape key
			document.addEventListener('keydown', function(e) {
				if (e.key === 'Escape') {
					mobileMenu.classList.remove('show');
					mobileMenu.classList.add('hidden');
				}
			});
		});
		
		// Smooth scrolling for anchor links
		document.querySelectorAll('a[href^="#"]').forEach(anchor => {
			anchor.addEventListener('click', function (e) {
				e.preventDefault();
				const target = document.querySelector(this.getAttribute('href'));
				if (target) {
					target.scrollIntoView({
						behavior: 'smooth',
						block: 'start'
					});
				}
			});
		});
	</script>
</body>
</html>