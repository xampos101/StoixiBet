<?php
require_once '../config/config.php';
require_once '../config/auth.php';

$message = '';
$messageType = '';
$isAdmin = isAdmin();

// Ανάκτηση όλων των εγγραφών από BETS_IN_CHARGE
$stmt = $pdo->query("
    SELECT b.*, y.employee_name 
    FROM BETS_IN_CHARGE b 
    LEFT JOIN YPALLHLOS y ON b.employee_id = y.employee_id 
    ORDER BY b.betsInCharge DESC
");
$betsInCharge = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Διαχείριση Στοιχημάτων ανά Υπάλληλο - StoixiBet Data Control</title>
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
                    <p class="header-subtitle">Στοιχήματα ανά Υπάλληλο</p>
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
                    <span class="page-icon">📋</span>
                    Στοιχήματα ανά Υπάλληλο
                </h2>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <?php if (!$isAdmin): ?>
                        <div class="view-only-badge">
                            <span>👁️ Προβολή μόνο</span>
                        </div>
                    <?php endif; ?>
                    <div class="info-badge">
                        <span>ℹ️ Αυτός ο πίνακας ενημερώνεται αυτόματα με trigger</span>
                    </div>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="message-alert message-<?php echo $messageType; ?>">
                    <span class="message-icon"><?php echo $messageType === 'success' ? '✓' : '⚠'; ?></span>
                    <span><?php echo htmlspecialchars($message); ?></span>
                </div>
            <?php endif; ?>

            <!-- Πίνακας Εμφάνισης -->
            <div class="page-card">
                <div class="card-header">
                    <h3 class="card-title">Κατάλογος Υπαλλήλων και Στοιχημάτων</h3>
                    <span class="card-count"><?php echo count($betsInCharge); ?> υπάλληλοι</span>
                </div>
                
                <?php if (empty($betsInCharge)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <p>Δεν υπάρχουν εγγραφές στη βάση δεδομένων.</p>
                    </div>
                <?php else: ?>
                    <div class="table-wrapper">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>ID Υπαλλήλου</th>
                                    <th>Όνομα Υπαλλήλου</th>
                                    <th>Αριθμός Στοιχημάτων</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($betsInCharge as $record): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($record['employee_id']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($record['employee_name'] ?? '-'); ?></td>
                                        <td class="balance-cell"><strong><?php echo htmlspecialchars($record['betsInCharge']); ?></strong></td>
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
