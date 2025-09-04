<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Article</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-0">Edit Article</h2>
      <a href="<?= site_url('dashboard/articles'); ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
      </a>
    </div>

    <?php if (!empty($article)): ?>
      <form 
            action="<?= base_url('dashboard/articles/update/' . $article['id']) ?>"
            method="POST"
            enctype="multipart/form-data"
            class="card shadow-sm p-4 border-0"
            id="form-data"
            >

        <!-- Title -->
        <div class="mb-3">
          <label for="title" class="form-label">Title</label>
          <input 
            type="text" 
            class="form-control" 
            id="title" 
            name="title" 
            value="<?= htmlspecialchars($article['title']); ?>" 
            required>
        </div>

        <!-- Excerpt -->
        <div class="mb-3">
          <label for="excerpt" class="form-label">Excerpt</label>
          <input 
            type="text" 
            class="form-control" 
            id="excerpt" 
            name="excerpt" 
            value="<?= htmlspecialchars($article['excerpt']); ?>" 
            maxlength="255" 
            required>
          <small class="text-muted">Ringkasan singkat artikel (maks. 255 karakter).</small>
        </div>

        <!-- Body -->
        <div class="mb-3">
          <label for="body" class="form-label">Content</label>
          <textarea 
            class="form-control" 
            id="body" 
            name="body" 
            rows="8" 
            required><?= htmlspecialchars($article['body']); ?></textarea>
        </div>

        <!-- Cover -->
        <div class="mb-3">
          <label for="cover" class="form-label">Cover Image</label>
          <?php if (!empty($article['cover_url'])): ?>
            <div class="mb-3">
              <img src="<?= base_url('uploads/articles/' . $article['cover_url']); ?>" 
                   alt="Cover" 
                   class="img-fluid rounded shadow-sm border" 
                   style="max-height: 250px;">

            </div>
          <?php endif; ?>
            
          <input type="hidden" id="cover_old" value="<?= $article['cover_url']; ?>">
          <input type="file" class="form-control" id="cover" name="cover">
          <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
        </div>

        <!-- Published At -->
        <div class="mb-3">
          <label for="published_at" class="form-label">Published At</label>
          <input 
            type="datetime-local" 
            class="form-control" 
            id="published_at" 
            name="published_at" 
            value="<?= date('Y-m-d\TH:i', strtotime($article['published_at'])); ?>">
          <small class="text-muted">Biarkan kosong jika tidak ingin mengubah waktu publikasi.</small>
        </div>

        <!-- Submit -->
        <div class="d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-success px-4">
            <i class="fas fa-save"></i> Update Article
          </button>
        </div>
      </form>
    <?php else: ?>
      <div class="alert alert-warning text-center">
        Artikel tidak ditemukan.
      </div>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
