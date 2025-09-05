<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2">Pengelolaan Artikel</h1>
            <p class="text-muted">Kelola semua artikel pada sistem Advokat Online</p>
        </div>
        <div>
            <a href="<?= base_url('dashboard/articles/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Artikel
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Artikel</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($articles) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Artikel Aktif</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($articles, function($article) { 
                                    return $article['status'] === 'active'; 
                                })) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-eye fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Artikel Diblokir</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($articles, function($article) { 
                                    return $article['status'] === 'banned'; 
                                })) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-ban fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Admin Articles</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($articles, function($article) { 
                                    return $article['author_role'] === 'admin'; 
                                })) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Articles Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Artikel</h6>
            <div class="d-flex gap-2">
                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cari artikel...">
                <select id="statusFilter" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="active">Active</option>
                    <option value="banned">Banned</option>
                </select>
                <select id="authorFilter" class="form-select form-select-sm">
                    <option value="">Semua Penulis</option>
                    <?php 
                    $authors = array_unique(array_column($articles, 'author_name'));
                    foreach ($authors as $author): 
                    ?>
                        <option value="<?= htmlspecialchars($author) ?>"><?= htmlspecialchars($author) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="articlesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul Artikel</th>
                            <th>Penulis</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Tanggal Publikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $index => $article): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <?= strtoupper(substr($article['title'], 0, 1)) ?>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold"><?= htmlspecialchars($article['title']) ?></div>
                                        <small class="text-muted">
                                            <?= character_limiter(strip_tags($article['excerpt']), 50) ?>
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-2">
                                        <div class="avatar bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                                            <?= strtoupper(substr($article['author_name'], 0, 1)) ?>
                                        </div>
                                    </div>
                                    <?= htmlspecialchars($article['author_name']) ?>
                                </div>
                            </td>
                            <td>
                                <span class="badge 
                                    <?= $article['author_role'] === 'admin' ? 'bg-danger' : '' ?>
                                    <?= $article['author_role'] === 'lawyer' ? 'bg-success' : '' ?>
                                    <?= $article['author_role'] === 'client' ? 'bg-info' : '' ?>">
                                    <?= ucfirst($article['author_role']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge 
                                    <?= $article['status'] === 'active' ? 'bg-success' : 'bg-danger' ?>">
                                    <?= $article['status'] === 'active' ? 'Active' : 'Banned' ?>
                                </span>
                            </td>
                            <td>
                                <?= $article['published_at'] ? date('d M Y', strtotime($article['published_at'])) : 'Belum dipublikasi' ?>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="<?= site_url('article/detail/'.$article['id']) ?>" 
                                       class="btn btn-sm btn-outline-info" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <a href="<?= site_url('dashboard/articles/edit/'.$article['slug']) ?>" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <?php if ($article['status'] !== 'banned'): ?>
                                        <button type="button" class="btn btn-sm btn-outline-warning ban-article" 
                                            data-article-id="<?= $article['id'] ?>" 
                                            data-article-title="<?= htmlspecialchars($article['title']) ?>">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-outline-success unban-article" 
                                            data-article-id="<?= $article['id'] ?>" 
                                            data-article-title="<?= htmlspecialchars($article['title']) ?>">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    <?php endif; ?>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-article" 
                                        data-article-slug="<?= $article['slug'] ?>" 
                                        data-article-title="<?= htmlspecialchars($article['title']) ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>

                    <?= $pagination?>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalTitle">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="confirmationModalBody">
                Apakah Anda yakin ingin melakukan tindakan ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" id="confirmAction">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
}

.badge {
    font-size: 0.75em;
}

.table th {
    font-weight: 600;
    color: #6c757d;
    background-color: #f8f9fa;
}

.btn-group .btn {
    border-radius: 4px;
    margin: 0 2px;
}

.card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.border-left-primary {
    border-left: 4px solid #4e73df !important;
}

.border-left-success {
    border-left: 4px solid #1cc88a !important;
}

.border-left-danger {
    border-left: 4px solid #e74a3b !important;
}

.border-left-info {
    border-left: 4px solid #36b9cc !important;
}

@media (max-width: 768px) {
    .card-header .d-flex {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .btn-group .btn {
        margin: 2px 0;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}

.article-preview {
    max-width: 200px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const authorFilter = document.getElementById('authorFilter');
    const table = document.getElementById('articlesTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    function filterTable() {
        const searchText = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const authorValue = authorFilter.value;

        for (let i = 0; i < rows.length; i++) {
            const title = rows[i].cells[1].textContent.toLowerCase();
            const author = rows[i].cells[2].textContent.toLowerCase();
            const status = rows[i].cells[4].textContent.toLowerCase();

            const matchesSearch = title.includes(searchText);
            const matchesStatus = statusValue === '' || status.includes(statusValue);
            const matchesAuthor = authorValue === '' || author.includes(authorValue.toLowerCase());

            rows[i].style.display = matchesSearch && matchesStatus && matchesAuthor ? '' : 'none';
        }
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    authorFilter.addEventListener('change', filterTable);

    // Ban/Unban article
    document.querySelectorAll('.ban-article, .unban-article').forEach(button => {
        button.addEventListener('click', function() {
            const articleId = this.dataset.articleId;
            const articleTitle = this.dataset.articleTitle;
            const isBanAction = this.classList.contains('ban-article');

            document.getElementById('confirmationModalTitle').textContent = 
                isBanAction ? 'Blokir Artikel' : 'Buka Blokir Artikel';
            document.getElementById('confirmationModalBody').innerHTML = 
                `Apakah Anda yakin ingin <strong>${isBanAction ? 'memblokir' : 'membuka blokir'}</strong> artikel <strong>"${articleTitle}"</strong>?`;
            
            document.getElementById('confirmAction').onclick = function() {
                // AJAX request to ban/unban article
                fetch(`<?= base_url('api/admin/') ?>${isBanAction ? 'ban_article' : 'unban_article'}/${articleId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?= $this->security->get_csrf_hash() ?>'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.ok) {
                        showNotification('success', data.message || 'Artikel berhasil diperbarui');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', error.message);
                });
            };

            new bootstrap.Modal(document.getElementById('confirmationModal')).show();
        });
    });

    // Delete article
    document.querySelectorAll('.delete-article').forEach(button => {
        button.addEventListener('click', function() {
            const articleSlug = this.dataset.articleSlug;
            const articleTitle = this.dataset.articleTitle;

            document.getElementById('confirmationModalTitle').textContent = 'Hapus Artikel';
            document.getElementById('confirmationModalBody').innerHTML = 
                `Apakah Anda yakin ingin menghapus artikel <strong>"${articleTitle}"</strong>? Tindakan ini tidak dapat dibatalkan!`;
            
            document.getElementById('confirmAction').onclick = function() {
                // AJAX request to delete article
                fetch(`<?= base_url('api/articles/delete/') ?>${articleSlug}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?= $this->security->get_csrf_hash() ?>'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showNotification('success', data.message || 'Artikel berhasil dihapus');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('error', error.message);
                });
            };

            new bootstrap.Modal(document.getElementById('confirmationModal')).show();
        });
    });

    // Notification function
    function showNotification(type, message) {
        // Anda bisa menggunakan toast library atau custom notification
        alert(`${type.toUpperCase()}: ${message}`);
    }
});
</script>