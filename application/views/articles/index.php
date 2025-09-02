<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Artikel Hukum - Advokat Online</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
	<style>
		:root {
			--primary-color: #16a34a;
			--primary-hover: #15803d;
			--secondary-color: #f0fdf4;
		}
		
		body {
			font-family: 'Inter', sans-serif;
			background-color: #f8fafc;
			color: #1f2937;
			padding-top: 2rem;
			padding-bottom: 3rem;
		}
		
		.header-title {
			color: #1f2937;
			font-weight: 700;
			position: relative;
			display: inline-block;
		}
		
		.header-title::after {
			content: '';
			position: absolute;
			bottom: -8px;
			left: 0;
			width: 50px;
			height: 4px;
			background: var(--primary-color);
			border-radius: 2px;
		}
		
		.article-card {
			border: none;
			border-radius: 16px;
			overflow: hidden;
			transition: all 0.3s ease;
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
			height: 100%;
		}
		
		.article-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
		}
		
		.card-body {
			padding: 1.5rem;
		}
		
		.article-title {
			font-weight: 600;
			color: #1f2937;
			line-height: 1.4;
			margin-bottom: 0.75rem;
			display: -webkit-box;
			-webkit-line-clamp: 2;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}
		
		.article-meta {
			color: #6b7280;
			font-size: 0.875rem;
			margin-bottom: 1rem;
			display: flex;
			align-items: center;
			gap: 0.5rem;
		}
		
		.article-excerpt {
			color: #4b5563;
			line-height: 1.6;
			margin-bottom: 1.5rem;
			display: -webkit-box;
			-webkit-line-clamp: 3;
			-webkit-box-orient: vertical;
			overflow: hidden;
		}
		
		.btn-read-more {
			background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
			color: white;
			border: none;
			border-radius: 8px;
			padding: 0.5rem 1.25rem;
			font-weight: 500;
			transition: all 0.3s ease;
			text-decoration: none;
			display: inline-block;
		}
		
		.btn-read-more:hover {
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
			color: white;
		}
		
		.btn-add-article {
			background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
			color: white;
			border: none;
			border-radius: 12px;
			padding: 0.75rem 1.5rem;
			font-weight: 600;
			transition: all 0.3s ease;
			display: flex;
			align-items: center;
			gap: 0.5rem;
		}
		
		.btn-add-article:hover {
			transform: translateY(-2px);
			box-shadow: 0 6px 15px rgba(22, 163, 74, 0.3);
			color: white;
		}
		
		.empty-state {
			text-align: center;
			padding: 3rem 1rem;
			color: #6b7280;
		}
		
		.empty-state i {
			font-size: 3rem;
			margin-bottom: 1rem;
			color: #d1d5db;
		}
		
		.article-image {
			height: 200px;
			background: linear-gradient(135deg, #4ade80 0%, #15803d 100%);
			display: flex;
			align-items: center;
			justify-content: center;
			color: white;
			font-size: 3rem;
		}
		
		.category-badge {
			background-color: var(--secondary-color);
			color: var(--primary-color);
			padding: 0.25rem 0.75rem;
			border-radius: 20px;
			font-size: 0.75rem;
			font-weight: 500;
			display: inline-block;
			margin-bottom: 1rem;
		}
		
		/* Responsive adjustments */
		@media (max-width: 768px) {
			.container {
				padding-left: 1rem;
				padding-right: 1rem;
			}
			
			.article-card {
				margin-bottom: 1.5rem;
			}
			
			.header-title {
				font-size: 1.75rem;
			}
		}
		
		@media (max-width: 576px) {
			.d-flex.justify-content-between {
				flex-direction: column;
				gap: 1rem;
				align-items: flex-start !important;
			}
			
			.btn-add-article {
				align-self: flex-start;
			}
			
			.article-image {
				height: 160px;
				font-size: 2.5rem;
			}
		}
	</style>
</head>
<body>
<div class="container mt-4">
	<!-- Header Section -->
	<div class="d-flex justify-content-between align-items-center mb-5">
		<div>
			<h2 class="header-title fw-bold">Artikel Hukum</h2>
			<p class="text-muted mt-2">Temukan artikel dan informasi hukum terbaru dari advokat profesional</p>
		</div>
		
	</div>

	<!-- Articles Grid -->
	<?php if (!empty($articles)): ?>
		<div class="row g-4">
			<?php foreach ($articles as $article): ?>
				<div class="col-md-6 col-lg-4">
					<div class="article-card card h-100">
						<!-- Article Image Placeholder -->
						<div class="article-image">
							<i class="bi bi-journal-text"></i>
						</div>
						
						<div class="card-body">
							<!-- Category Badge -->
							<div class="category-badge">
								<i class="bi bi-tag me-1"></i> Hukum
							</div>
							
							<!-- Article Title -->
							<h5 class="article-title">
								<?= character_limiter($article['title'], 50) ?>
							</h5>
							
							<!-- Article Meta -->
							<div class="article-meta">
								<i class="bi bi-person"></i>
								<span>By <?= $article['author_name']?></span>
								<i class="bi bi-clock ms-2"></i>
								<span><?= date('d M Y', strtotime($article['published_at'])) ?></span>
							</div>
							
							<!-- Article Excerpt -->
							<p class="article-excerpt">
								<?= character_limiter(strip_tags($article['body']), 120) ?>
							</p>
							
							<!-- Action Buttons -->
							<div class="d-flex gap-2">
								<a href="<?= site_url('article/detail/'.$article['id']) ?>" class="btn-read-more">
									<i class="bi bi-book me-1"></i> Baca Selengkapnya
								</a>
								
								<?php if (isset($article['can_edit']) && $article['can_edit']): ?>
									<a href="<?= site_url('articles/edit/'.$article['id']) ?>" class="btn btn-outline-warning btn-sm">
										<i class="bi bi-pencil"></i>
									</a>
									<a href="<?= site_url('articles/delete/'.$article['id']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Yakin ingin menghapus artikel ini?')">
										<i class="bi bi-trash"></i>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<!-- Empty State -->
		<div class="empty-state">
			<i class="bi bi-journal-x"></i>
			<h4 class="text-muted">Belum ada artikel</h4>
		
		</div>
	<?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>