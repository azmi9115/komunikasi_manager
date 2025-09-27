<?php
session_start();
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'teknik') {
        header("Location: dashboard_teknik.php");
        exit();
    } else {
        header("Location: dashboard_operasional.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Komunikasi Manager</title>
    <!-- Import Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset and base */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body, html {
            height: 100%;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #333;
            overflow: hidden;
        }

        /* Animated background particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        /* Container: flex for two sides */
        .container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 2;
        }

        /* Main card container */
        .login-card {
            display: flex;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            max-width: 900px;
            width: 90%;
            min-height: 500px;
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Left panel styling */
        .left-panel {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            width: 45%;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .logo {
            max-width: 180px;
            max-height: 180px;
            object-fit: contain;
            filter: drop-shadow(0 10px 30px rgba(0,0,0,0.2));
            animation: pulse 3s ease-in-out infinite;
            position: relative;
            z-index: 2;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .welcome-text {
            color: white;
            text-align: center;
            margin-top: 30px;
            position: relative;
            z-index: 2;
        }

        .welcome-text h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .welcome-text p {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }

        /* Right panel styling */
        .right-panel {
            width: 55%;
            padding: 60px 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Form styling */
        .login-form {
            width: 100%;
            max-width: 350px;
        }

        .form-title {
            font-size: 32px;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 8px;
            text-align: center;
        }

        .form-subtitle {
            color: #718096;
            text-align: center;
            margin-bottom: 40px;
            font-weight: 400;
        }

        /* Input field with icon container */
        .input-group {
            position: relative;
            margin-bottom: 24px;
            width: 100%;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: #4a5568;
            font-weight: 500;
            font-size: 14px;
        }

        /* Icons in input */
        .input-group i {
            position: absolute;
            top: 50%;
            left: 16px;
            transform: translateY(-50%);
            font-size: 18px;
            color: #a0aec0;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        /* Input styling */
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 16px 16px 16px 50px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 16px;
            outline: none;
            transition: all 0.3s ease;
            background-color: #f7fafc;
            font-family: inherit;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #4facfe;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(79, 172, 254, 0.1);
        }

        input[type="text"]:focus + i, input[type="password"]:focus + i {
            color: #4facfe;
        }

        /* Button styling */
        .login-button {
            width: 100%;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            padding: 16px 0;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            cursor: pointer;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(79, 172, 254, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        /* Loading state */
        .login-button.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .login-button.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Error message */
        .error-message {
            background: linear-gradient(135deg, #ff6b6b, #ee5a52);
            color: white;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
                width: 95%;
                max-width: 400px;
                min-height: auto;
            }
            
            .left-panel {
                width: 100%;
                padding: 40px 30px;
            }
            
            .right-panel {
                width: 100%;
                padding: 40px 30px;
            }

            .form-title {
                font-size: 28px;
            }

            .welcome-text h2 {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }
            
            .left-panel, .right-panel {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Animated background particles -->
    <div class="particles" id="particles"></div>

    <div class="container" role="main">
        <div class="login-card">
            <section class="left-panel" aria-label="Welcome section">
                <img 
                    src="assets/logo airnav1.png" 
                    alt="Logo AirNav Indonesia" 
                    class="logo"
                    onerror="this.onerror=null;this.src='https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/36fc9b82-bab6-4b71-83c8-62fe79441487.png';"
                />
                <div class="welcome-text">
                    <h2>Selamat Datang</h2>
                    <p>Sistem Manajemen Komunikasi AirNav Indonesia</p>
                </div>
            </section>
            
            <section class="right-panel" aria-labelledby="login-title">
                <form method="post" action="login_process.php" class="login-form" id="loginForm">
                    <h1 class="form-title" id="login-title">Masuk</h1>
                    <p class="form-subtitle">Silakan masuk ke akun Anda</p>
                    
                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" placeholder="Masukkan username" required aria-label="Username" />
                        <i class="fas fa-user" aria-hidden="true"></i>
                    </div>
                    
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan password" required aria-label="Password" />
                        <i class="fas fa-lock" aria-hidden="true"></i>
                    </div>
                    
                    <button type="submit" class="login-button" id="loginBtn">
                        <span>Masuk</span>
                    </button>
                </form>
            </section>
        </div>
    </div>

    <script>
        // Create animated particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 50;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                
                const size = Math.random() * 4 + 2;
                const x = Math.random() * window.innerWidth;
                const y = Math.random() * window.innerHeight;
                const duration = Math.random() * 3 + 2;
                const delay = Math.random() * 2;
                
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';
                particle.style.left = x + 'px';
                particle.style.top = y + 'px';
                particle.style.animationDuration = duration + 's';
                particle.style.animationDelay = delay + 's';
                
                particlesContainer.appendChild(particle);
            }
        }

        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const button = document.getElementById('loginBtn');
            button.classList.add('loading');
            button.innerHTML = '';
        });

        // Input focus effects
        const inputs = document.querySelectorAll('input[type="text"], input[type="password"]');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.querySelector('i').style.color = '#4facfe';
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.querySelector('i').style.color = '#a0aec0';
                }
            });
        });

        // Initialize particles when page loads
        window.addEventListener('load', createParticles);
        
        // Recreate particles on window resize
        window.addEventListener('resize', function() {
            document.getElementById('particles').innerHTML = '';
            createParticles();
        });
    </script>
</body>
</html>