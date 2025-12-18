# 🔄 Οδηγίες Ενημέρωσης PHP Files

## 📋 Αρχεία που Χρειάζονται Αλλαγές

Μετά την αλλαγή των ονομάτων πινάκων, πρέπει να ενημερώσετε τα παρακάτω PHP files:

### Files στο `Database pages/`:
1. `paikths.php` - PAIKTHS
2. `ypallhlos.php` - YPALLHLOS  
3. `stoixhma.php` - STOIXHMA → **μετατρέπεται σε** stoixima?
4. `summetoxh.php` - SUMMETOXH → **μετατρέπεται σε** symmetoxi
5. `katathesi.php` - KATATHESI
6. `logariasmos.php` - LOGARIASMOS → **μετατρέπεται σε** bank_account
7. `agonas.php` - AGONAS
8. `bonus.php` - BONUS
9. `paikths_bonus.php` - PAIKTHS_BONUS

### Νέα Files (αν χρειάζονται):
- `bets_in_charge.php` (νέος πίνακας)
- `paikths_stoixima.php` (νέος πίνακας)
- `synallages.php` (νέος πίνακας)

## 🔍 Αλλαγές που Πρέπει να Κάνετε

### 1. SQL Queries (SELECT, INSERT, UPDATE, DELETE)

**Παράδειγμα:**
```php
// ΠΡΙΝ:
$stmt = $pdo->prepare("SELECT * FROM SUMMETOXH WHERE player_id = ?");

// ΜΕΤΑ:
$stmt = $pdo->prepare("SELECT * FROM symmetoxi WHERE player_id = ?");
```

**Αλλαγές ονομάτων:**
- `SUMMETOXH` → `symmetoxi`
- `LOGARIASMOS` → `bank_account`
- `STOIXHMA` → `stoixima` (αν ισχύει)

### 2. Filenames (αν αλλάζουν)

Αν αλλάξετε το όνομα του πίνακα, μπορείτε να αλλάξετε και το filename:
- `summetoxh.php` → `symmetoxi.php`
- `logariasmos.php` → `bank_account.php`
- `stoixhma.php` → `stoixima.php`

**ΣΗΜΕΙΩΣΗ:** Αν αλλάξετε filenames, πρέπει να ενημερώσετε και το `index.php`!

### 3. Update στο index.php

```php
// ΠΡΙΝ:
<a href="Database pages/summetoxh.php" class="card-link">
    <h4 class="card-title">Συμμετοχές</h4>
</a>

// ΜΕΤΑ (αν αλλάξετε filename):
<a href="Database pages/symmetoxi.php" class="card-link">
    <h4 class="card-title">Συμμετοχές</h4>
</a>
```

## 🛠️ Script για Mass Find & Replace

### Στο VS Code / Editor:

1. **Find & Replace (Ctrl+Shift+H):**
   - Find: `FROM SUMMETOXH`
   - Replace: `FROM symmetoxi`
   - Scope: `Database pages/`

2. **Επαναλάβετε για:**
   - `SUMMETOXH` → `symmetoxi`
   - `LOGARIASMOS` → `bank_account`
   - `STOIXHMA` → `stoixima` (αν ισχύει)

3. **Ελέγξτε και για:**
   - `INSERT INTO SUMMETOXH`
   - `UPDATE SUMMETOXH`
   - `DELETE FROM SUMMETOXH`

## ✅ Checklist Ενημέρωσης

### Σε κάθε PHP file:
- [ ] SELECT queries
- [ ] INSERT queries
- [ ] UPDATE queries
- [ ] DELETE queries
- [ ] JOIN queries (π.χ. `FROM PAIKTHS p JOIN SUMMETOXH s`)

### Στο index.php:
- [ ] Links προς database pages
- [ ] Αν άλλαξε filename, update το href

### Γενικά:
- [ ] Test όλες τις λειτουργίες
- [ ] Ελέγξτε για syntax errors
- [ ] Ελέγξτε Foreign Keys (αν άλλαξαν)

## 🎯 Προτεινόμενη Σειρά

1. **Πρώτα:** Ενημερώστε το SQL schema στον server
2. **Μετά:** Ενημερώστε τα PHP files
3. **Τέλος:** Test everything!

---

**Συμβουλή:** Χρησιμοποιήστε Git commit πριν κάνετε αλλαγές, ώστε να μπορείτε να επιστρέψετε αν κάτι πάει στραβά!
