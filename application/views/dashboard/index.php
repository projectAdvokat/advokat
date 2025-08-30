<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Lawyer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
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
    .sidebar a:hover {
      background: #495057;
      color: #fff;
    }
    .sidebar .active {
      background: #0d6efd;
      color: #fff;
    }
    .content {
      margin-left: 260px;
      padding: 20px;
    }
    .card {
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center mb-4">Lawyer Dashboard</h4>
    <a href="#" class="active">Articles</a>
    <a href="#">Notifications</a>
    <a href="#">Chat</a>
  </div>

  <!-- Content -->
  <div class="content">
    <h2 class="mb-4">Welcome, Lawyer 👨‍⚖️</h2>

    <!-- Articles -->
    <div class="card mb-4">
      <div class="card-header bg-primary text-white">Articles</div>
      <div class="card-body">
        <button class="btn btn-success btn-sm mb-3">+ Add Article</button>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $articles = [
                ["id"=>1, "title"=>"Hukum Perdata Dasar", "date"=>"2025-08-20"],
                ["id"=>2, "title"=>"Tips Menghadapi Kasus Perdata", "date"=>"2025-08-21"],
              ];
              foreach ($articles as $a): ?>
              <tr>
                <td><?= $a['id'] ?></td>
                <td><?= $a['title'] ?></td>
                <td><?= $a['date'] ?></td>
                <td>
                  <button class="btn btn-primary btn-sm">Edit</button>
                  <button class="btn btn-danger btn-sm">Delete</button>
                </td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Notifications -->
    <div class="card mb-4">
      <div class="card-header bg-warning">Notifications</div>
      <div class="card-body">
        <?php 
          $notifications = [
            "Client A mengirim pesan baru",
            "Artikel kamu disetujui Admin",
            "Client B memesan konsultasi"
          ];
          foreach ($notifications as $n): ?>
          <div class="alert alert-info mb-2"><?= $n ?></div>
        <?php endforeach ?>
      </div>
    </div>

    <!-- Chat -->
    <div class="card">
      <div class="card-header bg-success text-white">Chat dari Client</div>
      <div class="card-body" style="height:300px; overflow-y:auto;">
        <?php 
          $chats = [
            ["from"=>"Client A", "message"=>"Halo Pak, saya butuh bantuan hukum"],
            ["from"=>"You", "message"=>"Baik, bisa ceritakan detailnya?"],
            ["from"=>"Client A", "message"=>"Terkait perjanjian kontrak kerja..."],
          ];
          foreach ($chats as $c): ?>
          <div class="mb-2">
            <strong><?= $c['from'] ?>:</strong> <?= $c['message'] ?>
          </div>
        <?php endforeach ?>
      </div>
      <div class="card-footer">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Tulis pesan...">
          <button class="btn btn-success">Kirim</button>
        </div>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
