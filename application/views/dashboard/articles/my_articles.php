<div class="d-flex justify-content-between align-items-center mb-4">
  <h2>Articles</h2>
  <a href="articles/create" class="btn btn-primary">+ Add Article</a>
</div>

<div class="row">
  <?php if(!empty($articles)): ?>
    <?php foreach($articles as $index => $article): ?>
      <div class="col-md-4">
        <div class="card p-3 mb-3">
          <h5><?= $article['title']; ?></h5>
          <p><?= $article['body']; ?></p>
          <div class="d-flex gap-1">
            <!-- Tombol Edit besar dan lebar -->
            <a href="articles/edit/<?= $article['slug']; ?>" class="btn btn-outline-primary flex-grow-1 py-2">
              Edit
            </a>

            <!-- Tombol Hapus dengan ikon -->
            <form action="delete/<?= $article['slug']; ?>" method="get" onsubmit="return confirm('Are you sure you want to delete this article?');">
              <button type="submit" class="btn btn-outline-danger d-flex align-items-center justify-content-center px-4 py-2">
                <i class="fas fa-trash-alt"></i>"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>

