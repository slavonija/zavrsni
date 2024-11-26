use adventureworkshop;

-- pogled generira popis gradova s njihovim odgovarajućim državama koristeći LEFT JOIN između tablica Grad i Drzava
-- rezultat se sortira po imenu države
create or replace view Grad_Drzava as 
select gr.Naziv as Grad, dr.Naziv as Drzava
from Grad as gr
left join Drzava as dr
on gr.DrzavaId = dr.IDDrzava
order by Drzava;

select * from grad_drzava order by Grad;

-- ovo ne prolazi jer po defaultu nije moguće napraviti ažuriranje
update grad_drzava set Drzava = "Hrvatska"
where Grad like "%Donja Motičina%";


-- Procedura za za naručivanje proizvoda - transakcija, okidač
-- omogućava naručivanje proizvoda i ažurira količinu na skladištu, ako je cijena proizvoda NULL (nema proizvoda), transakcija se poništava.
delimiter $$
-- ulazni parametri su ProizvodID i Kolicina
create procedure NaruciProizvod(
	in ProizvodID int,
    in Kolicina int
)
begin
-- lokalne varijable u koje napravimo select iz tablice kasnije
	declare RaspolozivaKolicina int;
    declare CijenaPoKomadu decimal;
-- pokretanje transakcije
    start transaction;

-- RaspolozivaKolicina prima vrijednost iz kolone MinimalnaKolicinaNaSkladistu a CijenaPoKomadu prima CijenaBezPDV
    select MinimalnaKolicinaNaSkladistu, CijenaBezPDV
    into RaspolozivaKolicina, CijenaPoKomadu
-- iz tablice Proizvod
    from Proizvod
-- uvjet koji osigurava da se podaci dohvaćaju samo za IDProizvod je kolona iz tablice Proizvod koji je jednak ulaznoj varijabli ProizvodID
    where IDProizvod = ProizvodID;
 
    if CijenaPoKomadu is null then
		rollback;
	else
-- prvo radimo update tablice Proizvod (ažuriramo je MinimalnaKolicinaNaSkladistu)
		update Proizvod
-- postavlja polje MinimalnaKolicinaNaSkladistu u tablici Proizvod umanjeno za Kolicina, varijablu koja je došla kao ulazni parametar
		set MinimalnaKolicinaNaSkladistu = RaspolozivaKolicina - Kolicina
-- ali samo za polje IDProizvod koji je jednak ulaznoj varijabli ProizvodID
		where IDProizvod = ProizvodID;
 
		insert into Racun (DatumIzdavanja, BrojRacuna, KupacID)
		values(now(), '1225877546', 1);
 
		set @racunID = last_insert_id();

		insert into Stavka 
		(RacunID, Kolicina, ProizvodID, CijenaPoKomadu, PopustUPostocima, UkupnaCijena)
		values
		(@racunID, Kolicina, ProizvodID, CijenaPoKomadu, 0, CijenaPoKomadu * Kolicina);
 
		if RaspolozivaKolicina >= Kolicina then
			commit;
		else
			rollback;
-- naredba signal prazni dijagnostičko područje i proizvodi prilagođenu grešku
			signal sqlstate '45000'
			set message_text = "Nema dovoljno proizvoda na zalihi.";
		end if;
	end if;
 
end $$
delimiter ;

-- okidač za praćenje promjena na zalihama -automatski prati promjene na zalihama proizvoda i zapisuje ih u tablicu Zapisnik
delimiter $$
create trigger AzurirajPromjenuZaliha
after update on Proizvod
for each row
begin
	if old.MinimalnaKolicinaNaSkladistu <> new.MinimalnaKolicinaNaSkladistu
		then
			insert into Zapisnik (Poruka)
			values(concat('Promijenjena količina za proizvod',
            new.Naziv,
            ', Staro stanje:',
            old.MinimalnaKolicinaNaSkladistu,
            ', Novo stanje:',
            new.MinimalnaKolicinaNaSkladistu,
            ', Datum: ',
            now()));
	end if;
end $$
delimiter ;
 

-- pozivanje procedure za naručivanje proizvoda s različitim unosima 
call NaruciProizvod(1,50);
call NaruciProizvod(996,500);
call NaruciProizvod(996,50);
call NaruciProizvod(8000,50);
