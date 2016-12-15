<!DOCTYPE html>
<html>
	<head>
		<title>BOOX | Snap and sell</title>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<link rel="shortcut icon" href="./images/boox_temna_favicon.png" />
	</head>
	<body>
		<div style="background-color: white; display: inline-block; width: 25%; opacity: 0.75;">
			<?php
				include("../security.php");

				echo "<h1>GRADIVO</h1>";

				$conn = new PDO("mysql:host=eu-cdbr-azure-west-a.cloudapp.net; dbname=booxdb", $user, $pass);

				$rezultat = $conn->query("SELECT * FROM gradivo");
				foreach ($rezultat as $vrstica) {
					var_dump($vrstica);
					echo "<br /><br />";
				}
			?>
		</div>
		<div style="background-color: white; display: inline-block; width: 25%; opacity: 0.75; vertical-align: top;">
			<h1>HOW TO USE BOOX API</h1>
			<h2>Poizvedba za knjigo</h2>
			<p>Call boox.azurewebsites.net/api.php/book/id</p>
			<p>Replace "id" with the id of the book</p>
			<h2>Splošno iskanje</h2>
			<p>Call boox.azurewebsites.net/search</p>
			<p>Add parameters as /key/value pairs</p>
			<p>Available parameters:</p>
			<ul>
				<li>naslov</li>
				<li>oblika</li>
				<li>novo</li>
				<li>cenaOd</li>
				<li>cenaDo</li>

				<li>profesor</li>
				<li>fakulteta</li>
				<li>predmet</li>
				<li>avtor</li>
			</ul>
			<p><b>EXAMPLE: boox.azurewebsites.net/api.php/novo/1/cenaDo/13</b></p>

		</div>
	</body>">

</html>