drop database if exists fcc;

create database if not exists fcc 
character set utf8mb4 collate utf8mb4_general_ci;

use fcc;

CREATE TABLE slova(
  slovo TEXT
);

INSERT INTO slova(slovo) VALUES ('A'), ('B'), ('C');

CREATE TABLE brojevi(
  broj TEXT
);

INSERT INTO brojevi(broj) VALUES (1), (2), (3);

# cross join ili Kartezijev produkt ili umnožak te dvije liste 
SELECT *
FROM slova
CROSS JOIN brojevi;



WITH recursive generirana_serija AS (
  SELECT (CURRENT_DATE - INTERVAL 5 day) AS Datum
  UNION ALL
  SELECT Datum + interval 1 day
  FROM generirana_serija
  WHERE Datum < CURRENT_DATE)
SELECT * FROM generirana_serija;

CREATE TABLE zadaci(
  ime TEXT
);

INSERT INTO zadaci(ime) VALUES
('Oprati zube'),
('Doručkovati'),
('Tuširanje'),
('Obući se');

SELECT
  zadaci.ime,
  datumi.Datum
FROM zadaci
CROSS JOIN
(
WITH recursive generirana_serija AS (
  SELECT (CURRENT_DATE - INTERVAL 5 day) AS Datum
  UNION ALL
  SELECT Datum + interval 1 day
  FROM generirana_serija
  WHERE Datum < CURRENT_DATE)
SELECT * FROM generirana_serija
) AS datumi;

CREATE TABLE režiseri(
  id SERIAL PRIMARY KEY,
  ime TEXT NOT NULL
);

INSERT INTO režiseri(ime) VALUES
('John Smith'),
('Sanja Ulipi'),
('Xavier Wills'),
('Bev Scott'),
('Bree Jensen');

CREATE TABLE filmovi(
  film_id SERIAL PRIMARY KEY,
  ime TEXT NOT NULL,
  id INTEGER REFERENCES režiseri
);

INSERT INTO filmovi(ime, id) VALUES
('Film 1', 1),
('Film 2', 1),
('Film 3', 2),
('Film 4', NULL),
('Film 5', NULL);

SELECT *
FROM filmovi
LEFT JOIN režiseri
  ON režiseri.id = filmovi.id
UNION
SELECT *
FROM filmovi
RIGHT JOIN režiseri
  ON režiseri.id = filmovi.id;
  
# INNER JOIN prikazuje sve filmove koji imaju režisera
SELECT *
FROM filmovi
INNER JOIN režiseri
  ON režiseri.id = filmovi.id;

# INNER JOIN prikazuje sve režisere koji imaju film
SELECT *
FROM režiseri
INNER JOIN filmovi
  ON filmovi.id = režiseri.id;

# INNER JOIN prikazuje s kolonama koje želimo sve režisere koji imaju film
SELECT filmovi.film_id, filmovi.ime, filmovi.id, režiseri.ime
FROM filmovi
INNER JOIN režiseri
  ON režiseri.id = filmovi.id;

# INNER JOIN prikazuje s kolone koje želimo sa aliasima sve režisere koji imaju film
SELECT F.film_id, F.ime, R.id, R.ime
FROM filmovi AS F
INNER JOIN režiseri AS R
  ON R.id = F.id;

# INNER JOIN prikazuje s kolama koje želimo i skraćenim aliasima skraćeno sve režisere koji imaju film
SELECT F.film_id, F.ime, R.id, R.ime
FROM filmovi F
INNER JOIN režiseri R
  ON R.id = F.id;

# INNER JOIN prikazuje koji su režiseri radili na filmovima, zbog grupiranja svaki jednom
SELECT R.ime
FROM filmovi F
INNER JOIN režiseri R
  ON R.id = F.id
GROUP BY R.ime;


# INNER JOIN prikazuje filmove u kojima je režiser bio John Smith
SELECT F.film_id, F.ime, R.id, R.ime
FROM filmovi F
INNER JOIN režiseri R
  ON R.id = F.id
WHERE R.ime = 'John Smith';

# INNER JOIN prikazuje tko je režirao Film 3
SELECT F.film_id, F.ime, R.id, R.ime
FROM filmovi F
INNER JOIN režiseri R
  ON R.id = F.id
WHERE F.ime = 'Film 3';

# INNER JOIN  prikazuje koji režiseri su radili na filmovima
SELECT R.ime
FROM filmovi F
INNER JOIN režiseri R
  ON R.id = F.id
GROUP BY R.ime;

# INNER JOIN prikazuje koliko je koji režiser snimio filmova
SELECT R.ime, COUNT(F.id) AS 'Snimi(o/la) filmova'
FROM filmovi F
INNER JOIN režiseri R
  ON R.id = F.id
GROUP BY R.ime;

# INNER JOIN  prikazuje koliko je koji režiser snimio filmova
SELECT R.ime, count(*) AS 'Snimi(o/la) filmova'
FROM filmovi F
INNER JOIN režiseri R
  ON R.id = F.id
GROUP BY R.ime
HAVING count(*) > 0;

# INNER JOIN prikazuje tko je režirao Film 2
SELECT F.film_id, F.ime, R.id, R.ime
FROM filmovi F
INNER JOIN režiseri R
  ON R.id = F.id
WHERE F.ime = 'Film 2';

# INNER JOIN prikazuje filmove u kojima je režiser bio John Smith
SELECT F.id, F.ime, R.id, R.ime
FROM filmovi F
INNER JOIN režiseri R
  ON R.id = F.id
WHERE R.ime = 'John Smith';


