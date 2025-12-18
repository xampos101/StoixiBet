<?php
require_once '../config/config.php';
require_once '../config/auth.php';

$message = '';
$messageType = '';
$isAdmin = isAdmin();

// Εισαγωγή νέας κατάθεσης (μόνο admin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert') {
    if (!$isAdmin) {
        $message = "Δεν έχετε δικαίωμα να προσθέσετε συναλλαγές!";
        $messageType = 'error';
    } else {
        try {
            $datetime = str_replace('T', ' ', $_POST['transaction_date']) . ':00';
            $stmt = $pdo->prepare("INSERT INTO SYNALLAGES (transaction_id, player_id, amount, transaction_date, transaction_type) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['transaction_id'], $_POST['player_id'], $_POST['amount'], $datetime, $_POST['transaction_type']]);
            $message = "Η συναλλαγή προστέθηκε επιτυχώς!";
            $messageType = 'success';
        } catch(PDOException $e) {
            $message = "Σφάλμα: " . $e->getMessage();
            $messageType = 'error';
        }
    }
}

// Διαγραφή κατάθεσης (μόνο admin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    if (!$isAdmin) {
        $message = "Δεν έχετε δικαίωμα να διαγράψετε συναλλαγές!";
        $messageType = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("DELETE FROM SYNALLAGES WHERE transaction_id = ?");
            $stmt->execute([$_POST['transaction_id']]);
            $message = "Η συναλλαγή διαγράφηκε επιτυχώς!";
            $messageType = 'success';
        } catch(PDOException $e) {
            $message = "Σφάλμα: " . $e->getMessage();
            $messageType = 'error';
        }
    }
}

// Ανάκτηση όλων των συναλλαγών
$stmt = $pdo->query("
    SELECT s.*, p.username 
    FROM SYNALLAGES s 
    LEFT JOIN PAIKTHS p ON s.player_id = p.player_id 
    ORDER BY s.transaction_date DESC
");
$transactions = $stmt->fetchAll();

// Ανάκτηση παικτών για το dropdown
$stmt = $pdo->query("SELECT player_id, username FROM PAIKTHS ORDER BY player_id");
$players = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Διαχείριση Συναλλαγών - StoixiBet Data Control</title>
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
                    <p class="header-subtitle">Διαχείριση Συναλλαγών</p>
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
                        <span class="page-icon">💵</span>
                        Διαχείριση Συναλλαγών
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
                    <h3 class="card-title">Εισαγωγή Νέας Συναλλαγής</h3>
                </div>
                <form method="POST" class="modern-form">
                    <input type="hidden" name="action" value="insert">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="transaction_id">ID Συναλλαγής (6 χαρακτήρες)</label>
                            <input type="text" id="transaction_id" name="transaction_id" maxlength="6" pattern=".{6}" required class="form-input">
                        </div>
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
                            <label for="amount">Ποσό (€)</label>
                            <input type="number" id="amount" name="amount" step="0.01" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="transaction_date">Ημερομηνία/Ώρα</label>
                            <input type="datetime-local" id="transaction_date" name="transaction_date" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="transaction_type">Τύπος (8 χαρακτήρες)</label>
                            <input type="text" id="transaction_type" name="transaction_type" maxlength="8" required class="form-input" placeholder="καταθεση / αναληψη">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary form-submit">
                        <span>Προσθήκη Συναλλαγής</span>
                        <span class="btn-icon">+</span>
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <!-- Πίνακας Εμφάνισης -->
            <div class="page-card">
                <div class="card-header">
                    <h3 class="card-title">Κατάλογος Συναλλαγών</h3>
                    <span class="card-count"><?php echo count($transactions); ?> συναλλαγές</span>
                </div>
                
                <?php if (empty($transactions)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <p>Δεν υπάρχουν συναλλαγές στη βάση δεδομένων.</p>
                    </div>
                <?php else: ?>
                    <div class="table-wrapper">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>ID Συναλλαγής</th>
                                    <th>Παίκτης</th>
                                    <th>Ποσό</th>
                                    <th>Ημερομηνία/Ώρα</th>
                                    <th>Τύπος</th>
                                    <?php if ($isAdmin): ?>
                                    <th>Ενέργειες</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($transactions as $trans): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($trans['transaction_id']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($trans['username'] ?? $trans['player_id']); ?></td>
                                        <td class="balance-cell"><?php echo number_format($trans['amount'], 2); ?> €</td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($trans['transaction_date'])); ?></td>
                                        <td><?php echo htmlspecialchars($trans['transaction_type'] ?? '-'); ?></td>
                                        <?php if ($isAdmin): ?>
                                        <td>
                                            <form method="POST" class="inline-form" onsubmit="return confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτή τη συναλλαγή;');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="transaction_id" value="<?php echo $trans['transaction_id']; ?>">
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
