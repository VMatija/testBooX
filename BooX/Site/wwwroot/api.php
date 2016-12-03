<?php
	/*
		JSPA - JSON Simple PHP API
	
		TODO 	Iskanje knjige s filtri 	url/api.php/search/query
		TODO 	Podatki o knjigi z id 		url/api.php/book/id

		query = "parameter=value&parameter=value"
	*/

	$metoda = $_SERVER["REQUEST_METHOD"];
	$parametri = explode("/", trim($_SERVER["PATH_INFO"], "/"));
	//var_dump($parametri);

	//echo "\n\n";

	// odgovor
	$json = null;
	$response = null;

	switch ($parametri[0]) {
		case "book":
			$id = intval($parametri[1]);
			// TODO Iz baze dobimo podatke o knjigi
			// Mock podatki za proof of concept
			$naslov = "Zapiski 2. kolokvija Diskretne strukture";
			$cena = 13.37;
			$datumNalozeno = date("d.m.Y");
			$novo = true;
			$avtorid = 37;
			$avtorime = "Janez";
			$avtorpriimek = "Novak";
			$email = "janez.novak@gmail.com";
			$imeuporabnika = "janeznovak";
			// Sestavimo knjigo
			$book = array(
				"id" => $id,
				"naslov" => $naslov,
				"cena" => $cena,
				"datumNalozeno" => $datumNalozeno,
				"novo" => $novo,
				"avtorid" => $avtorid,
				"avtorime" => $avtorime,
				"avtorpriimek" => $avtorpriimek,
				"email" => $email,
				"imeuporabnika" => $imeuporabnika
			);
			$response = array(
				"status" => 0,
				"description" => "OK",
				"book" => $book
			);
			$json = json_encode($response, JSON_PRETTY_PRINT);
			break;
		
		default:
			$response = array(
				"status" => 1,
				"description" => "API endpoint " . $parametri[0] . " does not exist"
			);
			$json = json_encode($response, JSON_PRETTY_PRINT);
			break;
	}

	// pokazemo json objekt
	echo($json);

	/*

		+-----------------------+
		| JSON RESPONSE FORMATS |
		+-----------------------+

		error

		{
			"status": 1,
			"description": opis napake
		}

		osnovni podatki o gradivu (book/id)
		{
			"status": 0,
			"description": opis operacije
			"book":
				{
					"id": id,
					"naslov": naslov,
					"cena": cena,
					"datumNalozeno": datum,
					"novo": novo,
					"avtorid": avtorid,
					"avtorime": avtorime,
					"avtorpriimek": avtorpriimek,
					"email": email,
					"imeuporabnika": imeuporabnika
				}
		}
	*/
?>