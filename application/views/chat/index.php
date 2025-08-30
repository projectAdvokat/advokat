<?php
$chat_id  = null;
$chat_start_time = null;
$chat_end_time = null;

// misalnya controller sudah passing $chat_session

$server_time = date('Y-m-d H:i:s');
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <title>Chat Session</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.css" rel="stylesheet" type="text/css" />
</head>
<body class="bg-gray-100 flex flex-col h-screen">

  <!-- Header -->
  <div class="navbar bg-base-200 shadow">
    <div class="flex-1">
      <a class="btn btn-ghost normal-case text-xl">Lawyer Chat</a>
    </div>
    <div class="flex-none">
      <!-- Timer -->
      <div id="timer" class="badge badge-secondary text-lg p-3">--:--</div>
    </div>
  </div>

  <!-- Booking Info -->
  <div class="p-4 bg-white shadow-md">
    <p class="text-sm text-gray-500">Booking ID: <span class="font-bold text-gray-700">#<?= $chat_id ?></span></p>
    <p class="text-sm text-gray-500">Lawyer: <span class="font-bold text-gray-700">John Doe</span></p>
  </div>

  <!-- Chat Area -->
  <div id="chatArea" class="flex-1 overflow-y-auto p-4 space-y-3">
    <?php if (!empty($chats)): ?>
      
      <?php foreach ($chats as $msg): ?>
         <?php
                if(  $msg['start_time'] !== null && $msg['end_time'] !== null){
                    $chat_start_time = $msg['start_time'];
                    $chat_end_time = $msg['end_time'];
                }
                ?>

        <div class="chat <?= $msg['sender_id'] == $this->session->userdata('user_id') ? 'chat-end' : 'chat-start' ?>">
          <div class="chat-bubble <?= $msg['sender_id'] == $this->session->userdata('user_id') ? 'chat-bubble-primary' : 'chat-bubble-secondary' ?>">
            <?= htmlspecialchars($msg['text']) ?>
          </div>
          <div class="text-xs text-gray-500 mt-1">
            <?= date('H:i', strtotime($msg['created_at'])) ?>
            
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p class="text-gray-500">Belum ada pesan</p>
    <?php endif; ?>
  </div>

  <!-- Input Area -->
  <form id="chatForm" class="p-4 bg-base-200 flex gap-2" action="<?= site_url('api/chats/'.$chat_id.'/messages') ?>" method="POST">
    <input type="hidden" name="chat_id" value="<?= $chat_id ?>" />
    <input id="messageInput" name="text" type="text" placeholder="Ketik pesan..." class="input input-bordered flex-1" />
    <button type="submit" class="btn btn-primary">Kirim</button>
  </form>

  <script>
    // ambil data dari PHP
    const endTime   = "<?= $chat_end_time ?>";
    const serverTime  = "<?= $server_time ?>";

    if (endTime) {
      const end   = new Date(endTime).getTime();
      let now     = new Date(serverTime).getTime();

      function startCountdown(end, now) {
        let remaining = end - now;
        const timerEl = document.getElementById("timer");

        const interval = setInterval(() => {
          if (remaining <= 0) {
            clearInterval(interval);
            timerEl.textContent = "00:00";
            document.getElementById("chatForm").classList.add("opacity-50", "pointer-events-none");
          } else {
            let minutes = Math.floor((remaining / 1000 / 60));
            let seconds = Math.floor((remaining / 1000) % 60);
            timerEl.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
            remaining -= 1000;
          }
        }, 1000);
      }

      startCountdown(end, now);
    } else {
      document.getElementById("timer").textContent = "--:--";
    }
  </script>
</body>
</html>
