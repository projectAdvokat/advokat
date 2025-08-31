<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body class="min-h-screen bg-base-200 flex items-center justify-center">

  <div class="card w-full max-w-md shadow-xl bg-base-100 p-6">
    <h2 class="text-2xl font-bold text-center mb-4">Register</h2>

    <form id="registerForm" class="space-y-3">
      <input type="text" id="name" placeholder="Nama Lengkap" class="input input-bordered w-full" required />
      <input type="email" id="email" placeholder="Email" class="input input-bordered w-full" required />
      <input type="text" id="phone" placeholder="Nomor Telepon" class="input input-bordered w-full" required />

      <select id="role" class="select select-bordered w-full" required>
        <option value="" disabled selected>Pilih Role</option>
        <option value="user">User</option>
        <option value="lawyer">Lawyer</option>
      </select>

      <input type="password" id="password" placeholder="Password" class="input input-bordered w-full" required />

      <button type="submit" class="btn btn-primary w-full">Daftar</button>
    </form>

    <div id="message" class="mt-4 text-center"></div>
  </div>

  <script>
    document.getElementById("registerForm").addEventListener("submit", async function(e) {
      e.preventDefault();

      const payload = {
        name: document.getElementById("name").value,
        email: document.getElementById("email").value,
        phone: document.getElementById("phone").value,
        role: document.getElementById("role").value,
        password: document.getElementById("password").value,
      };

      try {
        const res = await fetch("<?= site_url('api/auth/register') ?>", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(payload)
        });

        const data = await res.json();
        const msgEl = document.getElementById("message");

        if (data.status) {
          msgEl.innerHTML = `<p class="text-green-600">✅ ${data.message}. Silakan login.</p>`;
          // redirect ke halaman login jika mau:
          window.location.href = "<?= site_url('auth/login') ?>";
        } else {
          msgEl.innerHTML = `<p class="text-red-600">❌ ${data.message}</p>`;
        }
      } catch (err) {
        document.getElementById("message").innerHTML = `<p class="text-red-600">⚠️ Terjadi error koneksi</p>`;
      }
    });
  </script>

</body>
</html>
