<?php
require_once '../config/config.php';
require_once '../config/auth.php';

$message = '';
$messageType = '';
$isAdmin = isAdmin();

// Εισαγωγή νέας συσχέτισης παίκτη-μπόνους (μόνο admin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert') {
    if (!$isAdmin) {
        $message = "Δεν έχετε δικαίωμα να προσθέσετε συσχετίσεις!";
        $messageType = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO PAIKTHS_BONUS (player_id, bonus_id) VALUES (?, ?)");
            $stmt->execute([
                $_POST['player_id'], 
                $_POST['bonus_id']
            ]);
            $message = "Η συσχέτιση προστέθηκε επιτυχώς!";
            $messageType = 'success';
        } catch(PDOException $e) {
            $message = "Σφάλμα: " . $e->getMessage();
            $messageType = 'error';
        }
    }
}

// Διαγραφή συσχέτισης (μόνο admin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    if (!$isAdmin) {
        $message = "Δεν έχετε δικαίωμα να διαγράψετε συσχετίσεις!";
        $messageType = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("DELETE FROM PAIKTHS_BONUS WHERE player_id = ? AND bonus_id = ?");
            $stmt->execute([$_POST['player_id'], $_POST['bonus_id']]);
            $message = "Η συσχέτιση διαγράφηκε επιτυχώς!";
            $messageType = 'success';
        } catch(PDOException $e) {
            $message = "Σφάλμα: " . $e->getMessage();
            $messageType = 'error';
        }
    }
}

// Ανάκτηση όλων των συσχετίσεων
$stmt = $pdo->query("
    SELECT pb.*, p.username, b.bonus_type, b.bonus_value 
    FROM PAIKTHS_BONUS pb 
    LEFT JOIN PAIKTHS p ON pb.player_id = p.player_id 
    LEFT JOIN BONUS b ON pb.bonus_id = b.bonus_id 
    ORDER BY pb.player_id, pb.bonus_id
");
$playerBonuses = $stmt->fetchAll();

// Ανάκτηση παικτών και μπόνους για τα dropdowns
$stmt = $pdo->query("SELECT player_id, username FROM PAIKTHS ORDER BY player_id");
$players = $stmt->fetchAll();

$stmt = $pdo->query("SELECT bonus_id, bonus_type, bonus_value FROM BONUS ORDER BY bonus_id");
$bonuses = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Διαχείριση Παίκτες-Μπόνους - StoixiBet Data Control</title>
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
                    <p class="header-subtitle">Διαχείριση Παίκτες-Μπόνους</p>
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
                    <span class="page-icon">✅</span>
                    Διαχείριση Παίκτες-Μπόνους
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
                    <h3 class="card-title">Εισαγωγή Νέας Συσχέτισης</h3>
                </div>
                <form method="POST" class="modern-form">
                    <input type="hidden" name="action" value="insert">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="player_id">Παίκτης</label>
                            <select id="player_id" name="player_id" required class="form-input">
                                <option value="">-- Επιλέξτε Παίκτη --</option>
                                <?php foreach ($players as $player): ?>
                                    <option value="<?php echo htmlspecialchars($player['player_id']); ?>">
                                        <?php echo htmlspecialchars($player['player_id'] . ' - ' . $player['username']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bonus_id">Μπόνους</label>
                            <select id="bonus_id" name="bonus_id" required class="form-input">
                                <option value="">-- Επιλέξτε Μπόνους --</option>
                                <?php foreach ($bonuses as $bonus): ?>
                                    <option value="<?php echo htmlspecialchars($bonus['bonus_id']); ?>">
                                        <?php echo htmlspecialchars($bonus['bonus_id'] . ' - ' . $bonus['bonus_type'] . ' (' . number_format($bonus['bonus_value'], 2) . ' €)'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary form-submit">
                        <span>Προσθήκη Συσχέτισης</span>
                        <span class="btn-icon">+</span>
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <!-- Πίνακας Εμφάνισης -->
            <div class="page-card">
                <div class="card-header">
                    <h3 class="card-title">Κατάλογος Συσχετίσεων</h3>
                    <span class="card-count"><?php echo count($playerBonuses); ?> συσχετίσεις</span>
                </div>
                
                <?php if (empty($playerBonuses)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <p>Δεν υπάρχουν συσχετίσεις στη βάση δεδομένων.</p>
                    </div>
                <?php else: ?>
                    <div class="table-wrapper">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Παίκτης</th>
                                    <th>Μπόνους</th>
                                    <th>Αξία</th>
                                    <?php if ($isAdmin): ?>
                                    <th>Ενέργειες</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($playerBonuses as $pb): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($pb['username'] ?? $pb['player_id']); ?></td>
                                        <td><?php echo htmlspecialchars($pb['bonus_type'] ?? $pb['bonus_id']); ?></td>
                                        <td class="balance-cell"><?php echo number_format($pb['bonus_value'] ?? 0, 2); ?> €</td>
                                        <?php if ($isAdmin): ?>
                                        <td>
                                            <form method="POST" class="inline-form" onsubmit="return confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτή τη συσχέτιση;');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="player_id" value="<?php echo $pb['player_id']; ?>">
                                                <input type="hidden" name="bonus_id" value="<?php echo $pb['bonus_id']; ?>">
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
