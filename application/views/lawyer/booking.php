<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="<?= $this->config->item('midtrans_client_key') ?>"></script>

    <title>Booking Lawyer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4 text-center">Booking Lawyer</h2>
<?= getenv('MIDTRANS_CLIENT_KEY') ?>

    <div id="snap-container"></div>
<?php 
?>
    
    
    <!-- echo $CI->session->userdata('user_name'); -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-body">
                    <h4 class="card-title mb-3"><?= isset($lawyer['name']) ? $lawyer['name'] : 'Nama Tidak Ada'; ?></h4>
                    <p><strong>Experience:</strong> <?= isset($lawyer['years_experience']) ? $lawyer['years_experience'] : 0; ?> tahun</p>
                    <p><strong>Speciality:</strong> <?= isset($lawyer['specialties']) ? $lawyer['specialties'] : '-'; ?></p>
                    <p class="text-muted"><?= isset($lawyer['bio']) ? $lawyer['bio'] : ''; ?></p>
                    <?php 

// $CI =& get_instance(); 
// echo $this->session->userdata('user_');
?>
                    

                    <form id="bookingForm">
                        <input type="hidden" name="lawyer_id" id="lawyer_id" value="<?= isset($lawyer['user_id']) ? $lawyer['user_id'] : ''; ?>">
                        <input type="hidden" name="client_id" id="client_id" value="<?= $this->session->userdata('user_id'); ?>">
                        <div class="mb-3">
                            <label class="form-label">Durasi (menit)</label>
                            <input type="number" name="duration" id="duration" class="form-control" min="30" value="30" required>
                            <div class="form-text">Durasi konsultasi minimal 30 menit</div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Booking &amp; Bayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

 <script type="text/javascript">
document.getElementById("bookingForm").addEventListener("submit", async function(e) {
    e.preventDefault();

    const lawyerId = document.getElementById("lawyer_id").value;
    const clientId = document.getElementById("client_id").value;
    const duration = document.getElementById("duration").value;
    console.log("Lawyer ID:", lawyerId, "Duration:", duration);


    try {
        const response = await fetch(`/advokat/api/booking/pay/${lawyerId}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ duration: duration })
        });

        const result = await response.json();
        

        console.log("Response dari server:", result);

        if (result.data) {
             window.snap.pay(result.data,
                {
          onSuccess: async function(result){
            /*  */
            console.log(result);
            const data_booking = {
                client_id: clientId,
                lawyer_id: lawyerId,
                duration_minutes: duration,
                status:'paid',
                price_snapshot:150.00
            };
          const create_booking = await  fetch('/advokat/api/booking/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data_booking)
            })
            


            const data = await create_booking.json();
            console.log(data)
            if(data){
                const create_chat = await fetch('/advokat/api/chat/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        client_id: clientId,
                        booking_id: data.data.id,
                        lawyer_id: lawyerId
                    })
                });

                const chat = await create_chat.json();
            
                // console.log(chat)
                if(chat){
                    // alert("Booking dan chat berhasil dibuat! Silakan cek halaman chat.");
                    window.location.href = '/advokat/chat/booking/'+ chat.booking_id; ;
                } else {
                    alert("Gagal membuat chat.");
                }
            }
            // alert("payment success!"); console.log(result);
          },
       
        }
             )

            // alert("Booking berhasil! Token: " + result.token);
        } else {
            alert("Gagal membuat transaksi.");
        }

    } catch (error) {
        console.error("Error:", error);
        alert("Terjadi kesalahan saat memproses booking.");
    }
});      
    </script>
</body>

</html>
