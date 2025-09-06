<div class="container mt-4">

  <!-- Header -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-2">
    <h2 class="mb-0">Articles</h2>
    <a href="create" class="btn btn-primary">+ Add Article</a>
  </div>

  <!-- Articles Grid -->
  <div class="row g-3">
    <?php if (!empty($articles)): ?>
      <?php foreach ($articles as $article): ?>
        <div class="col-12 col-sm-6 col-md-4">
          <div class="card h-100 shadow-sm">
            
            <!-- Cover Image -->
            <?php if (!empty($article['cover_url'])): ?>
              <div class="position-relative">
                <img src="<?= base_url('uploads/articles/'.$article['cover_url']); ?>" 
                    class="card-img-top" 
                    style="height: 200px; object-fit: cover;" 
                    alt="<?= htmlspecialchars($article['title']); ?>">

                <!-- Tombol Edit -->
                <a href="<?= site_url('dashboard/articles/edit/'.$article['slug']); ?>" 
                  class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 shadow-sm" 
                  title="Edit Artikel">
                  <i class="fas fa-edit"></i>
                </a>
              </div>
              <?php else: ?>
                <a href="<?= site_url('dashboard/articles/edit/'.$article['slug']); ?>" 
                  class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 shadow-sm" 
                  title="Edit Artikel">
                  <i class="fas fa-edit"></i>
                </a>
            <?php endif; ?>

            
            <!-- Card Body -->
            <div class="card-body d-flex flex-column">
              <h5 class="card-title"><?= htmlspecialchars($article['title']); ?></h5>
              <p class="card-text text-muted small mb-3">
                <?= substr(strip_tags($article['excerpt']), 0, 100); ?>...
              </p>

              <!-- Action Buttons -->
              <div class="mt-auto d-flex justify-content-between gap-2">
                <a href="<?= site_url('articles/show/'.$article['id']); ?>" 
                   class="btn btn-sm btn-primary flex-fill">Baca Selengkapnya</a>
                
                <form action="delete/<?= $article['slug']; ?>" 
                      method="get" 
                      onsubmit="return confirm('Are you sure you want to delete this article?');"
                      class="flex-fill">
                  <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </form>
              </div>
            </div>

          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12">
        <div class="alert alert-info text-center">Belum ada artikel.</div>
      </div>
    <?php endif; ?>
  </div>

  <!-- Pagination -->
  <div class="mt-4 d-flex justify-content-center">
    <?= $pagination; ?>
  </div>
</div>
