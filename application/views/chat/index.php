<?php
// $chat_id  = null;
$chat = $chats['data']['chat'];
$messages = $chats['data']['messages'];
$chat_id = $chat['id'];
$chat_start_time = $chat['start_time'];
$chat_end_time = $chat['end_time'];
$lawyer = $chats['data']['lawyer'];

// misalnya controller sudah passing $chat_session
$server_time = date('Y-m-d H:i:s');
$current_user_id = $this->session->userdata('user_id');
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chat Session - Advokat Online</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.7.2/dist/full.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    :root {
      --primary-color: #16a34a;
      --primary-hover: #15803d;
    }
    
    body {
      font-family: 'Inter', 'Segoe UI', sans-serif;
      background-color: #f8fafc;
    }
    
    .chat-container {
      height: 100vh;
      display: flex;
      flex-direction: column;
    }
    
    .header {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
      color: white;
      padding: 1rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .booking-info {
      background-color: white;
      padding: 0.75rem 1rem;
      border-bottom: 1px solid #e2e8f0;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }
    
    .chat-area {
      flex: 1;
      overflow-y: auto;
      padding: 1rem;
      background-color: #f1f5f9;
      background-image: 
        radial-gradient(#cbd5e1 1px, transparent 1px),
        radial-gradient(#cbd5e1 1px, transparent 1px);
      background-size: 30px 30px;
      background-position: 0 0, 15px 15px;
    }
    
    .chat-message {
      max-width: 80%;
      margin-bottom: 1.25rem;
      animation: fadeIn 0.3s ease-out;
    }
    
    .user-message {
      margin-left: auto;
    }
    
    .lawyer-message {
      margin-right: auto;
    }
    
    .message-bubble {
      padding: 0.75rem 1rem;
      border-radius: 1.125rem;
      position: relative;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }
    
    .user-bubble {
      background-color: var(--primary-color);
      color: white;
      border-bottom-right-radius: 0.25rem;
    }
    
    .lawyer-bubble {
      background-color: white;
      color: #334155;
      border: 1px solid #e2e8f0;
      border-bottom-left-radius: 0.25rem;
    }
    
    .message-time {
      font-size: 0.75rem;
      margin-top: 0.25rem;
      opacity: 0.8;
    }
    
    .input-area {
      background-color: white;
      padding: 1rem;
      border-top: 1px solid #e2e8f0;
      box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
    }
    
    .message-input {
      border-radius: 1.5rem;
      padding: 0.75rem 1.25rem;
      border: 1px solid #e2e8f0;
      transition: all 0.3s ease;
    }
    
    .message-input:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }
    
    .send-button {
      border-radius: 50%;
      width: 50px;
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s ease;
    }
    
    .send-button:hover {
      transform: scale(1.05);
    }
    
    .timer-badge {
      background-color: white;
      color: var(--primary-color);
      padding: 0.5rem 1rem;
      border-radius: 1.5rem;
      font-weight: 600;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .lawyer-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 0.75rem;
    }
    
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }
    
    .timer-warning {
      animation: pulse 1s infinite;
      background-color: #ef4444;
      color: white;
    }
    
    /* Scrollbar styling */
    .chat-area::-webkit-scrollbar {
      width: 6px;
    }
    
    .chat-area::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 10px;
    }
    
    .chat-area::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 10px;
    }
    
    .chat-area::-webkit-scrollbar-thumb:hover {
      background: #94a3b8;
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
      .chat-message {
        max-width: 90%;
      }
      
      .header h1 {
        font-size: 1.25rem;
      }
      
      .message-input {
        padding: 0.6rem 1rem;
      }
      
      .send-button {
        width: 45px;
        height: 45px;
      }
    }
    
    @media (max-width: 480px) {
      .chat-area {
        padding: 0.75rem;
      }
      
      .input-area {
        padding: 0.75rem;
      }
      
      .booking-info {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
      }
    }
  </style>
