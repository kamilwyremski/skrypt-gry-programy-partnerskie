<?php
	$mysql_server = ""; // nazwa serwera
	$mysql_admin = "";  // nazwa u¿ytkownika
	$mysql_pass = "";  // has³o u¿ytkownika
	@mysql_connect($mysql_server, $mysql_admin, $mysql_pass);
	mysql_query("SET NAMES utf8");
	@mysql_select_db("test"); // nazwa bazy

	$q = mysql_query("select * from ustawienia limit 1");
	while($dane = mysql_fetch_array($q)){
		$dane["reklama_big"] = htmlspecialchars_decode($dane["reklama_big"]);
		$dane["reklama_big2"] = htmlspecialchars_decode($dane["reklama_big2"]);
		$dane["reklama_1"] = htmlspecialchars_decode($dane["reklama_1"]);
		$dane["reklama_2"] = htmlspecialchars_decode($dane["reklama_2"]);
		$dane["reklama_3"] = htmlspecialchars_decode($dane["reklama_3"]);
		$dane["reklama_4"] = htmlspecialchars_decode($dane["reklama_4"]);
		$dane["reklama_5"] = htmlspecialchars_decode($dane["reklama_5"]);
		$dane["reklama_ukryta"] = htmlspecialchars_decode($dane["reklama_ukryta"]);
		$ustawienia= $dane;
	}
	$base_url = $ustawienia["base_url"];
?>
