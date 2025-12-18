-- ============================================================
-- SQL ΕΞΕΤΑΣΗ - ΟΛΟΚΛΗΡΩΜΕΝΗ ΠΡΟΕΤΟΙΜΑΣΙΑ
-- ============================================================
-- Βασισμένο στη βάση δεδομένων StoixiBet
-- Περιλαμβάνει: SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, DROP
-- ============================================================

USE stoiximatiki;

-- ============================================================
-- ΜΕΡΟΣ 1: SELECT QUERIES (ΕΡΩΤΗΜΑΤΑ - ΑΝΑΚΤΗΣΗ ΔΕΔΟΜΕΝΩΝ)
-- ============================================================

-- 1.1. Βασικό SELECT - Επιλογή όλων των στηλών
-- Ζητούμενο: Εμφάνιση όλων των παικτών
SELECT * FROM PAIKTHS;

-- 1.2. SELECT με συγκεκριμένες στήλες
-- Ζητούμενο: Εμφάνιση username και balance των παικτών
SELECT username, balance FROM PAIKTHS;

-- 1.3. SELECT με WHERE - Φιλτράρισμα δεδομένων
-- Ζητούμενο: Παίκτες με balance > 100
SELECT * FROM PAIKTHS WHERE balance > 100;

-- Ζητούμενο: Στοιχήματα που δημιούργησε ο υπάλληλος 'E001'
SELECT * FROM STOIXHMA WHERE employee_id = 'E001';

-- 1.4. SELECT με σύγκριση (>, <, >=, <=, =, !=, <>)
SELECT * FROM PAIKTHS WHERE balance >= 150;
SELECT * FROM YPALLHLOS WHERE salary < 1500;
SELECT * FROM STOIXHMA WHERE employee_id != 'E001';

-- 1.5. SELECT με LIKE - Αναζήτηση με patterns
-- Ζητούμενο: Παίκτες με username που αρχίζει με 'g'
SELECT * FROM PAIKTHS WHERE username LIKE 'g%';

-- Ζητούμενο: Παίκτες με username που περιέχει '28'
SELECT * FROM PAIKTHS WHERE username LIKE '%28%';

-- 1.6. SELECT με IN - Έλεγχος αντιστοίχησης σε λίστα
-- Ζητούμενο: Παίκτες με player_id 1, 2 ή 3
SELECT * FROM PAIKTHS WHERE player_id IN (1, 2, 3);

-- 1.7. SELECT με BETWEEN - Εύρος τιμών
-- Ζητούμενο: Παίκτες με balance μεταξύ 50 και 200
SELECT * FROM PAIKTHS WHERE balance BETWEEN 50 AND 200;

-- Ζητούμενο: Στοιχήματα μεταξύ 2025-10-21 και 2025-10-23
SELECT * FROM STOIXHMA 
WHERE stoixima_datetime BETWEEN '2025-10-21 00:00:00' AND '2025-10-23 23:59:59';

-- 1.8. SELECT με NULL - Έλεγχος NULL τιμών
-- Ζητούμενο: Υπάλληλοι με μισθό NULL (αν υπάρχουν)
SELECT * FROM YPALLHLOS WHERE salary IS NULL;
SELECT * FROM YPALLHLOS WHERE salary IS NOT NULL;

-- 1.9. SELECT με ORDER BY - Ταξινόμηση αποτελεσμάτων
-- Ζητούμενο: Παίκτες ταξινομημένοι κατά balance (αύξουσα)
SELECT * FROM PAIKTHS ORDER BY balance ASC;

-- Ζητούμενο: Παίκτες ταξινομημένοι κατά balance (φθίνουσα)
SELECT * FROM PAIKTHS ORDER BY balance DESC;

-- Ζητούμενο: Υπάλληλοι ταξινομημένοι κατά fullname
SELECT * FROM YPALLHLOS ORDER BY fullname;

