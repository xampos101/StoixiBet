# 📚 SQL - Βασικές Εντολές για Εξέταση

## 🎯 Σύντομη Ανακεφαλαίωση

---

## 1. SELECT (Ερωτήματα - Ανάκτηση Δεδομένων)

### Βασική Σύνταξη
```sql
SELECT [DISTINCT] column1, column2, ...
FROM table_name
[WHERE condition]
[GROUP BY column]
[HAVING condition]
[ORDER BY column [ASC|DESC]]
[LIMIT number];
```

### Βασικές Παραλλαγές

#### SELECT όλων των στηλών
```sql
SELECT * FROM table_name;
```

#### SELECT συγκεκριμένων στηλών
```sql
SELECT column1, column2 FROM table_name;
```

#### WHERE - Φιλτράρισμα
```sql
-- Σύγκριση
SELECT * FROM table WHERE column = 'value';
SELECT * FROM table WHERE column > 100;
SELECT * FROM table WHERE column != 'value';

-- LIKE (patterns)
SELECT * FROM table WHERE column LIKE 'a%';      -- Αρχίζει με 'a'
SELECT * FROM table WHERE column LIKE '%a';      -- Τελειώνει σε 'a'
SELECT * FROM table WHERE column LIKE '%a%';     -- Περιέχει 'a'

-- IN (λίστα τιμών)
SELECT * FROM table WHERE column IN (1, 2, 3);

-- BETWEEN (εύρος)
SELECT * FROM table WHERE column BETWEEN 10 AND 20;

-- NULL
SELECT * FROM table WHERE column IS NULL;
SELECT * FROM table WHERE column IS NOT NULL;
```

#### ORDER BY - Ταξινόμηση
```sql
SELECT * FROM table ORDER BY column ASC;   -- Αύξουσα
SELECT * FROM table ORDER BY column DESC;  -- Φθίνουσα
SELECT * FROM table ORDER BY col1 ASC, col2 DESC;  -- Πολλαπλή ταξινόμηση
```

#### DISTINCT - Κατάργηση διπλότυπων
```sql
SELECT DISTINCT column FROM table;
```

#### LIMIT - Περιορισμός αποτελεσμάτων
```sql
SELECT * FROM table LIMIT 10;        -- Πρώτα 10
SELECT * FROM table LIMIT 5, 10;     -- Παράλειψη 5, επόμενα 10
```

#### Aggregate Functions (Συνάργειες)
```sql
SELECT COUNT(*) FROM table;              -- Αριθμός εγγραφών
SELECT SUM(column) FROM table;           -- Άθροισμα
SELECT AVG(column) FROM table;           -- Μέσος όρος
SELECT MAX(column) FROM table;           -- Μέγιστο
SELECT MIN(column) FROM table;           -- Ελάχιστο
```

#### GROUP BY - Ομαδοποίηση
```sql
SELECT column, COUNT(*) 
FROM table 
GROUP BY column;
```

#### HAVING - Φιλτράρισμα ομάδων
```sql
SELECT column, COUNT(*) 
FROM table 
GROUP BY column 
HAVING COUNT(*) > 1;
```

#### JOIN - Σύνδεση πινάκων
```sql
-- INNER JOIN
SELECT * 
FROM table1 t1
INNER JOIN table2 t2 ON t1.id = t2.id;

-- LEFT JOIN (όλα από table1)
SELECT * 
FROM table1 t1
LEFT JOIN table2 t2 ON t1.id = t2.id;

-- RIGHT JOIN (όλα από table2)
SELECT * 
FROM table1 t1
RIGHT JOIN table2 t2 ON t1.id = t2.id;
```

#### Subqueries (Υποερωτήματα)
```sql
-- Στο WHERE
SELECT * FROM table1 
WHERE column > (SELECT AVG(column) FROM table1);

-- Στο FROM
SELECT * 
FROM (SELECT * FROM table WHERE condition) AS subquery;
```

---

## 2. INSERT (Εισαγωγή Δεδομένων)

### Βασική Σύνταξη
```sql
INSERT INTO table_name (column1, column2, ...)
VALUES (value1, value2, ...);
```

### Παραλλαγές

#### Εισαγωγή μιας εγγραφής
```sql
INSERT INTO PAIKTHS (player_id, username, balance)
VALUES (1, 'user1', 100.00);
```

#### Εισαγωγή πολλαπλών εγγραφών
```sql
INSERT INTO PAIKTHS (player_id, username, balance)
VALUES 
    (2, 'user2', 200.00),
    (3, 'user3', 300.00);
```

#### Εισαγωγή με DEFAULT τιμές
```sql
INSERT INTO PAIKTHS (player_id, username)
VALUES (4, 'user4');  -- balance θα πάρει default τιμή
```

