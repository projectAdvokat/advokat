<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? $title : 'Dashboard Lawyer - Advokat Online' ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #16a34a;
      --primary-hover: #15803d;
      --sidebar-width: 280px;
      --sidebar-collapsed-width: 80px;
      --header-height: 70px;
      --transition-speed: 0.3s;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8fafc;
      color: #1f2937;
      overflow-x: hidden;
    }
    
    /* Sidebar Styles */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: var(--sidebar-width);
      background: linear-gradient(180deg, #1a1f24 0%, #2d3748 100%);
      color: #fff;
      padding: 1.5rem 0;
      transition: all var(--transition-speed) ease;
      z-index: 1000;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .sidebar-header {
      padding: 0 1.5rem 2rem;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      margin-bottom: 1rem;
    }
    
    .sidebar-brand {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      color: white;
      text-decoration: none;
      font-size: 1.25rem;
      font-weight: 700;
    }
    
    .sidebar-brand-icon {
      width: 40px;
      height: 40px;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
    }
    
    .sidebar-nav {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .sidebar-nav-item {
      margin-bottom: 0.5rem;
      padding: 0 1rem;
    }
    
    .sidebar-nav-link {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      color: #cbd5e0;
      text-decoration: none;
      padding: 0.875rem 1rem;
      border-radius: 12px;
      transition: all 0.3s ease;
      font-weight: 500;
    }
    
    .sidebar-nav-link:hover {
      background: rgba(255, 255, 255, 0.1);
      color: white;
      transform: translateX(5px);
    }
    
    .sidebar-nav-link.active {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
      color: white;
      box-shadow: 0 4px 12px rgba(22, 163, 74, 0.3);
    }
    
    .sidebar-nav-link i {
      width: 20px;
      text-align: center;
      font-size: 1.1rem;
    }
    
    .sidebar-footer {
      position: absolute;
      bottom: 2rem;
      left: 0;
      right: 0;
      padding: 0 1.5rem;
    }
    
    .user-profile {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      padding: 1rem;
      background: rgba(255, 255, 255, 0.05);
      border-radius: 12px;
    }
    
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
    }
    
    .user-info {
      flex: 1;
    }
    
    .user-name {
      font-weight: 600;
      font-size: 0.9rem;
      color: white;
    }
    
    .user-role {
      font-size: 0.75rem;
      color: #a0aec0;
    }
    
    /* Main Content Styles */
    .main-content {
      margin-left: var(--sidebar-width);
      transition: margin-left var(--transition-speed) ease;
      min-height: 100vh;
    }
    
    .top-header {
      position: sticky;
      top: 0;
      background: white;
      border-bottom: 1px solid #e5e7eb;
      padding: 1rem 2rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
      z-index: 100;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .page-title {
      font-size: 1.5rem;
      font-weight: 700;
      color: #1f2937;
    }
    
    .header-actions {
      display: flex;
      align-items: center;
      gap: 1rem;
    }
    
    .notification-badge {
      position: relative;
      cursor: pointer;
    }
    
    .notification-badge .badge {
      position: absolute;
      top: -5px;
      right: -5px;
      background: #ef4444;
      color: white;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      font-size: 0.7rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .content-wrapper {
      padding: 2rem;
    }
    
    /* Card Styles */
    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
      background: white;
    }
    
    .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }
    
    /* Responsive Styles */
    @media (max-width: 992px) {
      .sidebar {
        transform: translateX(-100%);
        width: var(--sidebar-width);
      }
      
      .sidebar.active {
        transform: translateX(0);
      }
      
      .main-content {
        margin-left: 0;
      }
      
      .menu-toggle {
        display: block !important;
      }
    }
    
    @media (max-width: 768px) {
      .content-wrapper {
        padding: 1rem;
      }
      
      .top-header {
        padding: 1rem;
      }
      
      .page-title {
        font-size: 1.25rem;
      }
    }
    
    @media (max-width: 576px) {
      .sidebar {
        width: 100%;
      }
      
      .header-actions {
        gap: 0.5rem;
      }
    }
    
    /* Menu Toggle Button */
    .menu-toggle {
      display: none;
      background: none;
      border: none;
      color: #4b5563;
      font-size: 1.5rem;
      cursor: pointer;
    }
    
    /* Animation Classes */
    .sidebar.collapsed {
      width: var(--sidebar-collapsed-width);
    }
    
    .sidebar.collapsed .sidebar-brand span,
    .sidebar.collapsed .sidebar-nav-link span,
    .sidebar.collapsed .user-info {
      display: none;
    }
    
    .sidebar.collapsed .sidebar-nav-link {
      justify-content: center;
      padding: 0.875rem 0;
    }
    
    .sidebar.collapsed .main-content {
      margin-left: var(--sidebar-collapsed-width);
    }
    
    /* Custom Scrollbar */
    .sidebar::-webkit-scrollbar {
      width: 6px;
    }
    
    .sidebar::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.1);
    }
    
    .sidebar::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.3);
      border-radius: 3px;
    }
    
    .sidebar::-webkit-scrollbar-thumb:hover {
      background: rgba(255, 255, 255, 0.5);
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <a href="<?= base_url('dashboard') ?>" class="sidebar-brand">
        <div class="sidebar-brand-icon">
          <i class="fas fa-scale-balanced"></i>
        </div>
        <span>Advokat Online</span>
      </a>
    </div>
    
    <ul class="sidebar-nav">
      <!-- <li class="sidebar-nav-item">
        <a href="<?= base_url('dashboard') ?>" 
           class="sidebar-nav-link <?= ($this->uri->segment(1) == 'dashboard' && $this->uri->segment(2) == '') ? 'active' : '' ?>">
          <i class="fas fa-home"></i>
          <span>Dashboard</span>
        </a>
      </li> -->


      <?php if ($this->load->session->userdata('user_role')==='admin'):?>

        <li class="sidebar-nav-item">
          <a href="<?= base_url('dashboard/users') ?>" 
             class="sidebar-nav-link <?= ($this->uri->segment(2) == 'users') ? 'active' : '' ?>">
            <i class="fas fa-newspaper"></i>
            <span>Users</span>
          </a>
        </li>
      
      <?php endif;?>

      <li class="sidebar-nav-item">
        <a href="<?= base_url('dashboard/articles') ?>" 
           class="sidebar-nav-link <?= ($this->uri->segment(2) == 'articles') ? 'active' : '' ?>">
          <i class="fas fa-newspaper"></i>
          <span>Artikel</span>
        </a>
      </li>
      <li class="sidebar-nav-item">
        <a href="<?= base_url('dashboard/chats') ?>" 
           class="sidebar-nav-link <?= ($this->uri->segment(2) == 'chats') ? 'active' : '' ?>">
          <i class="fas fa-comments"></i>
          <span>Chat</span>
          <span class="badge bg-danger ms-auto"></span>
        </a>
      </li>
      <li class="sidebar-nav-item">
        <a href="<?= base_url('dashboard/wallet/' . $this->session->userdata['user_id']) ?>" 
           class="sidebar-nav-link <?= ($this->uri->segment(2) == 'wallet') ? 'active' : '' ?>">
          <i class="fas fa-comments"></i>
          <span>Wallet</span>
          <span class="badge bg-danger ms-auto"></span>
        </a>
      </li>
      
    </ul>
    
    <div class="sidebar-footer">
      <div class="user-profile">
      <a href="<?= base_url('dashboard/profile') ?>" class="text-decoration-none">
        <div class="user-avatar">
          <?= strtoupper(substr($this->session->userdata('user_name'), 0, 1)) ?>
        </div>
      </a>
        <div class="user-info">
          <div class="user-name"><?= $this->session->userdata('user_name') ?></div>
          <div class="user-role"><?= $this->session->userdata('user_role') ?></div>
        </div>
        <a href="<?= base_url('logout') ?>" class="text-white" title="Logout">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </div>
      </a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content" id="mainContent">
    <!-- Top Header -->
    <div class="top-header">
      <div class="d-flex align-items-center">
        <button class="menu-toggle me-3" id="menuToggle">
          <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title"><?= isset($page_title) ? $page_title : 'Dashboard' ?></h1>
      </div>
      
     
    </div>
    
    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <?php $this->load->view($content); ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');
      const menuToggle = document.getElementById('menuToggle');
      
      // Toggle sidebar on mobile
      menuToggle.addEventListener('click', function() {
        sidebar.classList.toggle('active');
      });
      
      // Close sidebar when clicking outside on mobile
      document.addEventListener('click', function(event) {
        if (window.innerWidth < 992) {
          const isClickInsideSidebar = sidebar.contains(event.target);
          const isClickInsideToggle = menuToggle.contains(event.target);
          
          if (!isClickInsideSidebar && !isClickInsideToggle && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
          }
        }
      });
      
      // Handle window resize
      window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
          sidebar.classList.remove('active');
        }
      });
      
      // Add active class based on current URL
      const currentPath = window.location.pathname;
      const navLinks = document.querySelectorAll('.sidebar-nav-link');
      
      navLinks.forEach(link => {
        if (link.href.includes(currentPath)) {
          link.classList.add('active');
        }
      });
    });
  </script>
</body>
</html>