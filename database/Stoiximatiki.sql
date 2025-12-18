
-- Τίτλος: StoixiBet Data Control
-- Περιγραφή: Βάση Δεδομένων Στοιχηματικής Εταιρείας


--ΔΗΜΙΟΥΡΓΙΑ ΒΑΣΗΣ ΔΕΔΟΜΕΝΩΝ

CREATE DATABASE IF NOT EXISTS Stoiximatiki;
USE Stoiximatiki;
USE student_2507;
-- ΔΗΜΙΟΥΡΓΙΑ ΠΙΝΑΚΩΝ

-- Πίνακας Παικτών
-- Περιγράφει τους παίκτες του συστήματος
CREATE TABLE IF NOT EXISTS PAIKTHS (
    player_id INT,
    username VARCHAR(40),
    balance DECIMAL(10,2) DEFAULT 0.00,
    PRIMARY KEY (player_id),
    UNIQUE (username)
);

-- Πίνακας Υπαλλήλων
-- Περιγράφει τους υπαλλήλους που διαχειρίζονται το σύστημα
CREATE TABLE IF NOT EXISTS YPALLHLOS (
    employee_id CHAR(6),
    employee_name VARCHAR(40) NOT NULL,
    salary DECIMAL(9,2) NOT NULL,
    PRIMARY KEY (employee_id)
);

-- Πίνακας Αγώνων
-- Περιγράφει τους αγώνες στους οποίους μπορούν να γίνουν στοιχήματα
CREATE TABLE IF NOT EXISTS AGONAS (
    match_id CHAR(6),
    home_team VARCHAR(40) NOT NULL,
    away_team VARCHAR(40) NOT NULL,
    match_date DATETIME,
    PRIMARY KEY (match_id)
);

