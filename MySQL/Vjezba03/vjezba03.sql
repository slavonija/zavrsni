-- Dohvatite sve podatke o kreditnim karticama
SELECT * FROM kreditnakartica;
    
-- Dohvatite sve proizvode koji imaju stanje zaliha manje od 50
SELECT * FROM proizvod
WHERE MinimalnaKolicinaNaSkladistu <50;

-- Dohvati sve kupovine određenog kupca (npr. KupacID = 1)
SELECT * FROM racun
where KupacID = 1;

-- Dohvati proizvode bez dodijeljene potkategorije
SELECT * FROM proizvod
where PotkategorijaID is null;

-- Identificirajte državu s najvećim brojem gradova koristeći podupit.
SELECT Naziv as Drzava
FROM drzava
WHERE IDDrzava = (
	SELECT DrzavaID
    FROM grad
    GROUP BY DrzavaID
    ORDER BY COUNT(*) DESC
    LIMIT 1
);
    
-- Dohvatite sve proizvode čija je zaliha ispod prosječne zalihe za njihovu potkategoriju.
SELECT p.IDProizvod, p.Naziv, p.MinimalnaKolicinaNaSkladistu, p.PotkategorijaID
FROM proizvod p
JOIN (
	SELECT PotkategorijaID, avg(MinimalnaKolicinaNaSkladistu) as avg_zaliha
	FROM proizvod
    GROUP BY PotkategorijaID
) sub_avg
ON p.PotkategorijaID = sub_avg.PotkategorijaID
WHERE P.MinimalnaKolicinaNaSkladistu < sub_avg.avg_zaliha;


