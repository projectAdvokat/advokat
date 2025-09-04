<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Article</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: "Inter", sans-serif;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      border: none;
    }
    .card-body {
      padding: 2rem;
    }
    .form-label {
      font-weight: 600;
    }
    .btn-primary {
      background: #16a34a;
      border: none;
    }
    .btn-primary:hover {
      background: #15803d;
    }
    textarea {
      resize: vertical;
    }
  </style>
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="card">
        <div class="card-body">
          <h2 class="mb-4 text-center">✍️ Create New Article</h2>

          <!-- Flash messages -->
          <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
          <?php endif; ?>
          <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
          <?php endif; ?>

          <?= form_open_multipart('dashboard/articles/store') ?>

            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="slug" class="form-label">Slug</label>
              <input type="text" id="slug" name="slug" class="form-control" required>
              <div class="form-text">Slug biasanya huruf kecil dipisah dengan tanda minus (-)</div>
            </div>

            <div class="mb-3">
              <label for="coverUrl" class="form-label">Cover Image</label>
              <input type="file" id="coverUrl" name="coverUrl" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
              <label for="excerpt" class="form-label">Excerpt</label>
              <textarea id="excerpt" name="excerpt" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
              <label for="body" class="form-label">Body</label>
              <textarea id="body" name="body" class="form-control" rows="6" required></textarea>
            </div>

            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <select id="status" name="status" class="form-select">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="published_at" class="form-label">Published At</label>
              <input type="datetime-local" id="published_at" name="published_at" class="form-control">
            </div>

            <div class="d-flex justify-content-between mt-4">
              <a href="<?= site_url('dashboard/articles') ?>" class="btn btn-outline-secondary">
                ← Back
              </a>
              <button type="submit" class="btn btn-primary">
                Save Article
              </button>
            </div>

          <?= form_close() ?>

        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Auto-generate slug from title
  function slugify(text) {
    return text.toString().toLowerCase()
      .replace(/\s+/g, '-')     
      .replace(/[^\w\-]+/g, '') 
      .replace(/\-\-+/g, '-')   
      .replace(/^-+/, '')       
      .replace(/-+$/, '');      
  }

  document.getElementById('title').addEventListener('input', function() {
    const slugInput = document.getElementById('slug');
    if (!slugInput.dataset.modified) {
      slugInput.value = slugify(this.value);
    }
  });

  document.getElementById('slug').addEventListener('input', function() {
    this.dataset.modified = true;
  });
</script>
</body>
</html>