#### Εισαγωγή όλων των στηλών (χωρίς να ορίσουμε στήλες)
```sql
INSERT INTO PAIKTHS 
VALUES (5, 'user5', 150.00);
```

---

## 3. UPDATE (Ενημέρωση Δεδομένων)

### Βασική Σύνταξη
```sql
UPDATE table_name
SET column1 = value1, column2 = value2, ...
[WHERE condition];
```

### Παραλλαγές

#### Ενημέρωση συγκεκριμένων εγγραφών
```sql
UPDATE PAIKTHS SET balance = 200.00 WHERE player_id = 1;
```

#### Ενημέρωση με υπολογισμό
```sql
UPDATE PAIKTHS SET balance = balance + 50 WHERE player_id = 1;
UPDATE PAIKTHS SET balance = balance * 1.10;  -- Αύξηση 10%
```

#### Ενημέρωση πολλαπλών στηλών
```sql
UPDATE PAIKTHS 
SET username = 'newuser', balance = 300.00 
WHERE player_id = 1;
```

#### ⚠️ ΠΡΟΣΟΧΗ: Χωρίς WHERE ενημερώνει ΟΛΕΣ τις εγγραφές!
```sql
-- ΜΗΝ ΚΑΝΕΤΕ ΑΥΤΟ!
-- UPDATE PAIKTHS SET balance = 0;  -- Θα μηδενίσει όλους!
```

---

## 4. DELETE (Διαγραφή Δεδομένων)

### Βασική Σύνταξη
```sql
DELETE FROM table_name
[WHERE condition]
[LIMIT number];
```

### Παραλλαγές

#### Διαγραφή συγκεκριμένων εγγραφών
```sql
DELETE FROM PAIKTHS WHERE player_id = 1;
```

#### Διαγραφή με πολλαπλές συνθήκες
```sql
DELETE FROM PAIKTHS WHERE balance < 50 AND player_id > 10;
```

#### Διαγραφή με LIMIT
```sql
DELETE FROM PAIKTHS WHERE balance = 0 LIMIT 5;
```

#### ⚠️ ΠΡΟΣΟΧΗ: Χωρίς WHERE διαγράφει ΟΛΕΣ τις εγγραφές!
```sql
-- ΜΗΝ ΚΑΝΕΤΕ ΑΥΤΟ!
-- DELETE FROM PAIKTHS;  -- Θα διαγράψει όλους!
```

---

## 5. CREATE TABLE (Δημιουργία Πινάκων)

### Βασική Σύνταξη
```sql
CREATE TABLE [IF NOT EXISTS] table_name (
    column1 datatype constraints,
    column2 datatype constraints,
    ...
    PRIMARY KEY (column),
    FOREIGN KEY (column) REFERENCES other_table(column)
);
```

### Βασικά Constraints

#### PRIMARY KEY
```sql
CREATE TABLE table (
    id INT PRIMARY KEY,
    name VARCHAR(50)
);

-- ή Composite Key
CREATE TABLE table (
    col1 INT,
    col2 INT,
    PRIMARY KEY (col1, col2)
);
```

#### AUTO_INCREMENT
```sql
CREATE TABLE table (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50)
);
```

#### NOT NULL
```sql
CREATE TABLE table (
    id INT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);
```

