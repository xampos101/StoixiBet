<?php
require_once '../config/config.php';
require_once '../config/auth.php';

$message = '';
$messageType = '';
$isAdmin = isAdmin();

// Εισαγωγή νέας συμμετοχής (μόνο admin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert') {
    if (!$isAdmin) {
        $message = "Δεν έχετε δικαίωμα να προσθέσετε συμμετοχές!";
        $messageType = 'error';
    } else {
        try {
            $datetime = str_replace('T', ' ', $_POST['bet_datetime']) . ':00';
            $stmt = $pdo->prepare("INSERT INTO SUMMETOXH (player_id, bet_id, bet_amount, bet_datetime, result_amount) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['player_id'], 
                $_POST['bet_id'], 
                $_POST['bet_amount'], 
                $datetime,
                $_POST['result_amount'] ?? 0.00
            ]);
            $message = "Η συμμετοχή προστέθηκε επιτυχώς!";
            $messageType = 'success';
        } catch(PDOException $e) {
            $message = "Σφάλμα: " . $e->getMessage();
            $messageType = 'error';
        }
    }
}

// Διαγραφή συμμετοχής (μόνο admin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    if (!$isAdmin) {
        $message = "Δεν έχετε δικαίωμα να διαγράψετε συμμετοχές!";
        $messageType = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("DELETE FROM SUMMETOXH WHERE player_id = ? AND bet_id = ?");
            $stmt->execute([$_POST['player_id'], $_POST['bet_id']]);
            $message = "Η συμμετοχή διαγράφηκε επιτυχώς!";
            $messageType = 'success';
        } catch(PDOException $e) {
            $message = "Σφάλμα: " . $e->getMessage();
            $messageType = 'error';
        }
    }
}

// Ανάκτηση όλων των συμμετοχών
$stmt = $pdo->query("
    SELECT s.*, p.username, st.description as bet_description 
    FROM SUMMETOXH s 
    LEFT JOIN PAIKTHS p ON s.player_id = p.player_id 
    LEFT JOIN STOIXHMA st ON s.bet_id = st.bet_id 
    ORDER BY s.bet_datetime DESC
");
$participations = $stmt->fetchAll();

// Ανάκτηση παικτών και στοιχημάτων για τα dropdowns
$stmt = $pdo->query("SELECT player_id, username FROM PAIKTHS ORDER BY player_id");
$players = $stmt->fetchAll();

$stmt = $pdo->query("SELECT bet_id, description FROM STOIXHMA ORDER BY bet_id");
$bets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Διαχείριση Συμμετοχών - StoixiBet Data Control</title>
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
                    <p class="header-subtitle">Διαχείριση Συμμετοχών</p>
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
                    <span class="page-icon">📊</span>
                    Διαχείριση Συμμετοχών
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
                    <h3 class="card-title">Εισαγωγή Νέας Συμμετοχής</h3>
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
                            <label for="bet_id">Στοίχημα</label>
                            <select id="bet_id" name="bet_id" required class="form-input">
                                <option value="">-- Επιλέξτε Στοίχημα --</option>
                                <?php foreach ($bets as $bet): ?>
                                    <option value="<?php echo htmlspecialchars($bet['bet_id']); ?>">
                                        <?php echo htmlspecialchars($bet['bet_id'] . ' - ' . $bet['description']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="bet_amount">Ποσό Στοιχήματος (€)</label>
                            <input type="number" id="bet_amount" name="bet_amount" step="0.01" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="bet_datetime">Ημερομηνία/Ώρα Στοιχήματος</label>
                            <input type="datetime-local" id="bet_datetime" name="bet_datetime" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="result_amount">Ποσό Αποτελέσματος (€)</label>
                            <input type="number" id="result_amount" name="result_amount" step="0.01" value="0.00" class="form-input">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary form-submit">
                        <span>Προσθήκη Συμμετοχής</span>
                        <span class="btn-icon">+</span>
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <!-- Πίνακας Εμφάνισης -->
            <div class="page-card">
                <div class="card-header">
                    <h3 class="card-title">Κατάλογος Συμμετοχών</h3>
                    <span class="card-count"><?php echo count($participations); ?> συμμετοχές</span>
                </div>
                
                <?php if (empty($participations)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <p>Δεν υπάρχουν συμμετοχές στη βάση δεδομένων.</p>
                    </div>
                <?php else: ?>
                    <div class="table-wrapper">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Παίκτης</th>
                                    <th>Στοίχημα</th>
                                    <th>Ποσό Στοιχήματος</th>
                                    <th>Ημερομηνία Στοιχήματος</th>
                                    <th>Αποτέλεσμα</th>
                                    <?php if ($isAdmin): ?>
                                    <th>Ενέργειες</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($participations as $part): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($part['username'] ?? $part['player_id']); ?></td>
                                        <td><?php echo htmlspecialchars($part['bet_description'] ?? $part['bet_id']); ?></td>
                                        <td class="balance-cell"><?php echo number_format($part['bet_amount'], 2); ?> €</td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($part['bet_datetime'])); ?></td>
                                        <td class="balance-cell"><?php echo number_format($part['result_amount'], 2); ?> €</td>
                                        <?php if ($isAdmin): ?>
                                        <td>
                                            <form method="POST" class="inline-form" onsubmit="return confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτή τη συμμετοχή;');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="player_id" value="<?php echo $part['player_id']; ?>">
                                                <input type="hidden" name="bet_id" value="<?php echo $part['bet_id']; ?>">
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
