<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Booking - Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1a7f5c;
            --dark-color: #1e293b;
            --light-color: #ffffff;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
        }
        
        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .page-title {
            color: var(--dark-color);
            font-weight: 700;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 3px solid var(--primary-color);
            display: inline-block;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        
        .card-header {
            background-color: var(--light-color);
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-radius: 10px 10px 0 0 !important;
        }
        
        .table th {
            background-color: #f1f5f9;
            color: var(--dark-color);
            font-weight: 600;
            padding: 0.75rem;
        }
        
        .badge-pending {
            background-color: var(--warning-color);
            color: white;
        }
        
        .badge-paid {
            background-color: var(--success-color);
            color: white;
        }
        
        .badge-cancelled {
            background-color: var(--danger-color);
            color: white;
        }
        
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            border-radius: 4px;
        }
        
        .btn-edit {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        .btn-edit:hover {
            background-color: #146c4a;
            color: white;
        }
        
        .btn-delete {
            background-color: var(--danger-color);
            color: white;
            border: none;
        }
        
        .btn-delete:hover {
            background-color: #dc2626;
            color: white;
        }
        
        .btn-status {
            background-color: #3b82f6;
            color: white;
            border: none;
        }
        
        .btn-status:hover {
            background-color: #2563eb;
            color: white;
        }
        
        .filter-section {
            background-color: var(--light-color);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            padding: 0.5rem 1rem;
        }
        
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .btn-action {
                margin-bottom: 0.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <h1 class="page-title">Manajemen Booking</h1>
        
        <!-- Filter Section -->
        <div class="row filter-section">
            <div class="col-md-3 mb-2">
                <label for="statusFilter" class="form-label">Status</label>
                <select class="form-select" id="statusFilter">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <label for="dateFilter" class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="dateFilter">
            </div>
            <div class="col-md-3 mb-2">
                <label for="clientFilter" class="form-label">Klien</label>
                <input type="text" class="form-control" id="clientFilter" placeholder="Cari nama klien">
            </div>
            <div class="col-md-3 mb-2 d-flex align-items-end">
                <button class="btn btn-primary w-100" id="applyFilter">Terapkan Filter</button>
            </div>
        </div>
        
        <!-- Table Section -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Daftar Booking</span>
                <div>
                  
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="bookingTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Klien</th>
                                <th>Advokat</th>
                                <th>Durasi</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?= $booking['id'] ?></td>
                                <td>
                                    <div><?= $booking['client_name'] ?></div>
                                    <small class="text-muted"><?= $booking['client_email'] ?></small>
                                </td>
                                <td>
                                    <div><?= $booking['lawyer_name'] ?></div>
                                    <small class="text-muted"><?= $booking['lawyer_email'] ?></small>
                                </td>
                                <td><?= $booking['duration_minutes'] ?> menit</td>
                                <td>Rp <?= number_format($booking['price_snapshot'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge <?= $booking['status'] == 'pending' ? 'badge-pending' : ($booking['status'] == 'paid' ? 'badge-paid' : 'badge-cancelled') ?>">
                                        <?= ucfirst($booking['status']) ?>
                                    </span>
                                </td>
                                <td><?= $booking['created_at'] != '0000-00-00 00:00:00' ? date('d M Y H:i', strtotime($booking['created_at'])) : '-' ?></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-action btn-status" data-bs-toggle="modal" data-bs-target="#statusModal" data-id="<?= $booking['id'] ?>" data-status="<?= $booking['status'] ?>">
                                            <i class="fas fa-exchange-alt"></i>
                                        </button>
                                         <button class="btn btn-action btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $booking['id'] ?>">
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

    <!-- Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Status Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('api/booking/updateStatus') ?>" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="statusBookingId">
                        <div class="mb-3">
                            <label for="statusSelect" class="form-label">Status</label>
                            <select class="form-select" id="statusSelect" name="status">
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="cancelled">Cancelled</option>
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

    <!-- Edit Modal -->
    
    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Booking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus booking ini? Tindakan ini tidak dapat dibatalkan.</p>
                    <input type="hidden" id="deleteBookingId">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#bookingTable').DataTable({
                responsive: true,
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ data",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
            
            // Apply filter
            $('#applyFilter').click(function() {
                var status = $('#statusFilter').val();
                var date = $('#dateFilter').val();
                var client = $('#clientFilter').val();
                
                table.column(5).search(status).draw();
                
                if (date) {
                    table.column(6).search(date).draw();
                }
                
                if (client) {
                    table.column(1).search(client).draw();
                }
            });
            
            // Status modal handler
            $('#statusModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var bookingId = button.data('id');
                var status = button.data('status');
                
                var modal = $(this);
                modal.find('#statusBookingId').val(bookingId);
                modal.find('#statusSelect').val(status);
            });
            
            
            // Delete modal handler
            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var bookingId = button.data('id');
                
                var modal = $(this);
                modal.find('#deleteBookingId').val(bookingId);
            });
            
            // Confirm delete
            $('#confirmDelete').click(async function() {
                var bookingId = $('#deleteBookingId').val();
                
                // In a real application, you would make an AJAX request here
                const response = await fetch('<?= base_url('api/booking/delete/') ?>' + bookingId)
                const data = await response.json()
                alert(data.message)
                if(data.ok){
                    location.reload();
                }

            });
        });
    </script>
</body>
</html>