-- 1.10. SELECT με DISTINCT - Κατάργηση διπλότυπων
-- Ζητούμενο: Μοναδικά employee_id από στοιχήματα
SELECT DISTINCT employee_id FROM STOIXHMA;

-- 1.11. SELECT με LIMIT - Περιορισμός αριθμού αποτελεσμάτων
-- Ζητούμενο: Οι 2 πρώτοι παίκτες με το μεγαλύτερο balance
SELECT * FROM PAIKTHS ORDER BY balance DESC LIMIT 2;

-- 1.12. SELECT με COUNT - Μέτρηση εγγραφών
-- Ζητούμενο: Αριθμός παικτών
SELECT COUNT(*) FROM PAIKTHS;

-- Ζητούμενο: Αριθμός παικτών με balance > 100
SELECT COUNT(*) FROM PAIKTHS WHERE balance > 100;

-- 1.13. SELECT με SUM, AVG, MAX, MIN - Συνάργειες
-- Ζητούμενο: Συνολικό balance όλων των παικτών
SELECT SUM(balance) AS total_balance FROM PAIKTHS;

-- Ζητούμενο: Μέσο balance παικτών
SELECT AVG(balance) AS average_balance FROM PAIKTHS;

-- Ζητούμενο: Μέγιστο balance
SELECT MAX(balance) AS max_balance FROM PAIKTHS;

-- Ζητούμενο: Ελάχιστο balance
SELECT MIN(balance) AS min_balance FROM PAIKTHS;

-- 1.14. SELECT με GROUP BY - Ομαδοποίηση
-- Ζητούμενο: Αριθμός στοιχημάτων ανά υπάλληλο
SELECT employee_id, COUNT(*) AS bet_count 
FROM STOIXHMA 
GROUP BY employee_id;

-- Ζητούμενο: Συνολικό ποσό στοιχηματισμού ανά παίκτη
SELECT player_id, SUM(bet_amount) AS total_bet 
FROM SUMMETOXH 
GROUP BY player_id;

-- 1.15. SELECT με HAVING - Φιλτράρισμα ομάδων
-- Ζητούμενο: Υπάλληλοι με περισσότερα από 1 στοιχήματα
SELECT employee_id, COUNT(*) AS bet_count 
FROM STOIXHMA 
GROUP BY employee_id 
HAVING COUNT(*) > 1;

-- Ζητούμενο: Παίκτες με συνολικό στοίχημα > 50
SELECT player_id, SUM(bet_amount) AS total_bet 
FROM SUMMETOXH 
GROUP BY player_id 
HAVING SUM(bet_amount) > 50;

-- 1.16. SELECT με JOIN - Σύνδεση πινάκων
-- INNER JOIN: Στοιχήματα με πληροφορίες υπαλλήλου
SELECT s.bet_id, s.description, s.stoixima_datetime, y.fullname AS employee_name
FROM STOIXHMA s
INNER JOIN YPALLHLOS y ON s.employee_id = y.employee_id;

-- LEFT JOIN: Όλοι οι παίκτες και οι συμμετοχές τους (αν υπάρχουν)
SELECT p.player_id, p.username, s.bet_id, s.bet_amount
FROM PAIKTHS p
LEFT JOIN SUMMETOXH s ON p.player_id = s.player_id;

-- RIGHT JOIN: Όλα τα στοιχήματα και οι συμμετοχές τους
SELECT s.bet_id, s.description, sm.player_id, sm.bet_amount
FROM STOIXHMA s
RIGHT JOIN SUMMETOXH sm ON s.bet_id = sm.bet_id;

-- 1.17. SELECT με πολλαπλά JOIN
-- Ζητούμενο: Παίκτες, στοιχήματα και υπάλληλοι
SELECT p.username, s.description, y.fullname AS employee_name, sm.bet_amount
FROM PAIKTHS p
INNER JOIN SUMMETOXH sm ON p.player_id = sm.player_id
INNER JOIN STOIXHMA s ON sm.bet_id = s.bet_id
INNER JOIN YPALLHLOS y ON s.employee_id = y.employee_id;

