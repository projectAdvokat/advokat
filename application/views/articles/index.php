
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Advokat Online</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body class="bg-base-100">
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Articles</h2>
        <a href="<?= site_url('articles/create') ?>" class="btn btn-primary">
            <!-- <i class="bi bi-plus-circle"></i> Add Article -->
        </a>
    </div>

    <?php if (!empty($articles)): ?>
        <div class="row g-4">
            <?php foreach ($articles as $article): ?>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">
                                <?= character_limiter($article['title'], 50) ?>
                            </h5>
                            <p class="text-muted small mb-2">
                                By <?= $article['author_name']?> | <?= date('d M Y', strtotime($article['published_at'])) ?>
                            </p>
                            <p class="card-text">
                                <?= character_limiter(strip_tags($article['body']), 100) ?>
                            </p>
                            <a href="<?= site_url('articles/show/'.$article['id']) ?>" class="btn btn-outline-primary btn-sm">
                                Read More
                            </a>
                            <!-- <a href="<?= site_url('articles/edit/'.$article['id']) ?>" class="btn btn-outline-warning btn-sm">
                                Edit
                            </a>
                            <a href="<?= site_url('articles/delete/'.$article['id']) ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">
                                Delete
                            </a> -->
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No articles available.</div>
    <?php endif; ?>
</div>

</body>
</html>
