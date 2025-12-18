-- ============================================================
-- SQL ΑΣΚΗΣΕΙΣ ΜΕ ΛΥΣΕΙΣ - ΕΞΕΤΑΣΗ
-- ============================================================
-- Πρακτικές ασκήσεις βασισμένες στη βάση StoixiBet
-- ============================================================

USE stoiximatiki;

-- ============================================================
-- ΑΣΚΗΣΕΙΣ SELECT
-- ============================================================

-- ΑΣΚΗΣΗ 1: Να βρεθούν όλοι οι παίκτες με balance μεγαλύτερο από 100
-- ΛΥΣΗ:
SELECT * FROM PAIKTHS WHERE balance > 100;

-- ΑΣΚΗΣΗ 2: Να βρεθεί ο μέσος όρος των balance όλων των παικτών
-- ΛΥΣΗ:
SELECT AVG(balance) AS average_balance FROM PAIKTHS;

-- ΑΣΚΗΣΗ 3: Να βρεθούν τα στοιχήματα που δημιουργήθηκαν από τον υπάλληλο 'E001'
-- ΛΥΣΗ:
SELECT * FROM STOIXHMA WHERE employee_id = 'E001';

-- ΑΣΚΗΣΗ 4: Να βρεθεί ο αριθμός των συμμετοχών ανά παίκτη
-- ΛΥΣΗ:
SELECT player_id, COUNT(*) AS participation_count 
FROM SUMMETOXH 
GROUP BY player_id;

-- ΑΣΚΗΣΗ 5: Να βρεθούν οι παίκτες που έχουν συμμετάσχει σε περισσότερα από 1 στοιχήματα
-- ΛΥΣΗ:
SELECT player_id, COUNT(*) AS participation_count 
FROM SUMMETOXH 
GROUP BY player_id 
HAVING COUNT(*) > 1;

-- ΑΣΚΗΣΗ 6: Να βρεθεί το συνολικό ποσό που έχει στοιχηματίσει κάθε παίκτης
-- ΛΥΣΗ:
SELECT player_id, SUM(bet_amount) AS total_bet_amount 
FROM SUMMETOXH 
GROUP BY player_id;

-- ΑΣΚΗΣΗ 7: Να βρεθούν τα στοιχήματα με τα ονόματα των υπαλλήλων που τα δημιούργησαν
-- ΛΥΣΗ:
SELECT s.bet_id, s.description, y.fullname AS employee_name
FROM STOIXHMA s
INNER JOIN YPALLHLOS y ON s.employee_id = y.employee_id;

-- ΑΣΚΗΣΗ 8: Να βρεθούν όλοι οι παίκτες και οι συμμετοχές τους (αν υπάρχουν)
-- ΛΥΣΗ:
SELECT p.player_id, p.username, s.bet_id, s.bet_amount
FROM PAIKTHS p
LEFT JOIN SUMMETOXH s ON p.player_id = s.player_id;

-- ΑΣΚΗΣΗ 9: Να βρεθούν οι παίκτες με balance μεγαλύτερο από το μέσο όρο
-- ΛΥΣΗ:
SELECT * FROM PAIKTHS 
WHERE balance > (SELECT AVG(balance) FROM PAIKTHS);

-- ΑΣΚΗΣΗ 10: Να βρεθούν τα στοιχήματα που έχουν συμμετοχές, με τον αριθμό των συμμετοχών
-- ΛΥΣΗ:
SELECT s.bet_id, s.description, COUNT(sm.player_id) AS participation_count
FROM STOIXHMA s
INNER JOIN SUMMETOXH sm ON s.bet_id = sm.bet_id
GROUP BY s.bet_id, s.description;

-- ============================================================
-- ΑΣΚΗΣΕΙΣ INSERT
-- ============================================================

-- ΑΣΚΗΣΗ 11: Να προστεθεί ένας νέος παίκτης με id=10, username='testuser', balance=50.00
-- ΛΥΣΗ:
INSERT INTO PAIKTHS (player_id, username, balance)
VALUES (10, 'testuser', 50.00);

