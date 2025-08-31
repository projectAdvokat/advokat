<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.10/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-base-200 flex items-center justify-center min-h-screen">

<div class="card w-96 bg-base-100 shadow-xl">
  <div class="card-body">
    <h2 class="text-2xl font-bold text-center">Login</h2>
    <form method="post" action="<?= site_url('AuthPage/filter') ?>">
      <div class="form-control">
        <label class="label">Email</label>
        <input type="email" name="email" class="input input-bordered" required>
      </div>
      <div class="form-control">
        <label class="label">Password</label>
        <input type="password" name="password" class="input input-bordered" required>
      </div>
      <button class="btn btn-primary mt-4 w-full">Login</button>
    </form>
<?php 
$CI =& get_instance(); 
echo $CI->session->userdata('user_name');
?>

    <p class="text-center mt-2">Belum punya akun? <a href="<?= site_url('auth/register') ?>" class="text-blue-500">Register</a></p>
  </div>
</div>

</body>
</html>
