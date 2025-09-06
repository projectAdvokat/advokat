<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?= $article['title'] ?> - Advokat Online</title>
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
			line-height: 1.7;
			padding-top: 2rem;
			padding-bottom: 3rem;
		}
		
		.article-container {
			max-width: 800px;
			margin: 0 auto;
		}
		
		.article-card {
			border: none;
			border-radius: 16px;
			overflow: hidden;
			box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
			background: white;
		}
		
		.article-header {
			padding: 2.5rem 2.5rem 1.5rem;
			border-bottom: 1px solid #e5e7eb;
		}
		
		.article-title {
			font-weight: 700;
			color: #1f2937;
			font-size: 2.25rem;
			line-height: 1.3;
			margin-bottom: 1rem;
		}
		
		.article-meta {
			display: flex;
			align-items: center;
			gap: 1rem;
			color: #6b7280;
			font-size: 0.95rem;
			margin-bottom: 0.5rem;
		}
		
		.article-meta-item {
			display: flex;
			align-items: center;
			gap: 0.5rem;
		}
		
		.author-avatar {
			width: 40px;
			height: 40px;
			border-radius: 50%;
			background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
			display: flex;
			align-items: center;
			justify-content: center;
			color: white;
			font-weight: 600;
			font-size: 1.1rem;
		}
		
		.article-content {
			padding: 2.5rem;
			font-size: 1.1rem;
			color: #374151;
		}
		
		.article-content h2 {
			font-weight: 600;
			color: #1f2937;
			margin: 2rem 0 1rem;
			font-size: 1.5rem;
		}
		
		.article-content h3 {
			font-weight: 600;
			color: #1f2937;
			margin: 1.5rem 0 0.75rem;
			font-size: 1.25rem;
		}
		
		.article-content p {
			margin-bottom: 1.5rem;
		}
		
		.article-content ul, .article-content ol {
			margin-bottom: 1.5rem;
			padding-left: 1.5rem;
		}
		
		.article-content li {
			margin-bottom: 0.5rem;
		}
		
		.article-content blockquote {
			border-left: 4px solid var(--primary-color);
			padding-left: 1.5rem;
			margin: 2rem 0;
			font-style: italic;
			color: #6b7280;
		}
		
		.article-content img {
			max-width: 100%;
			height: auto;
			border-radius: 12px;
			margin: 2rem 0;
			box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
		}
		
		.article-footer {
			padding: 1.5rem 2.5rem;
			background: var(--secondary-color);
			border-top: 1px solid #e5e7eb;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		
		.btn-back {
			background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
			color: white;
			border: none;
			border-radius: 10px;
			padding: 0.75rem 1.5rem;
			font-weight: 500;
			transition: all 0.3s ease;
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			gap: 0.5rem;
		}
		
		.btn-back:hover {
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
			color: white;
		}
		
		.reading-time {
			color: #6b7280;
			font-size: 0.9rem;
			display: flex;
			align-items: center;
			gap: 0.5rem;
		}
		
		.article-hero {
			height: 300px;
			background: linear-gradient(135deg, #4ade80 0%, #15803d 100%);
			display: flex;
			align-items: center;
			justify-content: center;
			color: white;
			font-size: 4rem;
			margin-bottom: 2rem;
			border-radius: 16px;
			overflow: hidden;
		}
		
		/* Responsive adjustments */
		@media (max-width: 768px) {
			.article-header {
				padding: 2rem 1.5rem 1rem;
			}
			
			.article-title {
				font-size: 1.75rem;
			}
			
			.article-content {
				padding: 1.5rem;
				font-size: 1rem;
			}
			
			.article-footer {
				padding: 1.25rem 1.5rem;
				flex-direction: column;
				gap: 1rem;
				text-align: center;
			}
			
			.article-hero {
				height: 200px;
				font-size: 3rem;
			}
			
			.article-meta {
				flex-direction: column;
				align-items: flex-start;
				gap: 0.5rem;
			}
		}
		
		@media (max-width: 576px) {
			.article-header {
				padding: 1.5rem 1rem 1rem;
			}
			
			.article-title {
				font-size: 1.5rem;
			}
			
			.article-content {
				padding: 1.25rem 1rem;
			}
			
			.article-hero {
				height: 150px;
				font-size: 2.5rem;
				margin-bottom: 1.5rem;
			}
			
			.container {
				padding-left: 1rem;
				padding-right: 1rem;
			}
		}
		
		/* Content styling */
		.article-content strong {
			color: #1f2937;
			font-weight: 600;
		}
		
		.article-content em {
			color: #6b7280;
		}
		
		.article-content a {
			color: var(--primary-color);
			text-decoration: none;
			font-weight: 500;
		}
		
		.article-content a:hover {
			text-decoration: underline;
		}
		
		.article-content code {
			background: #f3f4f6;
			padding: 0.2rem 0.4rem;
			border-radius: 4px;
			font-family: 'Courier New', monospace;
			font-size: 0.9em;
		}
		
		.article-content pre {
			background: #1f2937;
			color: #f8fafc;
			padding: 1.5rem;
			border-radius: 8px;
			overflow-x: auto;
			margin: 2rem 0;
		}
		
		.article-content table {
			width: 100%;
			border-collapse: collapse;
			margin: 2rem 0;
		}
		
		.article-content th, .article-content td {
			padding: 0.75rem;
			border: 1px solid #e5e7eb;
			text-align: left;
		}
		
		.article-content th {
			background: var(--secondary-color);
			font-weight: 600;
		}
	</style>
</head>
<body>
<div class="container">
	<!-- Hero Section -->
	<div class="article-hero">
		<i class="bi bi-journal-text"></i>
	</div>
	
	<!-- Article Container -->
	<div class="article-container">
		<div class="article-card">
			<!-- Article Header -->
			<div class="article-header">
				<h1 class="article-title"><?= $article['title'] ?></h1>
				<div class="article-meta">
					<div class="article-meta-item">
						<div class="author-avatar">
							<?= substr($article['author_name'], 0, 1) ?>
						</div>
						<span>By <?= $article['author_name'] ?></span>
					</div>
					<div class="article-meta-item">
						<i class="bi bi-calendar"></i>
						<span><?= date('d M Y', strtotime($article['published_at'])) ?></span>
					</div>
					<div class="article-meta-item">
						<i class="bi bi-clock"></i>
						<span><?= $article['body'] ?> min read</span>
					</div>
				</div>

		 <img src="<?= base_url('uploads/articles/' . $article['cover_url']) ?>" class="img-fluid rounded-4" alt="" srcset="">

			</div>
			
			<!-- Article Content -->
			<div class="article-content">
				<?= $article['body'] ?>
			</div>
			
			<!-- Article Footer -->
			<div class="article-footer">
				<div class="reading-time">
					<i class="bi bi-clock-history"></i>
				
				</div>
				<?php
				$back_url  = ($user_role === 'lawyer') ? 'dashboard/articles' : 'articles';
				?>
				<a href="<?= site_url($back_url) ?>" class="btn-back">
					<i class="bi bi-arrow-left"></i> Kembali ke Artikel
				</a>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
	// Function to calculate reading time (fallback if PHP function doesn't exist)
	function calculateReadingTime(text) {
		const wordsPerMinute = 200;
		const words = text.split(/\s+/).length;
		return Math.ceil(words / wordsPerMinute);
	}
	
	// Add smooth scrolling for anchor links within the article
	document.addEventListener('DOMContentLoaded', function() {
		const articleLinks = document.querySelectorAll('.article-content a[href^="#"]');
		
		articleLinks.forEach(link => {
			link.addEventListener('click', function(e) {
				e.preventDefault();
				
				const targetId = this.getAttribute('href');
				if (targetId === '#') return;
				
				const targetElement = document.querySelector(targetId);
				if (targetElement) {
					targetElement.scrollIntoView({
						behavior: 'smooth',
						block: 'start'
					});
				}
			});
		});
		
		// Add responsive table wrapper
		const tables = document.querySelectorAll('.article-content table');
		tables.forEach(table => {
			const wrapper = document.createElement('div');
			wrapper.style.overflowX = 'auto';
			wrapper.style.margin = '2rem 0';
			table.parentNode.insertBefore(wrapper, table);
			wrapper.appendChild(table);
		});
	});
</script>
</body>
</html>