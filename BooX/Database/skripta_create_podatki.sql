/*=======================================*/
/* Skripta za polnjenje testnih podatkov */
/*=======================================*/

-- Pobrisemo vse obstojece podatke
DELETE FROM avtor;
DELETE FROM fakulteta;
DELETE FROM gradivo;
DELETE FROM jeavtor;
DELETE FROM nafakulteti;
DELETE FROM nakup;
DELETE FROM oblika;
DELETE FROM predmet;
DELETE FROM pripredmetu;
DELETE FROM profesor;
DELETE FROM profesorzahteva;
DELETE FROM uporabnik;

-- Uporabniki
INSERT INTO uporabnik (Email, ImeUporabnika, DatumPrijave, HashGesla) VALUES ("nejc@boox.com", "Nejc", date("12.12.2016"), "96605ce9ab4342d0a90b650607faae1f975bdba8");
INSERT INTO uporabnik (Email, ImeUporabnika, DatumPrijave, HashGesla) VALUES ("jaka@boox.com", "Jaka", date("12.12.2016"), "96605ce9ab4342d0a90b650607faae1f975bdba8");
INSERT INTO uporabnik (Email, ImeUporabnika, DatumPrijave, HashGesla) VALUES ("janez@boox.com", "Janez", date("12.12.2016"), "96605ce9ab4342d0a90b650607faae1f975bdba8");
INSERT INTO uporabnik (Email, ImeUporabnika, DatumPrijave, HashGesla) VALUES ("matija@boox.com", "Matija", date("12.12.2016"), "96605ce9ab4342d0a90b650607faae1f975bdba8");

-- Fakultete
INSERT INTO fakulteta (FakultetaID, NazivFakultete) VALUES (1, "FRI");
INSERT INTO fakulteta (FakultetaID, NazivFakultete) VALUES (2, "FKKT");
INSERT INTO fakulteta (FakultetaID, NazivFakultete) VALUES (3, "FE");
INSERT INTO fakulteta (FakultetaID, NazivFakultete) VALUES (4, "NTF");
INSERT INTO fakulteta (FakultetaID, NazivFakultete) VALUES (5, "FDV");

-- Oblike
INSERT INTO oblika (OblikaID, Oblika) VALUES (1, "Knjiga/Fizicni izvod");
INSERT INTO oblika (OblikaID, Oblika) VALUES (2, "Knjiga/PDF");
INSERT INTO oblika (OblikaID, Oblika) VALUES (3, "Zapiski/Papirnati");
INSERT INTO oblika (OblikaID, Oblika) VALUES (4, "Zapiski/PDF");

-- Gradivo
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (1, 1, "nejc@boox.com", "Računalniške komunikacije", 12.50, date("1.2.2016"), false);