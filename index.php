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

include('controller/config.php');

require_once('lib/Smarty.class.php');
$smarty = new Smarty();
$smarty->template_dir = 'templates/'.$ustawienia['template'];
$smarty->compile_dir = 'tmp';
$smarty->cache_dir = 'cache';
date_default_timezone_set('Europe/Warsaw');

$smarty->assign("ustawienia", $ustawienia);
require_once("php/funkcje.php");

$q = mysql_query("select * from strony limit 5"); // dodatkowe strony
while($dane = mysql_fetch_array($q)){$strony[]= $dane;}
$smarty->assign('strony',$strony);

if (isset($_GET['gra']) and isset($_GET['id']) and !isset($_POST['szukaj'])){

	if(isset($_POST['error_komentarz']) and $_POST['error_komentarz'] = '1'){
		$smarty->assign("komentarz_komentarz", $_POST['komentarz']);
		$smarty->assign("komentarz_podpis", $_POST['podpis']);
		$smarty->assign("komentarz_email", $_POST['email']);
	}

	$zapytanie = mysql_query('select * from gry where id="'.$_GET['id'].'" limit 1');
	$gra = pobierz_nazwy($zapytanie);
	if (isset($gra)){
		$smarty->assign("gra", $gra[0]);
	
		if($ustawienia['komentarze']=="1"){
			if(isset($_GET['aktywacja'])){
				mysql_query('update komentarze set status="'.$ustawienia['komentarze_potwierdzanie'].'" where kod="'.$_GET['aktywacja'].'" and status="0" limit 1');
			}
			$q = mysql_query('select * from komentarze where id_gry="'.$_GET['id'].'" and status="2"');
			while($dane = mysql_fetch_array($q)){$komentarze[]= $dane;}
			if(isset($komentarze)){
				$smarty->assign("komentarze", $komentarze);
			}
		}
		
		$strona='gra';
	}else{
		gra();
	}
	
}elseif (isset($_GET['site']) and !isset($_POST['szukaj'])){

	if ($_GET['site']=='kontakt' and $ustawienia['kontakt'] == '1'){
		if(isset($_POST['error_email']) and $_POST['error_email'] = '1'){
			$smarty->assign("email_imie", $_POST['imie']);
			$smarty->assign("email_email", $_POST['email']);
			$smarty->assign("email_temat", $_POST['temat']);
			$smarty->assign("email_tresc", $_POST['tresc']);
		}
		$smarty->assign("title", "Kontakt");
		$strona='kontakt';
	}else{
		$q = mysql_query("select * from strony where prosta_nazwa='".$_GET['site']."'limit 1"); // dodatkowe strony
		while($dane = mysql_fetch_array($q)){
			$dane["tresc"] = htmlspecialchars_decode($dane["tresc"]);
			$strony_content= $dane;
		}
		if(isset($strony_content)){
			$smarty->assign("strony_content", $strony_content);
			$strona='strony';
		}else{
			gra();
		}
	}
}else{
	gra();
}
function gra(){
	global $smarty;
	global $ustawienia;
	global $strona;
	
	if (isset($_POST['szukaj'])){
		$zapytanie = mysql_query('select * from gry where nazwa like "%'.$_POST['szukaj'].'%" order by pozycja desc limit '.$ustawienia['ile_wpisow'].'');
		
		$smarty->assign("left_info", "Szukaj: ".$_POST['szukaj']);
		$smarty->assign("title", $left_info['nazwa']);
	}elseif (isset($_GET['kategoria']) and isset($_GET['id'])){
		if($ustawienia['losowe_wpisy']=='1'){
			$zapytanie = mysql_query('select * from gry where kategorie like "%-'.$_GET['id'].'-%" order by rand()');
		}else{
			$zapytanie = mysql_query('select * from gry where kategorie like "%-'.$_GET['id'].'-%" order by pozycja desc');
		}
		$site_url = '/kategoria/'.$_GET['id'].'/'.$_GET['kategoria'];
		$smarty->assign("site_url", $site_url);
		
		$q = mysql_query('select nazwa from kategorie where id="'.$_GET['id'].'" limit 1');
		while($dane = mysql_fetch_array($q)){$left_info= $dane;}
		$smarty->assign("left_info", "Kategoria: ".$left_info['nazwa']);
		$smarty->assign("title", $left_info['nazwa']);
	}elseif (isset($_GET['tag']) and isset($_GET['id'])){
		if($ustawienia['losowe_wpisy']=='1'){
			$zapytanie = mysql_query('select * from gry where tagi like "%-'.$_GET['id'].'-%" order by rand()');
		}else{
			$zapytanie = mysql_query('select * from gry where tagi like "%-'.$_GET['id'].'-%" order by pozycja desc');
		}
		$site_url = '/tag/'.$_GET['id'].'/'.$_GET['tag'];
		$smarty->assign("site_url", $site_url);
		
		$q = mysql_query('select nazwa from tagi where id="'.$_GET['id'].'" limit 1');
		while($dane = mysql_fetch_array($q)){$left_info= $dane;}
		$smarty->assign("left_info", "Tag: ".$left_info['nazwa']);
		$smarty->assign("title", $left_info['nazwa']);
	}else{
		if($ustawienia['losowe_wpisy']=='1'){
			$zapytanie = mysql_query('select * from gry order by rand()');
		}else{
			$zapytanie = mysql_query('select * from gry order by pozycja desc');
		}
	}
	$gry = pobierz_nazwy($zapytanie);
	$smarty->assign("gry", $gry);
	
	if(isset($_GET['strona'])){
		$smarty->assign("site", $_GET['strona']);
	}else{
		$smarty->assign("site", '1');
	}
	$smarty->assign("ile_stron", ceil(count($gry)/$ustawienia['ile_wpisow']));
	
	$strona='main';
}