-- ΑΣΚΗΣΗ 12: Να προστεθούν δύο νέοι υπάλληλοι: 'E004' με όνομα 'John Doe' και μισθό 1300,
--            και 'E005' με όνομα 'Jane Smith' και μισθό 1500
-- ΛΥΣΗ:
INSERT INTO YPALLHLOS (employee_id, fullname, salary)
VALUES 
    ('E004', 'John Doe', 1300.00),
    ('E005', 'Jane Smith', 1500.00);

-- ΑΣΚΗΣΗ 13: Να προστεθεί μια νέα συμμετοχή: παίκτης 1, στοίχημα 'B0001', ποσό 25.00
-- ΛΥΣΗ:
-- ΣΗΜΕΙΩΣΗ: Αν ήδη υπάρχει (player_id=1, bet_id='B0001'), θα αποτύχει λόγω PRIMARY KEY
INSERT INTO SUMMETOXH (player_id, bet_id, bet_amount, bet_datetime, result_amount)
VALUES (1, 'B0001', 25.00, NOW(), 0.00);

-- ============================================================
-- ΑΣΚΗΣΕΙΣ UPDATE
-- ============================================================

-- ΑΣΚΗΣΗ 14: Να αυξηθεί το balance του παίκτη με id=2 κατά 50
-- ΛΥΣΗ:
UPDATE PAIKTHS SET balance = balance + 50 WHERE player_id = 2;

-- ΑΣΚΗΣΗ 15: Να ενημερωθεί ο μισθός του υπαλλήλου 'E001' σε 1250.00
-- ΛΥΣΗ:
UPDATE YPALLHLOS SET salary = 1250.00 WHERE employee_id = 'E001';

-- ΑΣΚΗΣΗ 16: Να αυξηθεί το balance όλων των παικτών κατά 10%
-- ΛΥΣΗ:
UPDATE PAIKTHS SET balance = balance * 1.10;

-- ΑΣΚΗΣΗ 17: Να ενημερωθεί το result_amount των συμμετοχών που έχουν bet_amount > 50
--            και το result_amount είναι 0, σε 100.00 (π.χ. κέρδισαν)
-- ΛΥΣΗ:
UPDATE SUMMETOXH 
SET result_amount = 100.00 
WHERE bet_amount > 50 AND result_amount = 0;

-- ============================================================
-- ΑΣΚΗΣΕΙΣ DELETE
-- ============================================================

-- ΑΣΚΗΣΗ 18: Να διαγραφεί ο παίκτης με id=10 (αν υπάρχει)
-- ΛΥΣΗ:
DELETE FROM PAIKTHS WHERE player_id = 10;

-- ΑΣΚΗΣΗ 19: Να διαγραφούν οι συμμετοχές με result_amount = 0
-- ΛΥΣΗ:
-- DELETE FROM SUMMETOXH WHERE result_amount = 0;

-- ΑΣΚΗΣΗ 20: Να διαγραφεί ο υπάλληλος 'E004' (αν υπάρχει)
-- ΛΥΣΗ:
-- DELETE FROM YPALLHLOS WHERE employee_id = 'E004';
-- ΣΗΜΕΙΩΣΗ: Αν υπάρχουν στοιχήματα με employee_id='E004', θα διαγραφούν αυτόματα 
--           λόγω ON DELETE CASCADE

-- ============================================================
-- ΑΣΚΗΣΕΙΣ CREATE TABLE
-- ============================================================