-- 1.18. SELECT με υποερώτηματα (Subqueries)
-- Ζητούμενο: Παίκτες με balance μεγαλύτερο από το μέσο όρο
SELECT * FROM PAIKTHS 
WHERE balance > (SELECT AVG(balance) FROM PAIKTHS);

-- Ζητούμενο: Παίκτες που έχουν συμμετάσχει σε τουλάχιστον ένα στοίχημα
SELECT * FROM PAIKTHS 
WHERE player_id IN (SELECT DISTINCT player_id FROM SUMMETOXH);

-- 1.19. SELECT με EXISTS
-- Ζητούμενο: Παίκτες που έχουν συμμετάσχει σε στοιχήματα
SELECT * FROM PAIKTHS p
WHERE EXISTS (SELECT 1 FROM SUMMETOXH s WHERE s.player_id = p.player_id);

-- 1.20. SELECT με UNION - Σύνδεση αποτελεσμάτων
-- Ζητούμενο: Ένωση player_id και employee_id
SELECT player_id AS id, 'player' AS type FROM PAIKTHS
UNION
SELECT CAST(employee_id AS CHAR) AS id, 'employee' AS type FROM YPALLHLOS;

-- ============================================================
-- ΜΕΡΟΣ 2: INSERT (ΕΙΣΑΓΩΓΗ ΔΕΔΟΜΕΝΩΝ)
-- ============================================================

-- 2.1. INSERT - Εισαγωγή μιας εγγραφής
-- Ζητούμενο: Προσθήκη νέου παίκτη
INSERT INTO PAIKTHS (player_id, username, balance)
VALUES (4, 'newplayer', 100.00);

-- 2.2. INSERT - Εισαγωγή πολλαπλών εγγραφών
-- Ζητούμενο: Προσθήκη πολλαπλών παικτών
INSERT INTO PAIKTHS (player_id, username, balance)
VALUES 
    (5, 'player5', 200.00),
    (6, 'player6', 300.00),
    (7, 'player7', 150.00);

-- 2.3. INSERT με DEFAULT τιμές
-- Ζητούμενο: Προσθήκη παίκτη με default balance (0.00)
INSERT INTO PAIKTHS (player_id, username)
VALUES (8, 'player8');

-- 2.4. INSERT με SELECT (εισαγωγή από άλλο πίνακα)
-- Παράδειγμα: Δημιουργία αντιγράφου (αν υπάρχει πίνακας backup)
-- INSERT INTO PAIKTHS_BACKUP SELECT * FROM PAIKTHS WHERE balance > 100;

-- ============================================================
-- ΜΕΡΟΣ 3: UPDATE (ΕΝΗΜΕΡΩΣΗ ΔΕΔΟΜΕΝΩΝ)
-- ============================================================

-- 3.1. UPDATE - Ενημέρωση όλων των εγγραφών
-- Ζητούμενο: Αύξηση όλων των balance κατά 10%
-- ΠΡΟΣΟΧΗ: Χωρίς WHERE θα ενημερώσει όλες τις εγγραφές!
-- UPDATE PAIKTHS SET balance = balance * 1.10;

-- 3.2. UPDATE με WHERE - Ενημέρωση συγκεκριμένων εγγραφών
-- Ζητούμενο: Ενημέρωση balance συγκεκριμένου παίκτη
UPDATE PAIKTHS SET balance = 250.00 WHERE player_id = 1;

-- Ζητούμενο: Αύξηση balance κατά 50 για παίκτες με balance < 100
UPDATE PAIKTHS SET balance = balance + 50 WHERE balance < 100;

-- 3.3. UPDATE με πολλαπλά πεδία
-- Ζητούμενο: Ενημέρωση username και balance
UPDATE PAIKTHS 
SET username = 'updated_user', balance = 175.50 
WHERE player_id = 2;

