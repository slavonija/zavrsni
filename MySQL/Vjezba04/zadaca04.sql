use adventureworkshop;

-- Ispiši kupce i imena gradova u kojima žive
select ku.prezime, ku.ime, gr.naziv
from kupac as ku, grad as gr
where ku.GradID = gr.IDGrad;

-- Ispiši račune  zajedno s detaljima o kupcu i proizvodu
select ra.BrojRacuna, ku.Prezime, ku.Ime, ku.Email, ku.Telefon
from racun as ra, kupac as ku
where ra.KupacID = ku.IDKupac;

-- Izračunaj prosječnu cijenu proizvoda u svakoj kategoriji
select ka.Naziv, avg(pr.CijenaBezPDV) as 'Cijena bez PDV-a'
from kategorija as ka
join potkategorija as po
on ka.IDKategorija = po.KategorijaID
join proizvod as pr 
on po.IDPotkategorija = pr.PotkategorijaID 
group by ka.Naziv;

-- Pronađi najpopularniji proizvod na temelju količine u računima
select st.proizvodID, st.Kolicina, pr.naziv
from stavka as st
join proizvod as pr
on st.ProizvodID = pr.IDProizvod
group by st.Kolicina
order by max(st.Kolicina) desc limit 1;

-- Prikaz proizvoda koji nisu niti jednom kupljeni
select * from proizvod
where IDproizvod
not in (select distinct ProizvodID from stavka);

-- Prikaži ukupni iznos prodaje za svaki grad
select gr.Naziv, sum(st.UkupnaCijena) as Promet
from racun as ra
join stavka as st
on st.RacunID = ra.IDRacun
join kupac as ku
on ra.kupacID = ku.IDkupac
join grad as gr
on gr.IDgrad = ku.GradID
group by gr.IdGrad
order by Promet desc;


-- Ubaci državu koja nema gradove
INSERT INTO Drzava (IDDrzava, Naziv) VALUES
    (6, 'Albanija');

-- Popis država koje nemaju gradove
select drzava.Naziv as Drzava
from drzava
left join grad
on grad.DrzavaID = drzava.IDDrzava
where grad.DrzavaID is null;

-- Pronađi grad s najvećim brojem narudžbi
select count(ra.IDRacun) as ZbrojRacuna, gr.Naziv as Grad
from racun as ra
join kupac as ku
on ra.kupacID = ku.IDkupac
join grad as gr
on gr.IDgrad = ku.GradID
group by gr.IdGrad
order by ZbrojRacuna desc limit 1;

-- Prikaži proizvode s cijenama iznad prosječne cijene u svojoj kategoriji
select 
pr.Naziv as Proizvod, 
ka.Naziv as Kategorija,
pr.CijenaBezPDV,
prosjek.Prosjecna
	from proizvod as pr
left join potkategorija as pk
	on pr.PotkategorijaID = pk.IDPotkategorija
left join kategorija as ka
	on pk.KategorijaID=ka.IDKategorija
join (
select ka.IDKategorija, avg(pr.CijenaBezPDV) as Prosjecna
from kategorija as ka, potkategorija as po, proizvod as pr
where ka.IDKategorija = po.KategorijaID
and po.IDPotkategorija = pr.PotkategorijaID
group by ka.IDKategorija) as prosjek
	on pk.KategorijaID=prosjek.IDKategorija
having pr.CijenaBezPDV > prosjek.Prosjecna;
    

-- Identificiraj kupce koji su kupovali više od jednog puta u različitim danima
select ku.Ime, ku.Prezime
from kupac as ku
join racun as ra
on ku.IDKupac = ra.KupacID
group by ku.IDKupac
having count(distinct ra.DatumIzdavanja) > 1;

-- Izračunaj ukupan broj prodanih proizvoda za svaku kategoriju proizvoda
select
ka.Naziv as Kategorija,
sum(st.Kolicina) as 'Prodana količina'
from stavka as st
left join proizvod as pr
	on st.ProizvodID = pr.IDproizvod
left join potkategorija as pk
	on pr.PotkategorijaID = pk.IDPotkategorija
left join kategorija as ka
	on pk.KategorijaID=ka.IDKategorija
group by ka.IDKategorija
order by sum(st.Kolicina) desc;


-- Pronađi mjesec s najvećim obujmom prodaje
select month(ra.DatumIzdavanja) as Mjesec, sum(st.UkupnaCijena) as Promet
from racun as ra
join stavka as st
on st.RacunID = ra.IDRacun
group by Mjesec
order by Promet desc;

-- Prikaz razlike u količinama proizvoda između dva najprodavanija proizvoda
select sum(st.Kolicina)
from stavka st
group by st.ProizvodID
order by sum(st.Kolicina) desc limit 2;


-- dohvati sve kupce bez računa - rješenje sa JOIN
select * from kupac as ku
left join racun ra
on ra.KupacID = ku.IDKupac
where ra.IDRacun is null;

-- Popis svih proizvoda koji nikada nisu prodani na istom računu s Proizvodom ID 1
select * from stavka
where stavka.RacunID
not in (select RacunID
from stavka as st
join proizvod as pr
	on st.ProizvodID = 1);

-- Izračunaj prosječni iznos prodaje po računu za svakog prodavača
select 
ko.Prezime as KomercijalistPrezime,
ko.Ime as KomercijalistIme,
avg(st.UkupnaCijena) as Promet
	from stavka as st
left join racun as ra
	on ra.IDRacun = st.racunID
join komercijalist as ko
	on ra.KomercijalistID = ko.IDKomercijalist
group by ko.IDKomercijalist
order by Promet desc;

-- Pronađi državu s najraznovrsnijim spektrom kategorija proizvoda u narudžbama
select
dr.Naziv,
count(distinct ka.IDKategorija)
from stavka as st
left join proizvod as pr
	on st.ProizvodID = pr.IDproizvod
left join potkategorija as pk
	on pr.PotkategorijaID = pk.IDPotkategorija
left join kategorija as ka
	on pk.KategorijaID=ka.IDKategorija
left join racun as ra
	on st.RacunID = ra.IDRacun
left join kupac as ku
	on ra.KupacID = ku.IDKupac
left join grad as gr
	on ku.GradID = gr.IDGrad
left join drzava as dr
	on gr.DrzavaID = dr.IDDrzava
group by dr.IDDrzava
order by dr.Naziv asc, count(ka.IDKategorija) desc limit 1;
