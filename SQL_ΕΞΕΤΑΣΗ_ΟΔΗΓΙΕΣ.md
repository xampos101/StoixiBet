# 📖 Οδηγίες Προετοιμασίας για SQL Εξέταση

## 🎯 Τι Να Μελετήσετε

### 1. SELECT Queries (Ερωτήματα)
- ✅ Βασικό SELECT με WHERE, ORDER BY, LIMIT
- ✅ Aggregate functions (COUNT, SUM, AVG, MAX, MIN)
- ✅ GROUP BY και HAVING
- ✅ JOIN (INNER, LEFT, RIGHT)
- ✅ Subqueries (στο WHERE, στο FROM)
- ✅ LIKE, IN, BETWEEN, IS NULL
- ✅ DISTINCT

### 2. Data Manipulation (Τροποποίηση Δεδομένων)
- ✅ INSERT (μεταξύ μίας και πολλαπλών εγγραφών)
- ✅ UPDATE (ΠΑΝΤΑ με WHERE!)
- ✅ DELETE (ΠΑΝΤΑ με WHERE!)

### 3. Data Definition (Ορισμός Δεδομένων)
- ✅ CREATE TABLE (με όλα τα constraints)
- ✅ ALTER TABLE (προσθήκη/τροποποίηση/διαγραφή στηλών)
- ✅ DROP TABLE / DROP DATABASE

### 4. Constraints (Περιορισμοί)
- ✅ PRIMARY KEY
- ✅ FOREIGN KEY (με ON DELETE/UPDATE CASCADE)
- ✅ UNIQUE
- ✅ NOT NULL
- ✅ DEFAULT
- ✅ AUTO_INCREMENT
- ✅ CHECK (MySQL 8.0.16+)

---

## 📚 Αρχεία Προετοιμασίας

1. **SQL_ΕΞΕΤΑΣΗ_ΠΡΟΕΤΟΙΜΑΣΙΑ.sql**
   - Περιέχει όλα τα παραδείγματα για κάθε εντολή
   - Εκτελέστε τα ένα-ένα για να κατανοήσετε τη λειτουργία

2. **SQL_ΑΣΚΗΣΕΙΣ_ΜΕ_ΛΥΣΕΙΣ.sql**
   - 30+ ασκήσεις με λύσεις
   - Προσπαθήστε να λύσετε πρώτα μόνοι σας, μετά δείτε τη λύση

3. **SQL_ΒΑΣΙΚΕΣ_ΕΝΤΟΛΕΣ.md**
   - Quick reference guide
   - Τύποι δεδομένων, syntax, examples

---

## ⚠️ Κρίσιμα Σημεία Προσοχής

### 1. UPDATE/DELETE χωρίς WHERE
```sql
-- ❌ ΠΟΤΕ ΜΗΝ ΚΑΝΕΤΕ ΑΥΤΟ!
UPDATE PAIKTHS SET balance = 0;  -- Θα μηδενίσει ΟΛΟΥΣ τους παίκτες!
DELETE FROM PAIKTHS;  -- Θα διαγράψει ΟΛΟΥΣ τους παίκτες!
```
**Πάντα χρησιμοποιήστε WHERE clause!**

### 2. Foreign Key Violations
```sql
-- ❌ Αυτό θα αποτύχει αν player_id=999 δεν υπάρχει στον PAIKTHS
INSERT INTO SUMMETOXH (player_id, bet_id, bet_amount) 
VALUES (999, 'B0001', 50.00);
```
**Πάντα χρησιμοποιήστε υπάρχουσες τιμές σε Foreign Keys**

### 3. Duplicate Primary Key
```sql
-- ❌ Αυτό θα αποτύχει αν player_id=1 υπάρχει ήδη
INSERT INTO PAIKTHS (player_id, username) VALUES (1, 'newuser');
```
**Κάθε Primary Key πρέπει να είναι μοναδικό**

### 4. Syntax Errors
- Πάντα τελειώνουν με `;`
- Χρησιμοποιήστε backticks για reserved words: `` `select` ``
- Προσοχή σε quotes: `'string'` για strings

---

## 📝 Στρατηγική Εξέτασης

### Πριν την Εξέταση:
1. ✅ Μελετήστε όλα τα παραδείγματα από το SQL_ΕΞΕΤΑΣΗ_ΠΡΟΕΤΟΙΜΑΣΙΑ.sql
2. ✅ Λύστε τις ασκήσεις από το SQL_ΑΣΚΗΣΕΙΣ_ΜΕ_ΛΥΣΕΙΣ.sql
3. ✅ Εξοικειωθείτε με τη δομή της βάσης StoixiBet
4. ✅ Εξασκήστε τη γραφή queries χειροκίνητα (χωρίς copy-paste)

