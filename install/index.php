<?php
/************************************************************************
 * Skrypt do gier z programów partnerskich
 *
 * Autorem tego oprogramowania jest:
 * Kamil Wyremski
 * http://wyremski.pl
 *
 * *********************************************************************/

error_reporting(E_ALL);
error_reporting(0);

ob_start();

$install = true;
include('../controller/config.php');
if(isset($base_url)){
	header_remove();
	header('location: '.$base_url.'cms');
}

require_once('../lib/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = '';
$smarty->compile_dir = 'tmp';
$smarty->cache_dir = 'cache';


if (isset($_POST['url']) and isset($_POST['serwer']) and isset($_POST['port']) and isset($_POST['uzytkownik']) and isset($_POST['nazwa']) and isset($_POST['logincms']) and isset($_POST['haslocms'])){

	$connect = mysql_connect($_POST['serwer'].':'.$_POST['port'], $_POST['uzytkownik'], $_POST['haslo']);
	if (!$connect) {
		$error = "Błąd! Nie można połączyć z wybranym serwerem.";
		$smarty->assign("error", $error);
	}else{
		mysql_query("SET NAMES utf8");
		$db_selected = @mysql_select_db($_POST['nazwa']);
		if (!$db_selected) {
			$error = "Błąd! Niewłaściwa nazwa bazy danych.";
			$smarty->assign("error", $error);
		}else{
			$dir = '../controller/config.php';
			if ( !file_exists($dir) ) {
				fwrite($dir,'');
			}else{
				chmod($dir, 0777);
			}
 
			file_put_contents('../controller/config.php', '<?php
	$mysql_server = "'.$_POST['serwer'].':'.$_POST['port'].'";
	$mysql_admin = "'.$_POST['uzytkownik'].'";  
	$mysql_pass = "'.$_POST['haslo'].'"; 
	@mysql_connect($mysql_server, $mysql_admin, $mysql_pass);
	mysql_query("SET NAMES utf8");
	@mysql_select_db("'.$_POST['nazwa'].'");

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
			');		
			
			$q=mysql_query("SHOW TABLES FROM ".$_POST['nazwa']);
			while($r=mysql_fetch_assoc($q)){
				mysql_query("DROP TABLE ".$r["Tables_in_".$_POST['nazwa']]); 
			}
			
			mysql_query("SET NAMES utf8");
			mysql_query("create table cms(id int auto_increment, login varchar(256), password varchar(256), primary key(id))");
			mysql_query("create table gry(id int(11) auto_increment, pozycja int(11), nazwa varchar(256), prosta_nazwa varchar(256), kategorie varchar(256), tagi varchar(256), opis text, krotkiopis text, keywords text, description text, slider int(11), data date, primary key(id))");
			mysql_query("create table kategorie(id int auto_increment, nazwa varchar(256), prosta_nazwa varchar(256), primary key(id))");
			mysql_query("create table komentarze(id int auto_increment, id_gry int(11), status int(11), tresc text, podpis varchar(256), email varchar(256), czas int(11), kod varchar(128), primary key(id))");
			mysql_query("create table polecane_strony(id int auto_increment, nazwa varchar(256), url varchar(256), primary key(id))");
			mysql_query("create table strony(id int auto_increment, nazwa varchar(256), prosta_nazwa varchar(256), tresc text, primary key(id))");
			mysql_query("create table tagi(id int auto_increment, nazwa varchar(256), prosta_nazwa varchar(256), ilosc int(11), primary key(id))");
			mysql_query("create table ustawienia(id int auto_increment, base_url varchar(256), template varchar(128), title varchar(256), email varchar(128), keywords text, description text, logo int(2), logo_text text, logo_text2 text, logo_url varchar(256), favicon int(2), favicon_url varchar(256), ile_wpisow int(11), losowe_wpisy int(11), polecane int(11), polecane_strony int(11), reklama_big text, reklama_big2 text, reklama_1 text, reklama_2 text, reklama_3 text, reklama_4 text, reklama_5 text, reklama_ukryta text, ile_nowych int(11), komentarze int(11), komentarze_potwierdzanie int(11), komentarze_nowe int(11), ile_komentarzy int(11), footer_url varchar(256), footer_nazwa varchar(256), slider int(11), kontakt int(11), statystyki int(11), wyszukiwarka int(11), primary key(id))");
			
			mysql_query("ALTER TABLE cms CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci");
			mysql_query("ALTER TABLE gry CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci");
			mysql_query("ALTER TABLE kategorie CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci");
			mysql_query("ALTER TABLE komentarze CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci");
			mysql_query("ALTER TABLE polecane CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci");
			mysql_query("ALTER TABLE strony CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci");
			mysql_query("ALTER TABLE tagi CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci");
			mysql_query("ALTER TABLE ustawienia CONVERT TO CHARACTER SET utf8 COLLATE utf8_polish_ci");
			
			$base_url = $_POST['url'];
			if(substr($base_url, 0, 7) != "http://" and $base_url !='') {
				$base_url = 'http://'.$base_url;
			}
			if(substr($base_url, -1)!='/'){
				$base_url = $base_url.'/';
			}
		
			mysql_query("insert into cms values(null, '".$_POST['logincms']."', md5('".$_POST['haslocms']."'))");
			mysql_query("insert into ustawienia values(null, '".$base_url."', 'default', 'Gry Online', '' , '', '', '0', 'Gry Online', 'Darmowe gry online', '', '0', '', '6', '0', '1', '1', '', '', '', '', '', '', '', '', '10', '1', '1', '1', '6', 'wyremski.pl', 'Kamil Wyremski', '1', '1', '1', '1')");
			
			chmod("../cache", 0777);
			chmod("../tmp", 0777);
			chmod("../cms/cache", 0777);
			chmod("../cms/tmp", 0777);
			chmod("../logo", 0777);
			chmod("../controller/config.php", 0644);
			
			array_map('unlink', glob("tmp/*"));
			array_map('unlink', glob("../tmp/*"));
			array_map('unlink', glob("../cms/tmp/*"));
			
			header('location: ../cms');
		}
	}
	
	$smarty->assign("url", $_POST['url']);
	$smarty->assign("serwer", $_POST['serwer']);
	$smarty->assign("port", $_POST['port']);
	$smarty->assign("uzytkownik", $_POST['uzytkownik']);
	$smarty->assign("nazwa", $_POST['nazwa']);
	$smarty->assign("haslo", $_POST['haslo']);
	$smarty->assign("logincms", $_POST['logincms']);
	$smarty->assign("haslocms", $_POST['haslocms']);
}


$smarty->display('index.tpl');

?>