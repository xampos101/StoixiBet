-- ⚠️ ΣΗΜΑΝΤΙΚΟ: Αλλάξτε το xx με τον αριθμό ομάδας σας!
-- Αυτό το αρχείο είναι έτοιμο για εκτέλεση στον server
-- Η βάση student_25xx πρέπει να υπάρχει ήδη (δημιουργείται αυτόματα)

USE student_25xx;  -- ⚠️ Αλλάξτε το xx!

-- Δημιουργία πινάκων
CREATE TABLE IF NOT EXISTS PAIKTHS (
    player_id INT PRIMARY KEY,
    username VARCHAR(40) NOT NULL,
    balance DECIMAL(10,2) DEFAULT 0.00
);

CREATE TABLE IF NOT EXISTS YPALLHLOS (
    employee_id CHAR(6) PRIMARY KEY,
    fullname VARCHAR(40) NOT NULL,
    salary DECIMAL(10,2)
);

CREATE TABLE IF NOT EXISTS STOIXHMA (
    bet_id CHAR(7) PRIMARY KEY,
    description VARCHAR(60),
    stoixima_datetime DATETIME,
    employee_id CHAR(6),
    FOREIGN KEY (employee_id) REFERENCES YPALLHLOS(employee_id)
	ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS SUMMETOXH (
    player_id INT,
    bet_id CHAR(7),
    bet_amount DECIMAL(10,2),
    bet_datetime DATETIME,
    result_amount DECIMAL(10,2),
    PRIMARY KEY (player_id, bet_id),
    FOREIGN KEY (player_id) REFERENCES PAIKTHS(player_id)
    ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (bet_id) REFERENCES STOIXHMA(bet_id)       
    ON DELETE CASCADE  ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS KATATHESI(
	transtaction_id INT primary key auto_increment,
    player_id int,
    amount decimal(10,2) NOT NULL,
    transtaction_date datetime NOT NULL,
    FOREIGN KEY(player_id) REFERENCES PAIKTHS(player_id)
);

CREATE TABLE IF NOT EXISTS LOGARIASMOS(
	account_id int primary key,
    player_id int,
    iban VARCHAR(34) unique not null,
    bank_name VARCHAR(40),
    FOREIGN KEY (player_id) references PAIKTHS(player_id)
);

CREATE TABLE IF NOT EXISTS AGONAS(
	match_id int Primary key,
    home_team varchar(40) not null,
    away_team varchar(40) not null,
    match_date datetime
);

CREATE TABLE IF NOT exists BONUS(
	bonus_id int primary key,
    bonus_type varchar(30) not null,
    value decimal(10,2) not null,
    expiration_date date
);

CREATE TABLE IF NOT EXISTS PAIKTHS_BONUS(
	player_id int,
    bonus_id int,
    received_date date,
	PRIMARY KEY (player_id, bonus_id),
    FOREIGN KEY (player_id) REFERENCES PAIKTHS(player_id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (bonus_id) REFERENCES BONUS(bonus_id)
        ON DELETE CASCADE ON UPDATE CASCADE
);

-- Εισαγωγή δειγματικών δεδομένων
INSERT INTO PAIKTHS (player_id, username, balance)
VALUES
(1, 'giorgos28', 150.00),
(2, 'maria32', 75.50),
(3, 'alex25', 250.00);

INSERT INTO YPALLHLOS (employee_id, fullname, salary)
VALUES
('E001', 'Eleni Stamati', 1200.00),
('E002', 'Petros Athanasiou', 1400.00),
('E003', 'Nikos Georgiou', 1600.00);

INSERT INTO STOIXHMA (bet_id, description, stoixima_datetime, employee_id)
VALUES
('B0001', 'Football Match: AEK vs PAOK', '2025-10-21 20:00:00', 'E001'),
('B0002', 'Basketball Game: Olympiakos vs Panathinaikos', '2025-10-22 19:00:00', 'E002'),
('B0003', 'Tennis Final: Tsitsipas vs Alcaraz', '2025-10-23 18:30:00', 'E001'),
('B0004', 'Horse Racing Event', '2025-10-24 17:00:00', 'E002');

INSERT INTO SUMMETOXH (player_id, bet_id, bet_amount, bet_datetime, result_amount)
VALUES
(1, 'B0001', 50.00, '2025-10-21 19:50:00', 125.00),
(1, 'B0002', 30.00, '2025-10-22 18:45:00', 0.00),
(2, 'B0002', 40.00, '2025-10-22 18:55:00', 0.00),
(2, 'B0003', 60.00, '2025-10-23 18:15:00', 180.00),
(3, 'B0001', 70.00, '2025-10-21 19:55:00', 175.00),
(3, 'B0004', 20.00, '2025-10-24 16:45:00', 0.00);













