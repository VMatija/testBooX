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
INSERT INTO uporabnik (Email, ImeUporabnika, DatumPrijave, HashGesla) VALUES ("dzs@dzs.si", "DZS", date("12.12.2016"), "96605ce9ab4342d0a90b650607faae1f975bdba8");

-- Oblike
INSERT INTO oblika (OblikaID, Oblika) VALUES (1, "Knjiga/Fizicni izvod");
INSERT INTO oblika (OblikaID, Oblika) VALUES (2, "Knjiga/PDF");
INSERT INTO oblika (OblikaID, Oblika) VALUES (3, "Zapiski/Papirnati");
INSERT INTO oblika (OblikaID, Oblika) VALUES (4, "Zapiski/PDF");

-- Gradivo
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (1, 1, "nejc@boox.com", "Računalniške komunikacije", 12.50, date("1.2.2016"), false);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (2, 4, "nejc@boox.com", "TPO zapiski", 5.00, date("1.2.2016"), false);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (3, 2, "nejc@boox.com", "Introduction to computer vision", 10.00, date("1.2.2016"), false);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (4, 3, "nejc@boox.com", "Statistika enačbe", 3.50, date("1.2.2016"), false);

INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (5, 3, "jaka@boox.com", "EMP zapiski 1. semester", 8.00, date("1.2.2016"), false);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (6, 4, "jaka@boox.com", "VIN rešeni kolokviji", 4.00, date("1.2.2016"), false);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (7, 4, "jaka@boox.com", "PUI izpiski", 5.00, date("1.2.2016"), false);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (8, 1, "jaka@boox.com", "TPO knjiga", 15.00, date("1.2.2016"), false);

INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (9, 4, "janez@boox.com", "KPOV navodila", 10.00, date("1.2.2016"), false);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (10, 1, "janez@boox.com", "RG knjiga", 9.50, date("1.2.2016"), false);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (11, 4, "janez@boox.com", "PB2 kolokviji", 3.00, date("1.2.2016"), false);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (12, 3, "janez@boox.com", "RK zapiski", 5.00, date("1.2.2016"), false);

INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (13, 4, "matija@boox.com", "GO principi", 8.00, date("1.2.2016"), false);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (14, 4, "matija@boox.com", "PUI izpiski", 7.50, date("1.2.2016"), false);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (15, 1, "matija@boox.com", "DPS knjiga", 16.00, date("1.2.2016"), true);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (16, 4, "matija@boox.com", "EMP rešeni kolokviji", 6.00, date("1.2.2016"), false);

INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (17, 1, "dzs@dzs.si", "DPS knjiga", 20.00, date("1.2.2016"), true);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (18, 1, "dzs@dzs.si", "Agilne metode", 15.00, date("1.2.2016"), true);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (19, 1, "dzs@dzs.si", "Barve v grafiki", 18.00, date("1.2.2016"), true);
INSERT INTO gradivo (GradivoID, OblikaID, Email, ImeGradiva, Cena, DatumNalozeno, Novo) VALUES (20, 1, "dzs@dzs.si", "Operacijski sistemi", 17.00, date("1.2.2016"), true);

-- Fakultete
INSERT INTO fakulteta (FakultetaID, NazivFakultete) VALUES (1, "FRI");
INSERT INTO fakulteta (FakultetaID, NazivFakultete) VALUES (2, "FKKT");
INSERT INTO fakulteta (FakultetaID, NazivFakultete) VALUES (3, "FE");
INSERT INTO fakulteta (FakultetaID, NazivFakultete) VALUES (4, "NTF");
INSERT INTO fakulteta (FakultetaID, NazivFakultete) VALUES (5, "FDV");

-- Povezava GRADIVO x FAKULTETA
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (1, 1);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (5, 2);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (9, 3);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (13, 4);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (17, 5);

INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (2, 1);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (6, 2);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (10, 3);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (14, 4);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (18, 5);

INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (3, 1);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (7, 2);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (11, 3);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (15, 4);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (19, 5);

INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (4, 1);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (8, 2);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (12, 3);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (16, 4);
INSERT INTO nafakulteti (GradivoID, FakultetaID) VALUES (20, 5);

-- Profesorji
INSERT INTO profesor (ProfesorID, ImeProfesorja, PriimekProfesorja) VALUES (1, "Janez", "Novak");
INSERT INTO profesor (ProfesorID, ImeProfesorja, PriimekProfesorja) VALUES (2, "Andrej", "Brodnik");
INSERT INTO profesor (ProfesorID, ImeProfesorja, PriimekProfesorja) VALUES (3, "Lovro", "Kuhar");
INSERT INTO profesor (ProfesorID, ImeProfesorja, PriimekProfesorja) VALUES (4, "Andrej", "Škraba");
INSERT INTO profesor (ProfesorID, ImeProfesorja, PriimekProfesorja) VALUES (5, "Aljaž", "Zrnec");

-- Povezava GRADIVO x PROFESOR
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (1, 2);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (5, 3);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (9, 4);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (13, 5);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (17, 1);

INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (2, 2);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (6, 3);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (10, 4);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (14, 5);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (18, 1);

INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (3, 2);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (7, 3);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (11, 4);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (15, 5);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (19, 1);

INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (4, 2);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (8, 3);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (12, 4);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (16, 5);
INSERT INTO profesorzahteva (GradivoID, ProfesorID) VALUES (20, 1);

-- Predmeti
INSERT INTO predmet (PredmetID, ImePredmeta) VALUES (1, "TPO");
INSERT INTO predmet (PredmetID, ImePredmeta) VALUES (2, "IPIRI");
INSERT INTO predmet (PredmetID, ImePredmeta) VALUES (3, "VIN");
INSERT INTO predmet (PredmetID, ImePredmeta) VALUES (4, "RG");
INSERT INTO predmet (PredmetID, ImePredmeta) VALUES (5, "PB2");

-- Povezava GRADIVO x PREDMET
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (1, 4);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (5, 5);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (9, 1);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (13, 2);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (17, 3);

INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (2, 4);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (6, 5);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (10, 1);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (14, 2);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (18, 3);

INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (3, 4);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (7, 5);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (11, 1);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (15, 2);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (19, 3);

INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (4, 4);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (8, 5);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (12, 1);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (16, 2);
INSERT INTO pripredmetu (GradivoID, PredmetID) VALUES (20, 3);