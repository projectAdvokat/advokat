<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= isset($title) ? $title : 'Dashboard Lawyer' ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-dyZbbd1E5CazU5hJ+e2aKaYZ8lvLj/rD7e0cY5NjzyF7rA1/8iZrZ2vFZka9XsV0t5v+UO3k3k6f9o0q6Gzq3A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: 'Segoe UI', sans-serif; }
    .sidebar {
      height: 100vh;
      background: #212529;
      color: #fff;
      padding-top: 20px;
      position: fixed;
      width: 250px;
    }
    .sidebar a {
      color: #adb5bd;
      text-decoration: none;
      display: block;
      padding: 12px 20px;
      border-radius: 8px;
      margin: 5px 10px;
    }
    .sidebar a:hover { background: #495057; color: #fff; }
    .sidebar .active { background: #0d6efd; color: #fff; }
    .content { margin-left: 260px; padding: 20px; }
    .card { border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center mb-4">Lawyer Dashboard</h4>
    <a href="<?= base_url('/dashboard/articles') ?>" 
       class="<?= ($this->uri->segment(1) == '/dashboard/articles') ? 'active' : '' ?>">Articles</a>
    <a href="<?= base_url('notification') ?>" 
       class="<?= ($this->uri->segment(1) == 'notification') ? 'active' : '' ?>">Notifications</a>
    <a href="<?= base_url('chat') ?>" 
       class="<?= ($this->uri->segment(1) == 'chat') ? 'active' : '' ?>">Chat</a>
  </div>

  <!-- Content -->
  <div class="content">
    <?php $this->load->view($content); ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
