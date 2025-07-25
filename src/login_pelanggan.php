<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND role='pelanggan'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];
        header("Location: pelanggan/index.php");
        exit;
    } else {
        echo "<script>alert('Email atau Password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Pelanggan - Azta Es Cream</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #ff69b4;
            --primary-dark: #d63384;
            --secondary: #ffe4e1;
            --accent: #ffb6c1;
            --purple: #6a11cb;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, var(--purple), var(--primary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 1rem;
            overflow: hidden;
            position: relative;
        }
        
        /* Background elements */
        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.15);
            z-index: 0;
        }
        
        .circle-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
        }
        
        .circle-2 {
            width: 200px;
            height: 200px;
            bottom: -80px;
            right: -80px;
        }
        
        .circle-3 {
            width: 150px;
            height: 150px;
            top: 40%;
            right: 20%;
        }
        
        .ice-cream {
            position: absolute;
            width: 60px;
            height: 90px;
            border-radius: 30px 30px 5px 5px;
            z-index: 0;
            animation: float 6s infinite ease-in-out;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .ice-cream-1 {
            background: linear-gradient(to bottom, #ffccd5, #ff80ab);
            top: 15%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .ice-cream-2 {
            background: linear-gradient(to bottom, #c8e6c9, #81c784);
            top: 20%;
            right: 15%;
            animation-delay: 1s;
        }
        
        .ice-cream-3 {
            background: linear-gradient(to bottom, #bbdefb, #64b5f6);
            bottom: 15%;
            left: 20%;
            animation-delay: 2s;
        }
        
        .container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 500px;
        }
        
        .card {
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
            overflow: hidden;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
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
            background: linear-gradient(135deg, var(--purple), var(--primary));
            color: white;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            padding: 30px 20px;
            border-bottom: none;
            position: relative;
            overflow: hidden;
            text-align: center;
        }
        
        .card-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
            transform: rotate(30deg);
        }
        
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            border: 3px solid white;
        }
        
        .logo img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 50%;
        }
        
        .card-title {
            font-weight: 700;
            margin: 0;
            font-size: 1.8rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .card-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 5px;
        }
        
        .card-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #555;
            display: flex;
            align-items: center;
        }
        
        .form-label i {
            margin-right: 10px;
            font-size: 18px;
            color: var(--purple);
        }
        
        .form-control {
            border: 2px solid #ddd;
            border-radius: 12px;
            padding: 12px 15px 12px 45px;
            font-size: 1rem;
            transition: all 0.3s ease;
            height: 50px;
            width: 100%;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.25rem rgba(255, 105, 180, 0.25);
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 20px;
            transition: color 0.3s;
        }
        
        .form-control:focus + .input-icon {
            color: var(--primary);
        }
        
        .btn-login {
            background: linear-gradient(135deg, var(--purple), var(--primary));
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(106, 17, 203, 0.4);
            position: relative;
            overflow: hidden;
            height: 50px;
            width: 100%;
            color: white;
        }
        
        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(106, 17, 203, 0.5);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .btn-login::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0) 70%);
            transform: scale(0);
            transition: transform 0.5s ease;
        }
        
        .btn-login:hover::after {
            transform: scale(1);
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.95rem;
        }
        
        .register-link a {
            color: var(--purple);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .register-link a:hover {
            text-decoration: underline;
            color: var(--primary-dark);
        }
        
        .footer {
            color: white;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
            font-weight: 500;
            margin-top: 20px;
            text-align: center;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        
        @media (max-width: 576px) {
            .card {
                width: 95%;
                margin: 0 auto;
            }
            
            .card-header {
                padding: 25px 15px;
            }
            
            .card-title {
                font-size: 1.5rem;
            }
            
            .card-subtitle {
                font-size: 1rem;
            }
            
            .card-body {
                padding: 20px;
            }
            
            .logo {
                width: 70px;
                height: 70px;
            }
            
            .ice-cream {
                width: 45px;
                height: 70px;
            }
        }
    </style>
</head>
<body>
    <!-- Background elements -->
    <div class="bg-circle circle-1"></div>
    <div class="bg-circle circle-2"></div>
    <div class="bg-circle circle-3"></div>
    
    <!-- Floating ice cream elements -->
    <div class="ice-cream ice-cream-1"></div>
    <div class="ice-cream ice-cream-2"></div>
    <div class="ice-cream ice-cream-3"></div>
    
    <div class="container">
        <div class="card" id="login-card">
            <div class="card-header">
                <div class="logo-container">
                    <div class="logo">
                        <img src="assets/img/logo.png" alt="Logo Azta Es Cream">
                    </div>
                </div>
                <h2 class="card-title">Login Pelanggan</h2>
                <div class="card-subtitle">Azta Es Cream</div>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label class="form-label" for="email">
                            <i class="fas fa-envelope"></i>Email
                        </label>
                        <div class="position-relative">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email Anda" required>
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password">
                            <i class="fas fa-lock"></i>Password
                        </label>
                        <div class="position-relative">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password Anda" required>
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" name="login" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>Login
                    </button>
                    
                    <div class="register-link">
                        Belum punya akun? <a href="register.php">Daftar di sini</a>
                    </div>
                </form>
            </div>
        </div>
        <p class="footer mt-4 small">© Azta Es Cream 2025 | Pelanggan</p>
    </div>
    
    <script>
        // Animasi saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.getElementById('login-card');
            
            // Animasi muncul card
            setTimeout(() => {
                card.classList.add('show');
            }, 300);
            
            // Animasi input focus
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
            
            // Animasi tombol login
            const loginBtn = document.querySelector('.btn-login');
            loginBtn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
            });
            
            loginBtn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>