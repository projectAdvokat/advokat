<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | Sistem</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    :root {
      --primary-color: #4f46e5;
      --primary-hover: #4338ca;
      --secondary-color: #f3f4f6;
    }
    
    body {
      background: linear-gradient(135deg,#4ade80 0%,#15803d 100%);
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .login-container {
      transition: all 0.3s ease;
    }
    
    .card {
      backdrop-filter: blur(10px);
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 16px;
      overflow: hidden;
    }
    
    .input-group {
      transition: all 0.3s ease;
    }
    
    .input-group:focus-within {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    }
    
    .social-btn {
      transition: all 0.3s ease;
    }
    
    .social-btn:hover {
      transform: translateY(-2px);
    }
    
    .floating-label {
      position: relative;
      margin-bottom: 20px;
    }
    
    .floating-input {
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 16px 12px;
      font-size: 16px;
      transition: all 0.3s ease;
      background: #fff;
    }
    
    .floating-input:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
    }
    
    .floating-label-text {
      position: absolute;
      top: 50%;
      left: 12px;
      transform: translateY(-50%);
      background: #fff;
      padding: 0 4px;
      transition: all 0.3s ease;
      pointer-events: none;
      color: #777;
    }
    
    .floating-input:focus + .floating-label-text,
    .floating-input:not(:placeholder-shown) + .floating-label-text {
      top: 0;
      font-size: 12px;
      color: var(--primary-color);
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
      animation: fadeIn 0.6s ease-out forwards;
    }
    
    .password-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #777;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
  <div class="login-container w-full max-w-md animate-fade-in">
    <div class="card shadow-2xl">
      <div class="card-body p-6 sm:p-8">
        <div class="text-center mb-6">
          <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
            <i class="fas fa-user-lock text-3xl text-green-600"></i>
          </div>
          <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Masuk ke Akun</h1>
          <p class="text-gray-600 mt-2">Selamat datang kembali, silakan masuk ke akun Anda</p>
        </div>

        <form method="post" action="<?= site_url('AuthPage/filter') ?>" class="space-y-5 mt-6">
          <div class="floating-label">
            <input type="email" name="email" class="floating-input w-full" placeholder=" " required>
            <label class="floating-label-text">Alamat Email</label>
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
              <!-- <i class="fas fa-envelope"></i> -->
            </div>
          </div>

          <div class="floating-label relative">
            <input type="password" name="password" id="password" class="floating-input w-full pr-10" placeholder=" " required>
            <label class="floating-label-text">Kata Sandi</label>
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
              <!-- <i class="fas fa-lock"></i> -->
            </div>
            <span class="password-toggle" id="passwordToggle">
              <!-- <i class="fas fa-eye"></i> -->
            </span>
          </div>

          
          <button class="btn btn-success w-full mt-4 py-3 text-lg rounded-xl transition-all duration-300 hover:shadow-lg">
            <i class="fas fa-sign-in-alt mr-2"></i> Masuk
          </button>
        </form>

       
        
        <?php 
          $CI =& get_instance(); 
          if($CI->session->userdata('user_name')): 
        ?>
          <div class="alert alert-success mt-6 shadow-lg">
            <div>
              <i class="fas fa-check-circle"></i>
              <span>Selamat datang, <span class="font-semibold"><?= $CI->session->userdata('user_name'); ?></span></span>
            </div>
          </div>
        <?php endif; ?>

        <p class="text-center mt-6 text-gray-700">
          Belum punya akun?
          <a href="<?= site_url('register') ?>" class="text-green-600 font-medium hover:text-green-800 hover:underline transition-colors">Daftar sekarang</a>
        </p>
      </div>
    </div>
    
    <p class="text-center text-white mt-6 text-sm opacity-90">
      &copy; <?= date('Y'); ?> Advokat Online. All rights reserved.
    </p>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Toggle password visibility
      const passwordToggle = document.getElementById('passwordToggle');
      const passwordInput = document.getElementById('password');
      
      if (passwordToggle && passwordInput) {
        passwordToggle.addEventListener('click', function() {
          if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordToggle.innerHTML = '<i class="fas fa-eye-slash"></i>';
          } else {
            passwordInput.type = 'password';
            passwordToggle.innerHTML = '<i class="fas fa-eye"></i>';
          }
        });
      }
      
      // Add floating label functionality
      const floatingInputs = document.querySelectorAll('.floating-input');
      floatingInputs.forEach(input => {
        // Check on page load if input has value
        if (input.value) {
          input.classList.add('has-value');
        }
        
        input.addEventListener('focus', () => {
          input.classList.add('focused');
        });
        
        input.addEventListener('blur', () => {
          if (!input.value) {
            input.classList.remove('focused');
          }
        });
      });
    });
  </script>
</body>
</html>