### Κατά την Εξέταση:
1. ✅ Διαβάστε προσεκτικά την εκφώνηση
2. ✅ Προσδιορίστε ποιοι πίνακες χρειάζονται
3. ✅ Προσδιορίστε ποιες στήλες χρειάζονται
4. ✅ Γράψτε το query βήμα-βήμα:
   - Αρχίστε με SELECT columns FROM table
   - Προσθέστε WHERE αν χρειάζεται
   - Προσθέστε JOINs αν χρειάζονται
   - Προσθέστε GROUP BY/HAVING αν χρειάζεται
   - Προσθέστε ORDER BY αν ζητείται ταξινόμηση
5. ✅ Ελέγξτε το syntax (semicolons, quotes, commas)
6. ✅ Σκεφτείτε edge cases (NULL values, empty results)

---

## 🔍 Τύποι Ερωτήσεων που Πιθανόν να Εμφανιστούν

### 1. Ερωτήματα SELECT
- "Να βρεθούν..."
- "Να εμφανιστούν..."
- "Να δοθεί λίστα..."
- "Ποιοι είναι..."
- "Πόσοι/Πόσα..."

### 2. Εισαγωγή/Ενημέρωση/Διαγραφή
- "Να προστεθεί..."
- "Να ενημερωθεί..."
- "Να διαγραφεί..."
- "Να αλλάξει..."

### 3. Δημιουργία/Τροποποίηση Πινάκων
- "Να δημιουργηθεί πίνακας..."
- "Να προστεθεί στήλη..."
- "Να αλλαχθεί..."

---

## 💡 Tips & Tricks

### 1. Aggregate Functions με NULL
```sql
-- Χρησιμοποιήστε COALESCE για NULL values
SELECT COALESCE(SUM(balance), 0) FROM PAIKTHS;
```

### 2. JOIN vs Subquery
- JOIN: Καλύτερο για πολλές στήλες από πολλούς πίνακες
- Subquery: Καλύτερο για απλές συνθήκες

### 3. GROUP BY
- Κάθε στήλη στο SELECT που δεν είναι aggregate πρέπει να είναι στο GROUP BY
```sql
-- ✅ ΣΩΣΤΟ
SELECT player_id, username, SUM(bet_amount) 
FROM PAIKTHS p JOIN SUMMETOXH s ON p.player_id = s.player_id
GROUP BY player_id, username;

-- ❌ ΛΑΘΟΣ
SELECT player_id, username, SUM(bet_amount) 
FROM PAIKTHS p JOIN SUMMETOXH s ON p.player_id = s.player_id
GROUP BY player_id;  -- username δεν είναι στο GROUP BY!
```

### 4. WHERE vs HAVING
- WHERE: Φιλτράρισμα πριν την ομαδοποίηση
- HAVING: Φιλτράρισμα μετά την ομαδοποίηση (με GROUP BY)

---

## 🎓 Practice Exercises Checklist

Προσπαθήστε να λύσετε αυτές τις ασκήσεις από μνήμης:

- [ ] SELECT με WHERE, ORDER BY, LIMIT
- [ ] SELECT με aggregate functions (COUNT, SUM, AVG)
- [ ] SELECT με GROUP BY και HAVING
- [ ] SELECT με INNER JOIN
- [ ] SELECT με LEFT JOIN
- [ ] SELECT με subquery
- [ ] INSERT μίας εγγραφής
- [ ] INSERT πολλαπλών εγγραφών
- [ ] UPDATE με WHERE
- [ ] DELETE με WHERE
- [ ] CREATE TABLE με PRIMARY KEY, FOREIGN KEY, UNIQUE
- [ ] ALTER TABLE ADD COLUMN
- [ ] ALTER TABLE MODIFY COLUMN
- [ ] ALTER TABLE DROP COLUMN

---

## 📞 Quick Reference - Συντακτικό

```
SELECT → FROM → WHERE → GROUP BY → HAVING → ORDER BY → LIMIT
```

```
INSERT INTO table (cols) VALUES (vals)
UPDATE table SET col=val WHERE condition
DELETE FROM table WHERE condition
```

```
CREATE TABLE name (col type constraints, ...)
ALTER TABLE name ADD/MODIFY/DROP ...
DROP TABLE name
```

---

**Καλή Επιτυχία στην Εξέταση! 🎉**