</head>
<body>
  <div class="chat-container">
    <!-- Header -->
    <header class="header flex justify-between items-center">
      <div class="flex items-center">
        <a href="<?= site_url('dashboard') ?>" class="btn btn-ghost btn-circle text-white">
          <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-xl font-semibold ml-2">Konsultasi Hukum</h1>
      </div>
      <div id="timer" class="timer-badge flex items-center">
        <i class="fas fa-clock mr-2"></i>
        <span>--:--</span>
      </div>
    </header>

    <!-- Booking Info -->
    <div class="booking-info flex items-center justify-between">
      <div class="flex items-center">
        <div class="lawyer-avatar bg-green-500 text-white flex items-center justify-center font-semibold">
          <?= substr($lawyer['user']['name'], 0, 1) ?>
        </div>
        <div>
          <p class="font-semibold"><?= $lawyer['user']['name'] ?></p>
          <p class="text-sm text-gray-500">Advokat</p>
        </div>
      </div>
      <div class="text-right">
        <p class="text-sm text-gray-500">Booking ID</p>
        <p class="font-semibold">#<?= $booking_id ?></p>
      </div>
    </div>

    <!-- Chat Area -->
    <div id="chatArea" class="chat-area">
      <?php if (!empty($messages)): ?>
        <?php foreach ($messages as $msg): ?>
          <div class="chat-message <?= $msg['sender_id'] == $current_user_id ? 'user-message' : 'lawyer-message' ?>">
            <div class="message-bubble <?= $msg['sender_id'] == $current_user_id ? 'user-bubble' : 'lawyer-bubble' ?>">
              <?= htmlspecialchars($msg['text']) ?>
            </div>
            <div class="message-time text-xs mt-1 <?= $msg['sender_id'] == $current_user_id ? 'text-right text-gray-600' : 'text-left text-gray-500' ?>">
              <?= date('H:i', strtotime($msg['created_at'])) ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="flex flex-col items-center justify-center h-full text-gray-500">
          <i class="fas fa-comments text-4xl mb-3 opacity-50"></i>
          <p>Belum ada pesan</p>
          <p class="text-sm mt-1">Mulai percakapan dengan mengirim pesan</p>
        </div>
      <?php endif; ?>
    </div>

    <!-- Input Area -->
    <form id="chatForm" class="input-area flex items-center gap-3" action="<?= site_url('api/chats/'.$chat_id.'/messages') ?>" method="POST">
      <input type="hidden" name="booking_id" value="<?= $chat['booking_id'] ?>" />
      
      <input id="messageInput" name="text" type="text" placeholder="Ketik pesan..." 
             class="message-input flex-1" autocomplete="off" />
      <button type="submit" class="send-button btn btn-primary">
        <i class="fas fa-paper-plane"></i>
      </button>
    </form>
  </div>

  <script>
    // Ambil data dari PHP
    const endTime = "<?= $chat_end_time ?>";
    const serverTime = "<?= $server_time ?>";
    const chatForm = document.getElementById('chatForm');
    const chatArea = document.getElementById('chatArea');
    const messageInput = document.getElementById('messageInput');

    // Fungsi untuk auto scroll ke bawah
    function scrollToBottom() {
      chatArea.scrollTop = chatArea.scrollHeight;
    }

    // Scroll ke bawah saat halaman dimuat
    setTimeout(scrollToBottom, 100);

    if (endTime) {
      const end = new Date(endTime).getTime();
      let now = new Date(serverTime).getTime();

      function startCountdown(end, now) {
        let remaining = end - now;
        const timerEl = document.getElementById("timer");

        const interval = setInterval(() => {
          if (remaining <= 0) {
            clearInterval(interval);
            timerEl.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i><span>Sesi Berakhir</span>';
            timerEl.classList.add('timer-warning');
            
            if (chatForm) {
              chatForm.classList.add("opacity-50", "pointer-events-none");
              messageInput.placeholder = "Sesi konsultasi telah berakhir";
            }
          } else {
            let minutes = Math.floor((remaining / 1000 / 60));
            let seconds = Math.floor((remaining / 1000) % 60);
            
            // Tambahkan warna peringatan jika waktu < 5 menit
            if (minutes < 5) {
              timerEl.classList.add('timer-warning');
            }
            
            timerEl.innerHTML = `<i class="fas fa-clock mr-2"></i><span>${minutes}:${seconds < 10 ? '0' : ''}${seconds}</span>`;
            remaining -= 1000;
          }
        }, 1000);
      }

      startCountdown(end, now);
    } else {
      document.getElementById("timer").innerHTML = '<i class="fas fa-infinity mr-2"></i><span>Tidak Terbatas</span>';
    }

    // Handle form submission
    // if (chatForm) {
    //   chatForm.addEventListener('submit', function(e) {
    //     // e.preventDefault();
        
    //     const formData = new FormData(this);
    //     const message = formData.get('text');
        
    //     if (message.trim() === '') return;
        
    //     // Kirim pesan via AJAX
    //     fetch(this.action, {
    //       method: 'POST',
    //       body: formData,
    //       headers: {
    //         'X-Requested-With': 'XMLHttpRequest'
    //       }
    //     })
    //     .then(response => response.json())
    //     .then(data => {
    //       if (data.success) {
    //         // Clear input
    //         messageInput.value = '';
            
    //         // Reload halaman untuk melihat pesan baru
    //         location.reload();
    //       }
    //     })
    //     .catch(error => {
    //       console.error('Error:', error);
    //     });
    //   });
    // }

    // Auto focus pada input pesan
    if (messageInput) {
      messageInput.focus();
    }
  </script>
</body>
</html>