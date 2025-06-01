<?php
require_once __DIR__ . '/core/CSRF.php';
session_start();
$error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
$show_error = isset($_SESSION['login_attempted']);

unset($_SESSION['login_error']);
unset($_SESSION['login_attempted']);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Poppins", sans-serif;
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
        }

        .login-container {
            background-color: #1f2937;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .welcome-text {
            font-size: 18px;
            color: #9ca3af;
            font-weight: 400;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 14px;
            color: #d1d5db;
            font-weight: 500;
        }

        .input-field {
            width: 100%;
            padding: 14px 16px;
            background-color: #374151;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            outline: none;
            border-color: #f97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
            background-color: #4b5563;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 16px;
            padding: 5px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
            color: #111827;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(249, 115, 22, 0.4);
        }

        .error-message {
            display: <?php echo $show_error ? 'block' : 'none'; ?>;
            background-color: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            padding: 12px;
            border-radius: 8px;
            margin: 0 auto 20px;
            text-align: center;
            animation: fadeIn 0.3s;
            border-left: 4px solid #ef4444;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }

            .login-header h1 {
                font-size: 24px;
            }

            .welcome-text {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h1>INICIAR SESIÓN</h1>
                <p class="welcome-text">WELCOME!</p>
            </div>

            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
            </div>

            <form class="login-form" action="core/procesar_login.php" method="POST">
                <?php echo CSRF::getTokenField(); ?>
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" id="usuario" name="usuario" required class="input-field" placeholder="Ingrese su usuario">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" required class="input-field" placeholder="****">
                        <button type="button" id="togglePassword" class="password-toggle">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login">Entrar</button>
            </form>
        </div>
    </div>

    <script>
        // Mostrar/ocultar contraseña
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        // Ocultar error al empezar a escribir
        document.querySelectorAll('.input-field').forEach(input => {
            input.addEventListener('input', () => {
                document.querySelector('.error-message').style.display = 'none';
            });
        });
    </script>
</body>

</html>