<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Article</title>
  <!-- wajib untuk responsive -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .card {
      border-radius: 1rem;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .form-label {
      font-weight: 600;
    }
  </style>
</head>
<body>
<div class="container py-5">
  <div class="row justify-content-center">
    <!-- gunakan col-12 supaya full di hp -->
    <div class="col-12 col-md-10 col-lg-8">
      <div class="card p-4">
        <div class="card-body">
          <h2 class="mb-4 text-center">✍️ Create New Article</h2>

          <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
          <?php endif; ?>
          <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
          <?php endif; ?>

          <?= form_open_multipart('dashboard/articles/store') ?>

            <div class="mb-3">
              <label class="form-label">Title</label>
              <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Slug</label>
              <input type="text" id="slug" name="slug" class="form-control" required>
              <div class="form-text">Slug biasanya huruf kecil dipisah dengan tanda minus (-)</div>
            </div>

            <div class="mb-3">
              <label class="form-label">Cover Image</label>
              <input type="file" name="coverUrl" class="form-control" accept="image/*">
            </div>

            <div class="mb-3">
              <label class="form-label">Excerpt</label>
              <textarea name="excerpt" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Body</label>
              <textarea name="body" class="form-control" rows="6" required></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Published At</label>
              <input type="datetime-local" name="published_at" class="form-control">
            </div>

            <div class="d-flex justify-content-between mt-4 flex-wrap gap-2">
              <a href="<?= site_url('dashboard/articles') ?>" class="btn btn-outline-secondary">← Back</a>
              <button type="submit" class="btn btn-primary">Save Article</button>
            </div>

          <?= form_close() ?>

        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
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
