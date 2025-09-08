<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- penting buat responsive -->
  <title>Register</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body class="min-h-screen bg-base-200 flex items-center justify-center p-4">

  <div class="card w-full max-w-md shadow-xl bg-base-100 p-6 md:p-8">
    <h2 class="text-2xl font-bold text-center mb-6">Register</h2>
    <?php
    // var_dump($this->input->get('ref'));
    ?>

    <form id="registerForm" class="space-y-4" method="post" action="api/register">
      <input type="text" name="name" id="name" placeholder="Nama Lengkap" class="input input-bordered w-full" required />
      <input type="email" name="email" id="email" placeholder="Email" class="input input-bordered w-full" required />
      <input type="text" name="phone" id="phone" placeholder="Nomor Telepon" class="input input-bordered w-full" required />
  
      <select id="role" name="role" class="select select-bordered w-full" required>
        <option value="" disabled selected>Pilih Role</option>
        <option value="client">Client</option>
        <option value="lawyer">Lawyer</option>
      </select>

      <!-- Extra fields khusus lawyer -->
      <div id="lawyerFields" class="hidden space-y-3">
        <input type="number" name="years_experience" id="years_experience" placeholder="Years of Experience" class="input input-bordered w-full" />
        <input type="text" name="specialties" id="specialties" placeholder="Specialties (e.g. Family, Business)" class="input input-bordered w-full" />
        <input type="number" name="price_30m" id="price_30m" placeholder="Price per 30 Minutes (Rp)" class="input input-bordered w-full" />
        <textarea id="bio" name="bio" placeholder="Short Bio" class="textarea textarea-bordered w-full"></textarea>
      </div>
      
      <input type="password" name="password" id="password" placeholder="Password" class="input input-bordered w-full" required />
      
      <input type="text" name="ref_code" id="ref_code" placeholder="Referral Code (optional)" class="input input-bordered w-full"  />
      <button type="submit" class="btn btn-primary w-full">Daftar</button>
    </form>
    
    <div id="message" class="mt-4 text-center text-sm md:text-base"></div>
  </div>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const roleSelect = document.getElementById("role");
    const lawyerFields = document.getElementById("lawyerFields");
    const msgEl = document.getElementById("message");

    // Toggle field lawyer saat role berubah
    if (roleSelect) {
      roleSelect.addEventListener("change", function () {
        if (this.value === "lawyer") {
          lawyerFields?.classList.remove("hidden");
        } else {
          lawyerFields?.classList.add("hidden");
        }
      });
    }

    // PHP → JS (gunakan json_encode biar aman dari error)
    const status = <?= json_encode($status ?? null) ?>;
    const message = <?= json_encode($message ?? "") ?>;

    if (status !== null) {
      if (status) {
        msgEl.innerHTML = `<p class="text-green-600">✅ ${message}. Silakan login.</p>`;
        // kasih delay 2 detik biar pesan terlihat
        setTimeout(() => {
          window.location.href = "<?= site_url('login') ?>";
        }, 2000);
      } else {
        msgEl.innerHTML = `<p class="text-red-600">❌ ${message}</p>`;
      }
    }
  });
</script>

</body>
</html>
