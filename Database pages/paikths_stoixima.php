<?php
require_once '../config/config.php';
require_once '../config/auth.php';

$message = '';
$messageType = '';
$isAdmin = isAdmin();

// Ανάκτηση όλων των εγγραφών από το VIEW PAIKTHS_STOIXIMA
$stmt = $pdo->query("
    SELECT * 
    FROM PAIKTHS_STOIXIMA 
    ORDER BY player_id, bet_id
");
$playerBets = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Παίκτες-Στοιχήματα - StoixiBet Data Control</title>
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
                    <p class="header-subtitle">Παίκτες και Στοιχήματα</p>
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
                    <span class="page-icon">🔗</span>
                    Παίκτες και Στοιχήματα
                </h2>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <?php if (!$isAdmin): ?>
                        <div class="view-only-badge">
                            <span>👁️ Προβολή μόνο</span>
                        </div>
                    <?php endif; ?>
                    <div class="info-badge">
                        <span>ℹ️ Προβολή από VIEW (Μόνο Ανάγνωση)</span>
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
                    <h3 class="card-title">Κατάλογος Παικτών και Στοιχημάτων</h3>
                    <span class="card-count"><?php echo count($playerBets); ?> εγγραφές</span>
                </div>
                
                <?php if (empty($playerBets)): ?>
                    <div class="empty-state">
                        <div class="empty-icon">📭</div>
                        <p>Δεν υπάρχουν εγγραφές στη βάση δεδομένων.</p>
                    </div>
                <?php else: ?>
                    <div class="table-wrapper">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>ID Παίκτη</th>
                                    <th>Username</th>
                                    <th>ID Αγώνα</th>
                                    <th>ID Στοιχήματος</th>
                                    <th>Περιγραφή Στοιχήματος</th>
                                    <th>Ποσό Στοιχήματος</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($playerBets as $record): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($record['player_id']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($record['username']); ?></td>
                                        <td><?php echo htmlspecialchars($record['match_id']); ?></td>
                                        <td><strong><?php echo htmlspecialchars($record['bet_id']); ?></strong></td>
                                        <td><?php echo htmlspecialchars($record['bet_desc']); ?></td>
                                        <td class="balance-cell"><?php echo number_format($record['bet_amount'], 2); ?> €</td>
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
