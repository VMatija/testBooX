<?php

	include "../../security.php";

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

	//header("Content-type: application/json");

	// Tovarna napak
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
		// Parametri za konstrukcijo poizvedbe
		$extra = array("avtor", "profesor", "fakulteta", "predmet");
		$basic = array("naziv", "oblika", "novo");
		$gt = array("cenaOd");
		$lt = array("cenaDo");
		// Priprava poizvedbe
		$sql = "SELECT * FROM gradivo NATURAL JOIN uporabnik NATURAL JOIN oblika";
		$joins = "";
		$where = " WHERE ";
		$fill = array();
		// Sestavljanje poizvedbe z JOIN in WHERE pogoji
		$params = explode("&", $query);
		foreach ($params as $param) {
			$pair = explode("=", $param);
			$key = $pair[0];
			$value = $pair[1];
			if (in_array($key, $extra)) {
				$joins = $joins . " NATURAL JOIN ?";
				array_push($fill, $key);
				$where = $where . $key . " = ? AND ";
				array_push($fill, $value);
			} else if (in_array($key, $basic)) {
				$where = $where . $key . " = ? AND ";
				array_push($fill, $value);
			} else if (in_array($key, $gt)) {
				$where = $where . "cena" . " > ? AND ";
				array_push($fill, $value);
			} else if (in_array($key, $lt)) {
				$where = $where . "cena" . " < ? AND ";
				array_push($fill, $value);
			}
		}
		// Odstranimo AND v zadnjem WHERE pogoju
		$where = preg_replace("/ AND $/", "", $where);
		// Naredimo poizvedbo na bazi
		$pdo = getBasicConnection();
		$sql = $sql . $joins . $where;
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

	

	// PDO objekt za povezavo na bazo
	$conn = new PDO("mysql:host=eu-cdbr-azure-west-a.cloudapp.net; dbname=booxdb", $user, $pass);

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
			search_query($parametri[1]);
			break;
		default:
			break;
	}
?>