-- Πίνακας Στοιχημάτων
-- Περιγράφει τα διαθέσιμα στοιχήματα για κάθε αγώνα
-- ΣΧΕΣΗ: N:1 με AGONAS (ένας αγώνας έχει πολλά στοιχήματα)
-- ΣΧΕΣΗ: N:1 με YPALLHLOS (ένας υπάλληλος διαχειρίζεται πολλά στοιχήματα)
CREATE TABLE IF NOT EXISTS STOIXIMA (
    match_id CHAR(6),
    bet_id CHAR(7),
    bet_desc VARCHAR(60) NOT NULL,
    bet_date DATETIME NOT NULL,
    employee_id CHAR(6),
    PRIMARY KEY (bet_id),
    FOREIGN KEY (employee_id) REFERENCES YPALLHLOS (employee_id) 
        ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY (match_id) REFERENCES AGONAS (match_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Πίνακας Συμμετοχών
-- Περιγράφει ποιοι παίκτες συμμετέχουν σε ποια στοιχήματα
-- ΣΧΕΣΗ: N:M μεταξύ PAIKTHS και STOIXIMA (ένας παίκτης μπορεί 
--        να συμμετάσχει σε πολλά στοιχήματα, ένα στοίχημα μπορεί 
--        να έχει πολλούς παίκτες)
CREATE TABLE IF NOT EXISTS SYMMETOXI (
    bet_id CHAR(7),
    player_id INT,
    bet_amount DECIMAL(10,2),
    bet_date DATETIME,
    PRIMARY KEY (bet_id, player_id),
    FOREIGN KEY (bet_id) REFERENCES STOIXIMA(bet_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (player_id) REFERENCES PAIKTHS(player_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Πίνακας Τραπεζικών Λογαριασμών
-- Περιγράφει τους τραπεζικούς λογαριασμούς των παικτών
-- ΣΧΕΣΗ: 1:1 με PAIKTHS (κάθε παίκτης έχει έναν μόνο λογαριασμό)
--        UNIQUE στο player_id εξασφαλίζει τη σχέση 1:1
CREATE TABLE IF NOT EXISTS BANK_ACCOUNT (
    IBAN CHAR(16),
    player_id INT NOT NULL,
    bank_name VARCHAR(40) NOT NULL,
    PRIMARY KEY(IBAN),
    UNIQUE (player_id),
    FOREIGN KEY (player_id) REFERENCES PAIKTHS(player_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Πίνακας Συναλλαγών
-- Περιγράφει τις οικονομικές συναλλαγές (καταθέσεις/ανταλήψεις)
-- ΣΧΕΣΗ: N:1 με PAIKTHS (ένας παίκτης μπορεί να έχει πολλές συναλλαγές)
CREATE TABLE IF NOT EXISTS SYNALLAGES (
    transaction_id CHAR(6),
    player_id INT NOT NULL,
    amount DECIMAL(8,2) NOT NULL,
    transaction_date DATETIME NOT NULL,
    transaction_type VARCHAR(8),
    PRIMARY KEY(transaction_id),
    FOREIGN KEY(player_id) REFERENCES PAIKTHS(player_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- ΖΗΤΟΥΜΕΝΟ 8: Πίνακας Μπόνους
-- Περιγράφει τα διαθέσιμα μπόνους του συστήματος
CREATE TABLE IF NOT EXISTS BONUS(
    bonus_id CHAR(6),
    bonus_type VARCHAR(30),
    bonus_value DECIMAL(10,2),
    expiration_date DATE,
    PRIMARY KEY (bonus_id)
);

-- ΖΗΤΟΥΜΕΝΟ 9: Πίνακας Παικτών-Μπόνους (Ενδιάμεσος Πίνακας)
-- Υλοποιεί τη σχέση N:M μεταξύ PAIKTHS και BONUS
-- Ένας παίκτης μπορεί να λάβει πολλά μπόνους, ένα μπόνους 
-- μπορεί να δοθεί σε πολλούς παίκτες
CREATE TABLE IF NOT EXISTS PAIKTHS_BONUS(
    player_id INT,
    bonus_id CHAR(6),
    PRIMARY KEY (player_id, bonus_id),
    FOREIGN KEY (player_id) REFERENCES PAIKTHS(player_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (bonus_id) REFERENCES BONUS(bonus_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- ΖΗΤΟΥΜΕΝΟ 10: Πίνακας Στοιχημάτων ανά Υπάλληλο
-- Ενημερώνεται αυτόματα με TRIGGER
-- Περιέχει τον αριθμό στοιχημάτων που διαχειρίζεται κάθε υπάλληλος
CREATE TABLE IF NOT EXISTS BETS_IN_CHARGE(
    employee_id CHAR(6),
    betsInCharge INT,
    PRIMARY KEY (employee_id),
    FOREIGN KEY (employee_id) REFERENCES YPALLHLOS(employee_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- ΕΙΣΑΓΩΓΗ ΔΕΔΟΜΕΝΩΝ

-- ΖΗΤΟΥΜΕΝΟ: Εισαγωγή δοκιμαστικών δεδομένων

INSERT INTO PAIKTHS (player_id, username, balance) VALUES
(1, 'nikos123', 120.50),
(2, 'maria23', 89.00),
(3, 'nikos_g', 0.00),
(4, 'giannis24', 450.75),
(5, 'kostas77', 33.20);

INSERT INTO YPALLHLOS (employee_id, employee_name, salary) VALUES
('EMP001', 'Giannis Papadopoulos', 1200.00),
('EMP002', 'Maria Kosta', 1450.50),
('EMP003', 'Petros Ioannou', 1300.00),
('EMP004', 'Eleni Markou', 1600.00),
('EMP005', 'Stavros Nikas', 1100.00);

INSERT INTO AGONAS (match_id, home_team, away_team, match_date) VALUES
('M001', 'Olympiakos', 'PAOK', '2025-03-01 20:30:00'),
('M002', 'AEK', 'Aris', '2025-03-05 19:00:00'),
('M003', 'Panathinaikos', 'Volos', '2025-03-07 21:00:00'),
('M004', 'PAOK', 'AEK', '2025-03-10 20:00:00'),
('M005', 'Aris', 'Olympiakos', '2025-03-15 19:30:00');

INSERT INTO STOIXIMA (match_id, bet_id, bet_desc, bet_date, employee_id) VALUES
('M001', 'B000001', 'Νικητής αγώνα', '2025-02-20 12:00:00', 'EMP001'),
('M002', 'B000002', 'Συνολικά γκολ', '2025-02-22 14:00:00', 'EMP001'),
('M001', 'B000003', 'Σκόρερ αγώνα', '2025-02-23 16:00:00', 'EMP003'),
('M004', 'B000004', 'Ημίχρονο/Τελικό', '2025-02-25 13:30:00', 'EMP004'),
('M002', 'B000005', 'Πέναλτι στον αγώνα', '2025-02-26 15:00:00', 'EMP005');

INSERT INTO SYMMETOXI (bet_id, player_id, bet_amount, bet_date) VALUES
('B000001', 1, 10.00, '2025-02-25 18:00:00'),
('B000002', 1, 15.50, '2025-02-26 12:30:00'),
('B000003', 3, 7.00, '2025-02-27 09:20:00'),
('B000004', 5, 20.00, '2025-02-28 14:10:00'),
('B000005', 5, 5.00, '2025-03-01 16:45:00');

INSERT INTO BANK_ACCOUNT (IBAN, player_id, bank_name) VALUES
('GR00000000000001', 1, 'Alpha Bank'),
('GR00000000000002', 2, 'Eurobank'),
('GR00000000000003', 3, 'Piraeus Bank'),
('GR00000000000004', 4, 'National Bank'),
('GR00000000000005', 5, 'Revolut');

INSERT INTO SYNALLAGES (transaction_id, player_id, amount, transaction_date, transaction_type) VALUES
('T00001', 1, 50.00, '2025-02-01 10:00:00', 'καταθεση'),
('T00002', 2, -20.00, '2025-02-03 11:20:00', 'αναληψη'),
('T00003', 1, 100.00, '2025-02-05 14:45:00', 'καταθεση'),
('T00004', 4, -10.00, '2025-02-10 09:15:00', 'αναληψη'),
('T00005', 5, 30.00, '2025-02-12 08:40:00', 'καταθεση');

INSERT INTO BONUS (bonus_id, bonus_type, bonus_value, expiration_date) VALUES
('BN001', 'Welcome Bonus', 10.00, '2025-06-01'),
('BN002', 'Deposit Bonus', 20.00, '2025-07-10'),
('BN003', 'Loyalty Bonus', 5.00, '2025-08-15'),
('BN004', 'Free Bet', 15.00, '2025-04-20'),
('BN005', 'VIP Bonus', 50.00, '2025-12-31');

INSERT INTO PAIKTHS_BONUS (player_id, bonus_id) VALUES
(1, 'BN001'),
(1, 'BN004'),
(2, 'BN002'),
(3, 'BN003'),
(5, 'BN005');

-- 4a
SELECT * FROM YPALLHLOS WHERE employee_name LIKE 'Mar%';

-- 4b
SELECT * FROM PAIKTHS WHERE balance > 40 ORDER BY balance ASC;

-- 4c
SELECT * FROM SYNALLAGES WHERE transaction_type = 'καταθεση'
AND NOT amount > 50;

-- 5a
SELECT employee_id, COUNT(*) AS betsInCharge
FROM STOIXIMA GROUP BY employee_id;

-- 5b
SELECT player_id, MAX(amount) AS maxTransaction
FROM SYNALLAGES WHERE transaction_type = 'καταθεση' 
GROUP BY player_id;

-- 6a
SELECT YPALLHLOS.employee_id, YPALLHLOS.employee_name, STOIXIMA.bet_desc
FROM YPALLHLOS INNER JOIN STOIXIMA ON YPALLHLOS.employee_id = STOIXIMA.employee_id;

-- 6b
SELECT PAIKTHS.player_id, PAIKTHS.username, SYNALLAGES.amount,
SYNALLAGES.transaction_date FROM PAIKTHS LEFT JOIN SYNALLAGES
ON PAIKTHS.player_id = SYNALLAGES.player_id;



--ΔΗΜΙΟΥΡΓΙΑ VIEW

-- ΖΗΤΟΥΜΕΝΟ: View για προβολή παικτών και στοιχημάτων
-- Συνδυάζει πληροφορίες από τους πίνακες PAIKTHS, STOIXIMA, SYMMETOXI
CREATE VIEW PAIKTHS_STOIXIMA AS 
SELECT 
    PAIKTHS.player_id, 
    PAIKTHS.username, 
    STOIXIMA.match_id,
    STOIXIMA.bet_id, 
    STOIXIMA.bet_desc, 
    SYMMETOXI.bet_amount 
FROM PAIKTHS, STOIXIMA, SYMMETOXI 
WHERE PAIKTHS.player_id = SYMMETOXI.player_id
    AND STOIXIMA.bet_id = SYMMETOXI.bet_id;

-- ΔΗΜΙΟΥΡΓΙΑ TRIGGER

-- ΖΗΤΟΥΜΕΝΟ: Trigger για αυτόματη ενημέρωση του πίνακα BETS_IN_CHARGE
-- Όταν εισάγεται νέο στοίχημα, αυξάνεται ο μετρητής στοιχημάτων 
-- του αντίστοιχου υπαλλήλου στον πίνακα BETS_IN_CHARGE
DELIMITER $$
CREATE TRIGGER yp_diaxeirizetai_bet
AFTER INSERT ON STOIXIMA 
FOR EACH ROW
BEGIN
    INSERT INTO BETS_IN_CHARGE(employee_id, betsInCharge)
    VALUES (NEW.employee_id, 1)
    ON DUPLICATE KEY UPDATE betsInCharge = betsInCharge + 1;
END $$
DELIMITER ;

-- Εισαγωγή δοκιμαστικού στοιχήματος για ενεργοποίηση του trigger
INSERT INTO STOIXIMA VALUES ('M004', 'b12395', 'ert',
    '2025-12-01 21:00:00', 'EMP001');

-- ============================================================
-- ΒΗΜΑ 6: ΔΗΜΙΟΥΡΓΙΑ STORED PROCEDURE
-- ============================================================

-- ΖΗΤΟΥΜΕΝΟ: Procedure για εισαγωγή νέου υπαλλήλου
-- Απλοποιεί τη διαδικασία προσθήκης υπαλλήλων
DELIMITER $$
CREATE PROCEDURE AddYpallhlos(
    IN emp_id CHAR(6), 
    IN emp_name VARCHAR(40),
    IN salary DECIMAL(9,2)
)
BEGIN
    INSERT INTO YPALLHLOS(employee_id, employee_name, salary)
    VALUES(emp_id, emp_name, salary);
END $$
DELIMITER ;

-- Παράδειγμα χρήσης:
-- CALL AddYpallhlos('Y00007', 'Μιχαλης Παπαδοπουλος', 1500);

-- ΕΛΕΓΧΟΣ ΔΗΜΙΟΥΡΓΙΑΣ

-- Εμφάνιση όλων των πινάκων
SHOW TABLES;

-- Εμφάνιση όλων των views
SHOW FULL TABLES WHERE Table_type = 'VIEW';

-- Ελέγχος Foreign Key Constraints
SELECT 
    TABLE_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    DELETE_RULE,
    UPDATE_RULE
FROM INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS
WHERE CONSTRAINT_SCHEMA = 'Stoiximatiki'
ORDER BY TABLE_NAME;

