SELECT p.fjmeno AS Jmeno, p.ljmeno AS Prijmeni
FROM profil AS p
INNER JOIN profil_has_film AS pf ON pf.profil_idprofil = p.idprofil
GROUP BY p.ljmeno;



INSERT INTO `mydb`.`profil` 
(`idprofil`, `fjmeno`, `ljmeno`, `email`, `heslo`, `mesto`, `psc`, 
`ulice`, `tel`, `opravneni`) 
VALUES (NULL, 'Jan', 'Novotny', 'jan.novotny@cz.cz', 
'79c2b46ce2594ecbcb5b73e928345492', 'Plzen', '33490', 
'Kvetinov', NULL, 'user');



SELECT p.fjmeno AS Jmeno, p.ljmeno AS Prijmeni
FROM profil AS p
INNER JOIN profil_has_film AS pf ON pf.profil_idprofil = p.idprofil
GROUP BY p.ljmeno;



INSERT INTO `mydb`.`film` 
(`idfilm`, `nazev`, `rok_vydani`, `cover_link`, 
`reziser_idreziser`, `cena`)
 VALUES (NULL, 'Zachrante vojina Ryana', '1998', 
 'zachrante_vojina_rajena.jpg', '5', '49');
 
 
 
 INSERT INTO `mydb`.`film_has_herci`
(`film_idfilm`, `herci_idherci`)
VALUES ('24', '2');


INSERT INTO `mydb`.`film_has_dabing`
(`film_idfilm`, `dabing_iddabing`)
VALUES ('24', '2');


INSERT INTO `mydb`.`profil_has_film` 
(`profil_idprofil`, `film_idfilm`, `datum_vypujceni`) 
VALUES ('16', '24', '2014-12-09');


UPDATE profil 
SET tel = '773346799' 
WHERE idprofil = '16';


SELECT p.fjmeno AS Jmeno, p.ljmeno AS Prijmeni 
FROM profil AS p 
INNER JOIN profil_has_film AS pf ON pf.profil_idprofil = p.idprofil 
GROUP BY p.ljmeno


DELETE FROM film 
WHERE idfilm = '24';


SELECT f.nazev FROM film AS f 
INNER JOIN film_has_dabing AS fd ON fd.film_idfilm = f.idfilm 
WHERE fd.dabing_iddabing = '2';