#### DEFAULT
```sql
CREATE TABLE table (
    id INT PRIMARY KEY,
    status VARCHAR(20) DEFAULT 'active',
    balance DECIMAL(10,2) DEFAULT 0.00,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### UNIQUE
```sql
CREATE TABLE table (
    id INT PRIMARY KEY,
    email VARCHAR(100) UNIQUE,
    username VARCHAR(50) UNIQUE NOT NULL
);
```

#### FOREIGN KEY
```sql
CREATE TABLE table (
    id INT PRIMARY KEY,
    player_id INT,
    FOREIGN KEY (player_id) REFERENCES PAIKTHS(player_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
```

#### CHECK (MySQL 8.0.16+)
```sql
CREATE TABLE table (
    id INT PRIMARY KEY,
    age INT CHECK (age >= 0 AND age <= 120),
    balance DECIMAL(10,2) CHECK (balance >= 0)
);
```

---

## 6. ALTER TABLE (Τροποποίηση Πινάκων)

### Προσθήκη Στήλης
```sql
ALTER TABLE table_name ADD COLUMN column_name datatype;

-- Με θέση
ALTER TABLE table_name ADD COLUMN column_name datatype AFTER existing_column;
ALTER TABLE table_name ADD COLUMN column_name datatype FIRST;
```

### Διαγραφή Στήλης
```sql
ALTER TABLE table_name DROP COLUMN column_name;
```

### Τροποποίηση Στήλης
```sql
ALTER TABLE table_name MODIFY COLUMN column_name new_datatype;
```

### Αλλαγή Ονόματος Στήλης
```sql
ALTER TABLE table_name 
CHANGE COLUMN old_name new_name datatype;
```

### Προσθήκη Constraints
```sql
-- PRIMARY KEY
ALTER TABLE table_name ADD PRIMARY KEY (column);

-- FOREIGN KEY
ALTER TABLE table_name 
ADD CONSTRAINT fk_name 
FOREIGN KEY (column) REFERENCES other_table(column);

-- UNIQUE
ALTER TABLE table_name ADD UNIQUE (column);

-- INDEX
ALTER TABLE table_name ADD INDEX index_name (column);
```

### Διαγραφή Constraints
```sql
-- FOREIGN KEY
ALTER TABLE table_name DROP FOREIGN KEY constraint_name;

-- PRIMARY KEY
ALTER TABLE table_name DROP PRIMARY KEY;

-- INDEX
ALTER TABLE table_name DROP INDEX index_name;
```

---

## 7. DROP (Διαγραφή)

### DROP TABLE
```sql
DROP TABLE [IF EXISTS] table_name;
```

### DROP DATABASE
```sql
DROP DATABASE [IF EXISTS] database_name;
```

### DROP INDEX
```sql
DROP INDEX index_name ON table_name;
```

---

## 8. Άλλες Χρήσιμες Εντολές

### USE - Επιλογή Βάσης
```sql
USE database_name;
```

### CREATE DATABASE
```sql
CREATE DATABASE [IF NOT EXISTS] database_name;
```

### SHOW TABLES
```sql
SHOW TABLES;
```

### DESCRIBE / DESC
```sql
DESCRIBE table_name;
DESC table_name;
```

### SHOW CREATE TABLE
```sql
SHOW CREATE TABLE table_name;
```

---

## 9. Σημαντικές Σημειώσεις

### ⚠️ ΠΡΟΣΟΧΗ σε Common Mistakes:

1. **UPDATE/DELETE χωρίς WHERE**
   ```sql
   -- ΜΗΝ!
   UPDATE table SET column = value;
   DELETE FROM table;
   ```

2. **Foreign Key Violations**
   - Πάντα χρησιμοποιήστε υπάρχουσες τιμές σε Foreign Keys

3. **Duplicate Primary Key**
   - Κάθε Primary Key πρέπει να είναι μοναδικό

4. **Συντακτικά Λάθη**
   - Πάντα τελειώνουν με `;`
   - Χρησιμοποιήστε backticks `` ` `` για reserved words: `` `select` ``

### ✅ Best Practices:

1. Πάντα χρησιμοποιήστε `WHERE` σε UPDATE/DELETE
2. Δοκιμάστε queries πρώτα με SELECT πριν UPDATE/DELETE
3. Χρησιμοποιήστε transactions για πολλαπλές αλλαγές
4. Κάντε backup πριν από σημαντικές αλλαγές
5. Χρησιμοποιήστε prepared statements σε applications

---

## 10. Τύποι Δεδομένων (Data Types)

### Αριθμητικοί
- `INT` - Ακέραιος
- `DECIMAL(p,s)` - Δεκαδικός (p=precision, s=scale)
- `FLOAT` - Κινητή υποδιαστολή

### Συμβολοσειρές
- `VARCHAR(n)` - Μεταβλητού μήκους (μέχρι n χαρακτήρες)
- `CHAR(n)` - Σταθερού μήκους (n χαρακτήρες)
- `TEXT` - Μακριά κείμενα

### Ημερομηνίες
- `DATE` - Ημερομηνία (YYYY-MM-DD)
- `DATETIME` - Ημερομηνία και ώρα (YYYY-MM-DD HH:MM:SS)
- `TIMESTAMP` - Timestamp

---

## 📝 Quick Reference Cheat Sheet

| Εντολή | Σκοπός | Παράδειγμα |
|--------|--------|------------|
| `SELECT` | Ανάκτηση | `SELECT * FROM table WHERE id=1` |
| `INSERT` | Εισαγωγή | `INSERT INTO table VALUES (1, 'value')` |
| `UPDATE` | Ενημέρωση | `UPDATE table SET col=val WHERE id=1` |
| `DELETE` | Διαγραφή | `DELETE FROM table WHERE id=1` |
| `CREATE TABLE` | Δημιουργία | `CREATE TABLE t (id INT PRIMARY KEY)` |
| `ALTER TABLE` | Τροποποίηση | `ALTER TABLE t ADD COLUMN c VARCHAR(50)` |
| `DROP TABLE` | Διαγραφή | `DROP TABLE t` |
| `JOIN` | Σύνδεση | `SELECT * FROM t1 JOIN t2 ON t1.id=t2.id` |
| `GROUP BY` | Ομαδοποίηση | `SELECT col, COUNT(*) FROM t GROUP BY col` |
| `ORDER BY` | Ταξινόμηση | `SELECT * FROM t ORDER BY col DESC` |

---

**Καλή Επιτυχία! 🎓**
