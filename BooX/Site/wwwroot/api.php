<?php
	/*
		JSPA - JSON Simple PHP API
	
		[X]		Error
		[ ] 	Iskanje knjige s filtri 			/search/{query}		Nejc
		[ ] 	Podatki o knjigi					/book/{id}			Nejc
		[ ]		Polni podatki o knjigi				/book/full/{id}		Jaka
	
	*/

	/*
		query = "parameter=value&parameter=value..."

		//__________________________________________//
		/|											|/
		/|		SPECIFIKACIJA OBLIKE ODGOVOROV		|/
		/|											|/
		//__________________________________________//


		//-------//
		// error //
		//-------//

		{
			"status": 1,
			"description": error
		}

		//---------------------------------------//
		// osnovni podatki o gradivu (book/{id}) //
		//---------------------------------------//

		{
			"status": 0,
			"description": OK
			"book":
				{
					"id": id(string),
					"naslov": naslov(string),
					"Cena": cena(decimal),
					"datumNalozeno": datum(date),
					"novo": novo(boolean),
				}
		}

		//------------------------------------------//
		// polni podatki o gradivu (book/full/{id}) //
		//------------------------------------------//

		{
			"status": 0,
			"description": OK
			"book":
				{
					"bookid": bookid(string),
					"naslov": naslov(string),
					"cena": cena(decimal),
					"datumNalozeno": datum(date),
					"novo": novo(boolean),
					"avtorid": avtorid(string),
					"avtorime": avtorime(string),
					"avtorpriimek": avtorpriimek(string),
					"oblikaid", oblikaid(string),
					"oblika", oblika(string),
					"email": email(string),
					"imeuporabnika": imeuporabnika(string)
				}
		}

		//--------------------------//
		// iskanje (search/{query}) //
		//--------------------------//

		{
			"status": 0,
			"description": OK,
			"books":
				[
					{
						"id": id(string),
						"naslov": naslov(string),
						"Cena": cena(decimal),
						"datumNalozeno": datum(date),
						"novo": novo(boolean),
						"avtorid": avtorid(string),
						"avtorime": avtorime(string),
						"avtorpriimek": avtorpriimek(string),
						"email": email(string),
						"imeuporabnika": imeuporabnika(string)
					},
					.
					.
					.
					{
						"id": id(string),
						"naslov": naslov(string),
						"Cena": cena(decimal),
						"datumNalozeno": datum(date),
						"novo": novo(boolean),
						"avtorid": avtorid(string),
						"avtorime": avtorime(string),
						"avtorpriimek": avtorpriimek(string),
						"email": email(string),
						"imeuporabnika": imeuporabnika(string)
					}
				]
		}
	*/

	// Napaka (splošno)
	$errorDefault = array(
		"status" => 1,
		"description" => "Error"
	);

	// PDO objekt za povezavo na bazo
	$conn = new PDO("mysql:host=eu-cdbr-azure-west-a.cloudapp.net; dbname=booxdb", "b62531693a0bc9", "6e560170");
	var_dump($conn);

	// [ ] Povezava na bazo
	// [ ] Izpis gradiva

	$metoda = $_SERVER["REQUEST_METHOD"];
	$parametri = explode("/", trim($_SERVER["PATH_INFO"], "/"));

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
			$json = json_encode($errorDefault, JSON_PRETTY_PRINT);
			break;
	}

	// Posljemo JSON formatiran string
	echo($json);
?>