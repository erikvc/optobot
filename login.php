<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;700&family=Plus+Jakarta+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Normalize CSS -->
    <link href="opto/css/normalize.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="opto/css/style.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <div class="logo-watermark"><img src="opto/images/OPTOBOT.png"></div>
    <section>
        <div class="login-box">
             <div class="login-box-header">Login</div>
             <div class="login-box-subheader">Glad you’re back.!</div>
            <form id="loginForm">
                <div class="login-box-inputField-container" style="margin-top: 40px;">
                    <label>Email</label>
                    <input type="email" name="email" id="email" required placeholder="Please enter your email">
                </div>
                <div class="login-box-inputField-container" style="margin-top: 40px; margin-bottom: 35px;">
                    <label>Senha</label>
                    <input type="password" name="password" id="password" required placeholder="Please enter password">
                </div>
                <div class="login-btn-submit-container">
                    <button type="submit">Log In</button>
                </div>
            </form>
            <div id="responseMessage" class="text-center mt-3"></div>

            <div class="login-forgot-container">
                <a href="forgot.php">Forgot password?</a>
            </div>

            <div class="login-box-footer">
                <a href="#">Don’t have an account? Signup</a><br>
                <a href="#">Terms & Conditions</a>
            </div>
        </div>
    </section>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="opto/js/opto.js"></script> <!-- Referência ao arquivo JS -->
</body>
</html>
