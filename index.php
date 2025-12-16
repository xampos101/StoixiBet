<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StoixiBet Data Control - Σύστημα Διαχείρισης</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Frontend/style.css">
    <!-- GSAP Animation Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/TextPlugin.min.js"></script>
    <!-- Three.js for 3D Graphics -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <!-- Lenis Smooth Scroll -->
    <script src="https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.29/bundled/lenis.min.js"></script>
</head>
<body>
    <!-- Loading Screen -->
    <div class="loader-wrapper" id="loader">
        <div class="loader-content">
            <div class="loader-logo">
                <div class="loader-logo-glow"></div>
                <img src="assets/university_logo.png" alt="Logo Δημοκρίτειο Πανεπιστήμιο Θράκης" class="loader-university-logo">
            </div>
            <div class="loader-text">StoixiBet Data Control</div>
            <div class="loader-progress">
                <div class="loader-progress-bar"></div>
            </div>
            <div class="loader-percentage">0%</div>
        </div>
        <div class="loader-background">
            <canvas id="loader-canvas"></canvas>
        </div>
    </div>

    <!-- Custom Cursor -->
    <div class="cursor" id="cursor">
        <div class="cursor-dot"></div>
        <div class="cursor-outline"></div>
    </div>
    <div class="cursor-trail"></div>
    
    <!-- Background Card Symbols - Grid Layout (3 rows x 5 columns) -->
    <div class="background-cards-grid">
        <!-- Row 1 -->
        <div class="card-symbol-grid" data-suit="♠" data-color="white">♠</div>
        <div class="card-symbol-grid" data-suit="♥" data-color="blue">♥</div>
        <div class="card-symbol-grid" data-suit="♦" data-color="blue">♦</div>
        <div class="card-symbol-grid" data-suit="♣" data-color="white">♣</div>
        <div class="card-symbol-grid" data-suit="♠" data-color="white">♠</div>
        <!-- Row 2 -->
        <div class="card-symbol-grid" data-suit="♥" data-color="blue">♥</div>
        <div class="card-symbol-grid" data-suit="♦" data-color="blue">♦</div>
        <div class="card-symbol-grid" data-suit="♣" data-color="white">♣</div>
        <div class="card-symbol-grid" data-suit="♠" data-color="white">♠</div>
        <div class="card-symbol-grid" data-suit="♥" data-color="blue">♥</div>
        <!-- Row 3 -->
        <div class="card-symbol-grid" data-suit="♦" data-color="blue">♦</div>
        <div class="card-symbol-grid" data-suit="♣" data-color="white">♣</div>
        <div class="card-symbol-grid" data-suit="♠" data-color="white">♠</div>
        <div class="card-symbol-grid" data-suit="♥" data-color="blue" data-faded="true">♥</div>
        <div class="card-symbol-grid" data-suit="♦" data-color="blue" data-faded="true">♦</div>
    </div>
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
                    <p class="header-subtitle">Σύστημα Διαχείρισης Βάσης Δεδομένων</p>
                </div>
            </div>
            <div class="header-actions">
                <?php
                session_start();
                if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
                    echo '<a href="logout.php" class="btn-secondary">Αποσύνδεση</a>';
                } else {
                    echo '<a href="login.php" class="btn-secondary">Σύνδεση</a>';
                }
                ?>
            </div>
        </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-background">
                <div class="hero-gradient hero-gradient-top"></div>
                <div class="hero-gradient hero-gradient-bottom"></div>
                <!-- Animated Gradient Mesh -->
                <div class="gradient-mesh"></div>
                <!-- Neural Network Nodes -->
                <canvas id="network-canvas" class="network-canvas"></canvas>
                <!-- Holographic Scan Lines -->
                <div class="scan-lines"></div>
                <!-- Animated Particles (WebGL) -->
                <canvas id="particles-canvas" class="particles-canvas"></canvas>
                <!-- Card Symbols Background Animation -->
                <div class="background-cards">
                    <div class="card-symbol-bg" data-suit="♠">♠</div>
                    <div class="card-symbol-bg" data-suit="♥">♥</div>
                    <div class="card-symbol-bg" data-suit="♦">♦</div>
                    <div class="card-symbol-bg" data-suit="♣">♣</div>
                    <div class="card-symbol-bg" data-suit="♠">♠</div>
                    <div class="card-symbol-bg" data-suit="♥">♥</div>
                    <div class="card-symbol-bg" data-suit="♦">♦</div>
                    <div class="card-symbol-bg" data-suit="♣">♣</div>
                    <div class="card-symbol-bg" data-suit="♠">♠</div>
                    <div class="card-symbol-bg" data-suit="♥">♥</div>
                    <div class="card-symbol-bg" data-suit="♦">♦</div>
                    <div class="card-symbol-bg" data-suit="♣">♣</div>
                    <div class="card-symbol-bg" data-suit="♠">♠</div>
                    <div class="card-symbol-bg" data-suit="♥">♥</div>
                    <div class="card-symbol-bg" data-suit="♦">♦</div>
                    <div class="card-symbol-bg" data-suit="♣">♣</div>
                    <div class="card-symbol-bg" data-suit="♠">♠</div>
                    <div class="card-symbol-bg" data-suit="♥">♥</div>
                    <div class="card-symbol-bg" data-suit="♦">♦</div>
                    <div class="card-symbol-bg" data-suit="♣">♣</div>
                </div>
            </div>
            
            <div class="hero-container">
                <div class="hero-content">
                    <div class="hero-text">
                        <h2 class="hero-title">
                            Διαχείρηση Βάσης Δεδομένων StoixiBet
                        </h2>
                        
                        <!-- University Logo and Team Info with About Section -->
                        <div class="hero-sections-wrapper">
                            <div class="hero-team-section">
                                <a href="https://www.cs.duth.gr/index.xhtml" target="_blank" rel="noopener noreferrer" class="hero-university-link">
                                    <img src="assets/university_logo.png" alt="Logo Δημοκρίτειο Πανεπιστήμιο Θράκης" class="hero-university-logo">
                                </a>
                                <div class="hero-team-info">
                                    <div class="hero-team-text">
                                        <strong>Τμήμα Πληροφορικής</strong>
                                        <span>Δημοκρίτειο Πανεπιστήμιο Θράκης</span>
                                    </div>
                                    <div class="hero-team-members">
                                        <div class="hero-team-member">
                                            <a href="https://github.com/xampos101" target="_blank" rel="noopener noreferrer" class="hero-member-name-link">
                                                <span class="hero-member-name">Χαράλαμπος Ευθυμιάδης</span>
                                            </a>
                                            <div class="hero-github-link-wrapper" data-github-user="xampos101">
                                                <a href="https://github.com/xampos101" target="_blank" rel="noopener noreferrer" class="hero-github-link">
                                                    <svg class="github-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                                                    </svg>
                                                </a>
                                                <div class="github-preview" data-github="xampos101">
                                                    <div class="github-preview-header">
                                                        <div class="github-preview-avatar">
                                                            <img src="assets/xampos101.gif" alt="xampos101" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22%233b82f6%22/%3E%3Ctext x=%2250%22 y=%2255%22 font-size=%2230%22 text-anchor=%22middle%22 fill=%22white%22%3EX%3C/text%3E%3C/svg%3E'">
                                                        </div>
                                                        <div class="github-preview-info">
                                                            <div class="github-preview-username">xampos101</div>
                                                            <div class="github-preview-name">Χαράλαμπος Ευθυμιάδης</div>
                                                        </div>
                                                    </div>
                                                    <div class="github-preview-bio"></div>
                                                    <div class="github-preview-stats">
                                                        <div class="github-stat">
                                                            <span class="github-stat-value">-</span>
                                                            <span class="github-stat-label">followers</span>
                                                        </div>
                                                        <span class="github-stat-separator">·</span>
                                                        <div class="github-stat">
                                                            <span class="github-stat-value">-</span>
                                                            <span class="github-stat-label">following</span>
                                                        </div>
                                                    </div>
                                                    <div class="github-preview-footer">
                                                        <a href="https://github.com/xampos101" target="_blank" rel="noopener noreferrer" class="github-preview-link">
                                                            View on GitHub →
                                                        </a>
                                                    </div>
                                                    <div class="github-preview-loading">
                                                        <div class="github-loading-spinner"></div>
                                                        <span>Loading profile...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hero-team-member">
                                            <a href="https://github.com/mouxtaris" target="_blank" rel="noopener noreferrer" class="hero-member-name-link">
                                                <span class="hero-member-name">Δημήτρης Μουχτάρης</span>
                                            </a>
                                            <div class="hero-github-link-wrapper" data-github-user="mouxtaris">
                                                <a href="https://github.com/mouxtaris" target="_blank" rel="noopener noreferrer" class="hero-github-link">
                                                    <svg class="github-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                                                    </svg>
                                                </a>
                                                <div class="github-preview" data-github="mouxtaris">
                                                    <div class="github-preview-header">
                                                        <div class="github-preview-avatar">
                                                            <img src="assets/mouxtaris.png" alt="mouxtaris" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22%233b82f6%22/%3E%3Ctext x=%2250%22 y=%2255%22 font-size=%2230%22 text-anchor=%22middle%22 fill=%22white%22%3EM%3C/text%3E%3C/svg%3E'">
                                                        </div>
                                                        <div class="github-preview-info">
                                                            <div class="github-preview-username">mouxtaris</div>
                                                            <div class="github-preview-name">Δημήτρης Μουχτάρης</div>
                                                        </div>
                                                    </div>
                                                    <div class="github-preview-bio"></div>
                                                    <div class="github-preview-stats">
                                                        <div class="github-stat">
                                                            <span class="github-stat-value">-</span>
                                                            <span class="github-stat-label">followers</span>
                                                        </div>
                                                        <span class="github-stat-separator">·</span>
                                                        <div class="github-stat">
                                                            <span class="github-stat-value">-</span>
                                                            <span class="github-stat-label">following</span>
                                                        </div>
                                                    </div>
                                                    <div class="github-preview-footer">
                                                        <a href="https://github.com/mouxtaris" target="_blank" rel="noopener noreferrer" class="github-preview-link">
                                                            View on GitHub →
                                                        </a>
                                                    </div>
                                                    <div class="github-preview-loading">
                                                        <div class="github-loading-spinner"></div>
                                                        <span>Loading profile...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hero-team-member">
                                            <a href="https://github.com/dipapag" target="_blank" rel="noopener noreferrer" class="hero-member-name-link">
                                                <span class="hero-member-name">Δημήτρης Παπαγιάννης</span>
                                            </a>
                                            <div class="hero-github-link-wrapper" data-github-user="dipapag">
                                                <a href="https://github.com/dipapag" target="_blank" rel="noopener noreferrer" class="hero-github-link">
                                                    <svg class="github-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                                                    </svg>
                                                </a>
                                                <div class="github-preview" data-github="dipapag">
                                                    <div class="github-preview-header">
                                                        <div class="github-preview-avatar">
                                                            <img src="assets/dipapag.png" alt="dipapag" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22%3E%3Ccircle cx=%2250%22 cy=%2250%22 r=%2240%22 fill=%22%233b82f6%22/%3E%3Ctext x=%2250%22 y=%2255%22 font-size=%2230%22 text-anchor=%22middle%22 fill=%22white%22%3ED%3C/text%3E%3C/svg%3E'">
                                                        </div>
                                                        <div class="github-preview-info">
                                                            <div class="github-preview-username">dipapag</div>
                                                            <div class="github-preview-name">Δημήτρης Παπαγιάννης</div>
                                                        </div>
                                                    </div>
                                                    <div class="github-preview-bio"></div>
                                                    <div class="github-preview-stats">
                                                        <div class="github-stat">
                                                            <span class="github-stat-value">-</span>
                                                            <span class="github-stat-label">followers</span>
                                                        </div>
                                                        <span class="github-stat-separator">·</span>
                                                        <div class="github-stat">
                                                            <span class="github-stat-value">-</span>
                                                            <span class="github-stat-label">following</span>
                                                        </div>
                                                    </div>
                                                    <div class="github-preview-footer">
                                                        <a href="https://github.com/dipapag" target="_blank" rel="noopener noreferrer" class="github-preview-link">
                                                            View on GitHub →
                                                        </a>
                                                    </div>
                                                    <div class="github-preview-loading">
                                                        <div class="github-loading-spinner"></div>
                                                        <span>Loading profile...</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="hero-about-section">
                                <h3 class="hero-about-title">Σχετικά με το Σύστημα</h3>
                                <div class="hero-about-text">
                                    <p>Ένα σύγχρονο σύστημα διαχείρισης βάσης δεδομένων για καζίνο και στοιχηματικές πλατφόρμες. Διαθέτει πλήρη λειτουργικότητα για διαχείριση παικτών, υπαλλήλων, στοιχημάτων και οικονομικών συναλλαγών.</p>
                                    <p>Το σύστημα φτιαχτηκε για τα πλαίσια του μαθήματος "Ειδικά Θέματα Βάσεων Δεδομένων" του <a href="https://www.cs.duth.gr" target="_blank" rel="noopener noreferrer" class="university-link">Τμήματος Πληροφορικής του Δημοκρίτειου Πανεπιστημίου Θράκης</a>.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="hero-buttons">
                            <a href="#dash" class="btn-primary">Άνοιγμα Πίνακα</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cards Section -->
        <section id="dash" class="cards-section">
            <div class="cards-container">
                <div class="section-header">
                    <h3 class="section-title">
                        <span class="title-word">Πίνακες</span>
                        <span class="title-word">Διαχείρισης</span>
                    </h3>
                    <div class="section-divider">
                        <div class="divider-line"></div>
                        <div class="divider-glow"></div>
                    </div>
                </div>

                <div class="cards-grid">
                    <a href="Database pages/paikths.php" class="card-link">
                        <article class="card">
                            <div class="card-glow"></div>
                            <div class="card-content">
                                <div class="card-icon">👥</div>
                                <h4 class="card-title">Παίκτες</h4>
                                <p class="card-description">Διαχείριση προφίλ και στοιχείων παικτών</p>
                            </div>
                        </article>
                    </a>

                    <a href="Database pages/ypallhlos.php" class="card-link">
                        <article class="card">
                            <div class="card-glow"></div>
                            <div class="card-content">
                                <div class="card-icon">👔</div>
                                <h4 class="card-title">Υπάλληλοι</h4>
                                <p class="card-description">Προσωπικό και ρόλοι εργαζομένων</p>
                            </div>
                        </article>
                    </a>

                    <a href="Database pages/stoixhma.php" class="card-link">
                        <article class="card card-highlight">
                            <div class="card-glow"></div>
                            <div class="card-content">
                                <div class="card-icon">🎲</div>
                                <h4 class="card-title">Στοιχήματα</h4>
                                <p class="card-description">Live και Pre-game στοιχήματα</p>
                            </div>
                        </article>
                    </a>

                    <a href="Database pages/summetoxh.php" class="card-link">
                        <article class="card">
                            <div class="card-glow"></div>
                            <div class="card-content">
                                <div class="card-icon">📊</div>
                                <h4 class="card-title">Συμμετοχές</h4>
                                <p class="card-description">Αρχείο κινήσεων και συμμετοχών</p>
                            </div>
                        </article>
                    </a>

                    <a href="Database pages/katathesi.php" class="card-link">
                        <article class="card">
                            <div class="card-glow"></div>
                            <div class="card-content">
                                <div class="card-icon">💵</div>
                                <h4 class="card-title">Καταθέσεις</h4>
                                <p class="card-description">Οικονομικά στοιχεία και συναλλαγές</p>
                            </div>
                        </article>
                    </a>

                    <a href="Database pages/logariasmos.php" class="card-link">
                        <article class="card">
                            <div class="card-glow"></div>
                            <div class="card-content">
                                <div class="card-icon">💳</div>
                                <h4 class="card-title">Λογαριασμοί</h4>
                                <p class="card-description">Status και διαχείριση χρηστών</p>
                            </div>
                        </article>
                    </a>

                    <a href="Database pages/agonas.php" class="card-link">
                        <article class="card card-highlight">
                            <div class="card-glow"></div>
                            <div class="card-content">
                                <div class="card-icon">⚽</div>
                                <h4 class="card-title">Αγώνες</h4>
                                <p class="card-description">Πρόγραμμα και σκορ αγώνων</p>
                            </div>
                        </article>
                    </a>

                    <a href="Database pages/bonus.php" class="card-link">
                        <article class="card">
                            <div class="card-glow"></div>
                            <div class="card-content">
                                <div class="card-icon">🎁</div>
                                <h4 class="card-title">Μπόνους</h4>
                                <p class="card-description">Προσφορές και ειδικά μπόνους</p>
                            </div>
                        </article>
                    </a>

                    <a href="Database pages/paikths_bonus.php" class="card-link">
                        <article class="card">
                            <div class="card-glow"></div>
                            <div class="card-content">
                                <div class="card-icon">✅</div>
                                <h4 class="card-title">Παίκτες-Μπόνους</h4>
                                <p class="card-description">Αναθέσεις μπόνους σε παίκτες</p>
                            </div>
                        </article>
                    </a>
                </div>
            </div>
        </section>

    </main>

    <!-- Progress Indicator -->
    <div class="scroll-progress">
        <div class="scroll-progress-bar"></div>
    </div>

    <!-- Scripts -->
    <script src="Frontend/particles.js"></script>
    <script src="Frontend/network.js"></script>
    <script src="Frontend/script.js"></script>
</body>
</html>
