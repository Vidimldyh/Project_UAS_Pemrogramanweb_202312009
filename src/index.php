<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang - Azta Es Cream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-image: url('assets/img/eskrim.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
            padding: 15px;
            margin: 0;
            position: relative;
            overflow: hidden;
        }

        /* Overlay untuk meningkatkan kontras */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            z-index: 0;
        }

        .card {
            max-width: 500px;
            width: 100%;
            border-radius: 20px;
            background-color: rgba(255, 230, 240, 0.85); /* Lebih solid */
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(4px);
            overflow: hidden;
            position: relative;
            z-index: 1;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: none;
        }

        .card.show {
            transform: translateY(0);
            opacity: 1;
        }

        .card-header {
            background: linear-gradient(135deg, #ff80ab, #ff4081);
            color: white;
            padding: 20px;
            border-radius: 20px 20px 0 0 !important;
            border-bottom: none;
        }

        .logo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid white;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.5s ease;
        }

        .logo:hover {
            transform: scale(1.05) rotate(5deg);
        }

        .card h3 {
            font-weight: 700;
            margin: 15px 0 5px;
            color: #fff;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .card p {
            color: #5a5a5a;
            font-size: 1.1rem;
            margin-bottom: 30px;
            font-weight: 500;
        }

        .btn-login {
            font-size: 1.1rem;
            padding: 12px 20px;
            border-radius: 50px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-weight: 600;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            border: none;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2196F3, #0D47A1);
        }

        .btn-success {
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
        }

        .btn-login i {
            margin-right: 10px;
        }

        .scoop {
            position: absolute;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            z-index: 0;
            animation: float 6s infinite ease-in-out;
            filter: drop-shadow(0 5px 5px rgba(0,0,0,0.1));
        }

        .scoop-1 {
            background: linear-gradient(135deg, #ffccd5, #ff80ab);
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .scoop-2 {
            background: linear-gradient(135deg, #c8e6c9, #81c784);
            top: 15%;
            right: 15%;
            animation-delay: 1s;
        }

        .scoop-3 {
            background: linear-gradient(135deg, #bbdefb, #64b5f6);
            bottom: 15%;
            left: 20%;
            animation-delay: 2s;
        }

        .scoop-4 {
            background: linear-gradient(135deg, #fff9c4, #ffd54f);
            bottom: 10%;
            right: 10%;
            animation-delay: 3s;
        }

        .card-body {
            padding: 30px;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        @media (max-width: 576px) {
            .card h3 {
                font-size: 1.4rem;
            }

            .btn-login {
                font-size: 1rem;
                padding: 12px;
            }

            .logo {
                width: 90px;
                height: 90px;
            }
            
            .scoop {
                width: 45px;
                height: 45px;
            }
        }
    </style>
</head>
<body>
    <!-- Elemen animasi scoop es krim -->
    <div class="scoop scoop-1"></div>
    <div class="scoop scoop-2"></div>
    <div class="scoop scoop-3"></div>
    <div class="scoop scoop-4"></div>

    <div class="card text-center" id="welcome-card">
        <div class="card-header">
            <img src="assets/img/logo.png" class="mx-auto logo mb-2" alt="Logo Azta Es Cream">
            <h3 class="mb-2">Selamat Datang di Azta Es Cream</h3>
        </div>
        <div class="card-body">
            <p class="mb-4">Silakan pilih login sebagai Admin atau Pengguna</p>

            <div class="d-grid gap-3">
                <a href="login.php" class="btn btn-primary btn-login">
                    <i class="fas fa-user-cog"></i>Login Admin
                </a>
                <a href="login_pelanggan.php" class="btn btn-success btn-login">
                    <i class="fas fa-user"></i>Login Pengguna
                </a>
            </div>
        </div>
    </div>

    <script>
        // Animasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.getElementById('welcome-card');
            
            // Animasi muncul card
            setTimeout(() => {
                card.classList.add('show');
            }, 300);
            
            // Animasi hover tombol
            const buttons = document.querySelectorAll('.btn-login');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>