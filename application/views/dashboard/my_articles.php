<div class="d-flex justify-content-between align-items-center mb-4">
  <h2>Articles</h2>
  <a href="#" class="btn btn-primary">+ Add Article</a>
</div>

<div class="row">
  <?php for ($i=1; $i<=3; $i++): ?>
  <div class="col-md-4">
    <div class="card p-3 mb-3">
      <h5>Dummy Article <?= $i ?></h5>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
      <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
    </div>
  </div>
  <?php endfor; ?>
</div>