$q = mysql_query('select * from gry order by id desc limit '.$ustawienia['ile_nowych'].'');
while($dane = mysql_fetch_array($q)){$nowe_gry[]= $dane;}
$smarty->assign("nowe_gry", $nowe_gry);

$q = mysql_query('select * from kategorie order by nazwa');
while($dane = mysql_fetch_array($q)){$kategorie[]= $dane;}
$smarty->assign("kategorie", $kategorie);

if($ustawienia['polecane']=="1"){
	$q = mysql_query('select * from gry order by pozycja desc limit 5');
	while($dane = mysql_fetch_array($q)){$polecane[]= $dane;}
	$smarty->assign("polecane", $polecane);
}

$ilosc=0;
$q = mysql_query('select ilosc from tagi order by nazwa');
while($dane = mysql_fetch_array($q)){$ile[]= $dane;}
for($i=0; $i <= count($ile) - 1; $i++){
	$ilosc = $ilosc+$ile[$i]['ilosc'];
}
$srednia = $ilosc/mysql_num_rows($q);
$q = mysql_query('select * from tagi order by nazwa');
while($dane = mysql_fetch_array($q)){
	if($dane['ilosc']>$srednia/4*3){
		$dane['size'] = '4';
	}elseif($dane['ilosc']>$srednia/2){
		$dane['size'] = '3';
	}elseif($dane['ilosc']>$srednia/4){
		$dane['size'] = '2';
	}elseif($dane['ilosc']>0){
		$dane['size'] = '1';
	}else{
		$dane['size'] = '0';
	}
	$tagi[]= $dane;
}
$smarty->assign("tagi", $tagi);

if($ustawienia['komentarze']=="1" and $ustawienia['komentarze_nowe']=="1"){
	$q = mysql_query('select gry.id, gry.nazwa, gry.prosta_nazwa, komentarze.podpis, komentarze.id_gry from komentarze, gry where komentarze.status="2" and komentarze.id_gry = gry.id group by gry.id order by komentarze.czas limit '.$ustawienia['ile_komentarzy'].' ');
	while($dane = mysql_fetch_array($q)){$nowe_komentarze[]= $dane;}
	$smarty->assign("nowe_komentarze", $nowe_komentarze);
}

if($ustawienia['slider']=="1"){
	$q = mysql_query('select * from gry where slider=1 order by rand() limit 6');
	if(mysql_num_rows($q)>=3){
		while($dane = mysql_fetch_array($q)){
			$dane['krotkiopis'] = htmlspecialchars_decode($dane['krotkiopis']);
			$slider[]= $dane;
		}
		$smarty->assign("slider", $slider);
	}
}

if($ustawienia['statystyki']=="1"){
	$q = mysql_query('select * from gry'); 	//panel statystyk
	$smarty->assign("st_gry", mysql_num_rows($q));
	$q = mysql_query('select * from kategorie');
	$smarty->assign("st_kategorie", mysql_num_rows($q));
	$q = mysql_query('select * from tagi');
	$smarty->assign("st_tagi", mysql_num_rows($q));
	$q = mysql_query('select * from komentarze where status="2"');
	$smarty->assign("st_komentarze", mysql_num_rows($q));
}

if($ustawienia['polecane_strony']=="1"){
	$q = mysql_query('select * from polecane_strony');
	while($dane = mysql_fetch_array($q)){$polecane_strony[]= $dane;}
	$smarty->assign("polecane_strony", $polecane_strony);
}
	
$smarty->assign('base_url',$base_url);
$smarty->assign('strona',$strona);
$smarty->display('index.tpl');

?>