-- ΑΣΚΗΣΗ 21: Να δημιουργηθεί πίνακας TRANSACTIONS με:
--            transaction_id (INT, AUTO_INCREMENT, PRIMARY KEY)
--            player_id (INT, FOREIGN KEY προς PAIKTHS)
--            amount (DECIMAL(10,2))
--            transaction_date (DATETIME)
-- ΛΥΣΗ:
CREATE TABLE IF NOT EXISTS TRANSACTIONS (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    player_id INT,
    amount DECIMAL(10,2) NOT NULL,
    transaction_date DATETIME NOT NULL,
    FOREIGN KEY (player_id) REFERENCES PAIKTHS(player_id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- ΑΣΚΗΣΗ 22: Να δημιουργηθεί πίνακας PROMOTIONS με:
--            promotion_id (INT, PRIMARY KEY)
--            title (VARCHAR(100), NOT NULL)
--            discount_percentage (DECIMAL(5,2))
--            start_date (DATE)
--            end_date (DATE)
-- ΛΥΣΗ:
CREATE TABLE IF NOT EXISTS PROMOTIONS (
    promotion_id INT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    discount_percentage DECIMAL(5,2),
    start_date DATE,
    end_date DATE
);

-- ============================================================
-- ΑΣΚΗΣΕΙΣ ALTER TABLE
-- ============================================================

-- ΑΣΚΗΣΗ 23: Να προστεθεί στήλη 'email' (VARCHAR(100)) στον πίνακα PAIKTHS
-- ΛΥΣΗ:
ALTER TABLE PAIKTHS ADD COLUMN email VARCHAR(100);

-- ΑΣΚΗΣΗ 24: Να προστεθεί στήλη 'phone' (VARCHAR(20)) στον πίνακα YPALLHLOS μετά τη στήλη fullname
-- ΛΥΣΗ:
ALTER TABLE YPALLHLOS ADD COLUMN phone VARCHAR(20) AFTER fullname;

-- ΑΣΚΗΣΗ 25: Να αλλαγεί ο τύπος της στήλης balance στον πίνακα PAIKTHS σε DECIMAL(12,2)
-- ΛΥΣΗ:
ALTER TABLE PAIKTHS MODIFY COLUMN balance DECIMAL(12,2);

-- ΑΣΚΗΣΗ 26: Να αλλάξει το όνομα της στήλης 'email' σε 'email_address' στον πίνακα PAIKTHS
-- ΛΥΣΗ:
ALTER TABLE PAIKTHS CHANGE COLUMN email email_address VARCHAR(100);

-- ΑΣΚΗΣΗ 27: Να διαγραφεί η στήλη 'phone' από τον πίνακα YPALLHLOS
-- ΛΥΣΗ:
-- ALTER TABLE YPALLHLOS DROP COLUMN phone;

-- ============================================================
-- ΑΣΚΗΣΕΙΣ ΠΟΛΥΠΛΟΚΕΣ
-- ============================================================

-- ΑΣΚΗΣΗ 28: Να βρεθούν οι παίκτες με το username τους, το συνολικό ποσό στοιχηματισμού,
--            το συνολικό κέρδος και το καθαρό κέρδος (κέρδος - στοίχημα)
-- ΛΥΣΗ:
SELECT 
    p.player_id,
    p.username,
    COALESCE(SUM(s.bet_amount), 0) AS total_bets,
    COALESCE(SUM(s.result_amount), 0) AS total_winnings,
    (COALESCE(SUM(s.result_amount), 0) - COALESCE(SUM(s.bet_amount), 0)) AS net_profit
FROM PAIKTHS p
LEFT JOIN SUMMETOXH s ON p.player_id = s.player_id
GROUP BY p.player_id, p.username
ORDER BY net_profit DESC;

-- ΑΣΚΗΣΗ 29: Να βρεθούν τα στοιχήματα με τον αριθμό συμμετοχών και το συνολικό ποσό στοιχημάτων
-- ΛΥΣΗ:
SELECT 
    s.bet_id,
    s.description,
    s.stoixima_datetime,
    COUNT(sm.player_id) AS participation_count,
    COALESCE(SUM(sm.bet_amount), 0) AS total_bet_amount
FROM STOIXHMA s
LEFT JOIN SUMMETOXH sm ON s.bet_id = sm.bet_id
GROUP BY s.bet_id, s.description, s.stoixima_datetime;

-- ΑΣΚΗΣΗ 30: Να βρεθούν οι υπάλληλοι που έχουν δημιουργήσει περισσότερα από 1 στοιχήματα,
--            με τον αριθμό των στοιχημάτων τους
-- ΛΥΣΗ:
SELECT 
    y.employee_id,
    y.fullname,
    COUNT(s.bet_id) AS bet_count
FROM YPALLHLOS y
INNER JOIN STOIXHMA s ON y.employee_id = s.employee_id
GROUP BY y.employee_id, y.fullname
HAVING COUNT(s.bet_id) > 1;

-- ============================================================
-- ΤΕΛΟΣ ΑΣΚΗΣΕΩΝ
-- ============================================================