-- 3.4. UPDATE με JOIN
-- Ζητούμενο: Ενημέρωση balance παικτών που έχουν κερδίσει στοιχήματα
UPDATE PAIKTHS p
INNER JOIN SUMMETOXH s ON p.player_id = s.player_id
SET p.balance = p.balance + s.result_amount
WHERE s.result_amount > 0;

-- ============================================================
-- ΜΕΡΟΣ 4: DELETE (ΔΙΑΓΡΑΦΗ ΔΕΔΟΜΕΝΩΝ)
-- ============================================================

-- 4.1. DELETE - Διαγραφή συγκεκριμένων εγγραφών
-- Ζητούμενο: Διαγραφή συγκεκριμένου παίκτη
DELETE FROM PAIKTHS WHERE player_id = 8;

-- 4.2. DELETE με WHERE - Πολλαπλές συνθήκες
-- Ζητούμενο: Διαγραφή παικτών με balance < 50
-- DELETE FROM PAIKTHS WHERE balance < 50;

-- 4.3. DELETE με LIMIT - Περιορισμός αριθμού διαγραφών
-- DELETE FROM PAIKTHS WHERE balance = 0 LIMIT 5;

-- 4.4. DELETE με JOIN
-- Παράδειγμα: Διαγραφή συμμετοχών παικτών που διαγράφηκαν
-- DELETE s FROM SUMMETOXH s
-- LEFT JOIN PAIKTHS p ON s.player_id = p.player_id
-- WHERE p.player_id IS NULL;

-- 4.5. DELETE ALL - Διαγραφή όλων των εγγραφών (ΠΡΟΣΟΧΗ!)
-- DELETE FROM PAIKTHS;  -- Διαγράφει όλες τις εγγραφές αλλά όχι τον πίνακα

-- ============================================================
-- ΜΕΡΟΣ 5: CREATE TABLE (ΔΗΜΙΟΥΡΓΙΑ ΠΙΝΑΚΩΝ)
-- ============================================================

-- 5.1. CREATE TABLE - Βασική δημιουργία πίνακα
CREATE TABLE IF NOT EXISTS TEST_TABLE (
    id INT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    value DECIMAL(10,2)
);

