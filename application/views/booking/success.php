<!-- application/views/booking/success.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil - Advokat Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }
        .success-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
        }
        .checkmark {
            width: 80px;
            height: 80px;
            background: #16a34a;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
        }
    </style>
</head>
<body>
    <div class="container success-container">
        <div class="card shadow-lg border-0">
            <div class="card-body text-center p-5">
                <div class="checkmark">
                    <i class="fas fa-check text-white" style="font-size: 2.5rem;"></i>
                </div>
                
                <h1 class="text-success mb-3">Pembayaran Berhasil!</h1>
                <p class="text-muted mb-4">Terima kasih telah melakukan pembayaran. Konsultasi Anda sudah siap dimulai.</p>
                 <a href="<?=base_url('chat/booking/'.$booking->id)?>" id="chat-link" class="btn btn-primary btn-lg">
                        <i class="fas fa-comments me-2"></i>Mulai Konsultasi Sekarang
                    </a>
                   
                <!-- <div id="payment-info" class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>
                    <span>Menunggu konfirmasi sistem...</span>
                </div>
                 -->
                <div id="success-content" style="display: none;">
                    <div class="alert alert-success mb-4">
                        <i class="fas fa-check-circle me-2"></i>
                        <span>Pembayaran telah dikonfirmasi. Anda akan diarahkan ke ruang chat secara otomatis.</span>
                    </div>
                    
                    <a href="<?=base_url('chat/booking/'.$booking['id'])?>" id="chat-link" class="btn btn-primary btn-lg">
                        <i class="fas fa-comments me-2"></i>Mulai Konsultasi Sekarang
                    </a>
                    
                    <div class="mt-3">
                        <small class="text-muted">Tidak redirect otomatis? </small>
                        <a href="#" id="manual-redirect" class="text-primary">Klik di sini</a>
                    </div>
                </div>
                
                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted">
                        Invoice ID: <?= $invoice_id ?><br>
                        Butuh bantuan? <a href="<?= base_url('contact') ?>">Hubungi kami</a>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script>
        const bookingId = '<?= $booking->id ?? "" ?>';
        
        function checkPaymentStatus() {
            if (!bookingId) {
                document.getElementById('payment-info').innerHTML = 
                    '<i class="fas fa-exclamation-triangle me-2"></i>Data booking tidak ditemukan';
                return;
            }
            
                        // Redirect otomatis setelah 3 detik
                        setTimeout(() => {
                            window.location.href = "<?=base_url('chat/booking/'.$booking->id)?>";
                        }, 3000);
                    
        }
        
        // Mulai pengecekan status
        document.addEventListener('DOMContentLoaded', function() {
            checkPaymentStatus();
        });
    </script>
</body>
</html>