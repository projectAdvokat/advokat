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
      <div id="timer" class="badge badge-secondary text-lg p-3">15:00</div>
    </div>
  </div>

  <!-- Booking Info -->
  <div class="p-4 bg-white shadow-md">
    <p class="text-sm text-gray-500">Booking ID: <span class="font-bold text-gray-700">#1</span></p>
    <p class="text-sm text-gray-500">Lawyer: <span class="font-bold text-gray-700">John Doe</span></p>
  </div>

  <!-- Chat Area -->
  <div id="chatArea" class="flex-1 overflow-y-auto p-4 space-y-3">
    <!-- Example messages -->
    <div class="chat chat-start">
      <div class="chat-bubble">Halo, silahkan ceritakan kronologinya.</div>
    </div>
    <div class="chat chat-end">
      <div class="chat-bubble chat-bubble-primary">Baik, saya jelaskan...</div>
    </div>
  </div>

  <!-- Input Area -->
  <form id="chatForm" class="p-4 bg-base-200 flex gap-2">
    <input id="messageInput" type="text" placeholder="Ketik pesan..." class="input input-bordered flex-1" />
    <button type="submit" class="btn btn-primary">Kirim</button>
  </form>

  <script>
    // Timer 15 menit
    let duration = 15 * 60; 
    const timerEl = document.getElementById("timer");

    function updateTimer() {
      let minutes = Math.floor(duration / 60);
      let seconds = duration % 60;
      timerEl.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
      if (duration > 0) {
        duration--;
      } else {
        clearInterval(timerInterval);
        document.getElementById("chatForm").classList.add("opacity-50", "pointer-events-none");
      }
    }
    let timerInterval = setInterval(updateTimer, 1000);

    // Dummy submit
    document.getElementById("chatForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const input = document.getElementById("messageInput");
      const message = input.value.trim();
      if(message !== "") {
        const chatArea = document.getElementById("chatArea");
        const newMsg = document.createElement("div");
        newMsg.classList.add("chat", "chat-end");
        newMsg.innerHTML = `<div class="chat-bubble chat-bubble-primary">${message}</div>`;
        chatArea.appendChild(newMsg);
        chatArea.scrollTop = chatArea.scrollHeight;
        input.value = "";
      }
    });
  </script>
</body>
</html>
