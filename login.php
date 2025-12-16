<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = 'admin';
        header('Location: index.php');
        exit;
    } else {
        $error = 'Λάθος username ή password';
    }
}

// Αν είναι ήδη logged in, redirect
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Σύνδεση - StoixiBet Data Control</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Frontend/style.css">
</head>
<body>
    <!-- Custom Cursor -->
    <div class="cursor" id="cursor">
        <div class="cursor-dot"></div>
        <div class="cursor-outline"></div>
    </div>
    <div class="cursor-trail"></div>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <div class="login-logo">
                    <span>🎰</span>
                </div>
                <h1 class="login-title">StoixiBet Data Control</h1>
                <p class="login-subtitle">Σύνδεση Διαχειριστή</p>
            </div>
            
            <?php if ($error): ?>
                <div class="login-error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required autofocus>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-primary login-btn">Σύνδεση</button>
            </form>
            
            <div class="login-footer">
                <a href="index.php" class="back-link">← Επιστροφή στην Αρχική</a>
            </div>
        </div>
        
        <!-- Background Card Symbols -->
        <div class="background-cards-grid">
            <div class="card-symbol-grid" data-suit="♠" data-color="white">♠</div>
            <div class="card-symbol-grid" data-suit="♥" data-color="blue">♥</div>
            <div class="card-symbol-grid" data-suit="♦" data-color="blue">♦</div>
            <div class="card-symbol-grid" data-suit="♣" data-color="white">♣</div>
            <div class="card-symbol-grid" data-suit="♠" data-color="white">♠</div>
            <div class="card-symbol-grid" data-suit="♥" data-color="blue">♥</div>
            <div class="card-symbol-grid" data-suit="♦" data-color="blue">♦</div>
            <div class="card-symbol-grid" data-suit="♣" data-color="white">♣</div>
            <div class="card-symbol-grid" data-suit="♠" data-color="white">♠</div>
            <div class="card-symbol-grid" data-suit="♥" data-color="blue">♥</div>
            <div class="card-symbol-grid" data-suit="♦" data-color="blue">♦</div>
            <div class="card-symbol-grid" data-suit="♣" data-color="white">♣</div>
            <div class="card-symbol-grid" data-suit="♠" data-color="white">♠</div>
            <div class="card-symbol-grid" data-suit="♥" data-color="blue" data-faded="true">♥</div>
            <div class="card-symbol-grid" data-suit="♦" data-color="blue" data-faded="true">♦</div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="Frontend/script.js"></script>
</body>
</html>


