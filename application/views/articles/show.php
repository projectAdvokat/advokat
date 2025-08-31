
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
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="fw-bold"><?= $article['title'] ?></h2>
            <p class="text-muted small mb-4">
                By <?= $article['author_name'] ?> | <?= date('d M Y', strtotime($article['published_at'])) ?>
            </p>
            <div class="content mb-4">
                <?= $article['body'] ?>
            </div>
            <a href="<?= site_url('articles') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Articles
            </a>
        </div>
    </div>
</div>

</body>
</html>
