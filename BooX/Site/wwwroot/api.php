<?php

	include "../security.php";

	/*
		JSPA - JSON Simple PHP API
	
		[X]		Error
		[ ] 	Iskanje knjige s filtri 			/search/{query}		Nejc
		[X] 	Podatki o knjigi					/book/{id}			Nejc
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
					"cena": cena(decimal),
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
		
		// params
		- uporabnik(uploader)
		- naziv
		- cenaOd
		- cenaDo
		- oblika
		- novo
		- avtor
		- profesor
		- fakulteta
		- predmet

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

	header("Content-type: application/json");

	// Tovarna statusov
	function statusFactory($status, $msg) {
		$error = array(
			"status" => $status,
			"description" => $msg
		);
		return $error;
	}

	function getBookFromRow($row) {
		$book = array();
		foreach ($row as $key => $value) {
			if (is_string($key)) {
				$book[$key] = $value;
			}
		}
		return $book;
	}

	function getBasicConnection() {
		global $user, $pass;
		return new PDO("mysql:host=eu-cdbr-azure-west-a.cloudapp.net; dbname=booxdb", $user, $pass);
	}

	function getAll($pdo, $sql, $params) {
		$query = $pdo->prepare($sql);
		$query->execute($params);
		$result = $query->fetchAll();
		return $result;
	}

	// search/query
	function search_query($query) {
		// Priprava poizvedbe
		$sql = " FROM Gradivo NATURAL JOIN Uporabnik NATURAL JOIN Oblika";
		$select = "SELECT GradivoID, OblikaID, Email, ImeUporabnika, ImeGradiva, Cena, DatumNalozeno, Novo";
		$join = "";
		$where = " WHERE";
		$fill = array();
		// Sestavljanje poizvedbe z JOIN in WHERE pogoji
		for ($i = 1; $i < count($query); $i += 2) {
			$key = $query[$i - 1];
			$value = $query[$i];
			switch ($key) {
				// Parametri iz sifrantov
				case "avtor":
					$select = $select . ", AvtorID, ImeAvtorja, PriimekAvtorja";
					$join = $join . " NATURAL JOIN JeAvtor NATURAL JOIN Avtor";
					$where = $where . " AvtorID = ? AND";
					array_push($fill, $value);
					break;
				case "profesor":
					$select = $select . ", ProfesorID, ImeProfesorja, PriimekProfesorja";
					$join = $join . " NATURAL JOIN ProfesorZahteva";
					$where = $where . " ProfesorID = ? AND";
					array_push($fill, $value);
					break;
				case "fakulteta":
					$select = $select . ", FakultetaID, NazivFakultete";
					$join = $join . " NATURAL JOIN NaFakulteti NATURAL JOIN Fakulteta";
					$where = $where . " FakultetaID = ? AND";
					array_push($fill, $value);
					break;
				case "predmet":
					$select = $select . ", PredmetID, ImePredmeta";
					$join = $join . " NATURAL JOIN PriPredmetu NATURAL JOIN Predmet";
					$where = $where . " PredmetID = ? AND";
					array_push($fill, $value);
					break;
				// Parametri iz gradiva
				case "naslov":
					$where = $where . " ImeGradiva = ? AND";
					array_push($fill, $value);
					break;
				case "oblika":
					$where = $where . " OblikaID = ? AND";
					array_push($fill, $value);
					break;
				case "novo":
					$where = $where . " Novo = ? AND";
					array_push($fill, $value);
					break;
				case "cenaOd":
					$where = $where . " Cena >= ? AND";
					array_push($fill, floatval($value));
					break;
				case "cenaDo":
					$where = $where . " Cena <= ? AND";
					array_push($fill, floatval($value));
					break;
			}
		}
		// Odstranimo AND v zadnjem WHERE pogoju
		$where = preg_replace("/ AND$/", "", $where);
		// Naredimo poizvedbo na bazi
		$pdo = getBasicConnection();
		$sql = $select . $sql . $join . $where;
		$result = getAll($pdo, $sql, $fill);
		$books = array();
		foreach ($result as $row) {
			$book = getBookFromRow($row);
			array_push($books, $book);
		}
		$response = statusFactory(0, count($books) . " zadetkov");
		$response["books"] = $books;
		$json = json_encode($response, JSON_PRETTY_PRINT);
		echo $json;
	}

	// book/id
	function book_id($bookId) {
		// Poizvedba na bazi
		$pdo = getBasicConnection();
		$sql = "SELECT GradivoID, ImeGradiva, Cena, DatumNalozeno, Novo FROM gradivo WHERE GradivoID = ?";
		$result = getAll($pdo, $sql, array($bookId));
		// Ce knjiga ne obstaja vrnemo napako
		if (!$result) {
			$response = statusFactory(1, "Knjiga z id " . $bookId . " ne obstaja!");
			$json = json_encode($response, JSON_PRETTY_PRINT);
			echo($json);
			return;
		}
		$book = getBookFromRow($result[0]);
		// Sestavljanje odgovora
		$response = statusFactory(0, "OK");
		$response["book"] = $book;
		$json = json_encode($response, JSON_PRETTY_PRINT);
		echo($json);
	}

	// book/full/id
	function book_full_id($bookId, $u, $p) {

	}

	$metoda = $_SERVER["REQUEST_METHOD"];
	$parametri = explode("/", trim($_SERVER["PATH_INFO"], "/"));

	// odgovor
	$json = null;
	$response = null;

	switch ($parametri[0]) {
		// /book
		case "book":
			if (count($parametri) == 2) {
				book_id(intval($parametri[1]), $user, $pass);
				$json = json_encode($response, JSON_PRETTY_PRINT);
			} else if (count($parametri) == 3) {
				book_full_id();
			}
			
			break;
		case "search":
			search_query(array_slice($parametri, 1));
			break;
		default:
			break;
	}
?>