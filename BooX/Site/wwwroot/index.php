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
				include("../../security.php");

				echo "<h1>GRADIVO</h1>";

				$conn = new PDO("mysql:host=eu-cdbr-azure-west-a.cloudapp.net; dbname=booxdb", $user, $pass);

				$rezultat = $conn->query("SELECT * FROM gradivo");
				foreach ($rezultat as $vrstica) {
					//var_dump($vrstica);
					echo "<br /><br />";
				}
			?>
		</div>
	</body>
</html>