
-- Τίτλος: StoixiBet Data Control
-- Περιγραφή: Βάση Δεδομένων Στοιχηματικής Εταιρείας


--ΔΗΜΙΟΥΡΓΙΑ ΒΑΣΗΣ ΔΕΔΟΜΕΝΩΝ

CREATE DATABASE IF NOT EXISTS Stoiximatiki;
USE Stoiximatiki;
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


