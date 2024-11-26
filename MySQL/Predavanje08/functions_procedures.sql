use adventureworkshop;

-- Functions
-- odredimo broj kupaca sa funkcijom
delimiter $$
create function BrojKupaca()
returns int
deterministic
begin
	# ovime najavljujemo varijablu brojKupaca i deklarirmo tip
	declare brojKupaca int;
	select count(*) into brojKupaca from kupac;
    return brojKupaca;
end $$
delimiter ;

-- ne možemo pozvati samo BrojKupaca()
select BrojKupaca();

-- promijeni delimiter
delimiter $$
-- kreiraj funkciju
create function DrugiNajprodavanijiProizvod()
-- koja vraća int
returns int
-- kaži da je deterministička
deterministic
-- započni sa definicijom
begin
	-- deklariraj varijablu
	declare volumenProdaje int;
	-- napravi select i zapiši to što si dobio u volumenProdaje
    select sum(st1.Kolicina) into volumenProdaje
		from stavka as st1
	group by st1.ProizvodID
	order by sum(st1.Kolicina) desc limit 1,1;
    -- vrati volumenProdaje;
    return volumenProdaje;
-- završi definiciju funkcije
end $$
-- vrati delimiter
delimiter ;


-- funkciju odavde pozivamo, razlika je što odavde pozivamo funkciju
select sum(st.Kolicina) - DrugiNajprodavanijiProizvod() as Razlika
from stavka as st
group by st.ProizvodID
order by sum(st.Kolicina) desc limit 1;

delimiter $$
create function BrojKupacaPoGradu(GradID int)
returns int
deterministic
begin
	declare brojKupaca int;
		select count(*) into brojKupaca 
			from kupac 
			where kupac.GradID = GradID;
    return brojKupaca;
end $$
delimiter ;

-- koliko je bilo kupaca iz Osijeka?
select BrojKupacaPoGradu(2);

-- Procedure
delimiter $$
create procedure DodajKreditnuKarticu(
	in Tip varchar(50),
	in Broj varchar(25),
	in IstekMjescec tinyint,
	in IstekGodina int
)
begin
	if length(Broj) = 16 then
		insert into kreditnakartica 
        (Tip, Broj, IstekMjescec, IstekGodina) values
        (Tip, Broj, IstekMjescec, IstekGodina);
	else
		signal sqlstate '45000'  
        set message_text = 'Broj kreditne kartice mora imati točno 16 znakova';
	end if;
end $$
delimiter ;

call DodajKreditnuKarticu(
	'Visa', '12354567801234576',
    07,
    2026
);

-- Definiraj proceduru koja će omogućiti narudžbu određenog proizvoda
--  tako da provjeri stanje na skladištu ako proizvod je dostupan vrati OK
-- i umanji stanje na skladištu za poslanu količinu. Ako nema proizvoda na
--  skladištu ili ako je željena količina veća od stanja, vrati ERR

delimiter $$
-- procedura ima 2 ulazna parametra ProizvodID i Kolicina i 1 izlazni parametar StatusNarudzbe
create procedure NaruciProizvod(
	in ProizvodID int,
    in Kolicina int,
    out StatusNarudzbe varchar(10)
)
begin
-- lokalne varijable kreiramo s declare
-- koliko ima proizvoda zapistat ćemo u RaspolozivaKolicina u selectu, iza declare ;
	declare RaspolozivaKolicina int;
    select MinimalnaKolicinaNaSkladistu into RaspolozivaKolicina
    from proizvod
    where proizvod.IDProizvod = ProizvodID;
    -- ako je RaspolozivaKolicina veća ili jednaka količini napravi update proizvoda i umanji
    -- količinu za količinu koju neko želi naručiti
    if RaspolozivaKolicina >= Kolicina then
		update proizvod
        set MinimalnaKolicinaNaSkladistu = RaspolozivaKolicina - Kolicina
        where proizvod.IDProizvod = ProizvodID;
        -- postavi status narudžbe na OK
        set StatusNarudzbe = 'OK';
	else
		set StatusNarudzbe = 'ERR';
    end if;
end $$
delimiter ;

-- koristimo 3 parametra (@StatusNarudzbe je sesijska varijabla)
call NaruciProizvod(1, 50, @StatusNarudzbe);
select @StatusNarudzbe as status;
