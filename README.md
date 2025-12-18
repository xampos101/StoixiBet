# 🎰 StoixiBet Data Control

<div align="center">

![StoixiBet Data Control](https://img.shields.io/badge/StoixiBet-Data%20Control-blue?style=for-the-badge)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

**Ένα σύγχρονο σύστημα διαχείρισης βάσης δεδομένων για καζίνο και στοιχηματικές πλατφόρμες**

🌐 **Live Demo**: [http://lessons.dcie.teiemt.gr/db2/student_2507/index.php](http://lessons.dcie.teiemt.gr/db2/student_2507/index.php)

[Features](#-features) • [Installation](#-installation) • [Database Schema](#-database-schema) • [Screenshots](#-screenshots) • [ER Diagram](#️-er-diagram) • [Usage](#-usage) • [Team](#-team) • [License](#-license)

</div>

---

## 📋 Περιγραφή

Το **StoixiBet Data Control** είναι ένα σύγχρονο web-based σύστημα διαχείρισης βάσης δεδομένων που αναπτύχθηκε για τα πλαίσια του μαθήματος **"Ειδικά Θέματα Βάσεων Δεδομένων"** του Τμήματος Πληροφορικής του Δημοκρίτειου Πανεπιστημίου Θράκης.

Το σύστημα προσφέρει πλήρη λειτουργικότητα για διαχείριση:
- 👥 **Παικτών** (Players)
- 👔 **Υπαλλήλων** (Employees)
- 🎲 **Στοιχημάτων** (Bets)
- 📊 **Συμμετοχών** (Participations)
- 💵 **Καταθέσεων** (Deposits)
- 💳 **Λογαριασμών** (Accounts)
- ⚽ **Αγώνων** (Matches)
- 🎁 **Μπόνους** (Bonuses)

## ✨ Features

### 🎨 Modern UI/UX
- **Cutting-edge Design**: Dark theme με neon accents και glassmorphism effects
- **3D Animations**: GSAP-powered animations με ScrollTrigger
- **Custom Cursor**: Interactive custom cursor με trailing particles
- **Smooth Scrolling**: Lenis smooth scroll integration
- **Responsive Design**: Fully responsive για όλες τις συσκευές

### 🔐 Security & Authentication
- **Admin Authentication**: Secure login system για διαχειριστές
- **View-Only Mode**: Regular users μπορούν μόνο να βλέπουν δεδομένα
- **Session Management**: Secure session handling
- **PDO Prepared Statements**: Protection από SQL injection

### 📊 Database Management
- **CRUD Operations**: Full Create, Read, Update, Delete functionality
- **Real-time Updates**: Instant feedback για όλες τις operations
- **Data Validation**: Client-side και server-side validation
- **Error Handling**: Comprehensive error handling και user feedback

### 🎯 Interactive Features
- **GitHub Profile Previews**: Hover preview cards με real-time GitHub API data
- **Animated Background**: Particle effects, network animations, και card symbols
- **Loading Screen**: Beautiful loading animation με progress indicator
- **Scroll Animations**: GSAP ScrollTrigger για smooth reveal animations

## 🛠️ Technologies

### Backend
- **PHP 8.0+**: Server-side logic
- **MySQL 8.0+**: Database management
- **PDO**: Secure database access

### Frontend
- **HTML5**: Semantic markup
- **CSS3**: Modern styling με advanced features (backdrop-filter, clip-path, 3D transforms)
- **JavaScript (ES6+)**: Interactive functionality
- **GSAP 3.12.5**: Professional animations
- **Three.js**: 3D graphics (optional)

### Libraries & Tools
- **Lenis**: Smooth scrolling
- **GitHub API**: Real-time profile data
- **Inter Font**: Modern typography

## 📦 Installation

### Προαπαιτούμενα

- PHP 8.0 ή νεότερη έκδοση
- MySQL 8.0 ή νεότερη έκδοση
- Web server (Apache/Nginx) ή PHP built-in server
- Modern web browser (Chrome, Firefox, Edge, Safari)

### Βήματα Εγκατάστασης

1. **Clone το repository**
   ```bash
   git clone https://github.com/your-username/stoixibet-data-control.git
   cd stoixibet-data-control
   ```

2. **Δημιουργήστε τη βάση δεδομένων**
   ```sql
   CREATE DATABASE Stoiximatiki;
   ```
   Εισαγάγετε το SQL schema από το αρχείο `database/Stoiximatiki.sql`
   
   > **Σημείωση**: Το SQL αρχείο περιέχει μόνο το καθαρό schema της βάσης (πίνακες, views, triggers, stored procedures) χωρίς INSERT ή SELECT statements, ώστε να είναι εύκολη η εγκατάσταση και η κατανόηση της δομής.

3. **Ρυθμίστε το config.php**
   ```bash
   cp config/config.php.example config/config.php
   ```
   Επεξεργαστείτε το `config/config.php` και προσθέστε τα database credentials σας:
   ```php
   $host = 'localhost';
   $dbname = 'stoiximatiki';
   $username = 'your_username';
   $password = 'your_password';
   ```

4. **Ανοίξτε το project στον browser**
   ```bash
   php -S localhost:8000
   ```
   ή χρησιμοποιήστε τον web server σας

5. **Login ως Admin**
   - Username: `admin`
   - Password: `admin`

> 🌐 **Live Demo**: Το σύστημα είναι διαθέσιμο online στο [http://lessons.dcie.teiemt.gr/db2/student_2507/index.php](http://lessons.dcie.teiemt.gr/db2/student_2507/index.php)

## 🚀 Usage

### Admin Mode
- **Login**: Κάντε login με τα admin credentials
- **Edit Data**: Προσθέστε, επεξεργαστείτε, ή διαγράψτε records
- **Full Access**: Πλήρης πρόσβαση σε όλες τις λειτουργίες

### View-Only Mode
- **No Login Required**: Regular users μπορούν να βλέπουν δεδομένα
- **Read-Only**: Δεν μπορούν να κάνουν αλλαγές
- **Browse Tables**: Μπορούν να περιηγηθούν σε όλους τους πίνακες

### Navigation
- **Main Dashboard**: Επιλέξτε τον πίνακα που θέλετε να διαχειριστείτε
- **Table Management**: Κάντε click στον πίνακα για να τον ανοίξετε
- **CRUD Operations**: Χρησιμοποιήστε τα forms για να προσθέσετε/επεξεργαστείτε/διαγράψετε records


## 📊 Database Schema

Η βάση δεδομένων **Stoiximatiki** αποτελείται από τους παρακάτω πίνακες:

### Κύριοι Πίνακες
- **PAIKTHS** - Πίνακας παικτών (player_id, username, balance)
- **YPALLHLOS** - Πίνακας υπαλλήλων (employee_id, employee_name, salary)
- **AGONAS** - Πίνακας αγώνων (match_id, home_team, away_team, match_date)
- **STOIXIMA** - Πίνακας στοιχημάτων (bet_id, match_id, bet_desc, bet_date, employee_id)
- **SYMMETOXI** - Πίνακας συμμετοχών παικτών σε στοιχήματα (bet_id, player_id, bet_amount, bet_date)
- **BANK_ACCOUNT** - Πίνακας τραπεζικών λογαριασμών (IBAN, player_id, bank_name)
- **SYNALLAGES** - Πίνακας συναλλαγών (transaction_id, player_id, amount, transaction_date, transaction_type)
- **BONUS** - Πίνακας μπόνους (bonus_id, bonus_type, bonus_value, expiration_date)
- **PAIKTHS_BONUS** - Ενδιάμεσος πίνακας για σχέση N:M μεταξύ παικτών και μπόνους
- **BETS_IN_CHARGE** - Πίνακας στοιχημάτων ανά υπάλληλο (employee_id, betsInCharge)

### Views
- **PAIKTHS_STOIXIMA** - View που συνδυάζει πληροφορίες παικτών, στοιχημάτων και συμμετοχών

### Triggers
- **yp_diaxeirizetai_bet** - Trigger που ενημερώνει αυτόματα τον πίνακα BETS_IN_CHARGE όταν προστίθεται νέο στοίχημα

### Stored Procedures
- **AddYpallhlos** - Procedure για εισαγωγή νέου υπαλλήλου

### Σχέσεις
- **1:1** - PAIKTHS ↔ BANK_ACCOUNT (κάθε παίκτης έχει έναν μόνο λογαριασμό)
- **1:N** - AGONAS → STOIXIMA (ένας αγώνας έχει πολλά στοιχήματα)
- **1:N** - YPALLHLOS → STOIXIMA (ένας υπάλληλος διαχειρίζεται πολλά στοιχήματα)
- **1:N** - PAIKTHS → SYNALLAGES (ένας παίκτης έχει πολλές συναλλαγές)
- **N:M** - PAIKTHS ↔ STOIXIMA (μέσω SYMMETOXI)
- **N:M** - PAIKTHS ↔ BONUS (μέσω PAIKTHS_BONUS)

## 📸 Screenshots

### Welcome Page
Η κύρια σελίδα υποδοχής με το σύγχρονο UI design και animations.

![Welcome Page](screenshots/Welcome%20Page.png)

### Loading Page
Η σελίδα φόρτωσης με animated progress indicator.

![Loading Page](screenshots/Loading%20Page.png)

### Login Page
Η σελίδα σύνδεσης για διαχειριστές με secure authentication.

![Login Page](screenshots/Login%20Page.png)

### Tables Page
Η κύρια σελίδα διαχείρισης με όλους τους διαθέσιμους πίνακες.

![Tables Page](screenshots/Tables%20Page.png)

### Players Table (View-Only Mode)
Προβολή του πίνακα παικτών σε view-only mode για regular users.

![Players Table View-Only](screenshots/Players%20TablePage.png)

### Players Table (Admin Mode)
Πλήρης διαχείριση του πίνακα παικτών με CRUD operations για διαχειριστές.

![Players Table Admin](screenshots/Players%20Table%20Page(admin).png)

## 🗺️ ER Diagram

Το Entity-Relationship (ER) διάγραμμα της βάσης δεδομένων:

![ER Diagram](docs/Diagram.png)

> 📋 Το ER διάγραμμα απεικονίζει όλες τις οντότητες, τα χαρακτηριστικά τους και τις σχέσεις μεταξύ τους στη βάση δεδομένων Stoiximatiki.

## 🗂️ Project Structure

```
stoixibet-data-control/
├── index.php                    # Main dashboard
├── login.php                    # Admin login page
├── logout.php                   # Logout handler
│
├── config/                      # Configuration files
│   ├── config.php.example      # Database config template
│   └── auth.php                # Authentication logic
│
├── Database pages/              # Database management pages
│   ├── paikths.php            # Players management
│   ├── ypallhlos.php          # Employees management
│   ├── stoixhma.php           # Bets management
│   ├── summetoxh.php          # Participations management
│   ├── katathesi.php          # Deposits management
│   ├── logariasmos.php        # Accounts management
│   ├── agonas.php             # Matches management
│   ├── bonus.php              # Bonuses management
│   ├── paikths_bonus.php      # Player-Bonus assignments
│   ├── bets_in_charge.php     # Bets in charge management
│   └── paikths_stoixima.php   # Player-Bets view
│
├── Frontend/                    # Frontend assets
│   ├── style.css              # Main stylesheet
│   ├── script.js              # Main JavaScript
│   ├── particles.js           # Particle effects
│   ├── network.js             # Network animations
│   └── three-scene.js         # 3D scene (optional)
│
├── assets/                      # Images and media
│   ├── university_logo.png
│   ├── xampos101.gif
│   ├── mouxtaris.png
│   └── dipapag.png
│
├── database/                    # Database files
│   └── Stoiximatiki.sql       # Main database schema (clean, no inserts/selects)
│
├── docs/                        # Documentation & diagrams
│   └── Diagram.png
│
├── screenshots/                 # Application screenshots
│   ├── Welcome Page.png
│   ├── Loading Page.png
│   ├── Login Page.png
│   ├── Tables Page.png
│   ├── Players TablePage.png
│   └── Players Table Page(admin).png
│
└── README.md                    # This file
```

## 🔧 Configuration

### Database Configuration
Επεξεργαστείτε το `config/config.php`:
```php
$host = 'localhost';
$dbname = 'stoiximatiki';
$username = 'your_username';
$password = 'your_password';
```

### Admin Credentials
Default admin credentials:
- **Username**: `admin`
- **Password**: `admin`

> ⚠️ **Security Note**: Αλλάξτε τα admin credentials σε production environment!

## 🐛 Troubleshooting

### Database Connection Issues
- Ελέγξτε ότι το MySQL server τρέχει
- Επιβεβαιώστε τα credentials στο `config.php`
- Ελέγξτε ότι η βάση δεδομένων έχει δημιουργηθεί

### PHP Errors
- Ελέγξτε ότι έχετε PHP 8.0+
- Ενεργοποιήστε το PDO extension
- Ελέγξτε τα error logs

### JavaScript Not Working
- Ελέγξτε ότι οι CDN links είναι accessible
- Ανοίξτε το browser console για errors
- Ελέγξτε ότι το JavaScript είναι enabled

## 📝 License

Αυτό το project αναπτύχθηκε για εκπαιδευτικούς σκοπούς στο πλαίσιο του μαθήματος "Ειδικά Θέματα Βάσεων Δεδομένων" του Τμήματος Πληροφορικής του Δημοκρίτειου Πανεπιστημίου Θράκης.

## 🙏 Acknowledgments

- **Τμήμα Πληροφορικής** - Δημοκρίτειο Πανεπιστήμιο Θράκης
- **GSAP** - GreenSock Animation Platform
- **GitHub** - For hosting και API

## 👥 StoixiBet Team

Αυτό το project αναπτύχθηκε από τους:

- **[Χαράλαμπος Ευθυμιάδης](https://github.com/xampos101)** - xampos101
- **[Δημήτρης Μουχτάρης](https://github.com/mouxtaris)** - mouxtaris
- **[Δημήτρης Παπαγιάννης](https://github.com/dipapag)** - dipapag

**Τμήμα Πληροφορικής**  
**Δημοκρίτειο Πανεπιστήμιο Θράκης**

## 📧 Contact

Για ερωτήσεις ή υποστήριξη, μπορείτε να επικοινωνήσετε με την ομάδα μέσω GitHub.

---

<div align="center">
   

**Made with ❤️ by the StoixiBet Team**

[![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com)
[![DUTH](https://img.shields.io/badge/DUTH-University-blue?style=for-the-badge)](https://www.cs.duth.gr)

</div>
