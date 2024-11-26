-- Trigeri
drop database if exists obrisi_me;

create database if not exists obrisi_me
character set utf8mb4 collate utf8mb4_general_ci;

use obrisi_me;

-- okidač prije ažuriranja(engl. Before Update Trigger)
create table kupac (račun_br integer primary key, 
	kupac_prezime varchar(20), 
	raspoloživ_saldo decimal
);

create table mini_obračun (
	račun_br integer, 
	raspoloživ_saldo decimal, 
	foreign key(račun_br) references kupac(račun_br) on delete cascade
); 

insert into kupac values (1000, "Branko", 7000);
insert into kupac values (1001, "Sanja", 12000);

delimiter $$
create trigger ažuriraj_kupca
	before update on kupac
    for each row
    begin
    insert into mini_obračun values (old.račun_br, old.raspoloživ_saldo);
end $$ 
delimiter ;

update kupac set raspoloživ_saldo = raspoloživ_saldo + 3000 where račun_br = 1001;
update kupac set raspoloživ_saldo = raspoloživ_saldo + 3000 where račun_br = 1000;

-- okidač nakon ažuriranja (engl. AFTER UPDATE Trigger)
create table mikro_obračun (
	račun_br integer,
	raspoloživ_saldo decimal,
    foreign key(račun_br) references kupac(račun_br) on delete cascade
); 


insert into kupac values (1002, "Mladen", 4500);

delimiter $$
create trigger nakon_ažuriranja
	after update on kupac
	for each row
begin
	insert into mikro_obračun values(new.račun_br, new.raspoloživ_saldo);
end $$
delimiter ;

update kupac set raspoloživ_saldo = raspoloživ_saldo + 1500 where račun_br = 1002;

-- okidač prije ubacivanja (BEFORE INSERT Trigger)
create table
	kontakti (
    kontakt_id INT (11) NOT NULL AUTO_INCREMENT, 
	prezime VARCHAR (30) NOT NULL,
    ime VARCHAR (25),
    rođendan DATE,
    datum_kreiranja DATE,
    kreirao VARCHAR(30),
    CONSTRAINT kontakti_pk PRIMARY KEY (kontakt_id)
); 

delimiter $$
create trigger kontakti_prije_inserta
	before insert
    on kontakti for each row
begin
	DECLARE vUser varchar(50);
	-- Pronađi korisničko ime osobe koja radi INSERT u tablicu
	select USER() into vUser;
	-- Ažuriraj polje datum_kreiranja na trenutni sistemski datum
	SET NEW.datum_kreiranja = SYSDATE();
	-- Ažuriraj polje kreirao sa korisničkim imenom osobe koja izvodi INSERT
	SET NEW.kreirao = vUser;
end $$
delimiter ;


insert into kontakti values (
	1, "Nikola", "Tesla",
    str_to_date ("10-07-1856", "%d-%m-%Y"),
    str_to_date ("10-06-2024", "%d-%m-%Y"), "xyz"); 



-- okidač nakon inserta (AFTER INSERT Trigger)
create table kontakti2
	(kontakt_id int (11) NOT NULL AUTO_INCREMENT, 
	prezime VARCHAR(30) NOT NULL, 
    ime VARCHAR(25), rođendan DATE,
    CONSTRAINT kontakti_pk PRIMARY KEY (kontakt_id)
);

create table kontakti_kontrola (
	kontakt_id integer,
	datum_kreiranja date,
	kreirao varchar (30)
);

delimiter $$
create trigger kontakti_nakon_inserta
after insert
on kontakti2 for each row
begin
	DECLARE vUser varchar(50);
	-- Pronađi korisničko ime osobe koja pravi INSERT u tablicu
	SELECT USER() into vUser;
	-- Ubaci slog u kontrolnu tablicu
	INSERT into kontakti_kontrola (
		kontakt_id,
		datum_kreiranja,
		kreirao)
        VALUES
			(NEW.kontakt_id, SYSDATE(), vUser);
end $$
delimiter ;

insert into kontakti2 values (1, "Sanja", "Ulipi", 
                         str_to_date("09.06.2024", "%d.%m.%Y")); 


-- okidač prije brisanja (BEFORE DELETE Trigger)
create table kontakti2 (
	kontakt_id int (11) NOT NULL AUTO_INCREMENT, 
	prezime VARCHAR (30) NOT NULL, ime VARCHAR (25), 
	rođendan DATE, created_date DATE, kreirao VARCHAR(30), 
	CONSTRAINT kontakti_pk PRIMARY KEY (kontakt_id)
);

create table kontakti_kontrola2 (
	kontakt_id integer,
    datum_brisanja date,
    obrisao varchar(20)
); 

delimiter $$
create trigger kontakti_prije_delete
before delete
on kontakti for each row
begin
	DECLARE vUser varchar(50);
	-- Pronađite korisničko ime osobe koja radi DELETE u tablici
	SELECT USER() into vUser;
	-- Umetnite zapis u kontrolnu tablicu
	INSERT into kontakti_kontrola2 (
		kontakt_id, datum_brisanja, obrisao)
		VALUES (OLD.kontakt_id, SYSDATE(), vUser);
end $$
delimiter ;

drop trigger kontakti_prije_delete;

insert into kontakti values (2, "Tolstoj", "Lav",
	str_to_date ("07.11.1910", "%d.%m.%Y"), 
    str_to_date ("09.06.2024", "%d.%m.%Y"), "xyz");
    
delete from kontakti where prezime="Tolstoj";


-- okidač nakon brisanja (AFTER DELETE Trigger)
    
create table kontakti_kontrola3 (
	kontakt_id integer,
    datum_brisanja date,
    obrisao varchar(20)
);

delimiter $$
create trigger kontakti_nakon_delete
after delete
on kontakti for each row
begin
	DECLARE vUser varchar(50);
	-- Pronađi korisničko ime osobe koja radi DELETE u tablici
	SELECT USER() into vUser;
	-- Ubaci slog u kontrolnu tablicu
	INSERT into kontakti_kontrola3 (kontakt_id, datum_brisanja, obrisao)
		VALUES
		(OLD.kontakt_id, SYSDATE(), vUser);
end $$
delimiter ;

insert into kontakti values (1, "Bošković", "Ruđer", 
	str_to_date ("18.05.1711", "%d.%m.%Y"), 
	str_to_date ("09.06.2024", "%d.%m.%Y"), "xyz");
delete from kontakti where prezime="Bošković";
