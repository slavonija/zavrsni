use adventureworkshop;

-- Dohvati sve proizvode
select * from proizvod;

-- Dohvati drugih 5 proizvoda
select * from proizvod limit 5;

-- Dohvati drugih 5 proizvoda
-- ili preskoči prvih 5 (offset) i uzmi idućih 5 (limit)
select * from proizvod limit 5 offset 5;

-- Dohvati drugih 5 proizvoda
-- preskoči prvih (offset) i uzmi idućih 5 (limit)
select * from proizvod limit 5,5;

-- Izbroj proizvode u svakoj podkategoriji
select PotkategorijaID, count(*) as BrojProizvoda
from proizvod
group by PotkategorijaID;

-- Izbroj ukupnu prodaju za svakog komercijalistu
select KomercijalistID,  count(*) as UkupnaProdaja
from racun
group by KomercijalistID;

-- ispiši sve gradove s imenom države
select grad.Naziv as Grad, drzava.Naziv as Država
from grad, drzava
where grad.DrzavaID = drzava.IDDrzava;

select grad.Naziv as Grad, drzava.Naziv as Drzava
from grad
join drzava
on grad.DrzavaID = drzava.IDDrzava;

select grad.Naziv as Grad, drzava.Naziv as Država
from grad
right join drzava
on grad.DrzavaID = drzava.IDDrzava;

select grad.Naziv as Grad, drzava.Naziv as Država
from drzava
right join grad
on grad.DrzavaID = drzava.IDDrzava;

-- FULL OUTER JOIN
select grad.Naziv as Grad, drzava.Naziv as Država
from grad
left join drzava
on grad.DrzavaID = drzava.IDDrzava
union
select grad.Naziv as Grad, drzava.Naziv as Država
from grad
right join drzava
on grad.DrzavaID = drzava.IDDrzava;

-- FULL OUTER JOIN with exclusion (bez presjeka A i B)
select grad.Naziv as Grad, drzava.Naziv as Drzava
from grad
left join drzava
on grad.DrzavaID = drzava.IDDrzava
where grad.DrzavaID is null 
union
select grad.Naziv as Grad, drzava.Naziv as Drzava
from grad
right join drzava
on grad.DrzavaID = drzava.IDDrzava
where grad.DrzavaID is null ;

-- ispiši sve račune s imenom i prezimenom komercijaliste
select ra.*, ko.IMe, ko.Prezime
from racun as ra
join komercijalist as ko
on ra.KomercijalistID = ko.IDKomercijalist;

-- dohvati sve račune, te ispiši broj računa s ukupnim brojem stavki po računu
select ra.BrojRacuna, count(st.IDStavka) as BrojStavki
from racun as ra
left join stavka as st
on ra.IDRacun = st.RacunID
group by ra.IDRacun
order by BrojStavki desc limit 5;

-- dohvati sve kupce bez računa - rješenje sa podupitom
select * from kupac
where IDkupac
not in (select distinct KupacID from racun);

-- dohvati sve kupce bez računa - rješenje sa JOIN
select * from kupac as ku
left join racun ra
on ra.KupacID = ku.IDKupac
where ra.IDRacun is null;

-- dohvati komercijaliste kod kojih je račun plaćen kreditnim karticama - rješenje sa podupitom
select * from komercijalist as ko
where ko.IDKomercijalist in 
(select distinct KomercijalistID
from racun
where KreditnaKarticaID is not null);

-- dohvati komercijaliste kod kojih je račun plaćen kreditnim karticama - rješenje sa JOIN
select distinct  ko.*
from komercijalist as ko
join racun as ra
on ra.KomercijalistID = ko.IDKomercijalist
order by ra.BrojRacuna desc;

SHOW DATABASES;
select database();
describe kupac;
SHOW TABLES;
SHOW CREATE TABLE drzava;
select now();
SELECT 2 + 4; 
SHOW DATABASES;

#-------------------------- novo predavanje
-- ispiši nazive gradova koji imaju više od 1500 kupaca 
select gr.Naziv, count(ku.IDKupac) as BrojKupaca
from grad as gr, kupac as ku
where gr.IDGrad = ku.GradID
group by ku.GradID
having BrojKupaca > 1500;

