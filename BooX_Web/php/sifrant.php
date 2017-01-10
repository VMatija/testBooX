<?php
	include "../security.php";

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

	$table = $_GET["table"];

	$pdo = getBasicConnection();
	if ($table == "profesor") {
		$sql = "SELECT ProfesorID, ImeProfesorja, PriimekProfesorja FROM Profesor ORDER BY PriimekProfesorja";
	} else if ($table == "fakulteta") {
		$sql = "SELECT FakultetaID, NazivFakultete FROM Fakulteta ORDER BY NazivFakultete";
	} else if ($table == "predmet") {
		$sql = "SELECT PredmetID, ImePredmeta FROM Predmet ORDER BY ImePredmeta";
	}
	$result = getAll($pdo, $sql, NULL);
	$html = "";
	if ($table == "profesor") {
		foreach ($result as $row) {
			$html = $html . "<option value='" . $row["ProfesorID"] . "'>" . $row["ImeProfesorja"] . " " . $row["PriimekProfesorja"] . "</option>";
		}
	} else if ($table == "fakulteta") {
		foreach ($result as $row) {
			$html = $html . "<option value='" . $row["FakultetaID"] . "'>" . $row["NazivFakultete"] . "</option>";
		}
	} else if ($table == "predmet") {
		foreach ($result as $row) {
			$html = $html . "<option value='" . $row["PredmetID"] . "'>" . $row["ImePredmeta"] . "</option>";
		}
	}
	echo $html;
?>