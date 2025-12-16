<?php
require_once '../config/config.php';
require_once '../config/auth.php';

$message = '';
$messageType = '';
$isAdmin = isAdmin();

// Εισαγωγή νέου στοιχήματος (μόνο admin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'insert') {
    if (!$isAdmin) {
        $message = "Δεν έχετε δικαίωμα να προσθέσετε στοιχήματα!";
        $messageType = 'error';
    } else {
        try {
            $datetime = str_replace('T', ' ', $_POST['stoixima_datetime']) . ':00';
            $stmt = $pdo->prepare("INSERT INTO STOIXHMA (bet_id, description, stoixima_datetime, employee_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$_POST['bet_id'], $_POST['description'], $datetime, $_POST['employee_id']]);
            $message = "Το στοίχημα προστέθηκε επιτυχώς!";
            $messageType = 'success';
        } catch(PDOException $e) {
            $message = "Σφάλμα: " . $e->getMessage();
            $messageType = 'error';
        }
    }
}

// Διαγραφή στοιχήματος (μόνο admin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    if (!$isAdmin) {
        $message = "Δεν έχετε δικαίωμα να διαγράψετε στοιχήματα!";
        $messageType = 'error';
    } else {
        try {
            $stmt = $pdo->prepare("DELETE FROM STOIXHMA WHERE bet_id = ?");
            $stmt->execute([$_POST['bet_id']]);
            $message = "Το στοίχημα διαγράφηκε επιτυχώς!";
            $messageType = 'success';
        } catch(PDOException $e) {
            $message = "Σφάλμα: " . $e->getMessage();
            $messageType = 'error';
        }
    }
}

// Ανάκτηση όλων των στοιχημάτων
$stmt = $pdo->query("SELECT s.*, y.employee_name FROM STOIXHMA s LEFT JOIN YPALLHLOS y ON s.employee_id = y.employee_id ORDER BY s.stoixima_datetime DESC");
$bets = $stmt->fetchAll();

// Ανάκτηση υπαλλήλων για το dropdown
$stmt = $pdo->query("SELECT employee_id, employee_name FROM YPALLHLOS ORDER BY employee_id");
$employees = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Διαχείριση Στοιχημάτων - StoixiBet Data Control</title>
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
                    <p class="header-subtitle">Διαχείριση Στοιχημάτων</p>
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
                    <span class="page-icon">🎲</span>
                    Διαχείριση Στοιχημάτων
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
                    <h3 class="card-title">Εισαγωγή Νέου Στοιχήματος</h3>
                </div>
                <form method="POST" class="modern-form">
                    <input type="hidden" name="action" value="insert">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="bet_id">ID Στοιχήματος (7 χαρακτήρες)</label>
                            <input type="text" id="bet_id" name="bet_id" maxlength="7" pattern=".{7}" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="description">Περιγραφή</label>
                            <input type="text" id="description" name="description" maxlength="60" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="stoixima_datetime">Ημερομηνία/Ώρα</label>
                            <input type="datetime-local" id="stoixima_datetime" name="stoixima_datetime" required class="form-input">
                        </div>
                        <div class="form-group">
                            <label for="employee_id">Υπάλληλος</label>
                            <select id="employee_id" name="employee_id" required class="form-input">
                                <option value="">-- Επιλέξτε Υπάλληλο --</option>
                                <?php foreach ($employees as $emp): ?>
                                    <option value="<?php echo htmlspecialchars($emp['employee_id']); ?>">
                                        <?php echo htmlspecialchars($emp['employee_id'] . ' - ' . $emp['employee_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary form-submit">
                        <span>Προσθήκη Στοιχήματος</span>
                        <span class="btn-icon">+</span>
                    </button>
                </form>
            </div>
            <?php endif; ?>

            <!-- Πίνακας Εμφάνισης -->
            <div class="page-card">
                <div class="card-header">
                    <h3 class="card-title">Κατάλογος Στοιχημάτων</h3>
                    <span class="card-count"><?php echo count($bets); ?> στοιχήματα</span>
                </div>
                
                <?php if (empty($bets)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <p>Δεν υπάρχουν στοιχήματα στη βάση δεδομένων.</p>
                    </div>
                <?php else: ?>
                    <div class="table-wrapper">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>ID Στοιχήματος</th>
                                    <th>Περιγραφή</th>
                                    <th>Ημερομηνία/Ώρα</th>
                                    <th>Υπάλληλος</th>
                                    <?php if ($isAdmin): ?>
                                    <th>Ενέργειες</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bets as $bet): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($bet['bet_id']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($bet['description']); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($bet['stoixima_datetime'])); ?></td>
                                        <td><?php echo htmlspecialchars($bet['employee_name'] ?? $bet['employee_id']); ?></td>
                                        <?php if ($isAdmin): ?>
                                        <td>
                                            <form method="POST" class="inline-form" onsubmit="return confirm('Είστε σίγουροι ότι θέλετε να διαγράψετε αυτό το στοίχημα;');">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="bet_id" value="<?php echo $bet['bet_id']; ?>">
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