-- 5.2. CREATE TABLE - Με AUTO_INCREMENT
CREATE TABLE IF NOT EXISTS TEST_AUTO (
    id INT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(100),
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- 5.3. CREATE TABLE - Με FOREIGN KEY
CREATE TABLE IF NOT EXISTS TEST_FK (
    id INT PRIMARY KEY AUTO_INCREMENT,
    player_id INT,
    amount DECIMAL(10,2),
    FOREIGN KEY (player_id) REFERENCES PAIKTHS(player_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- 5.4. CREATE TABLE - Με UNIQUE constraint
CREATE TABLE IF NOT EXISTS TEST_UNIQUE (
    id INT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE
);

-- 5.5. CREATE TABLE - Με CHECK constraint (MySQL 8.0.16+)
CREATE TABLE IF NOT EXISTS TEST_CHECK (
    id INT PRIMARY KEY,
    age INT CHECK (age >= 0 AND age <= 120),
    balance DECIMAL(10,2) CHECK (balance >= 0)
);

-- 5.6. CREATE TABLE - Με DEFAULT values
CREATE TABLE IF NOT EXISTS TEST_DEFAULT (
    id INT PRIMARY KEY,
    status VARCHAR(20) DEFAULT 'active',
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    balance DECIMAL(10,2) DEFAULT 0.00
);

-- 5.7. CREATE TABLE - Composite Primary Key
CREATE TABLE IF NOT EXISTS TEST_COMPOSITE (
    player_id INT,
    bonus_id INT,
    date_assigned DATE,
    PRIMARY KEY (player_id, bonus_id),
    FOREIGN KEY (player_id) REFERENCES PAIKTHS(player_id),
    FOREIGN KEY (bonus_id) REFERENCES BONUS(bonus_id)
);

-- ============================================================
-- ΜΕΡΟΣ 6: ALTER TABLE (ΤΡΟΠΟΠΟΙΗΣΗ ΠΙΝΑΚΩΝ)
-- ============================================================

-- 6.1. ALTER TABLE - Προσθήκη στήλης
ALTER TABLE TEST_TABLE ADD COLUMN new_column VARCHAR(50);

-- 6.2. ALTER TABLE - Προσθήκη στήλης με θέση
ALTER TABLE TEST_TABLE ADD COLUMN position_column INT AFTER name;

-- 6.3. ALTER TABLE - Διαγραφή στήλης
-- ALTER TABLE TEST_TABLE DROP COLUMN new_column;

-- 6.4. ALTER TABLE - Τροποποίηση τύπου στήλης
ALTER TABLE TEST_TABLE MODIFY COLUMN value DECIMAL(12,2);

-- 6.5. ALTER TABLE - Αλλαγή ονόματος στήλης
ALTER TABLE TEST_TABLE CHANGE COLUMN name full_name VARCHAR(100);

-- 6.6. ALTER TABLE - Προσθήκη PRIMARY KEY
-- ALTER TABLE TEST_TABLE ADD PRIMARY KEY (id);

-- 6.7. ALTER TABLE - Προσθήκη FOREIGN KEY
ALTER TABLE TEST_TABLE 
ADD CONSTRAINT fk_player 
FOREIGN KEY (id) REFERENCES PAIKTHS(player_id);

-- 6.8. ALTER TABLE - Προσθήκη UNIQUE constraint
ALTER TABLE TEST_TABLE ADD UNIQUE (full_name);

-- 6.9. ALTER TABLE - Προσθήκη INDEX
ALTER TABLE TEST_TABLE ADD INDEX idx_value (value);

-- 6.10. ALTER TABLE - Διαγραφή constraint
-- ALTER TABLE TEST_TABLE DROP FOREIGN KEY fk_player;
-- ALTER TABLE TEST_TABLE DROP PRIMARY KEY;
-- ALTER TABLE TEST_TABLE DROP INDEX idx_value;

-- ============================================================
-- ΜΕΡΟΣ 7: DROP (ΔΙΑΓΡΑΦΗ ΠΙΝΑΚΩΝ/ΒΑΣΕΩΝ)
-- ============================================================

-- 7.1. DROP TABLE - Διαγραφή πίνακα
-- DROP TABLE IF EXISTS TEST_TABLE;

-- 7.2. DROP TABLE - Πολλαπλοί πίνακες
-- DROP TABLE IF EXISTS TEST_AUTO, TEST_FK, TEST_UNIQUE;

-- 7.3. DROP DATABASE - Διαγραφή βάσης δεδομένων
-- DROP DATABASE IF EXISTS test_database;

-- 7.4. DROP INDEX - Διαγραφή index
-- DROP INDEX idx_value ON TEST_TABLE;

-- ============================================================
-- ΜΕΡΟΣ 8: ΑΛΛΕΣ ΧΡΗΣΙΜΕΣ ΕΝΤΟΛΕΣ
-- ============================================================

-- 8.1. SHOW TABLES - Εμφάνιση πινάκων
SHOW TABLES;

-- 8.2. DESCRIBE / DESC - Περιγραφή πίνακα
DESCRIBE PAIKTHS;
DESC PAIKTHS;

-- 8.3. SHOW CREATE TABLE - Εμφάνιση CREATE statement
SHOW CREATE TABLE PAIKTHS;

-- 8.4. USE - Επιλογή βάσης δεδομένων
USE stoiximatiki;

-- 8.5. CREATE DATABASE - Δημιουργία βάσης
CREATE DATABASE IF NOT EXISTS test_db;

-- ============================================================
-- ΜΕΡΟΣ 9: ΠΡΟΧΩΡΗΜΕΝΑ QUERIES (ΓΙΑ ΕΞΕΤΑΣΗ)
-- ============================================================

-- 9.1. Πολύπλοκο JOIN με aggregations
-- Ζητούμενο: Παίκτες με συνολικό κέρδος
SELECT 
    p.player_id,
    p.username,
    SUM(s.result_amount) AS total_winnings,
    SUM(s.bet_amount) AS total_bets,
    (SUM(s.result_amount) - SUM(s.bet_amount)) AS net_profit
FROM PAIKTHS p
INNER JOIN SUMMETOXH s ON p.player_id = s.player_id
GROUP BY p.player_id, p.username
ORDER BY total_winnings DESC;

-- 9.2. Nested Subqueries
-- Ζητούμενο: Παίκτες που έχουν το μεγαλύτερο balance
SELECT * FROM PAIKTHS
WHERE balance = (SELECT MAX(balance) FROM PAIKTHS);

-- 9.3. EXISTS με υποερώτημα
-- Ζητούμενο: Υπάλληλοι που έχουν δημιουργήσει στοιχήματα
SELECT * FROM YPALLHLOS y
WHERE EXISTS (
    SELECT 1 FROM STOIXHMA s 
    WHERE s.employee_id = y.employee_id
);

-- 9.4. CASE statement - Υπό όρους τιμές
SELECT 
    player_id,
    username,
    balance,
    CASE 
        WHEN balance >= 200 THEN 'High'
        WHEN balance >= 100 THEN 'Medium'
        ELSE 'Low'
    END AS balance_category
FROM PAIKTHS;

-- 9.5. DATE functions
-- Ζητούμενο: Στοιχήματα του τρέχοντος μήνα
SELECT * FROM STOIXHMA
WHERE MONTH(stoixima_datetime) = MONTH(CURRENT_DATE)
AND YEAR(stoixima_datetime) = YEAR(CURRENT_DATE);

-- ============================================================
-- ΜΕΡΟΣ 10: ΠΡΟΣΟΧΗ ΣΕ ΣΥΝΗΘΗ ΛΑΘΗ
-- ============================================================

-- ❌ ΛΑΘΟΣ: UPDATE/DELETE χωρίς WHERE (τροποποιεί όλες τις εγγραφές!)
-- UPDATE PAIKTHS SET balance = 0;  -- ΠΑΡΑΚΑΛΩ ΜΗΝ!

-- ✅ ΣΩΣΤΟ: Πάντα με WHERE
-- UPDATE PAIKTHS SET balance = 0 WHERE player_id = 1;

-- ❌ ΛΑΘΟΣ: Foreign Key violation
-- INSERT INTO SUMMETOXH VALUES (999, 'B0001', 50, NOW(), 0);
-- (player_id 999 δεν υπάρχει στον PAIKTHS)

-- ✅ ΣΩΣΤΟ: Χρήση υπαρχόντων IDs
-- INSERT INTO SUMMETOXH VALUES (1, 'B0001', 50, NOW(), 0);

-- ❌ ΛΑΘΟΣ: Duplicate Primary Key
-- INSERT INTO PAIKTHS VALUES (1, 'newuser', 100);  -- player_id 1 υπάρχει ήδη

-- ✅ ΣΩΣΤΟ: Νέο μοναδικό ID
-- INSERT INTO PAIKTHS VALUES (10, 'newuser', 100);

-- ============================================================
-- ΤΕΛΟΣ ΣΚΡΙΠΤ
-- ============================================================
-- Σημείωση: Για εξέταση, βεβαιωθείτε ότι γνωρίζετε:
-- 1. SELECT με όλες τις παραλλαγές (WHERE, JOIN, GROUP BY, HAVING, ORDER BY)
-- 2. INSERT, UPDATE, DELETE με WHERE clauses
-- 3. CREATE TABLE με constraints (PRIMARY KEY, FOREIGN KEY, UNIQUE, DEFAULT)
-- 4. ALTER TABLE για προσθήκη/τροποποίηση/διαγραφή στηλών
-- 5. DROP TABLE και DROP DATABASE
-- ============================================================
