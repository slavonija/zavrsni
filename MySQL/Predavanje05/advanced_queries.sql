-- ispiši nazive gradova koji imaju više od 20 kupaca
select gr.Naziv, count(ku.IDKupac) as BrojKupaca
from grad as gr, kupac as ku
where gr.IdGrad = ku.GradID
group by ku.GradID
HAVING BrojKupaca > 1500;

-- Ispiši sve proizvode (naziv) s nazivom kateorije i nazivom podkategorije.
select
pr.Naziv as Proizvod,
pk.Naziv, ka.Naziv as Potkategorija,
ka.Naziv as Kategorija
  from proizvod as pr
left join potkategorija as pk
  on pr.PotkategorijaID = pk.IDPotkategorija
left join kategorija as ka
  on pk.KategorijaID = ka.IDKategorija;
  
  -- ispiši sve račune (brojeve računa) s imenom komercijaliste i imenom kupca
select
ra.BrojRacuna,
ko.Ime as KomercijalistIme,
ko.Prezime as KomercijalistPrezime,
ku.Ime as KupacIme,
ku.Prezime as KupacPrezime
  from racun as ra
left join komercijalist as ko
  on ra.KomercijalistID = ko.IdKomercijalist
left join kupac as ku
  on ra.KupacID = ku.IDKupac
