<?php
session_start();

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $host = "localhost";
    $user = "root";
    $password = "root"; // modifie si nécessaire
    $dbname = "eglise";

    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Eroare de conexiune la baza de date: " . $conn->connect_error);
    }

    $utilisateur = $_POST['utilisateur'];
    $motdepasse = $_POST['motdepasse'];

    $sql = "SELECT * FROM admin WHERE utilisateur = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $utilisateur);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // Mot de passe non chiffré
        if ($motdepasse === $admin['motdepasse']) {
            $_SESSION['admin'] = $admin['utilisateur'];
            header("Location: admin.php");
            exit();
        } else {
            $erreur = "Parolă incorectă.";
        }
    } else {
        $erreur = "Nume de utilizator invalid.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="ro">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexiune Admin - Biserica Harul</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        /* Reset et base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            color: #ffffff;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Effet de particules en arrière-plan */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.02) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.02) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Container principal */
        .login-container {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            width: 100%;
            max-width: 450px;
            position: relative;
            animation: slideUp 0.8s ease-out;
        }

        /* En-tête */
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #ffffff, #e0e0e0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.1);
        }

        .login-icon i {
            font-size: 2rem;
            color: #1a1a1a;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(45deg, #ffffff, #e0e0e0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            font-weight: 400;
        }

        /* Formulaire */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        /* Groupes de champs */
        .form-group {
            position: relative;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #ffffff;
            font-size: 0.95rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.1rem;
            z-index: 2;
        }

        /* Inputs */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #ffffff;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
        }

        input[type="text"]::placeholder,
        input[type="password"]::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        /* Bouton de connexion */
        .login-button {
            background: linear-gradient(45deg, #ffffff, #e0e0e0);
            color: #1a1a1a;
            border: none;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 255, 255, 0.3);
            background: linear-gradient(45deg, #f0f0f0, #d0d0d0);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button i {
            margin-left: 0.5rem;
        }

        /* Messages d'erreur */
        .error-message {
            background: rgba(244, 67, 54, 0.1);
            border: 1px solid rgba(244, 67, 54, 0.3);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: #f44336;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: shake 0.5s ease-out;
        }

        .error-message i {
            color: #f44336;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-footer p {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 2rem;
                margin: 1rem;
                border-radius: 16px;
            }

            .login-title {
                font-size: 1.75rem;
            }

            .login-icon {
                width: 60px;
                height: 60px;
            }

            .login-icon i {
                font-size: 1.5rem;
            }
        }

        /* Animations */
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        /* Effet de brillance sur le bouton */
        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .login-button:hover::before {
            left: 100%;
        }

        /* Loading state */
        .login-button.loading {
            pointer-events: none;
        }

        .login-button.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Scrollbar personnalisée */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="login-icon">
                <i class="fas fa-church"></i>
            </div>
            <h1 class="login-title">Biserica Harul</h1>
            <p class="login-subtitle">Panoul de Administrare</p>
        </div>

        <?php if (!empty($erreur)): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-triangle"></i>
                <?php echo $erreur; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="login-form">
            <div class="form-group">
                <label for="utilisateur">Nume de utilizator</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" id="utilisateur" name="utilisateur"
                        placeholder="Introduceți numele de utilizator" required autocomplete="username">
                </div>
            </div>

            <div class="form-group">
                <label for="motdepasse">Parolă</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="motdepasse" name="motdepasse" placeholder="Introduceți parola" required
                        autocomplete="current-password">
                </div>
            </div>

            <button type="submit" class="login-button">
                Conectați-vă
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <div class="login-footer">
            <p>&copy; 2025 Biserica Harul - Sistem de administrare securizat</p>
        </div>
    </div>

    <script>
        // Animation du bouton lors de la soumission
        document.querySelector('.login-form').addEventListener('submit', function(e) {
            const button = document.querySelector('.login-button');
            const icon = button.querySelector('i');

            button.classList.add('loading');
            icon.className = 'fas fa-spinner';
        });

        // Animation des inputs au focus
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });
    </script>
</body>

</html>