# INNER JOIN prikazuje tko je režirao 'Film 3' sa upotrebom USING
SELECT id, F.ime, R.ime
FROM filmovi F
INNER JOIN režiseri R
USING (id)
WHERE F.ime = 'Film 3';


# INNER JOIN prikazuje tko je režirao 'Film 3' sa upotrebom ON
SELECT F.id, F.ime, R.ime
FROM filmovi F
INNER JOIN režiseri R
  ON R.id = F.id
WHERE F.ime = 'Film 3';

# INNER JOIN prikazuje režisere koji su snimili barem 1 film a ID njihovog filma je veći od 1
SELECT F.film_id, F.ime, R.id, R.ime
FROM režiseri R
INNER JOIN filmovi F
  ON F.id = R.id
WHERE F.film_id >1;

# LEFT JOIN pronađeo sve filmove i njihove režisere bez obzira imaju li ili ne režisera sa ON
SELECT *
FROM filmovi
LEFT JOIN režiseri
  ON režiseri.id = filmovi.id;

# LEFT JOIN pronađeo sve filmove i njihove režisere bez obzira imaju li ili ne režisera sa USING
SELECT *
FROM filmovi
LEFT JOIN režiseri
  USING(id);

# LEFT JOIN koliko je koji režiser snimio filmova
SELECT R.ime, COUNT(F.id) AS 'Broj filmova'
FROM filmovi F
LEFT JOIN režiseri R
  ON R.id = F.id
GROUP BY R.ime;

# INNER JOIN prikazuje tko je režirao 'Film 3' sa upotrebom ON
SELECT F.film_id, F.ime, R.id, R.ime
FROM filmovi F
LEFT JOIN režiseri R
  ON R.id = F.id
WHERE F.ime = 'Film 3';

# neupareni zapisi unutar tablca - koji filmovi su bez režisera
SELECT *
FROM filmovi
LEFT JOIN režiseri
    ON režiseri.id = filmovi.id
WHERE filmovi.id IS NULL;

# neupareni zapisi unutar tablca - koji režiseri su bez filma
SELECT *
FROM režiseri
LEFT JOIN filmovi
    ON režiseri.id = filmovi.id
WHERE filmovi.id IS NULL;

# prikazuži sve režisere i filmove koje su snimili, uključivši i režisere koji nisu snimili filmove
SELECT *
FROM filmovi
RIGHT JOIN režiseri
  ON režiseri.id = filmovi.id;

# LEFT JOIN koliko je koji režiser snimio filmova
SELECT R.ime, COUNT(F.id) AS 'Snimi(o/la) filmova'
FROM filmovi F
RIGHT JOIN režiseri R
  ON R.id = F.id
GROUP BY R.ime;

# RIGHT JOIN prikazuje tko je režirao 'Film 3' sa upotrebom ON
SELECT F.film_id, F.ime, R.id, R.ime
FROM filmovi F
RIGHT JOIN režiseri R
  ON R.id = F.id
WHERE F.ime = 'Film 3';


# neupareni zapisi unutar tablca - koji filmovi su bez režisera
SELECT *
FROM filmovi
RIGHT JOIN režiseri
    ON režiseri.id = filmovi.id
WHERE filmovi.id IS NULL;

# neupareni zapisi unutar tablca - koji režiseri su bez filma
SELECT *
FROM režiseri
RIGHT JOIN filmovi
    ON režiseri.id = filmovi.id
WHERE filmovi.id IS NULL;

SELECT *
FROM režiseri
LEFT JOIN filmovi
  ON filmovi.id = režiseri.id
WHERE filmovi.film_id IS NOT NULL;

CREATE TABLE ulaznice(
  id SERIAL PRIMARY KEY,
  film_id INTEGER NOT NULL
    REFERENCES filmovi
);

INSERT INTO ulaznice(film_id) VALUES (1), (1), (3);

SELECT *
FROM režiseri
INNER JOIN filmovi
  ON filmovi.id = režiseri.id
INNER JOIN ulaznice
  ON ulaznice.film_id = filmovi.id;
  
  SELECT *
FROM režiseri
INNER JOIN filmovi
  ON filmovi.id = režiseri.id
LEFT JOIN ulaznice
  ON ulaznice.film_id = filmovi.film_id;

SELECT *
FROM filmovi
INNER JOIN režiseri
  ON režiseri.id = filmovi.id
  AND režiseri.ime <> 'John Smith';
  
SELECT *
FROM filmovi
INNER JOIN režiseri
  ON režiseri.id = filmovi.id
  WHERE režiseri.ime <> 'John Smith';
  
CREATE TABLE zaposleni(
  zaposlen_id INT PRIMARY KEY,
  zaposlen_ime  varchar(30),
  manager_id INT,
  FOREIGN KEY (manager_id) references zaposleni(zaposlen_id)
);


insert into zaposleni values
(1, 'Daniel', null);
insert into zaposleni values
(2, 'Dario', 1);
insert into zaposleni values
(3, 'Sanja', 2);
insert into zaposleni values
(4, 'Dinko', 1);
insert into zaposleni values
(5, 'Smiljka', 3);


SELECT e1.zaposlen_id AS zaposlen_id,
  e1.zaposlen_ime AS Radnik,
  e2.zaposlen_ime AS 'Njegov Manager'
FROM zaposleni AS e1
INNER JOIN zaposleni AS e2
  ON e1.manager_id = e2.zaposlen_id;

SELECT e1.zaposlen_id AS zaposlen_id,
  e1.zaposlen_ime AS Radnik,
  e2.zaposlen_ime AS 'Njegov Manager'
FROM zaposleni AS e1
LEFT JOIN zaposleni AS e2
  ON e1.manager_id = e2.zaposlen_id;

