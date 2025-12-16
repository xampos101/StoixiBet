<?php
require_once '../config/config.php';
require_once '../config/auth.php';

$message = '';
$messageType = '';
$isAdmin = isAdmin();

// Εισαγωγή νέου μπόνους (μόνο admin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert') {
    if (!$isAdmin) {
        $message = "Δεν έχετε δικαίωμα να προσθέσετε μπόνους!";
        $messageType = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO BONUS (bonus_id, bonus_type, bonus_value, expiration_date) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                $_POST['bonus_id'], 
                $_POST['bonus_type'], 
                $_POST['value'],
                $_POST['expiration_date'] ?: null
            ]);
            $message = "Το μπόνους προστέθηκε επιτυχώς!";
            $messageType = 'success';
        } catch(PDOException $e) {
            $message = "Σφάλμα: " . $e->getMessage();
            $messageType = 'error';
        }
    }
}

// Διαγραφή μπόνους (μόνο admin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    if (!$isAdmin) {
        $message = "Δεν έχετε δικαίωμα να διαγράψετε μπόνους!";
        $messageType = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("DELETE FROM BONUS WHERE bonus_id = ?");
            $stmt->execute([$_POST['bonus_id']]);
            $message = "Το μπόνους διαγράφηκε επιτυχώς!";
            $messageType = 'success';
        } catch(PDOException $e) {
            $message = "Σφάλμα: " . $e->getMessage();
            $messageType = 'error';
        }
    }
}

// Ανάκτηση όλων των μπόνους
$stmt = $pdo->query("SELECT * FROM BONUS ORDER BY bonus_id");
$bonuses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Διαχείριση Μπόνους - StoixiBet Data Control</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Frontend/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
</head>
<body>
    <!-- Custom Cursor -->
    <div class="cursor" id="cursor">
        <div class="cursor-dot"></div>
        <div class="cursor-outline"></div>
    </div>
    <div class="cursor-trail"></div>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="header-logo">
                <div class="logo-wrapper">
                    <div class="logo-glow"></div>
                    <div class="logo-content">
                        <span aria-hidden="true">🎰</span>
                    </div>
                </div>
                <div class="header-text">
                    <h1 class="header-title">StoixiBet Data Control</h1>
                    <p class="header-subtitle">Διαχείριση Μπόνους</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="../index.php" class="btn-secondary">← Αρχική</a>
                <?php if ($isAdmin): ?>
                    <a href="../logout.php" class="btn-secondary">Αποσύνδεση</a>
                <?php else: ?>
                    <a href="../login.php" class="btn-secondary">Σύνδεση</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content page-content">
        <div class="page-container">
            <div class="page-header">
                <h2 class="page-title">
                    <span class="page-icon">🎁</span>
                    Διαχείριση Μπόνους
                </h2>
                <?php if (!$isAdmin): ?>
                    <div class="view-only-badge">
                        <span>👁️ Προβολή μόνο</span>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($message): ?>
                <div class="message-alert message-<?php echo $messageType; ?>">
                    <span class="message-icon"><?php echo $messageType === 'success' ? '✓' : '⚠'; ?></span>
                    <span><?php echo htmlspecialchars($message); ?></span>
                </div>
            <?php endif; ?>

            <!-- Φόρμα Εισαγωγής (μόνο για admin) -->
            <?php if ($isAdmin): ?>
            <div class="page-card">
                <div class="card-header">
                    <h3 class="card-title">Εισαγωγή Νέου Μπόνους</h3>
                </div>
                <form method="POST" class="modern-form">
                    <input type="hidden" name="action" value="insert">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="bonus_id">ID Μπόνους</label>
                            <input type="text" id="bonus_id" name="bonus_id" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="bonus_type">Τύπος Μπόνους</label>
                            <input type="text" id="bonus_type" name="bonus_type" maxlength="30" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="value">Αξία (€)</label>
                            <input type="number" id="value" name="value" step="0.01" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="expiration_date">Ημερομηνία Λήξης</label>
                            <input type="date" id="expiration_date" name="expiration_date" class="form-input">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary form-submit">
                        <span>Προσθήκη Μπόνους</span>
                        <span class="btn-icon">+</span>
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <!-- Πίνακας Εμφάνισης -->
            <div class="page-card">
                <div class="card-header">
                    <h3 class="card-title">Κατάλογος Μπόνους</h3>
                    <span class="card-count"><?php echo count($bonuses); ?> μπόνους</span>
                </div>
                
                <?php if (empty($bonuses)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <p>Δεν υπάρχουν μπόνους στη βάση δεδομένων.</p>
                    </div>
                <?php else: ?>
                    <div class="table-wrapper">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>ID Μπόνους</th>
                                    <th>Τύπος</th>
                                    <th>Αξία</th>
                                    <th>Ημερομηνία Λήξης</th>
                                    <?php if ($isAdmin): ?>
                                    <th>Ενέργειες</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($bonus['bonus_id']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($bonus['bonus_type']); ?></td>
                                        <td class="balance-cell"><?php echo number_format($bonus['bonus_value'], 2); ?> €</td>
                                        <td><?php echo $bonus['expiration_date'] ? date('d/m/Y', strtotime($bonus['expiration_date'])) : '-'; ?></td>
                                        <?php if ($isAdmin): ?>
                                        <td>
                                            <form method="POST" class="inline-form" onsubmit="return confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτό το μπόνους;');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="bonus_id" value="<?php echo $bonus['bonus_id']; ?>">
                                                <button type="submit" class="btn-danger btn-small">
                                                    <span>Διαγραφή</span>
                                                    <span class="btn-icon">🗑️</span>
                                                </button>
                                            </form>
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

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

    <script src="../Frontend/script.js"></script>
</body>
</html>
