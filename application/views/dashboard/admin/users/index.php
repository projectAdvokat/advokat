<div class="container-fluid" data-baseurl="<?= base_url();?>">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-2">User Management</h1>
            <p class="text-muted">Kelola semua pengguna sistem Advokat Online</p>
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
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($users) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                Active Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($users, function($user) { return $user['status'] === 'active'; })) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Banned Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($users, function($user) { return $user['status'] === 'banned'; })) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-slash fa-2x text-gray-300"></i>
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
                                Lawyers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($users, function($user) { return $user['role'] === 'lawyer'; })) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-gavel fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
            <div class="d-flex gap-2">
                <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Cari pengguna...">
                <select id="roleFilter" class="form-select form-select-sm">
                    <option value="">Semua Role</option>
                    <option value="admin">Admin</option>
                    <option value="lawyer">Lawyer</option>
                    <option value="client">Client</option>
                </select>
                <select id="statusFilter" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="active">Active</option>
                    <option value="banned">Banned</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm me-3">
                                        <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                            <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold"><?= htmlspecialchars($user['name']) ?></div>
                                        <small class="text-muted">ID: <?= $user['id'] ?></small>
                                    </div>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="badge 
                                    <?= $user['role'] === 'admin' ? 'bg-danger' : '' ?>
                                    <?= $user['role'] === 'lawyer' ? 'bg-success' : '' ?>
                                    <?= $user['role'] === 'client' ? 'bg-info' : '' ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge 
                                    <?= $user['status'] === 'active' ? 'bg-success' : 'bg-danger' ?>">
                                    <?= ucfirst($user['status']) ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                        data-bs-toggle="modal" data-bs-target="#editUserModal" 
                                        data-user-id="<?= $user['id'] ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <?php if ($user['status'] === 'active'): ?>
                                        <button type="button" class="btn btn-sm btn-outline-warning ban-user" 
                                            data-user-id="<?= $user['id'] ?>" data-user-name="<?= htmlspecialchars($user['name']) ?>">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-outline-success unban-user" 
                                            data-user-id="<?= $user['id'] ?>" data-user-name="<?= htmlspecialchars($user['name']) ?>">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    <?php endif; ?>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-danger delete-user" 
                                        data-user-id="<?= $user['id'] ?>" data-user-name="<?= htmlspecialchars($user['name']) ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addUserForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="lawyer">Lawyer</option>
                            <option value="client">Client</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm">
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="editUserId">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" id="editUserName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="editUserEmail" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role" id="editUserRole" required>
                            <option value="admin">Admin</option>
                            <option value="lawyer">Lawyer</option>
                            <option value="client">Client</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="status" id="editUserStatus" required>
                            <option value="active">Active</option>
                            <option value="banned">Banned</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
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

.border-left-warning {
    border-left: 4px solid #f6c23e !important;
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
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
     
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');
    const table = document.getElementById('usersTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    function filterTable() {
        const searchText = searchInput.value.toLowerCase();
        const roleValue = roleFilter.value;
        const statusValue = statusFilter.value;

        for (let i = 0; i < rows.length; i++) {
            const name = rows[i].cells[1].textContent.toLowerCase();
            const email = rows[i].cells[2].textContent.toLowerCase();
            const role = rows[i].cells[3].textContent.toLowerCase();
            const status = rows[i].cells[4].textContent.toLowerCase();

            const matchesSearch = name.includes(searchText) || email.includes(searchText);
            const matchesRole = roleValue === '' || role.includes(roleValue);
            const matchesStatus = statusValue === '' || status.includes(statusValue);

            rows[i].style.display = matchesSearch && matchesRole && matchesStatus ? '' : 'none';
        }
    }

    searchInput.addEventListener('input', filterTable);
    roleFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);

    // Ban/Unban user
    document.querySelectorAll('.ban-user, .unban-user').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;
            const isBanAction = this.classList.contains('ban-user');

            document.getElementById('confirmationModalTitle').textContent = 
                isBanAction ? 'Ban User' : 'Unban User';
            document.getElementById('confirmationModalBody').innerHTML = 
                `Apakah Anda yakin ingin <strong>${isBanAction ? 'ban' : 'unban'}</strong> user <strong>${userName}</strong>?`;
            
            document.getElementById('confirmAction').onclick = function() {
                // AJAX request to ban/unban user
                fetch(`<?= base_url('api/admin/')?>${isBanAction ? 'ban_user' : 'unban_user'}/${userId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan');
                });
            };

            new bootstrap.Modal(document.getElementById('confirmationModal')).show();
        });
    });

    // Delete user
    document.querySelectorAll('.delete-user').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;

            document.getElementById('confirmationModalTitle').textContent = 'Hapus User';
            document.getElementById('confirmationModalBody').innerHTML = 
                `Apakah Anda yakin ingin menghapus user <strong>${userName}</strong>? Tindakan ini tidak dapat dibatalkan!`;
            
            document.getElementById('confirmAction').onclick = function() {
                console.log(userId)
                // AJAX request to delete user
                fetch(`<?=base_url('users/delete/')?>${userId}`, {
                    method: 'POST',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == 'success') {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan');
                });
            };

            new bootstrap.Modal(document.getElementById('confirmationModal')).show();
        });
    });

    // Edit user modal
    const editUserModal = document.getElementById('editUserModal');
    editUserModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const userId = button.dataset.userId;
        
        // Load user data via AJAX
        fetch(`<?=base_url('users/view/')?>${userId}`)
            .then(response => response.json())
            .then(data => {

                const user = data.data
                document.getElementById('editUserId').value = user.id;
                document.getElementById('editUserName').value = user.name;
                document.getElementById('editUserEmail').value = user.email;
                document.getElementById('editUserRole').value = user.role;
                document.getElementById('editUserStatus').value = user.status;
            });
    });

    // Form submissions
    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const userId = formData.get('user_id');
    
    // Konversi FormData ke object JSON
    const jsonData = {};
    formData.forEach((value, key) => {
        jsonData[key] = value;
    });
    
    // Tampilkan loading state
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    submitButton.disabled = true;
    
    fetch(`<?= base_url('users/update/') ?>${userId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(jsonData)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.status==='success') {
            // Tampilkan pesan sukses
            alert('Data user berhasil diperbarui!');
            
            // Tutup modal
            const modal = bootstrap.Modal.getInstance(editUserModal);
            modal.hide();
            
            // Refresh halaman atau update tabel
            location.reload();
        } else {
            throw new Error(data.message || 'Terjadi kesalahan saat memperbarui user');
        }
    })
    .catch(error => {
        console.error('Error updating user:', error);
        alert('Gagal memperbarui user: ' + error.message);
    })
    .finally(() => {
        // Kembalikan state tombol ke semula
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
        // Handle edit user form submission
    });
});
</script>