-- Ispiši sve proizvode (naziv) s nazivom kategorije i nazivom potkategorije
select 
pr.Naziv as Proizvod, 
pk.Naziv as Potkategorija, 
ka.Naziv as Kategorija
	from proizvod as pr
left join potkategorija as pk
	on pr.PotkategorijaID = pk.IDPotkategorija
left join kategorija as ka
	on pk.KategorijaID=ka.IDKategorija;
    
-- Ispiši sve račune (broj računa) s imenom komercijaliste i imenom kupca
select 
ra.BrojRacuna,
ko.Ime as KomercijalistIme,
ko.Prezime as KomercijalistPrezime,
ku.Ime as KupacIme,
ku.Prezime as KupacPrezime
	from racun as ra
left join komercijalist as ko
	on ra.KomercijalistID=ko.IDKomercijalist
left join kupac as ku
	on ra.KupacID=ku.IDKupac;


-- Izračunaj prosječnu cijenu proizvoda u svakoj kategoriji - rješenje sa INNER JOIN
select ka.Naziv, avg(pr.CijenaBezPDV)
from kategorija as ka
join potkategorija as po
on ka.IDKategorija = po.KategorijaID
join proizvod as pr 
on po.IDPotkategorija = pr.PotkategorijaID 
group by ka.Naziv ;

-- Izračunaj prosječnu cijenu proizvoda u svakoj kategoriji - rješenje sa CROSS JOIN
select ka.Naziv, avg(pr.CijenaBezPDV)
from kategorija as ka, potkategorija as po, proizvod as pr
where ka.IDKategorija = po.KategorijaID
and po.IDPotkategorija = pr.PotkategorijaID
group by ka.Naziv;

-- Pronađi grad s najvećim brojem narudžbi (računa) - rješenje sa podupitom
select gr.Naziv as Grad
from grad as gr
where gr.IDGrad =
	(select ku.GradID
	from kupac as ku
	join racun as ra
	on ku.IDKupac = ra.KupacID
	group by ku.GradID
	order by count(ra.IDRacun) desc limit 1);
    
-- Pronađi grad s najvećim brojem narudžbi (računa) - rješenje sa višestrukim INNER JOIN
select count(ra.IDRacun) as ZbrojRacuna, gr.Naziv as Grad
from racun as ra
join kupac as ku
on ra.kupacID = ku.IDkupac
join grad as gr
on gr.IDgrad = ku.GradID
group by gr.IdGrad
order by ZbrojRacuna desc limit 1;


-- dohvatiti kupce koji su obavili kupovinu u više različitih datuma
select ku.Ime, ku.Prezime
from kupac as ku
join racun as ra
on ku.IDKupac = ra.KupacID
group by ku.IDKupac
having count(distinct ra.DatumIzdavanja) > 1;

-- prikaži razliku u količinama prodanih proizvoda između 2 najprodavanija proizvoda
select sum(st.Kolicina)
from stavka st
group by st.ProizvodID
order by sum(st.Kolicina) desc limit 2;


select sum(st.Kolicina) - (
	select sum(st1.Kolicina)
		from stavka st1
	group by st1.ProizvodID
	order by sum(st1.Kolicina) desc limit 1,1
) as Razlika
from stavka st
group by st.ProizvodID
order by sum(st.Kolicina) desc limit 1;

-- Prodaja po broju računa
select month(ra.DatumIzdavanja) as Mjesec, count(ra.IdRacun) as UkupnoRacuna
from racun as ra
group by Mjesec
order by UkupnoRacuna desc;

-- Prodaja po volumenu
select month(ra.DatumIzdavanja) as Mjesec, sum(st.Kolicina) as UkupnaKolicina
from racun as ra
join stavka as st
on st.RacunID = ra.IDRacun
group by Mjesec
order by UkupnaKolicina desc;

-- Pronađi mjesec u kojem ste imali najveći volumen prodaje
select month(ra.DatumIzdavanja) as Mjesec, sum(st.UkupnaCijena) as Promet
from racun as ra
join stavka as st
on st.RacunID = ra.IDRacun
group by Mjesec
order by Promet desc;
